@extends('layouts.master_instructor')

@section('content')
    <div class="container-fluid mt-4">
        <h2 class="text-center">Danh Sách Khóa Học</h2>
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
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
                            <input type="text" name="search" style="border: 1px solid #ccc; padding: 5px 10px;"
                                placeholder="Tìm kiếm khóa học" value="{{ request('search') }}">
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
                <tr id="noCourseMessage" style="display: none;">
                    <td colspan="7" class="text-center text-danger fw-bold">Chưa có khóa học trong danh mục này.</td>
                </tr>
                @if ($courses->isEmpty())
                    <tr>
                        <td colspan="7" class="text-center text-danger fw-bold">Không tìm thấy khóa học phù hợp.</td>
                    </tr>
                @endif

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
                            {{ $course->title }}
                        </td>
                        <td>{{ Str::limit($course->description, 50) }}</td>
                        <td>{{ $course->category->name ?? 'Chưa có danh mục' }}</td>
                        <td class="fw-bold">
                            <p class="card-text m-0">
                                @if ($course->is_free)
                                    <span class="badge bg-success">Miễn phí</span>
                                @else
                                    <span class="text-danger">
                                        {{ number_format($course->price, 0, ',', '.') }} VNĐ
                                    </span>
                                @endif
                            </p>
                        </td>
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
            let courseItems = document.querySelectorAll('.course-item');
            let noCourseMessage = document.getElementById('noCourseMessage');
            let hasVisibleCourses = false;

            courseItems.forEach(item => {
                if (selectedCategory === '' || item.getAttribute('data-category') === selectedCategory) {
                    item.style.display = 'table-row';
                    hasVisibleCourses = true;
                } else {
                    item.style.display = 'none';
                }
            });

            // Hiển thị thông báo nếu không có khóa học nào
            if (!hasVisibleCourses) {
                noCourseMessage.style.display = 'table-row';
            } else {
                noCourseMessage.style.display = 'none';
            }
        });
    </script>
@endsection
