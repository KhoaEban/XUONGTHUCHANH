@extends('layouts.master_admin')

@section('content')
    <div class="container">
        <h2 class="mb-4">Chỉnh sửa Danh Mục</h2>

        <form action="{{ route('admin.category.update', $category->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Tên danh mục:</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ $category->name }}" required>
            </div>

            <div class="form-group">
                <label for="parent_id">Danh mục cha:</label>
                <select name="parent_id" id="parent_id" class="form-control">
                    <option value="">-- Không có --</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}" {{ $category->parent_id == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="image">Hình ảnh danh mục:</label>
                <input type="file" name="image" id="image" class="form-control">
                @if ($category->image)
                    <img src="{{ asset('storage/' . $category->image) }}" width="50" height="50">
                @endif
            </div>

            <button type="submit" class="btn btn-primary">Cập nhật</button>
            <a href="{{ route('admin.category.index') }}" class="btn btn-secondary">Hủy</a>
        </form>
    </div>
@endsection
