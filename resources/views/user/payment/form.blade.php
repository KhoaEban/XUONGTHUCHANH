<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Thanh toán')</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

</head>

<body>
    {{-- Logo về trang chủ --}}
    <div class="container">
        <a href="{{ url('/') }}">
            <img src="{{ asset('image/logo.png') }}" alt="Logo" width="200">
        </a>
    </div>
    <div class="container mt-5 p-0">
        <div class="left-section">
            <div class="layoutss"></div>
            <div style="padding: 20px;">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <img height="50" src="{{ asset($course->thumbnail ?? 'images/default-thumbnail.jpg') }}"
                        style="border-radius: 50%; object-fit: cover;" width="50" alt="JavaScript Pro logo" />
                    <h1 class="m-0" style="font-size: 20px;">Khóa học {{ $course->title }}</h1>
                </div>
                <p style="font-size: 14px;">{{ $course->description }}</p>

                <h2 style="font-size: 14px;">Bạn nhận được gì từ khóa học này?</h2>
                <ul class="px-4">
                    @foreach ($course->lessons as $lesson)
                    <li style="font-size: 14px; list-style-type: disc;">{{ $lesson->title }}</li>
                    @endforeach
                </ul>
                <h2 style="font-size: 16px;" class="mt-4">Đánh giá khóa học</h2>
                @if ($course->reviews->count() > 0)
                @foreach ($course->reviews as $review)
                <div class="border p-2 rounded mb-2">
                    <strong>{{ $review->user->name }}</strong>
                    <span class="ms-2 text-warning">
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <=$review->rating)
                            ★
                            @else
                            ☆
                            @endif
                            @endfor
                    </span>
                    <p class="mb-0">{{ $review->content }}</p>
                    <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                </div>
                @endforeach
                @else
                <p class="text-muted">Chưa có đánh giá nào cho khóa học này.</p>
                @endif
            </div>

        </div>
        <div class="right-section" style="padding: 20px;">
            <h2>Chi tiết thanh toán</h2>
            <div class="price-details">
                <div>Khóa học {{ $course->title }}</div>
                <div class="original-price">Giá gốc: {{ number_format($course->price, 0, ',', '.') }} VNĐ</div>
                <div class="discounted-price">Giá ưu đãi hôm nay: <span
                        class="text-danger">{{ number_format($course->price, 0, ',', '.') }} VNĐ</span></div>
            </div>
            <div class="discount-code">
                <input placeholder="Nhập mã giảm giá" type="text" />
                <button>Áp dụng</button>
            </div>
            <div class="total d-flex justify-content-between">
                <p class="m-0">TỔNG:</p> <span class="text-danger">{{ number_format($course->price, 0, ',', '.') }}
                    VNĐ</span>
            </div>
            <form action="{{ route('course.payment.process', ['slug' => $course->slug]) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="payment_method" class="form-label">Phương thức thanh toán:</label>
                    <select name="payment_method" id="payment_method" class="select" required>
                        <option value="credit_card">Thẻ tín dụng</option>
                        <option value="paypal">PayPal</option>
                        <option value="momo">MoMo</option>
                        <option value="vnpay">VNPay</option> <!-- Add VNPay option -->
                    </select>
                </div>
                <button type="submit" class="checkout-button">
                    Mua khóa học
                </button>
            </form>
            {{-- <div class="safe-payment">
                    <i class="fas fa-lock"></i>
                    <span>Thanh toán an toàn với SePay</span>
                </div> --}}
        </div>
    </div>
</body>

</html>

<!-- Thêm CSS tùy chỉnh -->
<style>
    body {
        position: relative;
        min-height: 100vh;
        padding: 30px 0 200px;
        font-family: Lato, sans-serif;
        background: linear-gradient(rgba(51, 92, 153, 0.288), rgba(145, 79, 140, 0.288)), #fff;
        background-size: cover;
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-position: center;
        overflow: hidden;
    }

    .container {
        display: flex;
        border-radius: 8px;
        overflow: hidden;
        width: 1320px;
        transform: translate(0%, 25%);
    }

    .layoutss {
        position: absolute;
        z-index: -1;
        width: 100%;
        height: 100%;
    }

    .layoutss::before {
        content: "";
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        z-index: -2;
        background: #fff;
    }

    .layoutss::after {
        content: "";
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        z-index: -1;
        opacity: .08;
        background-image: radial-gradient(#ffffff40, #fff0 40%), radial-gradient(hsl(44, 100%, 66%) 30%, hsl(338, 68%, 65%), hsla(338, 68%, 65%, .4) 41%, transparent 52%), radial-gradient(hsl(272, 100%, 60%) 37%, transparent 46%), linear-gradient(155deg, transparent 65%, hsl(142, 70%, 49%) 95%), linear-gradient(45deg, #0065e0, #0f8bff);
        background-size: 200% 200%, 285% 500%, 285% 500%, cover, cover;
        background-position: bottom left, 109% 68%, 109% 68%, center, center;
    }

    .left-section {
        flex: 2;
        border-right: 2px dashed #e0e0e0;
        position: relative;
    }

    .right-section {
        flex: 1;
        background-color: #f9f9f9;
        position: relative;
    }

    .left-section h1 {
        font-size: 24px;
        margin-bottom: 10px;
    }

    .left-section p {
        font-size: 16px;
        margin-bottom: 20px;
    }

    .left-section ul {
        list-style: none;
        padding: 0;
    }

    .left-section ul li {
        font-size: 16px;
        margin-bottom: 10px;
    }

    .right-section h2 {
        font-size: 18px;
        margin-bottom: 20px;
    }

    .right-section .price-details {
        font-size: 16px;
        margin-bottom: 20px;
    }

    .right-section .price-details .original-price {
        text-decoration: line-through;
        color: #888;
    }

    .right-section .price-details .discounted-price {
        font-weight: bold;
        color: #333;
    }

    .right-section .discount-code {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
        height: 34px;
    }

    .right-section .discount-code input {
        flex: 1;
        padding: 10px;
        border: 1px solid #909090;
        border-radius: 5px;
        outline: none;
    }

    .right-section .discount-code input::placeholder {
        font-style: italic;
        font-size: 14px;
    }

    .right-section .discount-code input:focus {
        border-color: #0265dc;
    }

    .right-section .discount-code button {
        padding: 0px 24px;
        border: none;
        background: transparent;
        color: #0265dc;
        border: 1px solid #0265dc;
        border-radius: 50px;
        cursor: pointer;
    }

    .right-section .discount-code button:hover {
        background-color: #0056b3;
    }

    .right-section .total {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 20px;
    }

    .right-section .checkout-button {
        display: block;
        float: right;
        width: 170px;
        font-size: 14px;
        font-weight: 600;
        padding: 10px 24px;
        background-color: #007bff;
        color: white;
        text-align: center;
        border: none;
        border-radius: 50px;
        cursor: pointer;
        text-decoration: none;
    }

    .right-section .checkout-button:hover {
        background-color: #0056b3;
    }

    .right-section .safe-payment {
        display: flex;
        align-items: center;
        font-size: 14px;
        color: #888;
    }

    .right-section .safe-payment i {
        margin-right: 5px;
    }

    .close-button {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 20px;
        cursor: pointer;
    }

    .select {
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .select:focus {
        outline: none;
    }

    @media (max-width: 768px) {
        .container {
            flex-direction: column;
        }

        .left-section,
        .right-section {
            border-right: none;
            border-bottom: 1px solid #e0e0e0;
        }
    }
</style>
