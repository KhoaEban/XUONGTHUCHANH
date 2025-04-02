@extends('layouts.master')

@section('content')
<div class="container">
    <h2>{{ $quiz->title }}</h2>
    <p>{{ $quiz->description }}</p>

    <form action="#" method="POST">
        @csrf
        @foreach ($quiz->questions as $question)
            <div class="question">
                <h4>{{ $question->text }}</h4>
                @foreach ($question->options as $option)
                    <label>
                        <input type="radio" name="question_{{ $question->id }}" value="{{ $option->id }}">
                        {{ $option->text }}
                    </label>
                @endforeach
            </div>
        @endforeach
        <button type="submit" class="btn btn-primary">Nộp bài</button>
    </form>
</div>
@endsection
