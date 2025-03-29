@extends('layouts.master_admin')

@section('content')
    <div class="container-fluid">
        <button class="btn btn-secondary mb-3"><a href="{{ route('admin.answers.index') }}" class="text-white"><i
                    class="fas fa-arrow-left me-1"></i> Quay lại</a></button>
        <div class="py-3 mb-3" style="background-color: #2184d057">
            <p class="text-decoration-underline m-0 px-2" style="color: #15274F">Thêm câu trả lời</p>
        </div>
        <form action="{{ route('admin.answers.store') }}" method="POST">
            @csrf
            <label class="form-label">Câu hỏi:</label>
            <select name="question_id" class="form-select mb-3">
                @foreach ($questions as $question)
                    <option value="{{ $question->id }}">{{ $question->content }}</option>
                @endforeach
            </select>

            <label class="form-label">Câu trả lời:</label>
            <input type="text" name="answer_text" class="form-control mb-3" required>

            <label class="form-label">Trả lời đúng:</label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="is_correct" value="1" id="correctAnswer">
                <label class="form-check-label" for="correctAnswer">Câu trả lời đúng</label>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="radio" name="is_correct" value="0" id="incorrectAnswer">
                <label class="form-check-label" for="incorrectAnswer">Câu trả lời sai</label>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="radio" name="is_correct" value="2" id="noAnswer">
                <label class="form-check-label" for="noAnswer">Không câu trả lời</label>
            </div>

            <button type="submit">Save</button>
        </form>
    </div>
@endsection
