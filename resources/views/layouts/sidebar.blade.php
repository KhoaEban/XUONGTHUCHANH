<div class="video-sidebar">
    <ul>
        <li>
            <a href="/" class="menu-item">
                <i class="fa fa-home"></i>
                <div>Trang chủ</div>
            </a>
        </li>
        <li>
            <a href="{{ route('user.support') }}" class="menu-item">
                <i class="fa fa-life-ring"></i>
                <div>Hỗ trợ</div>
            </a>
        </li>
        <li>
            <a href="{{ route('user.faq') }}" class="menu-item">
                <i class="fa fa-question-circle"></i>
                <div>Câu hỏi thường gặp</div>
            </a>
        </li>
        <li>
            <a href="{{ route('user.simulation') }}" class="menu-item">
                <i class="fa fa-flask"></i>
                <div>Thí nghiệm mô phỏng</div>
            </a>
        </li>
        <li>
            <a href="#" class="menu-item">
                <i class="fa fa-desktop"></i>
                <div>Học liệu tập huấn CM hè</div>
            </a>
        </li>
    </ul>
</div>

<style>
    .video-sidebar {
        width: 156px;
        position: absolute;
        /* Mặc định nằm dưới navbar */
        top: 70px;
        /* Điều chỉnh theo độ cao của navbar */
        left: 0;
        background-color: #f8f8f8;
        border-right: 1px solid #ddd;
        padding: 0 0;
        height: calc(100vh - 56px);
        transition: all 0.3s ease-in-out;
    }

    .video-sidebar.fixed {
        position: fixed;
        /* Khi cuộn xuống thì cố định */
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
