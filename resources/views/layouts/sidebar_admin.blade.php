<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Course Management</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="admin-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <div class="logo">
                    <a href="{{ route('admin.dashboard') }}">
                        <img src="{{ asset('image/logo.png') }}" alt="Logo" class="logo-img">
                    </a>
                </div>
            </div>

            <div class="sidebar-menu">
                <div class="menu-item has-submenu">
                    <a href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i> Dashboard</a>
                </div>
                <div class="menu-item has-submenu">
                    <a href="#courseMenu" class="" data-bs-toggle="collapse" aria-expanded="false">
                        <i class="fas fa-book"></i> Khóa học
                        <i class="fas fa-chevron-down toggle-icon"></i>
                    </a>
                    <div class="collapse submenu" id="courseMenu">
                        <a href="{{ route('admin.courses.index') }}">Danh sách khóa học</a>
                        <a href="{{ route('admin.lessons.index') }}">Danh sách bài học</a>
                    </div>
                </div>

                <div class="menu-item has-submenu">
                    <a href="#quizMenu" class="" data-bs-toggle="collapse" aria-expanded="false">
                        <i class="fas fa-question-circle"></i> Quản lý Quizzes
                        <i class="fas fa-chevron-down toggle-icon"></i>
                    </a>
                    <div class="collapse submenu" id="quizMenu">
                        <a href="{{ route('admin.quizzes.index') }}">Quizzes</a>
                        <a href="{{ route('admin.questions.index') }}">Câu hỏi</a>
                        <a href="{{ route('admin.answers.index') }}">Câu trả lời</a>
                    </div>
                </div>

                <div class="menu-item has-submenu">
                    <a href="#userMenu" class="" data-bs-toggle="collapse" aria-expanded="false">
                        <i class="fas fa-users"></i> Quản lý người dùng
                        <i class="fas fa-chevron-down toggle-icon"></i>
                    </a>
                    <div class="collapse submenu" id="userMenu">
                        <a href="{{ route('admin.user.index') }}">Người dùng</a>
                        <a href="{{ route('admin.orders.index') }}">Quản lý đơn hàng</a>
                        <a href="{{ route('admin.comments.index') }}">Quản lý bình luận</a>
                    </div>
                </div>

                <div class="menu-item has-submenu">
                    <a href="{{ route('admin.category.index') }}"><i class="fas fa-folder"></i> Quản lý danh mục</a>
                </div>
            </div>

            <div class="sidebar-footer">
                <a href="{{ url('/') }}" class="back-home">
                    <i class="fas fa-arrow-left footer-icon"></i> <span>Quay lại trang chủ</span>
                </a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="topbar">
                <div class="topbar-left">
                    <button class="sidebar-toggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h4 class="page-title">Dashboard</h4>
                </div>
                <div class="topbar-right">
                    <div class="user-profile dropdown">
                        <a href="#" class="dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <img src="{{ asset(Auth::user()->avatar) }}" alt="User" class="avatar me-2">
                            <span>Admin</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#">Cài đặt</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item text-danger" href="{{ route('logout') }}">Đăng xuất</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="content">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle sidebar
        document.querySelector('.sidebar-toggle').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('collapsed');
            document.querySelector('.main-content').classList.toggle('expanded');
        });
    </script>
</body>

</html>

<style>
    /* CSS cho giao diện admin */
    .admin-container {
        display: flex;
        min-height: 100vh;
        background-color: #f5f6fa;
    }

    .sidebar {
        width: 260px;
        background: linear-gradient(180deg, #34495e 0%, #2c3e50 100%);
        color: white;
        position: fixed;
        height: 100vh;
        transition: width 0.3s ease;
    }

    .sidebar.collapsed {
        width: 80px;
    }

    .sidebar-header {
        padding: 20px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .logo {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .logo-img {
        width: 100%;
        transition: all 0.3s ease;
    }

    .sidebar.collapsed .logo-img {
        margin: 0 auto;
    }

    .logo-text {
        font-size: 20px;
        font-weight: 600;
    }

    .sidebar.collapsed .logo-text {
        display: none;
    }

    .sidebar-menu {
        padding: 15px 0;
    }

    .menu-item {
        padding: 0;
        transition: all 0.3s ease;
    }

    .menu-item a {
        color: white;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 20px;
    }

    .menu-item:hover {
        background-color: rgba(255, 255, 255, 0.1);
    }

    .menu-item.has-submenu .dropdown-toggle {
        position: relative;
    }

    .toggle-icon {
        position: absolute;
        right: 20px;
        transition: transform 0.3s ease;
    }

    .menu-item.has-submenu .dropdown-toggle[aria-expanded="true"] .toggle-icon {
        transform: rotate(180deg);
    }

    .submenu {
        background-color: rgba(0, 0, 0, 0.2);
    }

    .submenu a {
        display: block;
        padding: 10px 20px 10px 50px;
        color: #ddd;
        font-size: 14px;
    }

    .submenu a:hover {
        color: white;
        background-color: rgba(255, 255, 255, 0.05);
    }

    .sidebar.collapsed .submenu {
        display: none !important;
    }

    .sidebar.collapsed .menu-item a:not(.dropdown-toggle) {
        display: none;
    }

    .sidebar.collapsed .toggle-icon {
        display: none;
    }

    .sidebar-footer {
        padding: 20px;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        display: flex;
        justify-content: center;
    }

    .back-home {
        color: white;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 10px;
        transition: all 0.3s ease;
    }

    .footer-icon {
        font-size: 16px;
        transition: all 0.3s ease;
    }

    /* Khi sidebar thu gọn */
    .sidebar.collapsed .back-home {
        justify-content: center;
        padding: 10px;
    }

    .sidebar.collapsed .back-home span {
        display: none;
    }

    .sidebar.collapsed .footer-icon {
        font-size: 20px;
        border-radius: 10%;
        padding: 5px;
        border: 1px solid white;
    }
    
    .sidebar.collapsed .footer-icon:hover {
        background: white;
        color: #34495e;
    }

    .main-content {
        flex: 1;
        margin-left: 260px;
        padding: 20px;
        transition: margin-left 0.3s ease;
    }

    .main-content.expanded {
        margin-left: 80px;
    }

    .topbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 25px;
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        margin-bottom: 20px;
    }

    .topbar-left {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .sidebar-toggle {
        border: none;
        background: none;
        font-size: 20px;
        cursor: pointer;
        color: #34495e;
    }

    .page-title {
        margin: 0;
        color: #2c3e50;
    }

    /* Style cho user-profile dropdown */
    .user-profile {
        position: relative;
    }

    .user-profile .dropdown-toggle {
        color: #2c3e50;
        text-decoration: none;
    }

    .user-profile .dropdown-toggle:hover {
        color: #1a252f;
    }

    .dropdown-menu {
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        border: none;
        margin-top: 10px;
    }

    .dropdown-item {
        padding: 10px 20px;
        font-size: 14px;
        color: #2c3e50;
    }

    .dropdown-item:hover {
        background-color: #f8f9fa;
        color: #1a252f;
    }

    .dropdown-divider {
        margin: 5px 0;
    }

    .dropdown-item.text-danger {
        color: #dc3545;
    }

    .dropdown-item.text-danger:hover {
        background-color: #f8d7da;
        color: #b02a37;
    }

    .avatar {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        object-fit: cover;
    }

    .content {
        background-color: white;
        padding: 25px;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        min-height: calc(100vh - 120px);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .sidebar {
            width: 80px;
        }

        .main-content {
            margin-left: 80px;
        }

        .logo-text,
        .submenu {
            display: none;
        }
    }
</style>

@if (session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Thành công!',
            text: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 2000
        });
    </script>
@endif

@if (session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Lỗi!',
            text: "{{ session('error') }}",
            showConfirmButton: false,
            timer: 2000
        });
    </script>
@endif

