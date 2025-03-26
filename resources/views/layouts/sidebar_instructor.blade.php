<div class="container-fluid">
    <div class="row">
        <div class="col-md-2 p-0">
            <div class="edu-sidebar">
                <ul>
                    <li class="dropdown">
                        <a class="menu-item">
                            <i class="fa fa-user-graduate"></i>
                            <div>Quản lý học viên</div>
                            <i class="fa fa-chevron-down"></i>
                        </a>
                        <ul class="submenu">
                            <li><a href="#">Danh sách học viên</a></li>
                            <li><a href="#">Thêm mới học viên</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a class="menu-item">
                            <i class="fa fa-building"></i>
                            <div>Quản lý Khóa Học</div>
                            <i class="fa fa-chevron-down"></i>
                        </a>
                        <ul class="submenu">
                            <li><a href="{{ route('instructor.courses.index') }}">Danh sách khóa học</a></li>
                            <li><a href="{{ route('instructor.courses.create') }}">Thêm mới khóa học</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a class="menu-item">
                            <i class="fa fa-book"></i>
                            <div>Quản lý bài học</div>
                            <i class="fa fa-chevron-down"></i>
                        </a>
                        <ul class="submenu">
                            <li><a href="{{ route('instructor.lesson.index') }}">Danh sách bài học</a></li>
                            <li><a href="{{ route('instructor.lesson.create') }}">Thêm mới bài học</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-md-10 content-wrapper p-0">
            <main class="main-content px-3" style="min-height: 50vh">
                @yield('content')
            </main>

            <br>
            <br>
            <br>
            {{-- Footer --}}
            <footer style="background-image: url({{ asset('image/footer-background.png') }});">
                <div class="footer-container">
                    <div class="footer-section">
                        <img src="{{ asset('image/logo-trung-tam-giao-duc-setdc.png') }}" alt="Logo 1"
                            class="footer-logo">
                        <h3>TRUNG TÂM PHÁT TRIỂN GDĐT PHÍA NAM</h3>
                        <p>BỘ GIÁO DỤC VÀ ĐÀO TẠO</p>
                        <p>ĐỐI TÁC NGHIÊN CỨU, ỨNG DỤNG KHCN VÀ CHUYỂN ĐỔI SỐ</p>
                    </div>

                    <div class="footer-section">
                        <img src="{{ asset('image/logo-khong-nen---color.png') }}" height="80" width="160"
                            alt="Logo 2" class="">
                        <h3>TẬP ĐOÀN KHOA HỌC CÔNG NGHỆ BÁCH KHOA</h3>
                        <p>Địa chỉ: Số 3 Công Trường Quốc Tế, Quận 3, TPHCM</p>
                        <p>Điện thoại: (0287)102 0246 - 090 303 0246</p>
                    </div>

                    <div class="footer-section">
                        <img src="{{ asset('image/logo-stb.png') }}" alt="Logo 3" class="footer-logo">
                        <h3>CÔNG TY CỔ PHẦN SÁCH VÀ THIẾT BỊ TRƯỜNG HỌC TPHCM</h3>
                        <p>ĐƠN VỊ CUNG CẤP HỌC LIỆU SỐ BẢN QUYỀN</p>
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
        </div>
    </div>
</div>


<style>
    .edu-sidebar {
        width: 317.484px;
        background-color: #0A2647;
        color: white;
        position: absolute;
        top: 70px;
        /* left: 0; */
        padding: 10px 0;
        height: calc(100vh - 56px);
        transition: all 0.3s ease-in-out;
        overflow-y: auto;
    }

    .edu-sidebar.fixed {
        position: fixed;
        top: 0;
        height: 100vh;
    }

    .edu-sidebar ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .edu-sidebar li {
        border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    }

    .edu-sidebar .menu-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        color: white;
        text-decoration: none;
        padding: 12px 15px;
        transition: 0.3s;
    }

    .edu-sidebar .menu-item:hover {
        background-color: #145DA0;
    }

    .edu-sidebar .submenu {
        display: none;
        background: #1A3B5D;
        padding-left: 20px;
    }

    .edu-sidebar .submenu li {
        padding: 8px 0;
    }

    .edu-sidebar .submenu a {
        color: white;
        text-decoration: none;
        display: block;
        padding: 8px 10px;
        transition: 0.3s;
    }

    .edu-sidebar .submenu a:hover {
        background: #367DBD;
    }

    .dropdown.active .submenu {
        display: block;
    }

    .dropdown .fa-chevron-down {
        transition: transform 0.3s;
    }

    .dropdown.active .fa-chevron-down {
        transform: rotate(180deg);
    }

    footer {}
</style>

<script>
    document.querySelectorAll('.dropdown').forEach(item => {
        item.addEventListener('click', function() {
            this.classList.toggle('active');
        });
    });

    window.addEventListener("scroll", function() {
        var sidebar = document.querySelector(".edu-sidebar");
        var navbarHeight = 70; // Điều chỉnh nếu navbar có độ cao khác
        if (window.scrollY > navbarHeight) {
            sidebar.classList.add("fixed");
        } else {
            sidebar.classList.remove("fixed");
        }
    });
</script>
