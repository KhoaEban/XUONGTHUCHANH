@extends('layouts.master_admin')

@section('title', 'Thêm Danh Mục Con')

@section('content')
    <div class="container-fluid">
        <h2 class="mb-4">Thêm Danh Mục Con</h2>

        <form action="{{ route('admin.category.assignChild') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="parent_id" value="{{ $parentCategory->id }}">

            <!-- Hiển thị danh mục cha -->
            <div class="form-group mb-3">
                <label for="parent_name" class="form-label">Danh mục cha:</label>
                <input type="text" class="form-control" value="{{ $parentCategory->name }}" readonly>
            </div>

            <!-- Chọn danh mục có sẵn để gán -->
            <div class="form-group mb-3">
                <label for="child_id" class="form-label">Chọn danh mục con có sẵn:</label>
                <select name="child_id" id="child_id" class="form-control">
                    <option value="">-- Chọn danh mục --</option>
                    @foreach ($categories as $category)
                        @if ($category->id !== $parentCategory->id)
                            {{-- Tránh chọn chính nó làm danh mục con --}}
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="d-flex">
                <button type="submit" class="btn btn-success me-2">Gán danh mục</button>
                <a href="{{ route('admin.category.index') }}" class="btn btn-secondary">Hủy</a>
            </div>
        </form>
    </div>
@endsection
