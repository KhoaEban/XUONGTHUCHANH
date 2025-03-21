<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header LMS360</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

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
            background-image: url(image/footer-background.png);
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
    </style>
</head>

<body>
    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container-fluid">
            {{-- Menu responsive bên trái --}}
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Logo -->
            <a class="navbar-brand m-0" href="{{ route('home') }}">
                <img class="img-fluid rounded" src="{{ asset('image/images.png') }}" alt="Logo">
            </a>

            <!-- Thanh tìm kiếm -->
            <div class="search-box d-flex justify-content-center gap-5">
                <div class="d-flex align-items-center" style="width: 1000px">
                    <input type="text" placeholder="Tìm kiếm">
                    <button class="search-btn" type="submit"><i class="fas fa-search"></i> Tìm kiếm</button>
                </div>
                {{-- <button class="search-adv btn btn-light" type="submit">Tìm kiếm nâng cao</button> --}}
            </div>

            <!-- Icon bên phải -->
            <div class="d-flex align-items-center ms-3">
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
                                @if (Auth::user()->role == 'teacher')
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <i class="fas fa-tachometer-alt"></i> Quản lý
                                        </a>
                                        <a class="dropdown-item" href="#">
                                            {{-- icon hồ sơ --}}
                                            <i class="fas fa-user"></i> Hồ sơ
                                        </a>
                                    </li>
                                @else
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            {{-- icon hồ sơ --}}
                                            <i class="fas fa-user"></i> Hồ sơ
                                        </a>
                                    </li>
                                @endif
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

    

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar bên trái -->
            <div class="col-md-1 col-lg-1 p-0 bg-light sidebar">
                @extends('layouts.sidebar')
            </div>

            <!-- Nội dung chính -->
            <div class="col-md-7 col-lg-11 main-content">
                @yield('content')
            </div>
        </div>
    </div>
    <br>
    <br>
    <br>





    {{-- Footer --}}
    <hr class="my-4" style="border: 1px dashed #000000; ">
    <footer>
        <div class="footer-container">
            <div class="footer-section">
                <img src="{{ asset('image/logo-trung-tam-giao-duc-setdc.png') }}" alt="Logo 1" class="footer-logo">
                <h3>TRUNG TÂM PHÁT TRIỂN GDĐT PHÍA NAM</h3>
                <p>BỘ GIÁO DỤC VÀ ĐÀO TẠO</p>
                <p>ĐỐI TÁC NGHIÊN CỨU, ỨNG DỤNG KHCN VÀ CHUYỂN ĐỔI SỐ</p>
            </div>

            <div class="footer-section">
                <img src="{{ asset('image/logo-khong-nen---color.png') }}" alt="Logo 2" class="footer-logo">
                <p>TẬP ĐOÀN KHOA HỌC CÔNG NGHỆ BÁCH KHOA</p>
                <p>Địa chỉ: Số 3 Công Trường Quốc Tế, Quận 3, TPHCM</p>
                <p>Điện thoại: (0287)102 0246 - 090 303 0246</p>
            </div>

            <div class="footer-section">
                <img src="{{ asset('image/logo-stb.png') }}" alt="Logo 3" class="footer-logo">
                <h3>CÔNG TY CỔ PHẦN SÁCH VÀ THIẾT BỊ TRƯỜNG HỌC TPHCM</h3>
                <p>ĐƠN VỊ CUNG CẤP HỌC LIỆU SỐ BẢN QUYỀN</p>
            </div>
        </div>

        <div class="footer-links">
            <div class="footer-column">
                <h4>BACH KHOA TECH GROUP</h4>
                <ul>
                    <li><a href="#">Giới thiệu</a></li>
                    <li><a href="#">Tầm nhìn - Sứ mệnh</a></li>
                    <li><a href="#">Khách hàng tiêu biểu</a></li>
                    <li><a href="#">Tin tức</a></li>
                    <li><a href="#">Tuyển dụng</a></li>
                    <li><a href="#">Phân phối sản phẩm</a></li>
                    <li><a href="#">Liên hệ hỗ trợ</a></li>
                </ul>
                <div class="app-links">
                    <img src="appstore.png" alt="App Store">
                    <img src="googleplay.png" alt="Google Play">
                </div>
            </div>

            <div class="footer-column">
                <h4>CHUYỂN ĐỔI SỐ TRONG DẠY VÀ HỌC</h4>
                <ul>
                    <li><a href="#">Hệ thống Quản lý học tập LMS 360 e-Learning</a></li>
                    <li><a href="#">Hệ thống Ngân hàng học liệu số dùng chung</a></li>
                    <li><a href="#">Học liệu số bản quyền</a></li>
                    <li><a href="#">Phòng thí nghiệm mô phỏng</a></li>
                    <li><a href="#">Chatbot BKTech ứng dụng trí tuệ nhân tạo</a></li>
                    <li><a href="#">Hệ thống Kiểm tra đánh giá trực tuyến</a></li>
                    <li><a href="#">Phần mềm tạo học liệu số bảng trí tuệ nhân tạo</a></li>
                    <li><a href="#">Đào tạo nhân lực số</a></li>
                </ul>
            </div>

            <div class="footer-column">
                <h4>CHUYỂN ĐỔI SỐ TRONG QUẢN LÝ</h4>
                <ul>
                    <li><a href="#">Hệ thống Quản lý trường học</a></li>
                    <li><a href="#">Ứng dụng truyền thông nội bộ</a></li>
                    <li><a href="#">Học bạ số</a></li>
                    <li><a href="#">Sắp xếp Thời khóa biểu tự động</a></li>
                    <li><a href="#">Điểm danh thông minh với camera AI</a></li>
                    <li><a href="#">Hệ thống Kiểm định chất lượng Giáo dục</a></li>
                    <li><a href="#">Hệ thống Thi đua khen thưởng</a></li>
                    <li><a href="#">Hệ thống đánh giá và tự đánh giá</a></li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <p>Copyright ©2021 - Bản quyền thuộc Công Ty Cổ Phần Tập Đoàn Khoa Học Công Nghệ Bách Khoa</p>
            <div class="social-icons">
                <a href="#"><img src="facebook.png" alt="Facebook"></a>
                <a href="#"><img src="zalo.png" alt="Zalo"></a>
            </div>
        </div>
    </footer>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<script>
    document.querySelector('.tag-slider-next').addEventListener('click', function() {
        document.querySelector('.tag-slider').scrollBy({
            left: 200,
            behavior: 'smooth'
        });
    });

    document.querySelector('.tag-slider-prev').addEventListener('click', function() {
        document.querySelector('.tag-slider').scrollBy({
            left: -200,
            behavior: 'smooth'
        });
    });
</script>
