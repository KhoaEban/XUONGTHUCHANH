@extends('layouts.master_admin')

@section('content')
    <div class="container">
        <h2 class="mb-4">Thêm Danh Mục</h2>

        <form action="{{ route('admin.category.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">Tên danh mục:</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="parent_id">Danh mục cha:</label>
                <select name="parent_id" id="parent_id" class="form-control">
                    <option value="">-- Không có --</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="image">Hình ảnh danh mục:</label>
                <input type="file" name="image" id="image" class="form-control">
            </div>

            <button type="submit" class="btn btn-success">Thêm</button>
            <a href="{{ route('admin.category.index') }}" class="btn btn-secondary">Hủy</a>
        </form>
    </div>
@endsection
