@extends('layouts.master')

<style>
    /* Container */
    .quiz-container {
        max-width: 700px;
        margin: 20px auto;
        padding: 15px;
        font-family: 'Arial', sans-serif;
    }

    /* Back button */
    .back-to-lesson {
        display: inline-flex;
        align-items: center;
        color: #008040;
        padding: 6px 12px;
        border-radius: 6px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.2s;
    }
    .back-to-lesson:hover {
        background: #ecfdf5;
        color: #00a86b;
    }
    .back-to-lesson .fa {
        margin-right: 6px;
    }

    /* Quiz header */
    .quiz-header {
        margin-bottom: 20px;
    }
    .quiz-title {
        font-size: 22px;
        font-weight: 600;
        color: #1f2a44;
        margin-bottom: 8px;
    }
    .quiz-description {
        font-size: 14px;
        color: #6b7280;
        line-height: 1.4;
    }

    /* Question */
    .question-card {
        margin-bottom: 20px;
    }
    .question-text {
        font-size: 16px;
        font-weight: 500;
        color: #1f2a44;
        margin-bottom: 12px;
    }
    .question-text::before {
        content: "Câu hỏi " attr(data-index) ":";
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: #008040;
        margin-bottom: 4px;
    }

    /* Answer options */
    .form-check {
        display: flex;
        align-items: center;
        padding: 8px 0;
        border-bottom: 1px solid #e5e7eb;
    }
    .form-check:last-child {
        border-bottom: none;
    }
    .form-check-input {
        width: 16px;
        height: 16px;
        margin-right: 10px;
        accent-color: #008040;
        cursor: pointer;
    }
    .form-check-label {
        font-size: 14px;
        color: #1f2a44;
        cursor: pointer;
        flex-grow: 1;
    }

    /* Submit button */
    .submit-quiz-btn {
        display: block;
        width: 150px;
        margin: 20px auto 0;
        background: #008040;
        border: none;
        color: white;
        padding: 8px;
        font-size: 14px;
        font-weight: 500;
        border-radius: 6px;
        transition: all 0.2s;
    }
    .submit-quiz-btn:hover {
        background: #00a86b;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .quiz-container {
            margin: 10px;
            padding: 10px;
        }
        .quiz-title {
            font-size: 20px;
        }
        .submit-quiz-btn {
            width: 100%;
        }
    }
</style>

@section('content')
    <div class="quiz-container">
        <a href="{{ url()->previous() }}" class="back-to-lesson">
            <i class="fa fa-arrow-left"></i> Quay lại
        </a>

        <div class="quiz-header">
            <h2 class="quiz-title">{{ $quiz->title }}</h2>
            <p class="quiz-description">{{ $quiz->description }}</p>
        </div>

        <form action="{{ route('user.quizzes.submit', $quiz->id) }}" method="POST">
            @csrf
            @foreach ($quiz->questions as $index => $question)
                <div class="question-card">
                    <h4 class="question-text" data-index="{{ $index + 1 }}">{{ $question->question_text }}</h4>
                    @foreach ($question->answers as $answer)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="answers[{{ $question->id }}]"
                                value="{{ $answer->id }}" id="answer_{{ $answer->id }}"
                                required>
                            <label class="form-check-label" for="answer_{{ $answer->id }}">
                                {{ $answer->answer_text }}
                            </label>
                        </div>
                    @endforeach
                </div>
            @endforeach

            <button type="submit" class="submit-quiz-btn">Nộp bài</button>
        </form>
    </div>
@endsection