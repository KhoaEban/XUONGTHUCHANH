@extends('layouts.master_admin')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between">
            <h2>Danh sách Người Dùng</h2>
            <div class="d-flex justify-content-between gap-2">
                <!-- Tìm kiếm -->
                <form action="{{ route('admin.user.index') }}" method="GET" class="d-flex align-items-center mb-3">
                    <input type="text" name="search" placeholder="Tìm kiếm tên/email" value="{{ request('search') }}"
                        class="d-inline w-auto"
                        style="border: none; border: 1px solid #6C757D; color: #000000; padding: 10px; font-size: 14px;"
                        onchange="this.form.submit()">
                </form>

                <!-- Form lọc vai trò (tự động submit) -->
                <form id="roleFilterForm" action="{{ route('admin.user.index') }}" method="GET"
                    class="d-flex align-items-center mb-3">
                    <select name="role" class="d-inline w-auto"
                        style="border: none; border: 1px solid #6C757D; color: #000000; padding: 10px; font-size: 14px;"
                        id="roleSelect">
                        <option value="">Tất cả vai trò</option>
                        <option value="student" {{ request('role') == 'student' ? 'selected' : '' }}>Học viên</option>
                        <option value="instructor" {{ request('role') == 'instructor' ? 'selected' : '' }}>Giảng viên
                        </option>
                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Quản trị viên</option>
                    </select>
                </form>
            </div>
        </div>

        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>ID</th>
                    <th>Tên</th>
                    <th>Email</th>
                    <th>Quyền</th>
                    <th>Ngày tham gia</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td><a href="{{ route('admin.user.edit', $user->id) }}">{{ $user->name }}</a></td>
                        <td>{{ $user->email }}</td>
                        <td>{{ ucfirst($user->role) }}</td>
                        <td>{{ $user->created_at ? $user->created_at->format('d/m/Y') : 'Chưa đăng nhập' }}</td>
                        <td>
                            <a href="{{ route('admin.user.edit', $user->id) }}" class="btn btn-sm btn-primary">Sửa</a>
                            <form action="{{ route('admin.user.delete', $user->id) }}" method="POST"
                                class="d-inline delete-user-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-end">
            {{ $users->links('pagination::bootstrap-5') }}
        </div>
    </div>

    <script>
        // Tự động submit form lọc vai trò
        document.getElementById("roleSelect").addEventListener("change", function() {
            document.getElementById("roleFilterForm").submit();
        });

        // Xác nhận trước khi xóa
        document.querySelectorAll('.delete-user-form').forEach(form => {
            form.addEventListener('submit', function(event) {
                event.preventDefault();
                if (confirm('Bạn có chắc chắn muốn xóa người dùng này không?')) {
                    this.submit();
                }
            });
        });
    </script>
@endsection
