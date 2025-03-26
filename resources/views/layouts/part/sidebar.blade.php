<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Các bảng chọn</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Bảng chức năng</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    @auth
        @if (Auth::user()->vaitro == 'admin')
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                   aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Quản lý</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="{{ route('khoa.index') }}">
                            <i class="fas fa-university mr-2"></i> Khoa
                        </a>
                        <a class="collapse-item" href="{{ route('bomon.index') }}">
                            <i class="fas fa-building mr-2"></i> Bộ môn
                        </a>
                        <a class="collapse-item" href="{{ route('nganhhoc.index') }}">
                            <i class="fas fa-graduation-cap mr-2"></i> Ngành
                        </a>
                        <a class="collapse-item" href="{{ route('khoahoc.index') }}">
                            <i class="fas fa-calendar-alt mr-2"></i> Khóa học
                        </a>
                        <a class="collapse-item" href="{{ route('chuongtrinhdaotao.index') }}">
                            <i class="fas fa-book mr-2"></i> Chương trình đào tạo
                        </a>
                        <a class="collapse-item" href="{{ route('ctdthocphan.index') }}">
                            <i class="fas fa-layer-group mr-2"></i> CTĐT học phần
                        </a>
                        <a class="collapse-item" href="{{ route('khoikienthuc.index') }}">
                            <i class="fas fa-cubes mr-2"></i> Khối kiến thức
                        </a>
                        <a class="collapse-item" href="{{ route('hocphan.index') }}">
                            <i class="fas fa-book-reader mr-2"></i> Học phần
                        </a>
                        <a class="collapse-item" href="{{ route('loaihocphan.index') }}">
                            <i class="fas fa-tags mr-2"></i> Loại học phần
                        </a>
                        <a class="collapse-item" href="{{ route('decuongchitiet.index') }}">
                            <i class="fas fa-file-alt mr-2"></i> Đề cương chi tiết
                        </a>
                        {{-- <a class="collapse-item" href="{{ route('chuandaura.index') }}">
                            <i class="fas fa-clipboard-check"></i> Chuẩn đầu ra
                        </a> --}}
                    </div>
                </div>
            </li>

            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                   aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-users-cog"></i>
                    <span>Tài khoản người dùng</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                     data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Danh sách người dùng:</h6>
                        <a class="collapse-item" href="{{ route('users.index') }}">
                            <i class="fas fa-users mr-2"></i> Tổng
                        </a>
                        <a class="collapse-item" href="{{ route('users.index', ['vaitro' => 'admin']) }}">
                            <i class="fas fa-user-shield mr-2"></i> Admin
                        </a>
                        <a class="collapse-item" href="{{ route('users.index', ['vaitro' => 'biensoan']) }}">
                            <i class="fas fa-pencil-alt mr-2"></i> Ban biên soạn
                        </a>
                        <a class="collapse-item" href="{{ route('users.index', ['vaitro' => 'chunhiem']) }}">
                            <i class="fas fa-chalkboard-teacher mr-2"></i> Ban chủ nhiệm
                        </a>
                        <a class="collapse-item" href="{{ route('users.index', ['vaitro' => 'giangvien']) }}">
                            <i class="fas fa-user-graduate mr-2"></i> Giảng viên
                        </a>
                        <a class="collapse-item" href="{{ route('users.index', ['vaitro' => 'sinhvien']) }}">
                            <i class="fas fa-user mr-2"></i> Sinh viên
                        </a>
                    </div>
                </div>
            </li>
        @endif

        @if (Auth::user()->vaitro == 'sinhvien')
            <!-- Nav Item - Chương trình đào tạo -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('chuongtrinhdaotao.index') }}">
                    <i class="fas fa-fw fa-book"></i>
                    <span>Chương trình đào tạo</span>
                </a>
            </li>
        @endif
        @if (Auth::user()->vaitro == 'giangvien' || Auth::user()->vaitro == 'chunhiem')
        <!-- Nav Item - Chương trình đào tạo -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('chuongtrinhdaotao.index') }}">
                <i class="fas fa-fw fa-book"></i>
                <span>Chương trình đào tạo</span>
            </a>
            <a class="nav-link" href="{{ route('decuongchitiet.index') }}">
                <i class="fas fa-fw fa-book"></i>
                <span>Đề cương chi tiết</span>
            </a>
        </li>
        @endif
        @if (Auth::user()->vaitro == 'biensoan')
        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
               aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-cog"></i>
                <span>Quản lý</span>
            </a>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{ route('chuongtrinhdaotao.index') }}">Chương trình đào tạo</a>
                    <a class="collapse-item" href="{{ route('ctdthocphan.index') }}">CTDT học phần</a>
                    <a class="collapse-item" href="{{ route('khoikienthuc.index') }}">Khối kiến thức</a>
                    <a class="collapse-item" href="{{ route('hocphan.index') }}">Học phần</a>
                    <a class="collapse-item" href="{{ route('decuongchitiet.index') }}">Đề cương chi tiết</a>
                    <a class="collapse-item" href="{{ route('phancongmonhoc.index') }}">Phân công</a>
                    
                </div>
            </div>
        </li>
        @endif
    @endauth

    <!-- Divider -->
    <hr class="sidebar-divider">
</ul>
<!-- End of Sidebar -->
