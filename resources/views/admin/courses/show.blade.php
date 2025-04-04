@extends('layouts.master_admin')

@section('content')
<div class="container-fluid">
    <h2 class="mb-3">Chi Tiết Khóa Học</h2>
    
    <div class="card" style="background-color: #F8F9FC">
        <div class="text-dark card-header" style="background-color: #F8F9FC">
            <h4>{{ $course->title }}</h4>
        </div>
        <div class="card-body">
            <p><strong>Người tạo:</strong> {{ $course->instructor->name }}</p>
            <p><strong>Danh mục:</strong> {{ $course->category->name ?? 'Chưa có danh mục' }}</p>
            <p><strong>Giá:</strong> <span class="text-danger fw-bold">{{ number_format($course->price, 0, ',', '.') }} VNĐ</span></p>
            <p><strong>Mô tả:</strong> {{ $course->description }}</p>

            @if ($course->thumbnail)
                <p><strong>Hình ảnh:</strong></p>
                <img src="{{ asset($course->thumbnail) }}" width="200" alt="{{ $course->title }}">
            @endif

            <h4 class="mt-4">Chương trình học</h4>
            @if ($course->lessons->count() > 0)
                <ul class="list-group">
                    @foreach ($course->lessons as $lesson)
                        <li class="list-group-item">
                            <strong>Bài giảng:</strong> {{ $lesson->title }}
                            <br>
                            <small class="text-muted">{{ Str::limit($lesson->description, 100) }}</small>
                        </li>
                    @endforeach
                </ul>
            @else
                <p>Chưa có bài giảng nào.</p>
            @endif
        </div>
    </div>

    <a href="{{ route('admin.courses.index') }}" class="btn btn-secondary mt-3">Quay lại</a>
</div>
@endsection
