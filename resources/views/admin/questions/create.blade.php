@extends('layouts.master_admin')

@section('content')
    <div class="container-fluid">
        <button class="btn btn-secondary mb-3"><a href="{{ route('admin.questions.index') }}" class="text-white"><i
                    class="fas fa-arrow-left me-1"></i> Quay lại</a></button>
        <div class="py-3 mb-3" style="background-color: #2184d057">
            <p class="text-decoration-underline m-0 px-2" style="color: #15274F">Thêm bài học</p>
        </div>
        <form action="{{ route('admin.questions.store') }}" method="POST">
            @csrf
            <label>Quiz:</label>
            <select name="quiz_id">
                @foreach($quizzes as $quiz)
                    <option value="{{ $quiz->id }}">{{ $quiz->title }}</option>
                @endforeach
            </select>
        
            <label>Content:</label>
            <input type="text" name="question_text" required>
        
            <label>Correct Answer:</label>
            <input type="text" name="correct_answer" required>
        
            <button type="submit">Create</button>
        </form>
    </div>
@endsection
