@extends('layouts.master')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h2 class="mb-0">Danh sách khóa học</h2>
            <a href="{{ route('instructor.courses.create') }}" class="btn btn-light">+ Thêm Khóa Học</a>
        </div>
        <div class="card-body">
            <table class="table table-striped text-center">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tiêu đề</th>
                        <th>Ảnh</th>
                        <th>Giá</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($courses as $key => $course)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $course->title }}</td>
                            <td>
                                <img src="{{ asset('image/' . $course->image) }}" alt="{{ $course->title }}" width="100">
                            </td>
                            <td>{{ number_format($course->price, 0, ',', '.') }} VNĐ</td>
                            <td>
                                <a href="{{ route('instructor.courses.edit', $course->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                                <form action="{{ route('instructor.courses.destroy', $course->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @if($courses->isEmpty())
                <p class="text-center text-muted mt-3">Chưa có khóa học nào.</p>
            @endif
        </div>
    </div>
</div>
@endsection
