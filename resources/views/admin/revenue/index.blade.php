@extends('layouts.master_admin')

@section('title', 'Thống kê doanh thu')

@section('content')
    <div class="container-fluid">
        <h2 class="mt-4 mb-3">Thống kê doanh thu</h2>

        {{-- Bảng tổng hợp doanh thu --}}
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Tổng số giao dịch</th>
                    <th>Giao dịch thành công</th>
                    <th>Giao dịch thất bại</th>
                    <th>Tổng doanh thu</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $totalPayments }}</td>
                    <td>{{ $successfulPayments }}</td>
                    <td>{{ $failedPayments }}</td>
                    <td>{{ number_format($totalRevenue, 0, ',', '.') }} VNĐ</td>
                </tr>
            </tbody>
        </table>


        {{-- Bảng chi tiết giao dịch --}}
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Người dùng</th>
                    <th>Khóa học</th>
                    <th>Số tiền</th>
                    <th>Phương thức thanh toán</th>
                    <th>Trạng thái</th>
                    <th>Ngày thanh toán</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($payments as $key => $payment)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $payment->user->name ?? 'N/A' }}</td>
                        <td>{{ $payment->course->title ?? 'N/A' }}</td>
                        <td>{{ number_format($payment->amount, 0, ',', '.') }} VNĐ</td>
                        <td>{{ $payment->payment_method }}</td>
                        <td>
                            @if ($payment->status == 'success')
                                <span class="badge bg-success">Thành công</span>
                            @else
                                <span class="badge bg-danger">Thất bại</span>
                            @endif
                        </td>
                        <td>{{ $payment->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-center">
            {{ $payments->links() }}
        </div>
    </div>
@endsection
