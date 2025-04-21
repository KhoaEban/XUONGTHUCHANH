@extends('layouts.master_instructor')

@section('content')
    <div class="container-fluid mt-5">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Danh sách khóa học của bạn</h4>
                    </div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        @if ($courses->isEmpty())
                            <p class="text-muted">Bạn chưa tạo khóa học nào. Hãy bắt đầu tạo một khóa học mới!</p>
                            <a href="{{ route('instructor.courses.create') }}" class="btn btn-primary">Tạo khóa học mới</a>
                        @else
                            <div class="row">
                                @foreach ($courses as $course)
                                    <div class="col-md-4 mb-4">
                                        <div class="card h-100">
                                            @if ($course->thumbnail)
                                                <img src="{{ asset($course->thumbnail) }}" class="card-img-top"
                                                    alt="{{ $course->title }}" style="height: 200px; object-fit: cover;">
                                            @else
                                                <img src="https://via.placeholder.com/300x200" class="card-img-top"
                                                    alt="Placeholder" style="height: 200px; object-fit: cover;">
                                            @endif
                                            <div class="card-body">
                                                <h5 class="card-title">{{ $course->title }}</h5>
                                                <p class="card-text text-muted">{{ Str::limit($course->description, 100) }}
                                                </p>
                                                <div class="d-flex align-items-center text-secondary mb-2">
                                                    <p class="card-text m-0">
                                                        @if ($course->is_free)
                                                            Miễn phí
                                                        @else
                                                            Giá: {{ number_format($course->price, 0, ',', '.') }} VNĐ
                                                        @endif
                                                    </p>
                                                    <i class="fas fa-circle mx-2" style="font-size: 10px"></i>
                                                    <p class="card-text m-0">{{ $course->created_at->format('d/m/Y') }}</p>
                                                </div>
                                                <p class="card-text text-secondary" style="font-size: 12px">
                                                    Số bài học: {{ $course->lessons_count }} | Số học viên:
                                                    {{ $course->enrollments_count }}
                                                </p>
                                            </div>
                                            <div class="card-footer text-center bg-transparent">
                                                <a href="{{ route('instructor.courses.progress', $course->id) }}"
                                                    class="btn-sm text-dark">Theo dõi tiến độ</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="mt-4">
                                {{ $courses->links('pagination::bootstrap-5') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
