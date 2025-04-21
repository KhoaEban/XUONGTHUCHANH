@extends('layouts.sidebar_profile')

@section('content')
    <div class="container">
        <div class="alert alert-secondary">
            <a href="{{ asset('user/profile') }}" class="text-secondary text-decoration-none"><i class="fas fa-arrow-left me-1"></i>Quay lại</a>
        </div>
        <h2 class="mb-4 font-bold text-lg">{{ $course->title }}</h2>
        <div class="row">
            <div class="col-md-8">
                <div class="mb-6">
                    <p class="text-gray-700">Tiến độ: {{ $enrollment->progress }}%</p>
                    <p class="text-gray-700">Ngày đăng ký:
                        {{ \Carbon\Carbon::parse($enrollment->enrolled_at)->format('d/m/Y') }}
                    </p>
                </div>

                <h3 class="font-semibold text-base text-gray-800">Danh sách bài học</h3>
                <ul class="list-disc pl-5">
                    @foreach ($lessons as $lesson)
                        <li class="{{ in_array($lesson->id, $completedLessons) ? 'text-green-500' : 'text-gray-700' }}">
                            {{ $lesson->title }}
                        </li>
                    @endforeach
                </ul>

                <h3 class="font-semibold text-base text-gray-800 mt-6">Kết quả Quiz</h3>
                @if ($quizResults->isEmpty())
                    <p class="text-gray-500">Bạn chưa làm quiz nào.</p>
                @else
                    <ul class="list-disc pl-5">
                        @foreach ($quizResults as $result)
                            <li>
                                <strong>{{ $result->quiz->title }}</strong> - Điểm: {{ $result->score }}
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
            <div class="col-md-4">
                <div class="shadow-md">
                    <img src="{{ asset($enrollment->course->thumbnail) }}" style="width: 100%; height: 200px; object-fit: cover;" class="mb-2" alt="{{ $enrollment->course->title }}">
                </div>
            </div>
        </div>
    </div>
@endsection
