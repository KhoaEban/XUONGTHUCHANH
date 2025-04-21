<!-- resources/views/instructor/quizzes/create.blade.php -->
@extends('layouts.master_instructor')

@section('content')

    <div class="container-fluid mt-4">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        <button class="btn btn-secondary mb-3">
            <a href="{{ route('instructor.quizzes.index') }}" class="text-white">
                <i class="fas fa-arrow-left me-1"></i> Quay lại
            </a>
        </button>

        <div class="py-3 mb-3" style="background-color: #2184d057">
            <p class="text-decoration-underline m-0 px-2" style="color: #15274F">Tạo Quiz, Câu hỏi và Đáp án</p>
        </div>

        <form action="{{ route('instructor.quizzes.store') }}" method="POST">
            @csrf

            <!-- Quiz Section -->
            <div class="card mb-4">
                <div class="card-header">Thông tin Quiz</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Khóa học:</label>
                        <select class="form-select" name="course_id" id="courseSelect">
                            <option value="">-- Chọn khóa học --</option>
                            @foreach ($courses as $course)
                                <option value="{{ $course->id }}">{{ $course->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Bài học:</label>
                        <select class="form-select" name="lesson_id" id="lessonSelect">
                            <option value="">-- Chọn bài học --</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tiêu đề Quiz:</label>
                        <input class="form-control" type="text" name="title">
                    </div>
                </div>
            </div>

            <!-- Questions Section -->
            <div class="card mb-4">
                <div class="card-header">Thông tin Câu hỏi</div>
                <div class="card-body" id="questions-container">
                    <div class="question-item mb-3" data-index="0">
                        <div class="mb-3">
                            <label class="form-label">Nội dung câu hỏi:</label>
                            <input class="form-control" type="text" name="questions[0][question_text]">
                        </div>
                        <!-- Answers for this question -->
                        <div class="answers-container" data-question-index="0">
                            <div class="answer-item mb-2" data-answer-index="0">
                                <label class="form-label">Câu trả lời:</label>
                                <input class="form-control d-inline w-75" type="text"
                                    name="questions[0][answers][0][answer_text]">
                                <select class="form-select d-inline w-20 ms-2" name="questions[0][answers][0][is_correct]">
                                    <option value="0">Sai</option>
                                    <option value="1">Đúng</option>
                                </select>
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary btn-sm mt-2 add-answer" data-question-index="0">Thêm
                            đáp án</button>
                    </div>
                </div>
                <button type="button" class="btn btn-primary mt-2" id="add-question">Thêm câu hỏi</button>
            </div>

            <button type="submit" class="btn btn-success">Lưu tất cả</button>
        </form>
    </div>

    <script>
        // Load lessons based on course selection
        document.getElementById("courseSelect").addEventListener("change", function() {
            let courseId = this.value;
            let lessonSelect = document.getElementById("lessonSelect");
            lessonSelect.innerHTML = '<option value="">-- Chọn bài học --</option>';
            if (courseId) {
                fetch(`/instructor/quizzes/get-lessons/${courseId}`)
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
        let questionIndex = 1;
        document.getElementById("add-question").addEventListener("click", function() {
            let container = document.getElementById("questions-container");
            let newQuestion = `
                <div class="question-item mb-3" data-index="${questionIndex}">
                    <div class="mb-3">
                        <label class="form-label">Nội dung câu hỏi:</label>
                        <input class="form-control" type="text" name="questions[${questionIndex}][question_text]" >
                    </div>
                    <div class="answers-container" data-question-index="${questionIndex}">
                        <div class="answer-item mb-2" data-answer-index="0">
                            <label class="form-label">Câu trả lời:</label>
                            <input class="form-control d-inline w-75" type="text" 
                                   name="questions[${questionIndex}][answers][0][answer_text]" >
                            <select class="form-select d-inline w-20 ms-2" 
                                    name="questions[${questionIndex}][answers][0][is_correct]" >
                                <option value="0">Sai</option>
                                <option value="1">Đúng</option>
                            </select>
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary btn-sm mt-2 add-answer" 
                            data-question-index="${questionIndex}">Thêm đáp án</button>
                </div>`;
            container.insertAdjacentHTML("beforeend", newQuestion);
            questionIndex++;
        });

        // Add new answer for a specific question
        document.addEventListener("click", function(e) {
            if (e.target.classList.contains("add-answer")) {
                let questionIdx = e.target.getAttribute("data-question-index");
                let answersContainer = document.querySelector(
                    `.answers-container[data-question-index="${questionIdx}"]`);
                let answerIndex = answersContainer.querySelectorAll(".answer-item").length;
                let newAnswer = `
                    <div class="answer-item mb-2" data-answer-index="${answerIndex}">
                        <label class="form-label">Câu trả lời:</label>
                        <input class="form-control d-inline w-75" type="text" 
                               name="questions[${questionIdx}][answers][${answerIndex}][answer_text]" >
                        <select class="form-select d-inline w-20 ms-2" 
                                name="questions[${questionIdx}][answers][${answerIndex}][is_correct]" >
                            <option value="0">Sai</option>
                            <option value="1">Đúng</option>
                        </select>
                    </div>`;
                answersContainer.insertAdjacentHTML("beforeend", newAnswer);
            }
        });
    </script>

    <style>
        .w-20 {
            width: 20% !important;
        }

        .w-75 {
            width: 75% !important;
        }
    </style>
@endsection
