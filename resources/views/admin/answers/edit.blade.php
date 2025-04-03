@extends('layouts.master_admin')

@section('content')
    <div class="container-fluid">
        <button class="btn btn-secondary mb-3">
            <a href="{{ route('admin.questions.index') }}" class="text-white">
                <i class="fas fa-arrow-left me-1"></i> Quay lại
            </a>
        </button>

        <div class="py-3 mb-3" style="background-color: #2184d057">
            <p class="text-decoration-underline m-0 px-2" style="color: #15274F">Sửa câu hỏi</p>
        </div>

        <form action="{{ route('admin.questions.update', $question) }}" method="POST">
            @csrf @method('PUT')

            <div class="mb-3">
                <label class="form-label">Bài học:</label>
                <select class="form-select" name="lesson_id" id="lessonSelect" required>
                    @foreach ($lessons as $lesson)
                        <option value="{{ $lesson->id }}" {{ $lesson->id == $question->quiz->lesson_id ? 'selected' : '' }}>
                            {{ $lesson->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Quiz:</label>
                <select class="form-select" name="quiz_id" id="quizSelect" required>
                    @foreach ($quizzes as $quiz)
                        <option value="{{ $quiz->id }}" {{ $quiz->id == $question->quiz_id ? 'selected' : '' }}>
                            {{ $quiz->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Nội dung câu hỏi:</label>
                <input class="form-control" type="text" name="question_text" value="{{ $question->question_text }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Đáp án đúng:</label>
                <input class="form-control" type="text" name="correct_answer" value="{{ $question->correct_answer }}" required>
            </div>

            <button type="submit" class="btn btn-success">Cập nhật</button>
        </form>

        <hr>

        <form action="{{ route('admin.questions.destroy', $question->id) }}" method="POST" class="text-center">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">
                Xóa câu hỏi
            </button>
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

        // Khi load trang edit, tự động load quiz theo bài học đã chọn
        window.onload = function() {
            let selectedLesson = document.getElementById("lessonSelect").value;
            let selectedQuiz = "{{ $question->quiz_id }}";

            if (selectedLesson) {
                fetch(`/admin/questions/get-quizzes/${selectedLesson}`)
                    .then(response => response.json())
                    .then(data => {
                        let quizSelect = document.getElementById("quizSelect");
                        quizSelect.innerHTML = '<option value="">-- Chọn quiz --</option>'; 

                        data.forEach(quiz => {
                            let option = document.createElement("option");
                            option.value = quiz.id;
                            option.textContent = quiz.title;
                            if (quiz.id == selectedQuiz) option.selected = true;
                            quizSelect.appendChild(option);
                        });
                    });
            }
        };
    </script>
@endsection
