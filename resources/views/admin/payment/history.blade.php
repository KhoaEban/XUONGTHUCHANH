@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Lịch Sử Thanh Toán</h2>

    <div class="mb-3">
        <form action="{{ route('admin.payment.history') }}" method="GET">
            <div class="row">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Tìm kiếm...">
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-control">
                        <option value="">Tất cả trạng thái</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Đang xử lý</option>
                        <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Thành công</option>
                        <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Thất bại</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary">Lọc</button>
                </div>
            </div>
        </form>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Người dùng</th>
                <th>Khóa học</th>
                <th>Số tiền</th>
                <th>Phương thức thanh toán</th>
                <th>Trạng thái thanh toán</th>
                <th>Trạng thái đăng ký</th>
                <th>Ngày thanh toán</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payments as $payment)
            <tr>
                <td>{{ $payment->user->name }}</td>
                <td>{{ $payment->course->title }}</td>
                <td>{{ number_format($payment->amount) }} VNĐ</td>
                <td>{{ $payment->payment_method }}</td>
                <td>{{ $payment->status }}</td>
                <td>{{ $payment->latestEnrollment ? $payment->latestEnrollment->status : 'N/A' }}</td>
                <td>{{ $payment->created_at }}</td>
                <td>
                    @if($payment->latestEnrollment)
                        <form action="{{ route('admin.enrollment.update_status', $payment->latestEnrollment) }}" method="POST">
                            @csrf
                            <select name="status" class="form-control form-control-sm">
                                <option value="pending" {{ $payment->latestEnrollment->status === 'pending' ? 'selected' : '' }}>Đang xử lý</option>
                                <option value="active" {{ $payment->latestEnrollment->status === 'active' ? 'selected' : '' }}>Hoạt động</option>
                                <option value="cancelled" {{ $payment->latestEnrollment->status === 'cancelled' ? 'selected' : '' }}>Hủy</option>
                            </select>
                            <button type="submit" class="btn btn-primary btn-sm">Cập nhật</button>
                        </form>
                    @else
                        N/A
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $payments->links() }}
</div>
@endsection