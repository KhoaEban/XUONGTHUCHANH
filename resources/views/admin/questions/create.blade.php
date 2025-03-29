@extends('layouts.master_admin')

@section('content')
    <div class="container-fluid">
        <button class="btn btn-secondary mb-3">
            <a href="{{ route('admin.questions.index') }}" class="text-white">
                <i class="fas fa-arrow-left me-1"></i> Quay lại
            </a>
        </button>

        <div class="py-3 mb-3" style="background-color: #2184d057">
            <p class="text-decoration-underline m-0 px-2" style="color: #15274F">Thêm câu hỏi</p>
        </div>

        <form action="{{ route('admin.questions.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Bài học:</label>
                <select class="form-select" name="lesson_id" id="lessonSelect" required>
                    <option value="">-- Chọn bài học --</option>
                    @foreach ($lessons as $lesson)
                        <option value="{{ $lesson->id }}">{{ $lesson->title }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Quiz:</label>
                <select class="form-select" name="quiz_id" id="quizSelect" required>
                    <option value="">-- Chọn quiz --</option>
                    {{-- Danh sách quiz sẽ được load bằng AJAX --}}
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Nội dung câu hỏi:</label>
                <input class="form-control" type="text" name="question_text" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Đáp án đúng:</label>
                <input class="form-control" type="text" name="correct_answer" required>
            </div>

            <button type="submit" class="btn btn-success">Lưu</button>
        </form>
    </div>

    <script>
        document.getElementById("lessonSelect").addEventListener("change", function() {
            let lessonId = this.value;
            let quizSelect = document.getElementById("quizSelect");

            quizSelect.innerHTML = '<option value="">-- Chọn quiz --</option>';

            if (lessonId) {
                fetch(`/admin/questions/get-quizzes/${lessonId}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(quiz => {
                            let option = document.createElement("option");
                            option.value = quiz.id;
                            option.textContent = quiz.title;
                            quizSelect.appendChild(option);
                        });
                    });
            }
        });
    </script>
@endsection
