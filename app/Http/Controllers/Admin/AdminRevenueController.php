<?php

namespace App\Http\Controllers\Admin;

use App\Models\Payment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\View\View; // Import View class (nếu bạn dùng type hinting)

class AdminRevenueController extends Controller
{
    public function index(Request $request): View // Sử dụng type hinting cho return (nếu dùng)
    {
        $query = Payment::query();

        // Lọc theo user_id (nếu có)
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Lọc theo course_id (nếu có)
        if ($request->filled('course_id')) {
            $query->where('course_id', $request->course_id);
        }

        // Xác định khoảng thời gian
        $startDate = $request->filled('start_date') ? Carbon::parse($request->start_date)->startOfDay() : Carbon::now()->startOfMonth();
        $endDate = $request->filled('end_date') ? Carbon::parse($request->end_date)->endOfDay() : Carbon::now()->endOfMonth();

        // Lọc theo khoảng thời gian
        $query->whereBetween('created_at', [$startDate, $endDate]);

        // Phân trang
        $payments = $query->paginate(10)->withQueryString(); // Quan trọng: Giữ lại query string

        // Tính toán số liệu thống kê
        $totalPayments = Payment::whereBetween('created_at', [$startDate, $endDate])->count();
        $successfulPayments = Payment::where('status', 'completed')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();
        $failedPayments = Payment::where('status', 'failed')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();
        $totalRevenue = Payment::where('status', 'completed')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('amount');

        // Lấy doanh thu theo ngày
        $revenueByDay = Payment::selectRaw('DATE(created_at) as transaction_date, SUM(amount) as daily_revenue')
            ->where('status', 'completed')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('transaction_date')
            ->orderBy('transaction_date', 'asc')
            ->get();

        return view('admin.revenue.index', compact(
            'payments',
            'totalPayments',
            'successfulPayments',
            'failedPayments',
            'totalRevenue',
            'revenueByDay'
        ));
    }
}
