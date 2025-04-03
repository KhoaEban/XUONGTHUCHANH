@extends('layouts.master_instructor')

@section('content')
    <div class="container-fluid mt-4">
        <div class="card">
            <div class="card-header bg-primary text-white text-center">
                <h2 class="mb-0">Thêm Khóa Học</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('instructor.courses.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Tiêu đề:</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Mô tả:</label>
                        <textarea name="description" class="form-control" rows="4"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Danh mục:</label>
                        <select name="category_id" class="form-control" required>
                            <option value="">-- Chọn danh mục --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="thumbnail" class="form-label">Hình ảnh:</label>
                        <input type="file" name="thumbnail">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Giá:</label>
                        <input type="number" name="price" class="form-control" required>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-success">Thêm Khóa Học</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection