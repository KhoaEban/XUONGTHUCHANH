<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Enrollment;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function updateStatus(Request $request, Payment $payment)
    {
       
        $request->validate([
            'enrollment_status' => 'required|in:active,pending,cancelled,failed',
        ]);

        $enrollment = Enrollment::where('user_id', $payment->user_id)
            ->where('course_id', $payment->course_id)
            ->first();

        if ($enrollment) {
          
            $enrollment->status = $request->enrollment_status;
            // Cập nhật trạng thái hiện có
           
            $enrollment->enrolled_at = now();
            $enrollment->save();

            return redirect()->back()->with('success', 'Trạng thái đăng ký bài học đã được cập nhật thành công.');
        } else {
            // Tạo mới nếu không tồn tại
            Enrollment::create([
                'user_id' => $payment->user_id,
                'course_id' => $payment->course_id,
                'status' => $request->enrollment_status,
                'enrolled_at' => now(),
            ]);

            return redirect()->back()->with('success', 'Đã tạo mới và cập nhật trạng thái đăng ký bài học thành công.');
        }
    }
}