@extends('layouts.master_admin')

@section('content')
    <div class="container-fluid">
        <button class="btn btn-secondary mb-3"><a href="{{ route('admin.lessons.index') }}" class="text-white"><i
                    class="fas fa-arrow-left me-1"></i> Quay lại</a></button>
        <div class="py-3 mb-3" style="background-color: #2184d057">
            <p class="text-decoration-underline m-0 px-2" style="color: #15274F">Sửa khóa học</p>
        </div>
        <form action="{{ route('admin.lessons.update', $lesson->id) }}" method="POST">
            @csrf
            @method('PUT')
            @if ($errors->any())
                <div class="alert alert-danger d-flex justify-content-between">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="form-group">
                <label for="course_id">Khóa học:</label>
                <select name="course_id" id="course_id" class="form-control">
                    @foreach ($courses as $course)
                        <option value="{{ $course->id }}" {{ $lesson->course_id == $course->id ? 'selected' : '' }}>
                            {{ $course->title }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="title">Tiêu đề:</label>
                <input type="text" name="title" id="title" class="form-control" value="{{ $lesson->title }}">
            </div>
            <div class="form-group">
                <label for="slug">Slug:</label>
                <input type="text" name="slug" id="slug" class="form-control" value="{{ $lesson->slug }}" readonly>
            </div>
            <div class="form-group">
                <label for="video_url">Video URL:</label>
                <input type="url" name="video_url" id="video_url" class="form-control"
                    value="{{ $lesson->video_url }}">
            </div>
            <div class="form-group">
                <label for="content">Nội dung:</label>
                <textarea name="content" id="content" rows="4" class="form-control">{{ $lesson->content }}</textarea>
            </div>
            <div class="form-group">
                <label for="order_number">Sắp xếp:</label>
                <input type="number" name="order_number" id="order_number" class="form-control"
                    value="{{ $lesson->order_number }}">
            </div>
            <button type="submit" class="btn btn-success mt-3">Update</button>
        </form>

        <hr>

        <form action="{{ route('admin.lessons.destroy', $course->id) }}" method="POST" class="text-center">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa
                Khóa Học</button>
        </form>

    </div>

    <script>
        document.getElementById('title').addEventListener('input', function () {
            const slug = this.value.toLowerCase().trim().replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '');
            document.getElementById('slug').value = slug;
        });
    </script>
@endsection
