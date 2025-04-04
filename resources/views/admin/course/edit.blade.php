@extends('layouts.master_admin')

@section('title', 'Sửa Khoa Học')

@section('content')
    <div class="container-fluid">
        <h2>Sửa Khoa Học</h2>

        <form action="{{ route('admin.course.update', $course->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="title">Tieu de</label>
                <input type="text" class="form-control" name="title" value="{{ $course->title }}" required>
            </div>
            <div class="form-group">
                <label for="description">Mota</label>
                <textarea class="form-control" name="description" required>{{ $course->description }}</textarea>
            </div>
            <div class="form-group">
                <label for="price">Gia</label>
                <input type="number" class="form-control" name="price" value="{{ $course->price }}" required>
            </div>
            <div class="form-group mb-3">
                <label for="category_id">Danh mục:</label>
                <select name="category_id" id="category_id" class="form-control" required>
                    <option value="">-- Chọn danh mục --</option>
                    @if (!empty($categories) && $categories->count() > 0)
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">
                                {{ $category->name }}
                                {{ isset($category->child_categories) && $category->child_categories->count() > 0 ? '--' : '' }}
                            </option>
                        @endforeach
                    @else
                        <option value="">Không có danh mục nào</option>
                    @endif
                </select>
            </div>
            <div class="form-group">
                <label for="image">Hinh anh</label>
                <input type="file" class="form-control-file" name="image">
            </div>
            <button type="submit" class="btn btn-primary">Cap nhat</button>
            <a href="{{ route('admin.course.index') }}" class="btn btn-secondary">Huy</a>
        </form>
    </div>
@endsection
