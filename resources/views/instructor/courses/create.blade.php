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

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label">Tiêu đề:</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Mô tả:</label>
                        <textarea name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Danh mục:</label>
                        <select name="category_id" class="form-control" required>
                            <option value="">-- Chọn danh mục --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="thumbnail" class="form-label">Hình ảnh:</label>
                        <input type="file" name="thumbnail" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Giá:</label>
                        <input type="number" name="price" class="form-control" value="{{ old('price') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Khóa học miễn phí:</label>
                        <input type="checkbox" name="is_free" id="is_free" value="1" onchange="togglePriceField()">
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-success">Thêm Khóa Học</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function togglePriceField() {
            const priceField = document.querySelector('input[name="price"]');
            const isFreeCheckbox = document.getElementById('is_free');

            if (isFreeCheckbox.checked) {
                priceField.value = 0; // Set price to 0 if free
                priceField.setAttribute('readonly', true); // Make price field read-only
            } else {
                priceField.removeAttribute('readonly'); // Make price field editable
            }
        }
    </script>
@endsection