@extends('layouts.master_instructor')

@section('content')
    <div class="container-fluid mt-4">
        <h2 class="text-center">Danh Sách Khóa Học</h2>

        <!-- Bộ lọc danh mục -->
        <div class="mb-3 mt-5">
            <div class="row flex align-items-center">
                <div class="col-6 d-flex align-items-center">
                    <a href="{{ route('instructor.courses.create') }}" class="btn btn-primary">Thêm Khóa Học</a>
                    <select id="categoryFilter" style="margin-left: 10px; border: 1px solid #ccc; padding: 5px 10px;">
                        <option value="">-- Lọc theo danh mục --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-6 d-flex justify-content-end">
                    {{-- Tìm kiếm --}}
                    <form action="{{ route('instructor.courses.index') }}" method="GET">
                        <div class="input-group">
                            <input type="text" name="keyword" style="border: 1px solid #ccc; padding: 5px 10px;" placeholder="Tìm kiếm khóa học">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Bảng hiển thị danh sách khóa học -->
        <table class="table table-bordered">
            <thead class="table-primary">
                <tr>
                    <th>#</th>
                    <th>Hình ảnh</th>
                    <th>Tiêu đề</th>
                    <th>Mô tả</th>
                    <th>Danh mục</th>
                    <th>Giá</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($courses as $index => $course)
                    <tr class="course-item" data-category="{{ $course->category_id }}">
                        <td>{{ $index + 1 }}</td>
                        <td>
                            @if ($course->thumbnail)
                                <img src="{{ asset($course->thumbnail) }}" alt="{{ $course->title }}" width="80">
                            @else
                                <img src="{{ asset('uploads/default.png') }}" alt="Default Image" width="80">
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('courses.show', $course->slug) }}">{{ $course->title }}</a>
                        </td>
                        <td>{{ Str::limit($course->description, 50) }}</td>
                        <td>{{ $course->category->name ?? 'Chưa có danh mục' }}</td>
                        <td class="text-danger fw-bold">{{ number_format($course->price, 0, ',', '.') }} VNĐ</td>
                        <td>
                            <a href="{{ route('instructor.courses.edit', $course->id) }}"
                                class="btn btn-warning btn-sm">Sửa</a>
                            <form action="{{ route('instructor.courses.destroy', $course->id) }}" method="POST"
                                class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Bạn có chắc muốn xóa không?')">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        document.getElementById('categoryFilter').addEventListener('change', function() {
            let selectedCategory = this.value;
            document.querySelectorAll('.course-item').forEach(item => {
                item.style.display = selectedCategory === '' || item.getAttribute('data-category') ===
                    selectedCategory ? 'table-row' : 'none';
            });
        });
    </script>
@endsection