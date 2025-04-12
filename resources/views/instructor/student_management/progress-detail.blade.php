@extends('layouts.master_instructor')

@section('content')
    <div class="container-fluid mt-5">
        <div class="mb-3">
            <a href="{{ route('instructor.progress.index') }}" class="text-white d-flex align-items-center bg-secondary p-2"><i class="fas fa-arrow-left me-1"></i> Quay lại</a>
        </div>

        <h2>Chi tiết tiến độ: {{ $progress->user->name }} - {{ $progress->quiz->title }}</h2>
        <p>Điểm: {{ $progress->score }}/10</p>
        <p>Thời gian làm bài: {{ $progress->taken_at->format('d/m/Y H:i') }}</p>
        <p>Thời gian hoàn thành: {{ $progress->updated_at->format('d/m/Y H:i') }}</p>
        <table class="table">
            <thead>
                <tr>
                    <th>Câu hỏi</th>
                    <th>Đáp án chọn</th>
                    <th>Kết quả</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($progress->userAnswers as $answer)
                    <tr>
                        <td>{{ $answer->question->question_text }}</td>
                        <td>{{ $answer->answer ? $answer->answer->answer_text : 'Không chọn' }}</td>
                        <td>{{ $answer->is_correct ? 'Đúng' : 'Sai' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
