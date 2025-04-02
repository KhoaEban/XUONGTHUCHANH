@extends('layouts.master_admin')

@section('content')
    <div class="container-fluid">
        <button class="btn btn-secondary mb-3">
            <a href="{{ route('admin.quizzes.index') }}" class="text-white">
                <i class="fas fa-arrow-left me-1"></i> Quay lại
            </a>
        </button>

        <div class="py-3 mb-3" style="background-color: #2184d057">
            <p class="text-decoration-underline m-0 px-2" style="color: #15274F">Sửa bài kiểm tra</p>
        </div>

        <form action="{{ route('admin.quizzes.update', $quiz->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Chọn khóa học --}}
            <div class="mb-3">
                <label class="form-label">Khóa học:</label>
                <select class="form-select" name="course_id" id="courseSelect" required>
                    <option value="">-- Chọn khóa học --</option>
                    @foreach ($courses as $course)
                        <option value="{{ $course->id }}" {{ $course->id == $quiz->course_id ? 'selected' : '' }}>
                            {{ $course->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Chọn bài học --}}
            <div class="mb-3">
                <label class="form-label">Bài học:</label>
                <select class="form-select" name="lesson_id" id="lessonSelect" required>
                    <option value="">-- Chọn bài học --</option>
                    @foreach ($lessons as $lesson)
                        <option value="{{ $lesson->id }}" {{ $lesson->id == $quiz->lesson_id ? 'selected' : '' }}>
                            {{ $lesson->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Tiêu đề bài kiểm tra --}}
            <div class="mb-3">
                <label class="form-label">Tiêu đề bài kiểm tra:</label>
                <input class="form-control" type="text" name="title" value="{{ $quiz->title }}" required>
            </div>

            <button type="submit" class="btn btn-success">Cập nhật</button>
        </form>

        <hr>

        {{-- Nút xóa --}}
        <form action="{{ route('admin.quizzes.destroy', $quiz->id) }}" method="POST" class="text-center">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">
                Xóa bài kiểm tra
            </button>
        </form>
    </div>

    {{-- Script cập nhật danh sách bài học theo khóa học --}}
    <script>
        document.getElementById("courseSelect").addEventListener("change", function() {
            let courseId = this.value;
            let lessonSelect = document.getElementById("lessonSelect");

            lessonSelect.innerHTML = '<option value="">-- Chọn bài học --</option>'; // Xóa danh sách cũ

            if (courseId) {
                fetch(`/admin/quizzes/get-lessons/${courseId}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(lesson => {
                            let option = document.createElement("option");
                            option.value = lesson.id;
                            option.textContent = lesson.title;
                            lessonSelect.appendChild(option);
                        });
                    });
            }
        });

        // Load danh sách bài học ban đầu dựa trên khóa học hiện tại
        document.addEventListener("DOMContentLoaded", function() {
            let selectedCourse = document.getElementById("courseSelect").value;
            if (selectedCourse) {
                document.getElementById("courseSelect").dispatchEvent(new Event("change"));
            }
        });
    </script>
@endsection
