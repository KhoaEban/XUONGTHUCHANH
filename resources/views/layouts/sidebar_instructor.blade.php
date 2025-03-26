<div class="edu-sidebar">
    <ul>
        <li class="dropdown">
            <a href="#" class="menu-item">
                <i class="fa fa-user-graduate"></i>
                <div>Quản lý học viên</div>
                <i class="fa fa-chevron-down"></i>
            </a>
        </li>
        <li class="dropdown">
            <a href="#" class="menu-item">
                <i class="fa fa-building"></i>
                <div>Quản lý Khóa Học</div>
                <i class="fa fa-chevron-down"></i>
            </a>
            <ul class="submenu">
                <li>
                    <a href="{{ route('instructor.courses.index') }}">
                        <i class="fa fa-list"></i> Danh sách khóa học
                    </a>
                </li>
                <li>
                    <a href="{{ route('instructor.courses.create') }}">
                        <i class="fa fa-plus"></i> Thêm khóa học
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</div>




<style>
    .edu-sidebar {
        width: 250px;
        background-color: #0A2647;
        color: white;
        position: absolute;
        top: 70px;
        left: 0;
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
