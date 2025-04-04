@extends('layouts.master_admin')

@section('title', 'Lịch sử đơn hàng')

@section('content')
    <div class="container-fluid">
        <h2 class="mt-4 mb-3">Lịch sử đơn hàng</h2>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Người dùng</th>
                    <th>Khóa học</th>
                    <th>Số tiền</th>
                    <th>Phương thức thanh toán</th>
                    <th>Trạng thái thanh toán</th>
                    <th>Trạng thái đăng ký bài học</th>
                    <th>Ngày đăng ký</th>
                    <th>Ngày thanh toán</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($payments as $key => $payment)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $payment->user->name }}</td>
                        <td>{{ $payment->course->title }}</td>
                        <td>{{ number_format($payment->amount, 0, ',', '.') }} VNĐ</td>
                        <td>{{ $payment->payment_method }}</td>
                        <td>
                            <form action="{{ route('admin.orders.updateStatus', $payment) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <select name="status" class="form-control form-control-sm">
                                    <option value="pending" {{ $payment->status === 'pending' ? 'selected' : '' }}>Chờ xử lý
                                    </option>
                                    <option value="completed" {{ $payment->status === 'completed' ? 'selected' : '' }}>Thành
                                        công</option>
                                    <option value="failed" {{ $payment->status === 'failed' ? 'selected' : '' }}>Thất bại
                                    </option>
                                    <option value="cancelled" {{ $payment->status === 'cancelled' ? 'selected' : '' }}>Đã
                                        hủy</option>
                                </select>
                                <button type="submit" class="btn btn-sm btn-primary mt-2">Cập nhật</button>
                            </form>
                        </td>
                        <td>
                            @if ($payment->enrollment)
                                <form action="{{ route('admin.enrollments.updateStatus', $payment->enrollment->id) }}"
                                    method="POST">
                                    @csrf
                                    @method('PUT')
                                    <select name="enrollment_status" class="form-control form-control-sm">
                                        <option value="active"
                                            {{ $payment->enrollment->status === 'active' ? 'selected' : '' }}>Đã đăng ký
                                        </option>
                                        <option value="pending"
                                            {{ $payment->enrollment->status === 'pending' ? 'selected' : '' }}>Chờ xử lý
                                        </option>
                                        <option value="cancelled"
                                            {{ $payment->enrollment->status === 'cancelled' ? 'selected' : '' }}>Đã hủy
                                        </option>
                                        <option value="failed"
                                            {{ $payment->enrollment->status === 'failed' ? 'selected' : '' }}>Thất bại
                                        </option>
                                    </select>
                                    <button type="submit" class="btn btn-sm btn-success mt-2">Cập nhật</button>
                                </form>
                            @else
                                <form action="{{ route('admin.enrollments.store') }}" method="POST">
                                    <!-- Sử dụng route để tạo mới -->
                                    @csrf
                                    <select name="enrollment_status" class="form-control form-control-sm">
                                        <option value="active">Đã đăng ký</option>
                                        <option value="pending">Chờ xử lý</option>
                                        <option value="cancelled">Đã hủy</option>
                                        <option value="failed">Thất bại</option>
                                    </select>
                                    <input type="hidden" name="payment_id" value="{{ $payment->id }}">
                                    <input type="hidden" name="course_id" value="{{ $payment->course_id }}">
                                    <button type="submit" class="btn btn-sm btn-success mt-2">Cập nhật</button>
                                </form>
                            @endif
                        </td>
                        <td>
                            @if ($payment->enrollment && $payment->enrollment->getFormattedEnrollmentDate())
                                {{ $payment->enrollment->getFormattedEnrollmentDate() }}
                            @else
                                Chưa có
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
