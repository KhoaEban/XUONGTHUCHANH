@extends('layouts.master_admin')

@section('content')
    <div class="container-fluid">
        <button class="btn btn-secondary mb-3"><a href="{{ route('admin.category.index') }}" class="text-white"><i
                    class="fas fa-arrow-left me-1"></i> Quay lại</a></button>
        <div class="py-3 mb-3" style="background-color: #2184d057">
            <p class="text-decoration-underline m-0 px-2" style="color: #15274F">Thêm Danh Mục</p>
        </div>
        <form action="{{ route('admin.category.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group mb-3">
                <label for="name">Tên danh mục:</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>

            <div class="form-group mb-3">
                <label for="parent_id">Danh mục cha:</label>
                <select name="parent_id" id="parent_id" class="form-control">
                    <option value="">-- Không có --</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="image">Hình ảnh danh mục:</label>
                <input type="file" name="image" id="image" class="form-control">
            </div>

            <button type="submit" class="btn" style="background-color: #2185D0; color: #fff">Thêm danh mục</button>
        </form>
    </div>
@endsection
