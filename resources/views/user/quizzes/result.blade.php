@extends('layouts.master')

@section('content')
    <div class="container mt-4">
        <a class="bg-secondary text-white py-2 px-3" href="{{ $backUrl }}">
            <i class="fa fa-arrow-left me-1"></i>Quay lại bài học
        </a>
        <h2 class="mt-5">Kết quả: {{ $quiz->title }}</h2>
        <p>Điểm số: <strong>{{ number_format(($score / $total) * 10, 1) }} / 10</strong> (Đúng
            {{ $score }}/{{ $total }} câu)</p>

        <hr>
        @foreach ($details as $item)
            <div class="mb-4">
                <h5>{{ $item['question'] }}</h5>
                <p><i class="fa fa-check"></i> Bạn chọn: <strong>{{ $item['your_answer'] ?? 'Không chọn' }}</strong></p>
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
