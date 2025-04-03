<?php

namespace App\Http\Controllers\Admin;

use App\Models\Payment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
class AdminRevenueController extends Controller
{
    // Trang tổng quan doanh thu
    public function index(Request $request)
{
    $query = Payment::query();

    // Tìm kiếm theo người dùng
    if ($request->has('user_id') && $request->user_id != '') {
        $query->where('user_id', $request->user_id);
    }

    // Tìm kiếm theo khóa học
    if ($request->has('course_id') && $request->course_id != '') {
        $query->where('course_id', $request->course_id);
    }

    // Tìm kiếm theo ngày (từ ngày đến ngày)
    if ($request->has('start_date') && $request->has('end_date')) {
        $startDate = Carbon::parse($request->start_date)->startOfDay();
        $endDate = Carbon::parse($request->end_date)->endOfDay();
    } else {
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();
    }

    // Lấy danh sách giao dịch có phân trang
    $payments = $query->whereBetween('created_at', [$startDate, $endDate])->paginate(10);

    // **Tính toán tổng hợp dữ liệu trên toàn bộ bảng Payment**
    $totalPayments = Payment::whereBetween('created_at', [$startDate, $endDate])->count();
    $successfulPayments = Payment::where('status', 'success')
        ->whereBetween('created_at', [$startDate, $endDate])->count();
    $failedPayments = Payment::where('status', 'failed')
        ->whereBetween('created_at', [$startDate, $endDate])->count();
    $totalRevenue = Payment::where('status', 'success')
        ->whereBetween('created_at', [$startDate, $endDate])->sum('amount');

    return view('admin.revenue.index', compact(
        'payments',
        'totalPayments',
        'successfulPayments',
        'failedPayments',
        'totalRevenue'
    ));
}

}
