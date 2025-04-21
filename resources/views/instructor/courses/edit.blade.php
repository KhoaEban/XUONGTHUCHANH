@extends('layouts.master_instructor')

@section('content')
    <div class="container-fluid mt-4">
        <div class="card">
            <div class="card-header">
                <h2 class="mb-0 text-center">Sửa Khóa Học</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('instructor.courses.update', $course->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

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
                        <input type="text" name="title" class="form-control" value="{{ $course->title }}" >
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Mô tả:</label>
                        <textarea name="description" class="form-control" rows="4">{{ $course->description }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Danh mục:</label>
                        <select name="category_id" class="form-control" >
                            <option value="">-- Chọn danh mục --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ $category->id == $course->category_id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Hình ảnh hiện tại:</label><br>
                        <img src="{{ asset($course->thumbnail) }}" alt="{{ $course->title }}" class="img-thumbnail"
                            width="150">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Chọn hình ảnh mới:</label>
                        <input type="file" name="thumbnail" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Giá:</label>
                        <input type="number" name="price" class="form-control" value="{{ old('price') }}" >
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Khóa học miễn phí:</label>
                        <input type="checkbox" name="is_free" id="is_free" value="1" onchange="togglePriceField()">
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-success">Cập Nhật</button>
                    </div>
                </form>

                <hr>

                <form action="{{ route('instructor.courses.destroy', $course->id) }}" method="POST" class="text-center">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa
                        Khóa Học</button>
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
