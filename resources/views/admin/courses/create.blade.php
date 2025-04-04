@extends('layouts.master_admin')

@section('content')
    <div class="container-fluid">
        <button class="btn btn-secondary mb-3"><a href="{{ route('admin.courses.index') }}" class="text-white"><i
                    class="fas fa-arrow-left me-1"></i> Quay lại</a></button>
        <div class="py-3 mb-3" style="background-color: #2184d057">
            <p class="text-decoration-underline m-0 px-2" style="color: #15274F">Tạo khóa học</p>
        </div>
        <form action="{{ route('admin.courses.store') }}" method="POST" enctype="multipart/form-data">
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
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="thumbnail" class="form-label">Hình ảnh:</label>
                <input type="file" name="thumbnail">
            </div>

            <!-- Checkbox "Khóa học miễn phí" -->
            <div class="mb-3">
                <label for="is_free" class="form-label">Khóa học miễn phí</label>
                <input type="checkbox" name="is_free" id="is_free" value="1" {{ old('is_free') ? 'checked' : '' }}
                    onclick="togglePriceField()">
            </div>

                <!-- Trường giá sẽ bị ẩn khi "Khóa học miễn phí" được chọn -->
            <div class="mb-3" id="price-field">
                <label class="form-label">Giá:</label>
                <input type="number" name="price" class="form-control" required>
            </div>


            <div class="text-center">
                <button type="submit" class="btn btn-success">Thêm Khóa Học</button>
            </div>
        </form>
    </div>

    <script>
        function togglePriceField() {
            var isFree = document.getElementById('is_free').checked;
            var priceField = document.getElementById('price-field');
            var priceInput = document.getElementsByName('price')[0];

            if (isFree) {
                priceField.style.display = 'none'; // Ẩn trường giá
                priceInput.removeAttribute('required'); // Bỏ qua yêu cầu nhập giá khi miễn phí
            } else {
                priceField.style.display = 'block'; // Hiển thị lại trường giá
                priceInput.setAttribute('required', 'required'); // Đặt lại yêu cầu nhập giá
            }
        }

        // Gọi hàm khi trang tải để xử lý checkbox đã được chọn hay chưa
        window.onload = togglePriceField;
    </script>
@endsection
