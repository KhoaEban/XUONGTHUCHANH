@extends('layouts.master_admin')

@section('content')
    <div class="container-fluid">
        <button class="btn btn-secondary mb-3"><a href="{{ route('admin.course.index') }}" class="text-white"><i
                    class="fas fa-arrow-left me-1"></i> Quay lại</a></button>
        <div class="py-3 mb-3" style="background-color: #2184d057">
            <p class="text-decoration-underline m-0 px-2" style="color: #15274F">Tạo khóa học</p>
        </div>
        <form action="{{ route('admin.course.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group mb-3">
                <label for="name">Tên hóa học:</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="form-group mb-3">
                <label for="description">Mô tả:</label>
                <textarea name="description" id="description" class="form-control" required></textarea>
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

            <div class="form-group mb-3">
                <label for="image">Hình ảnh:</label>
                <input type="file" name="image" id="image" class="form-control-file" required>
            </div>
            <button type="submit" class="btn" style="background-color: #2185D0; color: #fff">Thêm khóa học</button>
        </form>
    </div>
@endsection
