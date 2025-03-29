@extends('layouts.master_admin')

@section('content')
    <div class="container-fluid">
        <button class="btn btn-secondary mb-3"><a href="{{ route('admin.quizzes.index') }}" class="text-white"><i
                    class="fas fa-arrow-left me-1"></i> Quay lại</a></button>
        <div class="py-3 mb-3" style="background-color: #2184d057">
            <p class="text-decoration-underline m-0 px-2" style="color: #15274F">Sửa khóa học</p>
        </div>
        <form action="{{ route('admin.quizzes.update', $quiz) }}" method="POST">
            @csrf @method('PUT')
            <label class="form-label">Khóa học:</label>
            <select class="form-select" name="course_id" required>
                @foreach ($courses as $course)
                    <option value="{{ $course->id }}" {{ $course->id == $quiz->course_id ? 'selected' : '' }}>
                        {{ $course->title }}
                    </option>
                @endforeach
            </select>
            <label class="form-label">Title:</label>
            <input class="form-control" type="text" name="title" value="{{ $quiz->title }}" required>
            <button type="submit">Update</button>
        </form>

        <hr>

        <form action="{{ route('admin.quizzes.destroy', $quiz->id) }}" method="POST" class="text-center">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa
                Khóa Học</button>
        </form>

    </div>
@endsection
