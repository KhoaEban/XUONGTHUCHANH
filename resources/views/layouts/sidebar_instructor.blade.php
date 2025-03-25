<div class="video-sidebar">
    <ul>
        <li class="dropdown">
            <a href="#" class="menu-item">
                <i class="fa fa-user-graduate"></i>
                <div>Quản lý học sinh</div>
                <i class="fa fa-chevron-down"></i>
            </a>
            <ul class="submenu"></ul>
        </li>
        <li class="dropdown">
            <a href="#" class="menu-item">
                <i class="fa fa-building"></i>
                <div>Sở GD&ĐT TPHCM</div>
                <i class="fa fa-chevron-down"></i>
            </a>
            <ul class="submenu"></ul>
        </li>
        <li class="dropdown">
            <a href="#" class="menu-item">
                <i class="fa fa-school"></i>
                <div>Phòng GD&ĐT</div>
                <i class="fa fa-chevron-down"></i>
            </a>
            <ul class="submenu"></ul>
        </li>
        <li>
            <a href="#" class="menu-item">
                <i class="fa fa-chalkboard-teacher"></i>
                <div>Khóa học cộng đồng giáo viên</div>
            </a>
        </li>
        <li>
            <a href="#" class="menu-item">
                <i class="fa fa-tasks"></i>
                <div>Nhiệm vụ trường học</div>
            </a>
        </li>
        <li>
            <a href="#" class="menu-item">
                <i class="fa fa-file-alt"></i>
                <div>Duyệt học liệu số</div>
            </a>
        </li>
        <li>
            <a href="#" class="menu-item">
                <i class="fa fa-book"></i>
                <div>Kho học liệu</div>
            </a>
        </li>
        <li class="dropdown active">
            <a href="#" class="menu-item">
                <i class="fa fa-user"></i>
                <div>Cá nhân</div>
                <i class="fa fa-chevron-down"></i>
            </a>
            <ul class="submenu">
                <li><a href="#">Danh sách khóa học đã tạo</a></li>
            </ul>
        </li>
    </ul>
</div>

<style>
    .video-sidebar {
        width: 250px;
        background-color: #0A2647;
        color: white;
        padding: 10px 0;
        height: 100vh;
        position: fixed;
        left: 0;
        /* top: 0; */
        overflow-y: auto;
        height: calc(100vh - 56px);
        transition: all 0.3s ease-in-out;
    }

    .video-sidebar ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .video-sidebar li {
        border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    }

    .video-sidebar .menu-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        color: white;
        text-decoration: none;
        padding: 12px 15px;
        transition: 0.3s;
    }

    .video-sidebar .menu-item:hover {
        background-color: #145DA0;
    }

    .video-sidebar .submenu {
        display: none;
        background: #1A3B5D;
        padding-left: 20px;
    }

    .video-sidebar .submenu li {
        padding: 8px 0;
    }

    .video-sidebar .submenu a {
        color: white;
        text-decoration: none;
        display: block;
        padding: 8px 10px;
        transition: 0.3s;
    }

    .video-sidebar .submenu a:hover {
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
</style>

<script>
    document.querySelectorAll('.dropdown').forEach(item => {
        item.addEventListener('click', function() {
            this.classList.toggle('active');
        });
    });
</script>
