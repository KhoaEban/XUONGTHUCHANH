<div class="video-sidebar">
    <ul>
        <li>
            <a href="{{ route('home') }}" class="menu-item">
                <i class="fa fa-home"></i>
                <div>Trang chủ</div>
            </a>
        </li>
        @if (Auth::user()->role == 'instructor')
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

<style>
    .video-sidebar {
        width: 156px;
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
