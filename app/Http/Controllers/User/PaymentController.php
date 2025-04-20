<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Payment;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function showPaymentForm($slug)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để thanh toán.');
        }

        $course = Course::where('slug', $slug)->firstOrFail();
        return view('user.payment.form', compact('course'));
    }

    public function processPayment(Request $request, $slug)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để thanh toán.');
        }

        $course = Course::where('slug', $slug)->firstOrFail();
        session(['course_slug' => $slug]); // Store course slug in session

        $paymentMethod = $request->input('payment_method'); // Get selected payment method

        if ($paymentMethod === 'vnpay') {
            // VNPay payment logic
            $vnp_TmnCode = config('vnpay.tmn_code');
            $vnp_HashSecret = config('vnpay.hash_secret');
            $vnp_Url = config('vnpay.url');
            $vnp_ReturnUrl = route('vnpay.callback');

            $vnp_TxnRef = uniqid(); // Unique transaction reference
            session(['vnp_TxnRef' => $vnp_TxnRef]); // Store transaction reference in session
            $vnp_OrderInfo = "Thanh toán khóa học: " . $course->title;
            $vnp_Amount = $course->price * 100; // Convert to VNPay's required format
            $vnp_Locale = config('vnpay.locale');
            $vnp_IpAddr = $request->ip();
            $vnp_CreateDate = date('YmdHis');

            $inputData = [
                "vnp_Version" => config('vnpay.version'),
                "vnp_TmnCode" => $vnp_TmnCode,
                "vnp_Amount" => $vnp_Amount,
                "vnp_Command" => config('vnpay.command'),
                "vnp_CreateDate" => $vnp_CreateDate,
                "vnp_CurrCode" => config('vnpay.currency'),
                "vnp_IpAddr" => $vnp_IpAddr,
                "vnp_Locale" => $vnp_Locale,
                "vnp_OrderInfo" => $vnp_OrderInfo,
                "vnp_OrderType" => "billpayment",
                "vnp_ReturnUrl" => $vnp_ReturnUrl,
                "vnp_TxnRef" => $vnp_TxnRef,
            ];

            ksort($inputData);
            $query = "";
            $hashdata = "";
            foreach ($inputData as $key => $value) {
                $hashdata .= ($hashdata ? '&' : '') . urlencode($key) . "=" . urlencode($value);
                $query .= urlencode($key) . "=" . urlencode($value) . '&';
            }

            $vnp_Url = $vnp_Url . "?" . $query;
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;

            // Log VNPay URL
            Log::info("Redirecting to VNPay: $vnp_Url");

            // Redirect to VNPay
            return redirect()->away($vnp_Url);
        }

        // Handle other payment methods
        $payment = Payment::create([
            'user_id' => Auth::id(),
            'course_id' => $course->id,
            'amount' => $course->price,
            'payment_method' => $paymentMethod,
            'status' => 'completed',
            'transaction_id' => uniqid(),
        ]);

        Enrollment::create([
            'user_id' => Auth::id(),
            'course_id' => $course->id,
            'payment_id' => $payment->id,
            'status' => 'active',
            'enrolled_at' => now(),
        ]);

        return redirect()->route('payment.success')->with('success', 'Bạn đã đăng ký khóa học thành công.');
    }

    public function vnpayCallback(Request $request)
    {
        $vnp_TxnRef = $request->input('vnp_TxnRef');
        $vnp_ResponseCode = $request->input('vnp_ResponseCode');
        $vnp_Amount = $request->input('vnp_Amount') / 100; // Convert to original amount
        $vnp_TransactionNo = $request->input('vnp_TransactionNo');

        $courseSlug = session('course_slug');
        $course = Course::where('slug', $courseSlug)->firstOrFail();

        if ($vnp_ResponseCode == '00') {
            // Payment successful
            Payment::create([
                'user_id' => Auth::id(),
                'course_id' => $course->id,
                'amount' => $vnp_Amount,
                'payment_method' => 'vnpay',
                'status' => 'completed',
                'transaction_id' => $vnp_TxnRef,
            ]);

            Enrollment::create([
                'user_id' => Auth::id(),
                'course_id' => $course->id,
                'status' => 'active',
                'enrolled_at' => now(),
            ]);

            return redirect()->route('payment.success');
        } else {
            // Payment failed
            Payment::create([
                'user_id' => Auth::id(),
                'course_id' => $course->id,
                'amount' => $vnp_Amount,
                'payment_method' => 'vnpay',
                'status' => 'failed',
                'transaction_id' => $vnp_TxnRef,
            ]);

            return redirect()->route('payment.failure');
        }
    }

    public function paymentSuccess()
    {
        return view('user.payment.success');
    }

    public function paymentFailure()
    {
        return view('user.payment.failure');
    }
    public function userPaymentHistory()
    {
        $userId = Auth::id();
        $payments = Payment::where('user_id', $userId)
            ->with('course')
            ->orderBy('created_at', 'desc')
            ->get();

        $enrollments = Enrollment::where('user_id', $userId)
            ->with('course')
            ->get();

        return view('user.history', compact('payments', 'enrollments'));
    }

    public function cancelPayment(Payment $payment)
    {
        if ($payment->user_id !== Auth::id()) {
            abort(403, 'Bạn không có quyền hủy thanh toán này.');
        }

        $payment->status = 'cancelled';
        $payment->save();

        Enrollment::where('user_id', Auth::id())
            ->where('course_id', $payment->course_id)
            ->update(['status' => 'cancelled']);

        return redirect()->back()->with('success', 'Thanh toán đã được hủy.');
    }

    public function buyAgain(Course $course)
    {
        $userId = Auth::id();

        // Tạo bản ghi thanh toán mới với trạng thái 'pending'
        $newPayment = Payment::create([
            'user_id' => $userId,
            'course_id' => $course->id,
            'amount' => $course->price,
            'payment_method' => 'buy_again',
            'status' => 'pending',
            'transaction_id' => uniqid(),
        ]);

        // Lưu payment_id vào session để sử dụng trong processPayment
        session(['payment_id' => $newPayment->id]);

        return redirect()->route('course.payment', ['slug' => $course->slug]);
    }

    public function enrollFreeCourse(Request $request, $slug)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để tham gia khóa học.');
        }

        $course = Course::where('slug', $slug)->firstOrFail();

        if (!$course->is_free) {
            return redirect()->route('course.payment', ['slug' => $course->slug])
                ->with('error', 'Khóa học này không miễn phí.');
        }

        $existingEnrollment = Enrollment::where('user_id', Auth::id())
            ->where('course_id', $course->id)
            ->where('status', 'active')
            ->exists();

        if ($existingEnrollment) {
            return redirect()->route('course.detail', ['slug' => $course->slug])
                ->with('error', 'Bạn đã tham gia khóa học này.');
        }

        $payment = Payment::create([
            'user_id' => Auth::id(),
            'course_id' => $course->id,
            'amount' => 0,
            'payment_method' => 'free', // Must match ENUM values in the payments table
            'status' => 'completed',
            'transaction_id' => uniqid(),
        ]);

        Log::info('Payment created: ' . json_encode($payment));

        $enrollment = Enrollment::create([
            'user_id' => Auth::id(),
            'course_id' => $course->id,
            'payment_id' => $payment->id,
            'status' => 'active',
            'enrolled_at' => now(),
        ]);

        Log::info('Enrollment created: ' . json_encode($enrollment));

        Enrollment::create([
            'user_id' => Auth::id(),
            'course_id' => $course->id,
            'payment_id' => $payment->id,
            'status' => 'active',
            'enrolled_at' => now(),
        ]);

        return redirect()->route('payment.success')
            ->with('success', 'Bạn đã tham gia khóa học miễn phí thành công.');
    }
}
