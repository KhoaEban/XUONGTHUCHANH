@extends('layouts.sidebar_profile')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Thông tin cá nhân</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="text-center">
                            <h5 class="card-title">Thông tin người dùng</h5>
                            <p><img src="{{ asset($user->avatar) }}" alt="Avatar" style="border-radius: 50%; object-fit: cover;" width="100" height="100"></p>
                            <p><strong>Tên:</strong> {{ $user->name }}</p>
                            <p><strong>Email:</strong> {{ $user->email }}</p>
                            <p><strong>Số điện thoại:</strong> {{ $user->phone ?? 'Chưa cập nhật' }}</p>
                            <p><strong>Địa chỉ:</strong> {{ $user->address ?? 'Chưa cập nhật' }}</p>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <h5 class="mt-4">Thông tin thanh toán</h5>
                                @if ($payments->isEmpty())
                                    <p>Chưa có thông tin thanh toán.</p>
                                @else
                                    <ul class="list-group">
                                        @foreach ($payments as $payment)
                                            <li class="list-group-item">
                                                {{-- <strong>Ngày thanh toán:</strong> {{ $payment->created_at->format('d/m/Y') }}<br> --}}
                                                <strong>Số tiền:</strong> {{ number_format($payment->amount, 0, ',', '.') }}
                                                VNĐ
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                            <div class="col-6">
                                <h5 class="mt-4">Khóa học đã đăng ký</h5>
                                @if ($enrollments->isEmpty())
                                    <p>Chưa có khóa học nào được đăng ký.</p>
                                @else
                                    <ul class="list-group">
                                        @foreach ($enrollments as $enrollment)
                                            <li class="list-group-item">
                                                <strong>Khóa học:</strong> {{ $enrollment->course->title }}<br>
                                                {{-- <strong>Ngày đăng ký:</strong> {{ $enrollment->created_at->format('d/m/Y') }} --}}
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>


                        <h5 class="mt-4">Kết quả Quiz</h5>
                        @if ($quizResults->isEmpty())
                            <p>Chưa có kết quả quiz nào.</p>
                        @else
                            <ul class="list-group">
                                @foreach ($quizResults as $result)
                                    <li class="list-group-item">
                                        <strong>Quiz:</strong> {{ $result->quiz->title }}<br>
                                        <strong>Điểm:</strong> {{ $result->score }}<br>
                                        {{-- <strong>Ngày làm:</strong> {{ $result->created_at->format('d/m/Y') }} --}}
                                    </li>
                                @endforeach
                            </ul>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<style>
    .card {
        border: 1px solid #dee2e6;
        /* Đường viền cho card */
        border-radius: 0.5rem;
        /* Bo góc cho card */
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        /* Đổ bóng cho card */
    }

    .card-header {
        background-color: #007bff;
        /* Màu nền cho header */
        color: white;
        /* Màu chữ cho header */
    }

    .list-group-item {
        border: 1px solid #dee2e6;
        /* Đường viền cho các mục trong danh sách */
        border-radius: 0.25rem;
        /* Bo góc cho các mục trong danh sách */
        margin-bottom: 0.5rem;
        /* Khoảng cách giữa các mục */
    }

    .btn-primary {
        background-color: #007bff;
        /* Màu nền cho nút */
        border-color: #007bff;
        /* Màu viền cho nút */
    }

    .btn-primary:hover {
        background-color: #0056b3;
        /* Màu nền khi hover */
        border-color: #0056b3;
        /* Màu viền khi hover */
    }

    h5 {
        margin-top: 1.5rem;
        /* Khoảng cách trên cho tiêu đề */
        color: #343a40;
        /* Màu chữ cho tiêu đề */
    }
</style>

