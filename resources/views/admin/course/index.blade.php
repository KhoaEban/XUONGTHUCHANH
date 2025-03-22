@extends('layouts.navbar_admin')

@section('content')
    <div class="container mt-4">
        <h1 class="text-center text-primary">Danh sách khóa học</h1>
        <a href="{{ route('courses.create') }}" class="btn btn-primary mb-3">Thêm khóa học</a>

        <table class="table table-bordered text-center">
            <thead class="table-primary">
                <tr>
                    <th>#</th>
                    <th>Hình ảnh</th>
                    <th>Tên khóa học</th>
                    <th>Danh mục</th>
                    <th>Giảng viên</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($courses as $key => $course)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            @if ($course->image)
                                <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->name }}" width="50">
                            @else
                                <span class="text-muted">Không có ảnh</span>
                            @endif
                        </td>
                        <td>{{ $course->name }}</td>
                        <td>{{ $course->category->name }}</td>
                        <td>{{ $course->teacher->name }}</td>
                        <td>
                            <a href="{{ route('courses.edit', $course->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                            <form action="{{ route('courses.destroy', $course->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-center">
            {{ $courses->links() }}
        </div>
    </div>
@endsection
