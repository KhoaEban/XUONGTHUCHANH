@extends('layouts.master_admin')

@section('content')
    <div class="container-fluid">
        <!-- Nút tạo khóa học -->
        <div class="d-flex justify-content-between mb-3">
            <a href="{{ route('admin.course.create') }}" class=""
                style="border: none; background-color: #2185D0; color: white; padding: 10px; font-size: 16px; font-weight: bold;">Tạo
                khóa học</a>
        </div>

        <div class="d-flex justify-content-between">
            <h2 class="">Danh sách Khóa Học</h2>
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
        <!-- Bảng danh sách khóa học -->
        <div class="row">
            <div class="col-md-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Tiêu đề</th>
                            <th>Giá</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($courses as $key => $course)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $course->title }}</td>
                                <td>{{ number_format($course->price, 0, ',', '.') }} VNĐ</td>
                                <td>
                                    <a href="{{ route('admin.course.edit', $course->id) }}" class="btn btn-warning">Sửa</a>
                                    <form action="{{ route('admin.course.destroy', $course->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger"
                                            onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Phân trang -->
                <div class="d-flex justify-content-end">
                    {{ $courses->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
