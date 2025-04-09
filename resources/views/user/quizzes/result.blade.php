@extends('layouts.master')

@section('content')
<div class="container">
    <h2>Kết quả: {{ $quiz->title }}</h2>
    <p>Điểm số: <strong>{{ $score }}/{{ $total }}</strong></p>

    <hr>
    @foreach ($details as $item)
        <div class="mb-4">
            <h5>{{ $item['question'] }}</h5>
            <p>❓ Bạn chọn: <strong>{{ $item['your_answer'] ?? 'Không chọn' }}</strong></p>
            <p>✅ Đáp án đúng: <strong>{{ $item['correct_answer'] }}</strong></p>
            @if ($item['is_correct'])
                <p class="text-success">✔ Chính xác!</p>
            @else
                <p class="text-danger">✘ Sai rồi!</p>
            @endif
        </div>
        <hr>
    @endforeach

    <a href="{{ route('quizzes.show', $quiz->id) }}" class="btn btn-secondary">Làm lại</a>
</div>
@endsection
