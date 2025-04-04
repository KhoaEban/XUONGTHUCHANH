@extends('layouts.master')

@section('content')
    <div class="container mt-5">
        <h3 class="text-center mb-4">Thanh toán khóa học: {{ $course->title }}</h3>
        
        <div class="card shadow-sm mx-auto" style="max-width: 500px;">
            <div class="card-body">
                <!-- Thông tin khóa học -->
                <div class="course-details text-center">
                    <img src="{{ asset($course->thumbnail ?? 'images/default-thumbnail.jpg') }}" 
                         alt="Thumbnail" 
                         class="img-fluid mb-3" 
                         style="max-width: 200px; border-radius: 10px; object-fit: cover;">
                    <p class="mb-2"><strong>Giá:</strong> {{ number_format($course->price, 0, ',', '.') }} VND</p>
                    <p class="mb-3"><strong>Số lượng bài học:</strong> {{ $course->lessons->count() }}</p>
                </div>

                <!-- Form thanh toán -->
                <form action="{{ route('course.payment.process', ['slug' => $course->slug]) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="payment_method" class="form-label">Phương thức thanh toán</label>
                        <select name="payment_method" id="payment_method" class="form-select" required>
                            <option value="credit_card">Thẻ tín dụng</option>
                            <option value="paypal">PayPal</option>
                            <option value="momo">MoMo</option>
                            <option value="vnpay">VNPay</option> <!-- Add VNPay option -->
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success btn-lg w-100">
                        <i class="fas fa-check-circle me-2"></i> Đăng ký khóa học
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Thêm CSS tùy chỉnh -->
    <style>
        .card {
            border: none;
            border-radius: 15px;
            transition: transform 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
            padding: 10px;
            font-size: 16px;
            border-radius: 10px;
        }
        .btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }
    </style>
@endsection