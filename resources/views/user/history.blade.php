@extends('layouts.sidebar_profile')

@section('content')
<div class="container">
    <h2>Khóa Học Đã Mua</h2>

    <table class="table">
        <thead>
            <tr>
                <th>Khóa học</th>
                <th>Số tiền</th>
                <th>Phương thức thanh toán</th>
                <th>Trạng thái thanh toán</th>
                <th>Trạng thái đăng ký</th>
                <th>Ngày thanh toán</th>
                {{-- <th>Hành động</th> --}}
            </tr>
        </thead>
        <tbody>
            @foreach($payments as $payment)
            <tr>
                <td>{{ $payment->course->title }}</td>
                <td>{{ number_format($payment->amount) }} VNĐ</td>
                <td>{{ $payment->payment_method }}</td>
                <td>{{ $payment->status }}</td>
                <td>
                    @php
                    $enrollment = $enrollments->where('course_id', $payment->course_id)->first();
                    echo $enrollment ? $enrollment->status : 'Chưa đăng ký';
                    @endphp
                </td>
                <td>{{ $payment->created_at }}</td>
                {{-- <td>
                    @if($payment->status === 'completed')
                    <form action="{{ route('user.payment.cancel', $payment) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn hủy thanh toán?')">Hủy</button>
                    </form>
                    @elseif($payment->status === 'cancelled')
                    <form action="{{ route('user.payment.buy_again', $payment->course) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-sm">Mua lại</button>
                    </form>
                    @endif
                </td> --}}
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection