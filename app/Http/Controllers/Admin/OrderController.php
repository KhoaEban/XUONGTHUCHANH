<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Enrollment;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $payments = Payment::with(['user', 'course', 'enrollment'])->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.orders.index', compact('payments'));
    }

    public function updateStatus(Request $request, Payment $payment)
    {
        $request->validate([
            'status' => 'required|in:pending,completed,failed,cancelled',
        ]);

        $payment->status = $request->status;
        $payment->save();

        if ($request->status === 'completed') {
            Enrollment::updateOrCreate(
                ['user_id' => $payment->user_id, 'course_id' => $payment->course_id],
                ['status' => 'active', 'enrolled_at' => now()]
            );
        } else if ($request->status === 'cancelled') {
            Enrollment::where('user_id', $payment->user_id)->where('course_id', $payment->course_id)->update(['status' => 'cancelled']);
        }

        return redirect()->back()->with('success', 'Trạng thái đơn hàng đã được cập nhật thành công.');
    }
}