@extends('layouts.sidebar_profile')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <span class="text-uppercase fw-bold text-white">Thông tin cá nhân</span>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="text-center">
                            <div class="row">
                                <div class="col-6 text-end px-5">
                                    <p>
                                        <img src="{{ asset($user->avatar) }}" alt="Avatar"
                                            style="border-radius: 5%; object-fit: cover;" width="200" height="200">
                                    </p>
                                </div>
                                <div class="col-6 text-start">
                                    <p><strong>Tên:</strong> {{ $user->name }}</p>
                                    <p><strong>Email:</strong> {{ $user->email }}</p>
                                    <p><strong>Số điện thoại:</strong> {{ $user->phone ?? 'Chưa cập nhật' }}</p>
                                    <p><strong>Địa chỉ:</strong> {{ $user->address ?? 'Chưa cập nhật' }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <h3 class="mt-4 mb-3">Khóa học đã đăng ký</h3>
                                @if ($enrollments->isEmpty())
                                    <p>Chưa có khóa học nào được đăng ký.</p>
                                @else
                                    <div id="enrollmentCarousel" class="carousel slide" data-bs-ride="carousel">
                                        <!-- Carousel Indicators -->
                                        <div class="carousel-indicators">
                                            @php
                                                $itemsPerSlide = 3; // Number of cards per slide
                                                $totalSlides = ceil($enrollments->count() / $itemsPerSlide);
                                            @endphp
                                            @for ($i = 0; $i < $totalSlides; $i++)
                                                <button type="button" data-bs-target="#enrollmentCarousel"
                                                    data-bs-slide-to="{{ $i }}"
                                                    class="{{ $i == 0 ? 'active' : '' }}"
                                                    aria-current="{{ $i == 0 ? 'true' : 'false' }}"
                                                    aria-label="Slide {{ $i + 1 }}"></button>
                                            @endfor
                                        </div>

                                        <!-- Carousel Items -->
                                        <div class="carousel-inner">
                                            @foreach ($enrollments->chunk($itemsPerSlide) as $key => $chunk)
                                                <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                                    <div class="d-flex">
                                                        @foreach ($chunk as $enrollment)
                                                            <div class="card mx-2" style="flex: 0 0 calc(33.33% - 16px);">
                                                                <!-- Course Image -->
                                                                @if ($enrollment->course && $enrollment->course->thumbnail)
                                                                    <img src="{{ asset($enrollment->course->thumbnail) }}"
                                                                        class="card-img-top"
                                                                        alt="{{ $enrollment->course->title }}"
                                                                        style="height: 150px; object-fit: cover;">
                                                                @else
                                                                    <img src="{{ asset('images/default-course.jpg') }}"
                                                                        class="card-img-top" alt="Default Course Image"
                                                                        style="height: 150px; object-fit: cover;">
                                                                @endif

                                                                <!-- Course Details -->
                                                                <div class="card-body">
                                                                    <h6 class="card-title">
                                                                        {{ $enrollment->course ? $enrollment->course->title : 'Khóa học không tồn tại' }}
                                                                    </h6>
                                                                    <p class="text-danger mb-1">
                                                                        {{ number_format($enrollment->course->price, 0, ',', '.') }}
                                                                        VNĐ
                                                                    </p>
                                                                    <p class="card-text" style="font-size: 0.9rem;">
                                                                        {{ $enrollment->getFormattedEnrollmentDate() ?? 'Chưa có ngày' }}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                        <!-- Carousel Controls -->
                                        <button class="carousel-control-prev" type="button"
                                            data-bs-target="#enrollmentCarousel" data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Previous</span>
                                        </button>
                                        <button class="carousel-control-next" type="button"
                                            data-bs-target="#enrollmentCarousel" data-bs-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Next</span>
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-6">
                                <h3 class="mt-4">Thông tin thanh toán</h3>
                                @if ($payments->isEmpty())
                                    <p>Chưa có thông tin thanh toán.</p>
                                @else
                                    <ul class="list-group">
                                        @foreach ($payments as $payment)
                                            <li class="list-group-item">
                                                <strong>Ngày thanh toán:</strong>
                                                {{ optional($payment->created_at)->format('d/m/Y') ?? 'Chưa có ngày' }}<br>
                                                <strong>Số tiền:</strong>
                                                {{ number_format($payment->amount, 0, ',', '.') }}
                                                VNĐ
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                            <div class="col-6">
                                <h3 class="mt-4">Kết quả Quiz</h3>
                                @if ($quizResults->isEmpty())
                                    <p>Chưa có kết quả quiz nào.</p>
                                @else
                                    <ul class="list-group">
                                        @foreach ($quizResults as $result)
                                            <li class="list-group-item">
                                                <strong>Quiz:</strong> {{ $result->quiz->title }}<br>
                                                <strong>Điểm:</strong> {{ $result->score }}<br>
                                                <strong>Ngày làm:</strong>
                                                {{ optional($result->created_at)->format('d/m/Y') ?? 'Chưa có ngày' }}
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<style>
    .carousel-inner {
        padding: 0 10px;
    }

    .carousel-item .card {
        margin: 0 8px;
        max-width: 100%;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .carousel-item .card:hover {
        transform: translateY(-5px);
    }

    .carousel-control-prev,
    .carousel-control-next {
        width: 7% !important;
        background: rgba(0, 0, 0, 0.1);
        border-radius: 50%;
        height: 40px;
        top: 50%;
        transform: translateY(200%);
    }

    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        background-color: #333;
        border-radius: 50%;
        background-size: 50% 50% !important;
    }

    .carousel-indicators {
        bottom: -40px;
    }

    .carousel-indicators button {
        background-color: #888;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        margin: 0 5px;
    }

    .carousel-indicators .active {
        background-color: #333;
    }

    .card {
        border: 1px solid #dee2e6;
        border-radius: 0.5rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .card-header {
        background: linear-gradient(to right, #4facfe, #00f2fe);
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

    @media (max-width: 768px) {
        .carousel-item .card {
            flex: 0 0 calc(50% - 16px);
            /* Show 2 cards per slide on smaller screens */
        }
    }

    @media (max-width: 576px) {
        .carousel-item .card {
            flex: 0 0 calc(100% - 16px);
            /* Show 1 card per slide on very small screens */
        }
    }
</style>
