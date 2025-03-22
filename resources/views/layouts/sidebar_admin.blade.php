<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-2 sidebar bg-light border-end">
            <div class="d-flex flex-column vh-100">
                <div class="p-3 text-center border-bottom">
                    <img src="{{ asset('image/images.png') }}" class="img-fluid" />
                </div>

                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-home"></i> Dashboard
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-dark collapsed" data-bs-toggle="collapse" href="#courseMenu">
                            <i class="fas fa-book"></i> Khóa học <i class="fas fa-chevron-down float-end"></i>
                        </a>
                        <div class="collapse" id="courseMenu">
                            <ul class="nav flex-column ps-3">
                                <li><a class="nav-link text-dark" href="{{ route('admin.course.index') }}">Danh sách khóa học</a></li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-dark" href="{{ route('admin.category.index') }}">
                            <i class="fas fa-folder"></i> Quản lý Danh mục
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-dark" href="{{ route('admin.user.index') }}">
                            <i class="fas fa-users"></i> Quản lý Người dùng
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Content -->
        <div class="col-md-10 content-wrapper py-5">
            @yield('content')
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll(".collapsed").forEach(item => {
            item.addEventListener("click", function() {
                this.querySelector("i.fas.fa-chevron-down").classList.toggle("rotate");
            });
        });
    });
</script>

<style>
    .sidebar {
        width: 260px;
        position: fixed;
        top: 0;
        left: 0;
        height: 100%;
        overflow: auto;
    }

    .content-wrapper {
        margin-left: 260px;
        width: calc(100% - 260px);
    }

    .nav-link {
        padding: 10px 15px;
    }

    .rotate {
        transform: rotate(180deg);
        transition: 0.3s;
    }
</style>
