@extends('layouts.master_admin')

@section('content')
<div class="container-fluid">
    <h2 class="mb-3">Chi Tiết Bài Học</h2>
    
    <div class="card" style="background-color: #F8F9FC">
        <div class="text-dark card-header" style="background-color: #F8F9FC">
            <h4>{{ $lessons->title }}</h4>
        </div>
        <div class="card-body">
            <p><strong>Người tạo:</strong> {{ $lessons->instructor->name }}</p>
            <p><strong>Danh mục:</strong> {{ $lessons->category->name ?? 'Chưa có danh mục' }}</p>
            <p><strong>Giá:</strong> <span class="text-danger fw-bold">{{ number_format($lessons->price, 0, ',', '.') }} VNĐ</span></p>
            <p><strong>Mô tả:</strong> {{ $lessons->description }}</p>

            @if ($lessons->thumbnail)
                <p><strong>Hình ảnh:</strong></p>
                <img src="{{ asset($lessons->thumbnail) }}" width="200" alt="{{ $lessons->title }}">
            @endif

            <h4 class="mt-4">Chương trình học</h4>
            @if ($lessons->lessons->count() > 0)
                <ul class="list-group">
                    @foreach ($lessons->lessons as $lesson)
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

    <a href="{{ route('admin.lessons.index') }}" class="btn btn-secondary mt-3">Quay lại</a>
</div>
@endsection
