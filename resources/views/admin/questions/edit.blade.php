@extends('layouts.master_admin')

@section('content')
    <div class="container-fluid">
        <button class="btn btn-secondary mb-3"><a href="{{ route('admin.questions.index') }}" class="text-white"><i
                    class="fas fa-arrow-left me-1"></i> Quay lại</a></button>
        <div class="py-3 mb-3" style="background-color: #2184d057">
            <p class="text-decoration-underline m-0 px-2" style="color: #15274F">Sửa khóa học</p>
        </div>
        <form action="{{ route('admin.questions.update', $question) }}" method="POST">
            @csrf @method('PUT')

            <label>Quiz:</label>
            <select name="quiz_id">
                @foreach ($quizzes as $quiz)
                    <option value="{{ $quiz->id }}" {{ $quiz->id == $question->quiz_id ? 'selected' : '' }}>
                        {{ $quiz->title }}
                    </option>
                @endforeach
            </select>

            <label>Content:</label>
            <input type="text" name="question_text" value="{{ $question->question_text }}" required>

            <label>Correct Answer:</label>
            <input type="text" name="correct_answer" value="{{ $question->correct_answer }}" required>

            <button type="submit">Update</button>
        </form>

        <hr>

        <form action="{{ route('admin.questions.destroy', $question->id) }}" method="POST" class="text-center">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa
                Khóa Học</button>
        </form>

    </div>
@endsection
