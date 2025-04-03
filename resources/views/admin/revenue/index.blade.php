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

        {{-- Bảng doanh thu theo ngày --}}
        <h3 class="mt-4 mb-3">Doanh thu theo ngày</h3>
        {{-- Form chọn khoảng thời gian --}}
        <form method="GET" action="{{ route('admin.revenue.index') }}" class="mb-4">
            <div class="row">
                <div class="col-md-3">
                    <label for="start_date">Từ ngày:</label>
                    <input type="date" name="start_date" id="start_date" class="form-control" value="{{ request('start_date') }}">
                </div>
                <div class="col-md-3">
                    <label for="end_date">Đến ngày:</label>
                    <input type="date" name="end_date" id="end_date" class="form-control" value="{{ request('end_date') }}">
                </div>
                <div class="col-md-3 align-self-end">
                    <button type="submit" class="btn btn-primary">Lọc</button>
                    <a href="{{ route('admin.revenue.index') }}" class="btn btn-secondary">Xóa bộ lọc</a>
                </div>
            </div>
        </form>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Ngày</th>
                    <th>Doanh thu</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($revenueByDay) && !$revenueByDay->isEmpty())
                    @foreach($revenueByDay as $revenue)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($revenue->transaction_date)->format('d/m/Y') }}</td>
                            <td>{{ number_format($revenue->daily_revenue, 0, ',', '.') }} VNĐ</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="2" class="text-center">Không có dữ liệu doanh thu trong khoảng thời gian này.</td>
                    </tr>
                @endif
            </tbody>
        </table>

        {{-- Bảng chi tiết giao dịch --}}
        <h3 class="mt-4 mb-3">Chi tiết giao dịch</h3>
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