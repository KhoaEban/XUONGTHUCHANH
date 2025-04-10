@extends('layouts.master_admin')

@section('content')
    <div class="container-fluid">
        <button class="btn btn-secondary mb-3">
            <a href="{{ route('admin.quizzes.index') }}" class="text-white">
                <i class="fas fa-arrow-left me-1"></i> Quay lại
            </a>
        </button>

        <div class="py-3 mb-3" style="background-color: #2184d057">
            <p class="text-decoration-underline m-0 px-2" style="color: #15274F">Sửa Quiz, Câu hỏi và Đáp án</p>
        </div>

        <form action="{{ route('admin.quizzes.update', $quiz->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Quiz Section -->
            <div class="card mb-4">
                <div class="card-header">Thông tin Quiz</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Khóa học:</label>
                        <select class="form-select" name="course_id" id="courseSelect" required>
                            <option value="">-- Chọn khóa học --</option>
                            @foreach ($courses as $course)
                                <option value="{{ $course->id }}" {{ $quiz->course_id == $course->id ? 'selected' : '' }}>
                                    {{ $course->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Bài học:</label>
                        <select class="form-select" name="lesson_id" id="lessonSelect" required>
                            <option value="">-- Chọn bài học --</option>
                            @foreach ($lessons as $lesson)
                                <option value="{{ $lesson->id }}" {{ $quiz->lesson_id == $lesson->id ? 'selected' : '' }}>
                                    {{ $lesson->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tiêu đề Quiz:</label>
                        <input class="form-control" type="text" name="title" value="{{ $quiz->title }}" required>
                    </div>
                </div>
            </div>

            <!-- Questions Section -->
            <div class="card mb-4">
                <div class="card-header">Thông tin Câu hỏi</div>
                <div class="card-body" id="questions-container">
                    @foreach ($quiz->questions as $qIndex => $question)
                        <div class="question-item mb-3" data-index="{{ $qIndex }}">
                            <input type="hidden" name="questions[{{ $qIndex }}][id]" value="{{ $question->id }}">
                            <div class="mb-3">
                                <label class="form-label">Nội dung câu hỏi:</label>
                                <input class="form-control" type="text" name="questions[{{ $qIndex }}][question_text]" 
                                       value="{{ $question->question_text }}" required>
                            </div>
                            <!-- Answers for this question -->
                            <div class="answers-container" data-question-index="{{ $qIndex }}">
                                @foreach ($question->answers as $aIndex => $answer)
                                    <div class="answer-item mb-2" data-answer-index="{{ $aIndex }}">
                                        <input type="hidden" name="questions[{{ $qIndex }}][answers][{{ $aIndex }}][id]" 
                                               value="{{ $answer->id }}">
                                        <label class="form-label">Câu trả lời:</label>
                                        <input class="form-control d-inline w-75" type="text" 
                                               name="questions[{{ $qIndex }}][answers][{{ $aIndex }}][answer_text]" 
                                               value="{{ $answer->answer_text }}" required>
                                        <select class="form-select d-inline w-20 ms-2" 
                                                name="questions[{{ $qIndex }}][answers][{{ $aIndex }}][is_correct]" required>
                                            <option value="0" {{ $answer->is_correct == 0 ? 'selected' : '' }}>Sai</option>
                                            <option value="1" {{ $answer->is_correct == 1 ? 'selected' : '' }}>Đúng</option>
                                        </select>
                                        <button type="button" class="btn btn-danger btn-sm ms-2 remove-answer">Xóa</button>
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" class="btn btn-primary btn-sm mt-2 add-answer" 
                                    data-question-index="{{ $qIndex }}">Thêm đáp án</button>
                            <button type="button" class="btn btn-danger btn-sm mt-2 remove-question">Xóa câu hỏi</button>
                        </div>
                    @endforeach
                </div>
                <button type="button" class="btn btn-primary mt-2" id="add-question">Thêm câu hỏi</button>
            </div>

            <button type="submit" class="btn btn-success">Cập nhật</button>
        </form>
    </div>

    <script>
        // Load lessons based on course selection
        document.getElementById("courseSelect").addEventListener("change", function() {
            let courseId = this.value;
            let lessonSelect = document.getElementById("lessonSelect");
            lessonSelect.innerHTML = '<option value="">-- Chọn bài học --</option>';
            if (courseId) {
                fetch(`/admin/quizzes/get-lessons/${courseId}`)
                    .then(response => response.ok ? response.json() : Promise.reject('Lỗi khi lấy dữ liệu'))
                    .then(data => {
                        data.forEach(lesson => {
                            let option = document.createElement("option");
                            option.value = lesson.id;
                            option.textContent = lesson.title;
                            lessonSelect.appendChild(option);
                        });
                    })
                    .catch(error => alert(error));
            }
        });

        // Add new question
        let questionIndex = {{ $quiz->questions->count() }};
        document.getElementById("add-question").addEventListener("click", function() {
            let container = document.getElementById("questions-container");
            let newQuestion = `
                <div class="question-item mb-3" data-index="${questionIndex}">
                    <div class="mb-3">
                        <label class="form-label">Nội dung câu hỏi:</label>
                        <input class="form-control" type="text" name="questions[${questionIndex}][question_text]" required>
                    </div>
                    <div class="answers-container" data-question-index="${questionIndex}">
                        <div class="answer-item mb-2" data-answer-index="0">
                            <label class="form-label">Câu trả lời:</label>
                            <input class="form-control d-inline w-75" type="text" 
                                   name="questions[${questionIndex}][answers][0][answer_text]" required>
                            <select class="form-select d-inline w-20 ms-2" 
                                    name="questions[${questionIndex}][answers][0][is_correct]" required>
                                <option value="0">Sai</option>
                                <option value="1">Đúng</option>
                            </select>
                            <button type="button" class="btn btn-danger btn-sm ms-2 remove-answer">Xóa</button>
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary btn-sm mt-2 add-answer" 
                            data-question-index="${questionIndex}">Thêm đáp án</button>
                    <button type="button" class="btn btn-danger btn-sm mt-2 remove-question">Xóa câu hỏi</button>
                </div>`;
            container.insertAdjacentHTML("beforeend", newQuestion);
            questionIndex++;
        });

        // Add new answer
        document.addEventListener("click", function(e) {
            if (e.target.classList.contains("add-answer")) {
                let questionIdx = e.target.getAttribute("data-question-index");
                let answersContainer = document.querySelector(`.answers-container[data-question-index="${questionIdx}"]`);
                let answerIndex = answersContainer.querySelectorAll(".answer-item").length;
                let newAnswer = `
                    <div class="answer-item mb-2" data-answer-index="${answerIndex}">
                        <label class="form-label">Câu trả lời:</label>
                        <input class="form-control d-inline w-75" type="text" 
                               name="questions[${questionIdx}][answers][${answerIndex}][answer_text]" required>
                        <select class="form-select d-inline w-20 ms-2" 
                                name="questions[${questionIdx}][answers][${answerIndex}][is_correct]" required>
                            <option value="0">Sai</option>
                            <option value="1">Đúng</option>
                        </select>
                        <button type="button" class="btn btn-danger btn-sm ms-2 remove-answer">Xóa</button>
                    </div>`;
                answersContainer.insertAdjacentHTML("beforeend", newAnswer);
            }
        });

        // Remove answer
        document.addEventListener("click", function(e) {
            if (e.target.classList.contains("remove-answer")) {
                e.target.closest(".answer-item").remove();
            }
        });

        // Remove question
        document.addEventListener("click", function(e) {
            if (e.target.classList.contains("remove-question")) {
                e.target.closest(".question-item").remove();
            }
        });
    </script>

    <style>
        .w-20 { width: 20% !important; }
        .w-75 { width: 75% !important; }
    </style>
@endsection