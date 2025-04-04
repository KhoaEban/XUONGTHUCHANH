<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Payment;
use App\Models\Enrollment;

class EnrollmentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'enrollment_status' => 'required|in:active,pending,cancelled,failed',
            'payment_id' => 'required|exists:payments,id', // Kiểm tra payment_id
            'course_id' => 'required|exists:courses,id', // Kiểm tra course_id
        ]);

        // Tạo mới enrollment
        Enrollment::create([
            'user_id' => Auth::user()->id, // Hoặc lấy từ payment nếu cần
            'course_id' => $request->course_id, // Lấy course_id từ request
            'payment_id' => $request->payment_id,
            'status' => $request->enrollment_status,
            'enrolled_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Đã tạo mới và cập nhật trạng thái đăng ký bài học thành công.');
    }

    public function updateStatus(Request $request, Payment $payment)
    {
        $request->validate([
            'enrollment_status' => 'required|in:active,pending,cancelled,failed',
        ]);

        $enrollment = Enrollment::where('user_id', $payment->user_id)
            ->where('course_id', $payment->course_id)
            ->first();

        if (!$payment->course_id) {
            return redirect()->back()->with('error', 'Payment không có course_id.');
        }

        if ($enrollment) {
            $enrollment->status = $request->enrollment_status;
            $enrollment->enrolled_at = now();
            $enrollment->save();

            return redirect()->route('admin.orders.index')->with('success', 'Trạng thái đăng ký bài học đã được cập nhật thành công.');
        } else {
            Enrollment::create([
                'user_id' => $payment->user_id,
                'course_id' => $payment->course_id,
                'payment_id' => $payment->id,
                'status' => $request->enrollment_status,
                'enrolled_at' => now(),
            ]);

            return redirect()->route('admin.orders.index')->with('success', 'Đã tạo mới và cập nhật trạng thái đăng ký bài học thành công.');
        }
    }
}
