<div class="container-fluid">
    <div class="row">
        <div class="col-md-1 p-0">
            <div class="video-sidebar">
                <ul>
                    <li>
                        <a href="{{ url('/') }}" class="menu-item">
                            <i class="fa fa-home"></i>
                            <div>Trang chủ</div>
                        </a>
                    </li>
                    @if (Auth::check() && Auth::user()->role == 'instructor')
                        <li>
                            <a href="{{ route('instructor.dashboard') }}" class="menu-item">
                                <i class="fa fa-user-cog"></i>
                                <div>Chức năng</div>
                            </a>
                        </li>
                    @endif
                    <li>
                        <a href="{{ route('support') }}" class="menu-item">
                            <i class="fa fa-life-ring"></i>
                            <div>Hỗ trợ</div>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('faq') }}" class="menu-item">
                            <i class="fa fa-question-circle"></i>
                            <div>Câu hỏi thường gặp</div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-md-11 content-wrapper p-0">
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
    .video-sidebar {
        width: 158.734px;
        background-color: #f8f8f8;
        position: absolute;
        top: 70px;
        left: 0;
        padding: 0 0;
        height: calc(100vh - 56px);
        transition: all 0.3s ease-in-out;
    }

    .video-sidebar.fixed {
        position: fixed;
        top: 0;
        height: 100vh;
    }

    .video-sidebar ul {
        list-style: none;
        padding: 0;
        margin: 0;
        width: 100%;
    }

    .video-sidebar li {
        text-align: center;
        border-bottom: 1px solid #eee;
        width: 100%;
    }

    .video-sidebar .menu-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: black;
        text-decoration: none;
        transition: all 0.3s;
        padding: 15px 0;
        width: 100%;
    }

    .video-sidebar .menu-item img {
        height: 40px;
    }

    .video-sidebar .menu-item:hover {
        background-color: #dfe6ed;
    }

    .video-sidebar .menu-item.active {
        background-color: #008C72;
        color: white;
    }
</style>


<script>
    window.addEventListener("scroll", function() {
        var sidebar = document.querySelector(".video-sidebar");
        var navbarHeight = 70; // Điều chỉnh nếu navbar có độ cao khác
        if (window.scrollY > navbarHeight) {
            sidebar.classList.add("fixed");
        } else {
            sidebar.classList.remove("fixed");
        }
    });
</script>
