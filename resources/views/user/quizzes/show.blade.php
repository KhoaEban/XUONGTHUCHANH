@extends('layouts.master')

@section('content')
    <div class="container mt-4">
        <h3 class="mb-4">Làm bài kiểm tra: {{ $quiz->title }}</h3>

        <form action="{{ route('user.quiz.submit', $quiz->id) }}" method="POST">
            @csrf

            @foreach ($quiz->questions as $index => $question)
                <div class="mb-4 border p-3 rounded shadow-sm bg-light">
                    <h5>Câu {{ $index + 1 }}: {{ $question->content }}</h5>

                    @foreach ($question->answers as $answer)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="answers[{{ $question->id }}]"
                                id="answer_{{ $answer->id }}" value="{{ $answer->id }}" required>
                            <label class="form-check-label" for="answer_{{ $answer->id }}">
                                {{ $answer->content }}
                            </label>
                        </div>
                    @endforeach
                </div>
            @endforeach

            <button type="submit" class="btn btn-success mt-3">Nộp bài</button>
        </form>
    </div>
@endsection
