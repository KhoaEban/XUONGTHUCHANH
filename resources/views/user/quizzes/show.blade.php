@extends('layouts.master')

@section('content')
    <div class="container mt-4">
        <a class="bg-secondary text-white py-2 px-3" href="{{ url()->previous() }}"><i class="fa fa-arrow-left me-1"></i>Quay lại bài học</a>
        <h2 class="mt-5">{{ $quiz->title }}</h2>
        <p>{{ $quiz->description }}</p>

        <form action="{{ route('user.quizzes.submit', $quiz->id) }}" method="POST">
            @csrf
            @foreach ($quiz->questions as $question)
                <div class="question mb-4">
                    <h4>{{ $question->question_text }}</h4>

                    @foreach ($question->answers as $answer)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="answers[{{ $question->id }}]"
                                value="{{ $answer->id }}" id="answer_{{ $answer->id }}">
                            <label class="form-check-label" for="answer_{{ $answer->id }}">
                                {{ $answer->answer_text }}
                            </label>
                        </div>
                    @endforeach
                </div>
            @endforeach

            <button type="submit" class="btn btn-primary">Nộp bài</button>
        </form>
    </div>
@endsection
