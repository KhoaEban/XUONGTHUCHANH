@extends('layouts.master')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h2 class="mb-0 text-center">Sửa Khóa Học</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('instructor.courses.update', $course->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Tiêu đề:</label>
                    <input type="text" name="title" class="form-control" value="{{ $course->title }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Mô tả:</label>
                    <textarea name="description" class="form-control" rows="4">{{ $course->description }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Hình ảnh hiện tại:</label><br>
                    <img src="{{ asset('image/' . $course->image) }}" alt="{{ $course->title }}" class="img-thumbnail" width="150">
                </div>

                <div class="mb-3">
                    <label class="form-label">Chọn hình ảnh mới:</label>
                    <input type="file" name="image" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Giá:</label>
                    <input type="number" name="price" class="form-control" value="{{ $course->price }}" required>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-success">Cập Nhật</button>
                </div>
            </form>

            <hr>

            <form action="{{ route('instructor.courses.destroy', $course->id) }}" method="POST" class="text-center">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa Khóa Học</button>
            </form>
        </div>
    </div>
</div>
@endsection
