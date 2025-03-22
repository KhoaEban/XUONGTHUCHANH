<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Quản trị Admin')</title>

    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        * {
            text-decoration: none !important;
        }

        body {
            background-color: #e9e9e9;
        }
    </style>
</head>

<body>
    <div class="pusher">
        <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom ps-3" style="margin-left: 260px;">
            <a class="navbar-brand position-relative" href="#">
                <div class="d-flex align-items-center justify-content-center" style="position: absolute; top: 1px; right: 90px; font-size: 13px; font-weight: bold; background-color: red; border-radius: 50%; width: 18px; height: 18px; text-align: center; color: #ffffff">
                    <span>0</span>
                </div>
                <i class="fas fa-bell me-1"></i>
                Messages
            </a>

            <div class="collapse navbar-collapse justify-content-end">
                <!-- Dropdown Chọn Ngôn Ngữ -->
                <div class="dropdown me-3">
                    <button class="btn btn-light dropdown-toggle" type="button" id="languageDropdown"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Language
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="languageDropdown">
                        <li><a class="dropdown-item" href="#">English</a></li>
                        <li><a class="dropdown-item" href="#">Russian</a></li>
                        <li><a class="dropdown-item" href="#">Spanish</a></li>
                    </ul>
                </div>

                <!-- Dropdown Tài Khoản -->
                <div class="dropdown">
                    @if (Auth::check())
                        <button class="btn btn-light dropdown-toggle" type="button" id="accountDropdown"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Xin chào, {{ Auth::user()->name }}
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="accountDropdown">
                            @if (Auth::user()->role == 'admin')
                                <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                        <i class="fas fa-tachometer-alt"></i> Quản lý</a>
                                </li>
                            @endif
                            <li>
                                <a class="dropdown-item" href="#"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt"></i> Đăng xuất
                                </a>
                            </li>
                        </ul>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-primary me-2">Đăng nhập</a>
                        <a href="{{ route('register') }}" class="btn btn-primary">Đăng ký</a>
                    @endif
                </div>
            </div>
        </nav>
    </div>



    @include('layouts.sidebar_admin')



    <script>
        $(document).ready(function() {
            $('.ui.dropdown').dropdown(); // Kích hoạt dropdown Semantic UI
        });
    </script>
</body>

</html>
