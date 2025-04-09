<?php

namespace App\Http\Controllers\Admin;

use App\Models\Payment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class AdminRevenueController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::query();

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

        $payments = $query->whereBetween('created_at', [$startDate, $endDate])->paginate(10);

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