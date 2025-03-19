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
            padding: 10px 80px;
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

        .icon-container {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .icon-container .icon {
            width: 40px;
            height: 40px;
            background-color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .icon-container .icon i {
            font-size: 18px;
            color: #333;
        }

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

        .relative {
            width: 1500px;
            margin: 0 auto;
        }

        /* Nút điều hướng slider */
        .tag-slider-prev,
        .tag-slider-next {
            position: absolute;
            /* Canh giữa theo chiều dọc */
            transform: translateY(-200%);
            /* Đẩy lên đúng vị trí giữa */
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
            left: 200px;
            /* Điều chỉnh vị trí bên trái */
        }

        .tag-slider-next {
            right: 200px;
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
    </style>
</head>

<body>
    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container-fluid">
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
                <button class="search-adv btn btn-light" type="submit">Tìm kiếm nâng cao</button>
            </div>

            <!-- Icon bên phải -->
            <div class="icon-container">
                <div class="icon"><i class="fas fa-th"></i></div>
                <div class="icon"><i class="fas fa-bell"></i></div>
                <a href="#" class="login-btn"><i class="fas fa-user"></i> Đăng nhập</a>
            </div>
        </div>
    </nav>

    {{-- sidebar --}}
    @include('layouts.sidebar')


    <div class="relative">
        <ul class="tag-slider slick-slider">
            <div class="slick-list draggable">
                <div class="slick-track" style="opacity: 1; width: auto; transform: translate3d(0px, 0px, 0px);">
                    <li><a href="/ket-qua?c=0&s=28&t=">Hoạt động trải nghiệm</a></li>
                    <li><a href="/ket-qua?c=0&s=29&t=">Giáo dục thể chất</a></li>
                    <li><a href="/ket-qua?c=0&s=30&t=">Khoa học tự nhiên</a></li>
                    <li><a href="/ket-qua?c=0&s=31&t=">Giáo dục quốc phòng</a></li>
                    <li><a href="/ket-qua?c=0&s=32&t=">Kinh tế và pháp luật</a></li>
                    <li><a href="/ket-qua?c=0&s=35&t=">Lịch sử và Địa lí</a></li>
                    <li><a href="/ket-qua?c=0&s=36&t=">Âm nhạc và Mĩ thuật</a></li>
                    <li><a href="/ket-qua?c=0&s=37&t=">Tiếng Việt</a></li>
                    <li><a href="/ket-qua?c=0&s=38&t=">Giáo dục địa phương</a></li>
                    <li><a href="/ket-qua?c=0&s=39&t=">Hướng nghiệp</a></li>
                    <li><a href="/ket-qua?c=0&s=40&t=">Thể dục</a></li>
                    <li><a href="/ket-qua?c=0&s=33&t=">Môn khác</a></li>
                </div>
            </div>
        </ul>

        <!-- Nút điều hướng slider -->
        <div class="tag-slider-prev">
            <div class="slider-btn"><i class="fas fa-angle-left"></i></div>
        </div>
        <div class="tag-slider-next">
            <div class="slider-btn"><i class="fas fa-angle-right"></i></div>
        </div>
    </div>

    <div class="py-5">
        @yield('content')
    </div>

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
