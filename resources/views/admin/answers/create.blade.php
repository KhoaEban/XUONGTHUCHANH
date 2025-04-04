@extends('layouts.master_admin')

@section('content')
    <div class="container-fluid">
        <button class="btn btn-secondary mb-3">
            <a href="{{ route('admin.answers.index') }}" class="text-white"><i class="fas fa-arrow-left me-1"></i> Quay lại</a>
        </button>

        <div class="py-3 mb-3" style="background-color: #2184d057">
            <p class="text-decoration-underline m-0 px-2" style="color: #15274F">Thêm câu trả lời</p>
        </div>

        <form action="{{ route('admin.answers.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <!-- Chọn Quiz -->
                <label class="form-label">Chọn Bài học:</label>
                <select class="form-select" id="quiz-select" name="quiz_id">
                    <option value="">-- Chọn bài học --</option>
                    @foreach ($quizzes as $quiz)
                        <option value="{{ $quiz->id }}">{{ $quiz->title }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <!-- Chọn Câu hỏi (cập nhật qua AJAX) -->
                <label class="form-label">Chọn Câu hỏi:</label>
                <select class="form-select" id="question-select" name="question_id">
                    <option value="">-- Chọn câu hỏi --</option>
                </select>
            </div>

            <div class="mb-3">
                <!-- Nội dung câu trả lời -->
                <label class="form-label">Câu trả lời:</label>
                <input class="form-control" type="text" name="answer_text" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Đáp án đúng:</label>
                <select class="form-select" name="is_correct" required>
                    <option value="0">Sai</option>
                    <option value="1">Đúng</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success">Save</button>
        </form>
    </div>

    <script>
        document.getElementById('quiz-select').addEventListener('change', function() {
            let quizId = this.value;
            let questionSelect = document.getElementById('question-select');

            // Xóa danh sách câu hỏi cũ
            questionSelect.innerHTML = '<option value="">-- Chọn câu hỏi --</option>';

            if (quizId) {
                fetch(`/admin/answers/get-questions/${quizId}`) // ✅ Sửa URL
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(err => {
                                throw new Error(err.message || 'Lỗi khi lấy dữ liệu');
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.length === 0) {
                            alert("Không có câu hỏi nào cho bài học này!");
                        }
                        data.forEach(question => {
                            let option = document.createElement('option');
                            option.value = question.id;
                            option.textContent = question.question_text;
                            questionSelect.appendChild(option);
                        });
                    })
                    .catch(error => {
                        alert(error.message);
                    });
            }
        });
    </script>
@endsection
