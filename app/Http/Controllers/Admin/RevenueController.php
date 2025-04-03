<?php

namespace App\Http\Controllers\Admin;

use App\Models\Payment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\Courses;
class RevenueController extends Controller // <--- Bổ sung class
{
    public function index(Request $request)
    {
        $query = Payment::query();
        
        // Lấy danh sách tất cả khóa học
        $courses = Course::all();  // Lấy tất cả khóa học
    
        // Lọc theo người dùng, khóa học, và ngày
        if ($request->has('user_id') && $request->user_id != '') {
            $query->where('user_id', $request->user_id);
        }
    
        if ($request->has('course_id') && $request->course_id != '') {
            $query->where('course_id', $request->course_id);
        }
    
        if ($request->has('start_date') && $request->has('end_date')) {
            $startDate = Carbon::parse($request->start_date)->startOfDay();
            $endDate = Carbon::parse($request->end_date)->endOfDay();
        } else {
            $startDate = Carbon::now()->startOfMonth();
            $endDate = Carbon::now()->endOfMonth();
        }
    
        // Lọc danh sách thanh toán có phân trang
        $payments = $query->whereBetween('created_at', [$startDate, $endDate])->paginate(10);
    
        // Tính toán tổng hợp dữ liệu
        $totalPayments = Payment::whereBetween('created_at', [$startDate, $endDate])->count();
        $successfulPayments = Payment::where('status', 'success')
            ->whereBetween('created_at', [$startDate, $endDate])->count();
        $failedPayments = Payment::where('status', 'failed')
            ->whereBetween('created_at', [$startDate, $endDate])->count();
        $totalRevenue = Payment::where('status', 'success')
            ->whereBetween('created_at', [$startDate, $endDate])->sum('amount');
    
        // Truyền dữ liệu vào view
        return view('admin.revenue.index', compact(
            'payments',
            'totalPayments',
            'successfulPayments',
            'failedPayments',
            'totalRevenue',
            'courses'  // Truyền danh sách khóa học vào view
        ));
    }
    
}