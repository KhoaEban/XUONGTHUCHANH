<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header LMS360</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.js"></script>
    <style>
        body {
            background-color: #f8f8f8;
        }
    </style>
</head>

<body>
    <div class="pusher">
        <div class="ui menu asd borderless"
            style="border-radius: 0!important; border: 0; margin-left: 260px; -webkit-transition-duration: 0.1s;">
            <a class="item openbtn">
                <i class="icon content"></i>
            </a>
            <a class="item">Messages</a>
            <div class="right menu">
                <div class="ui dropdown item">
                    Language <i class="dropdown icon"></i>
                    <div class="menu">
                        <a class="item">English</a>
                        <a class="item">Russian</a>
                        <a class="item">Spanish</a>
                    </div>
                </div>
                <div class="item">
                    @if (Auth::check())
                        <div class="ui dropdown">
                            <a class="ui light button" href="#">
                                Xin chào, {{ Auth::user()->name }} <i class="dropdown icon"></i>
                            </a>
                            <div class="menu">
                                @if (Auth::user()->role == 'admin')
                                    <a class="item" href="{{ route('admin.dashboard') }}"><i
                                            class="fas fa-tachometer-alt"></i> Quản lý</a>
                                @endif
                                <a class="item" href="#"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt"></i> Đăng xuất
                                </a>
                            </div>
                        </div>


                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="ui btn-outline-light button me-2">Đăng nhập</a>
                        <a href="{{ route('register') }}" class="ui primary button">Đăng ký</a>
                    @endif
                </div>
            </div>
        </div>
    </div>


    @include('layouts.sidebar_admin')



    <script>
        $(document).ready(function() {
            $('.ui.dropdown').dropdown(); // Kích hoạt dropdown Semantic UI
        });
    </script>
</body>

</html>
