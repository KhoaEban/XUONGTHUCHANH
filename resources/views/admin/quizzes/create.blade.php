@extends('layouts.master_admin')

@section('content')
    <div class="container-fluid">
        <button class="btn btn-secondary mb-3">
            <a href="{{ route('admin.quizzes.index') }}" class="text-white">
                <i class="fas fa-arrow-left me-1"></i> Quay lại
            </a>
        </button>

        <div class="py-3 mb-3" style="background-color: #2184d057">
            <p class="text-decoration-underline m-0 px-2" style="color: #15274F">Thêm bài kiểm tra</p>
        </div>

        <form action="{{ route('admin.quizzes.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Khóa học:</label>
                <select class="form-select" name="course_id" id="courseSelect" required>
                    <option value="">-- Chọn khóa học --</option>
                    @foreach ($courses as $course)
                        <option value="{{ $course->id }}">{{ $course->title }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Bài học:</label>
                <select class="form-select" name="lesson_id" id="lessonSelect" required>
                    <option value="">-- Chọn bài học --</option>
                    {{-- Bài học sẽ được load bằng AJAX --}}
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Tiêu đề bài kiểm tra:</label>
                <input class="form-control" type="text" name="title" required>
            </div>

            <button type="submit" class="btn btn-success">Lưu</button>
        </form>
    </div>

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
    </script>
@endsection
