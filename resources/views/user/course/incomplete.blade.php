@extends('layouts.master')

@section('content')
    <div class="container">
        <h1>Các Khóa Học Chưa Hoàn Thành</h1>
        <br>
        <div class="row">
            @forelse ($incompleteCourses as $enrollment)
                @php
                    $course = $enrollment->course;
                @endphp
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <a href="{{ route('course.show', $course->slug) }}" class="card-link text-decoration-none text-dark">
                            <img class="card-img-top" src="{{ asset($course->thumbnail ?? 'images/default-thumbnail.jpg') }}" alt="{{ $course->title }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $course->title }}</h5>
                                <p class="card-text text-secondary small">Tác giả: {{ $course->instructor?->name ?? 'Không có tác giả' }}</p>
                                {{-- Bạn có thể thêm thông tin tiến độ hoặc nút "Tiếp tục học" ở đây --}}
                            </div>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p>Bạn chưa đăng ký khóa học nào hoặc đã hoàn thành tất cả.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection