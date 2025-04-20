@extends('layouts.master')

@section('content')
    <div class="container my-5">
        <h2>Kết quả bài kiểm tra: {{ $quiz->title }}</h2>
        <div class="card">
            <div class="card-body">
                <h4>
                    Điểm số: {{ $score }}/{{ $total }} ({{ number_format(($score / $total) * 10, 1) }}/10)
                </h4>
                @if ($passed)
                    <p class="text-success">
                        Chúc mừng! Bạn đã vượt qua bài kiểm tra. Tiến độ khóa học đã được cập nhật.
                    </p>
                @else
                    <p class="text-danger">
                        Bạn chưa vượt qua bài kiểm tra (điểm tối thiểu: 10/10). Vui lòng thử lại.
                    </p>
                    <a href="{{ route('quizzes.show', $quiz->id) }}" class="btn btn-primary">
                        Thử lại bài kiểm tra
                    </a>
                @endif
                <h5>Chi tiết câu trả lời:</h5>
                <ul>
                    @foreach ($details as $detail)
                        <li>
                            <strong>Câu hỏi:</strong> {{ $detail['question'] }}<br>
                            <strong>Câu trả lời của bạn:</strong> {{ $detail['your_answer'] ?? 'Không trả lời' }}<br>
                            <strong>Đáp án đúng:</strong> {{ $detail['correct_answer'] }}<br>
                            <strong>Trạng thái:</strong>
                            <span class="{{ $detail['is_correct'] ? 'text-success' : 'text-danger' }}">
                                {{ $detail['is_correct'] ? 'Đúng' : 'Sai' }}
                            </span>
                        </li>
                    @endforeach
                </ul>
                <a href="{{ $backUrl }}" class="btn btn-secondary mt-3">Quay lại khóa học</a>
            </div>
        </div>
    </div>
@endsection
