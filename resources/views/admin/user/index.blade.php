@extends('layouts.master_admin')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between mb-3">
            <a href="#" class=""
                style="border: none; background-color: #2185D0; color: white; padding: 10px; font-size: 16px; font-weight: bold;">Thêm
                Người Dùng</a>
        </div>

        <div class="d-flex justify-content-between">
            <h2 class="">Danh sách Người Dùng</h2>
            <div>
                <form action="" method="">
                    <select class="d-inline w-auto"
                        style="border: none; border: 1px solid #6C757D; color: #000000; padding: 7px; font-size: 14px;">
                        <option value="">Bulk Actions</option>
                        <option value="delete">Delete</option>
                    </select>
                    <button type="submit"
                        style="border: none; background-color: #6C757D; color: white; padding: 7px; font-size: 14px;">Apply</button>
                </form>
            </div>
        </div>

        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th><input type="checkbox" id="select-all"></th>
                    <th>ID</th>
                    <th>Tên</th>
                    <th>Email</th>
                    <th>Quyền</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td><input type="checkbox" class="user-checkbox"></td>
                        <td>{{ $user->id }}</td>
                        <td><a href="#">{{ $user->name }}</a></td>
                        <td>{{ $user->email }}</td>
                        <td>{{ ucfirst($user->role) }}</td>
                        <td>
                            <a href="#" class="btn btn-sm btn-primary">Sửa</a>
                            <form action="#" method="POST" style="display: inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Phân trang -->
        <div class="d-flex justify-content-end">
            {{ $users->links() }}
        </div>
    </div>

    <script>
        // Chọn tất cả checkbox
        document.getElementById("select-all").addEventListener("change", function() {
            let checkboxes = document.querySelectorAll(".user-checkbox");
            checkboxes.forEach(checkbox => checkbox.checked = this.checked);
        });
    </script>
@endsection
