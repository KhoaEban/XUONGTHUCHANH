<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Hồ sơ')</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        /* Định dạng màu gradient nền */
        .navbar-custom {
            background: linear-gradient(to right, #008040, #0099cc);
            padding: 10px 0;
        }

        /* Định dạng logo */
        .navbar-brand img {
            height: 40px;
        }

        /* Ô tìm kiếm */
        .search-box {
            flex: 1;
            display: flex;
            align-items: center;
        }

        .search-box input {
            width: 100%;
            padding: 8px 15px;
            border: none;
            border-radius: 20px 0 0 20px;
        }

        .search-btn {
            padding: 8px 12px;
            font-size: 14px;
            background-color: #d9dbd9;
            color: black;
            border: none;
            width: 115px;
            height: 40px;
            border-radius: 0 20px 20px 0;

        }

        .search-adv {
            padding: 8px 12px;
            font-size: 14px;
            background-color: #d9dbd9;
            color: black;
            border: none;
            height: 40px;
            border-radius: 20px;
        }

        .icon {
            width: 40px;
            height: 40px;
            background-color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .icon i {
            font-size: 18px;
            color: #333;
        }

        /* Navbar bên phải */

        /* Nút đăng nhập */
        .login-btn {
            display: flex;
            align-items: center;
            background-color: #28a745;
            color: white;
            padding: 8px 15px;
            border-radius: 20px;
            text-decoration: none;
        }

        .login-btn i {
            margin-right: 5px;
        }

        /* Nút điều hướng slider */
        .tag-slider-prev,
        .tag-slider-next {
            position: absolute;
            transform: translateY(-200%);
            width: 40px;
            height: 40px;
            background: #ddd;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .tag-slider-prev {
            left: 170px;
            /* Điều chỉnh vị trí bên trái */
        }

        .tag-slider-next {
            right: 13px;
            /* Điều chỉnh vị trí bên phải */
        }

        .tag-slider-prev:hover,
        .tag-slider-next:hover {
            background: #bbb;

        }

        .tag-slider {
            display: flex;
            overflow-x: auto;
            white-space: nowrap;
            padding: 10px;
            width: 1700px;
            margin: 0 auto;
            margin-bottom: 16px;
        }

        .tag-slider li {
            display: inline-block;
            margin-right: 10px;
        }

        .tag-slider a {
            display: flex;
            align-items: center;
            height: 40px;
            padding: 0 15px;
            border: 1px solid #d8d8d8;
            border-radius: 99px;
            font-weight: 400;
            font-size: 13px;
            text-decoration: none;
            color: #333;
        }

        .slider-btn {
            cursor: pointer;
            display: inline-block;
        }

        /* Ẩn thanh tìm kiếm trên mobile */
        @media (max-width: 768px) {
            .search-box {
                display: none;
            }

            /* Căn giữa lại nút slider */
            .tag-slider-prev,
            .tag-slider-next {
                width: 30px;
                height: 30px;
                font-size: 12px;
                transform: translateY(-50%);
            }

            .tag-slider-prev {
                left: 10px;
            }

            .tag-slider-next {
                right: 10px;
            }

            /* Hiển thị slider có thể cuộn */
            .tag-slider {
                overflow-x: auto;
                flex-wrap: nowrap;
                -webkit-overflow-scrolling: touch;
                scroll-behavior: smooth;
            }

            .tag-slider a {
                font-size: 12px;
                padding: 5px 10px;
            }

            /* Điều chỉnh lại icon */
            .icon-container {
                gap: 5px;
            }

            .icon-container .icon {
                width: 30px;
                height: 30px;
            }

            /* Định dạng lại nút đăng nhập */
            .login-btn {
                padding: 5px 10px;
                font-size: 12px;
            }
        }

        /* footer */
        footer {
            padding: 40px 10%;
            color: #1a1a1a;
            font-family: Arial, sans-serif;
        }

        .footer-container {
            display: flex;
            justify-content: space-between;
            text-align: center;
        }

        .footer-section {
            width: 30%;
        }

        .footer-logo {
            max-width: 80px;
            margin-bottom: 10px;
        }

        .footer-links {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ccc;
        }

        .footer-column {
            width: 30%;
        }

        .footer-column h4 {
            font-size: 16px;
            margin-bottom: 10px;
            font-weight: bold;
        }

        .footer-column ul {
            list-style: none;
        }

        .footer-column ul li {
            margin: 5px 0;
        }

        .footer-column ul li a {
            text-decoration: none;
            color: #1a1a1a;
            transition: 0.3s;
        }

        .footer-column ul li a:hover {
            color: #0056b3;
        }

        .app-links img {
            width: 120px;
            margin-top: 10px;
        }

        .footer-bottom {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ccc;
            font-size: 14px;
        }

        .social-icons img {
            width: 30px;
            margin-left: 10px;
        }

        /* Định dạng cho sidebar */
        .sidebar {
            height: 100vh;
            /* Chiều cao 100% của viewport */
            background-color: #f8f9fa;
            /* Màu nền cho sidebar */
            padding: 20px;
            /* Padding cho sidebar */
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            /* Đổ bóng cho sidebar */
        }

        /* Định dạng cho các liên kết trong sidebar */
        .sidebar a {
            color: #333;
            /* Màu chữ */
            text-decoration: none;
            /* Bỏ gạch chân */
            padding: 10px 15px;
            /* Padding cho các liên kết */
            display: block;
            /* Hiển thị dưới dạng block */
            border-radius: 5px;
            /* Bo góc cho các liên kết */
            transition: background-color 0.3s;
            /* Hiệu ứng chuyển màu nền */
        }

        /* Hiệu ứng hover cho các liên kết */
        .sidebar a:hover {
            background-color: #e2e6ea;
            /* Màu nền khi hover */
        }

        /* Định dạng cho nội dung chính */
        .content {
            flex-grow: 1;
            /* Chiếm không gian còn lại */
            padding: 20px;
            /* Padding cho nội dung chính */
            background-color: #ffffff;
            /* Màu nền cho nội dung chính */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            /* Đổ bóng cho nội dung chính */
            border-radius: 5px;
            /* Bo góc cho nội dung chính */
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand m-0" href="{{ url('/') }}">
                <img class="img-fluid rounded" src="{{ asset('image/images.png') }}" alt="Logo">
            </a>

            <div class="search-box d-flex justify-content-center gap-5">
                <div class="d-flex align-items-center" style="width: 1000px">
                    <input type="text" placeholder="Tìm kiếm" class="form-control">
                    <button class="search-btn btn btn-light" type="submit"><i class="fas fa-search"></i> Tìm
                        kiếm</button>
                </div>
            </div>

            <div class="d-flex align-items-center">
                <div class="icon me-3"><i class="fas fa-th"></i></div>
                <div class="icon me-3"><i class="fas fa-bell"></i></div>

                @if (Auth::check())
                    <div class="dropdown">
                        <a class="btn btn-light dropdown-toggle" href="#" role="button" id="userDropdown"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Xin chào, {{ Auth::user()->name }}
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            @if (Auth::user()->role == 'admin')
                                <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}"><i
                                            class="fas fa-tachometer-alt"></i> Quản lý</a></li>
                            @else
                                <li>
                                    <a class="dropdown-item" href="{{ route('user.payment.history') }}">
                                        <i class="fas fa-user"></i> Hồ sơ
                                    </a>
                                </li>
                            @endif
                            <li>
                                <a class="dropdown-item" href="#"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt"></i> Đăng xuất
                                </a>
                            </li>
                        </ul>
                    </div>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-light me-2">Đăng nhập</a>
                    <a href="{{ route('register') }}" class="btn btn-primary">Đăng ký</a>
                @endif
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="d-flex">
            <div class="sidebar">
                <h6 class="text-lg mt-4"><img style="width: 30px; height: 30px; object-fit: cover; border-radius: 50%" src="{{ asset(Auth::user()->avatar) }}" alt="Avatar">
                    {{ Auth::user()->name }}</h6>
                <ul class="list-unstyled">
                    <li><a href="{{ route('user.profile') }}" class="d-block py-2">Hồ sơ</a></li>
                    <li><a href="{{ route('user.payment.history') }}" class="d-block py-2">Lịch sử đơn hàng</a></li>
                    <li><a href="{{ route('user.profile.edit') }}" class=" d-block py-2">Cài đặt hồ sơ</a></li>
                    <li><a href="{{ route('logout') }}" class="d-block py-2 text-danger">Đăng xuất</a></li>
                </ul>
            </div>

            <div class="flex-grow-1 m-4">
                @yield('content')
            </div>
        </div>
    </div>

</body>

</html>

@if (session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Thành công!',
            text: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 2000
        });
    </script>
@endif

@if (session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Lỗi!',
            text: "{{ session('error') }}",
            showConfirmButton: false,
            timer: 2000
        });
    </script>
@endif
