@extends('layouts.master_instructor')

@section('content')
    <div class="container-fluid mt-4">
        <h2 class="text-center">Danh Sách Bài Học</h2>
        <!-- Bộ lọc danh mục -->
        <div class="mb-3 mt-5">
            <div class="row flex align-items-center">
                <div class="col-6 d-flex align-items-center">
                    <a href="{{ route('instructor.lesson.create') }}" class="btn btn-primary">Thêm Bài Học</a>
                    <select id="categoryFilter" style="margin-left: 10px; border: 1px solid #ccc; padding: 5px 10px;">
                        <option value="">-- Lọc theo Khóa Học --</option>
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-6 d-flex justify-content-end">
                    {{-- Tìm kiếm --}}
                    <form action="{{ route('instructor.courses.index') }}" method="GET">
                        <div class="input-group">
                            <input type="text" name="keyword" style="border: 1px solid #ccc; padding: 5px 10px;"
                                placeholder="Tìm kiếm bài học">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <table class="table table-hover table-bordered">
            <thead class="table-primary">
                <tr>
                    <th>#</th>
                    <th>Hình ảnh</th>
                    <th>Tiêu đề</th>
                    <th>Khóa học</th>
                    <th>Thứ tự</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($lessons as $lesson)
                    <tr class="course-item" data-category="{{ $lesson->course_id }}">
                        <td>{{ $lesson->id }}</td>

                        {{-- Hiển thị hình ảnh khóa học nếu có --}}
                        <td>
                            @if ($lesson->course->thumbnail)
                                <img src="{{ asset($lesson->course->thumbnail) }}" alt="Course Image" width="80"
                                    height="50" style="object-fit: cover; border-radius: 5px;">
                            @else
                                <img src="{{ asset('images/default-thumbnail.jpg') }}" alt="Default Image" width="80"
                                    height="50" style="object-fit: cover; border-radius: 5px;">
                            @endif
                        </td>

                        <td>{{ $lesson->title }}</td>
                        <td>{{ $lesson->course->title ?? 'N/A' }}</td>
                        <td>{{ $lesson->order_number }}</td>

                        <td>
                            <a href="{{ route('instructor.lesson.edit', $lesson->id) }}"
                                class="btn btn-warning btn-sm">Sửa</a>
                            <form action="{{ route('instructor.lesson.destroy', $lesson->id) }}" method="POST"
                                style="display:inline;" onsubmit="return confirm('Bạn có chắc muốn xóa?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Hiển thị thông báo nếu không có bài học nào --}}
        @if ($lessons->isEmpty())
            <div class="alert alert-warning text-center mt-3">Chưa có bài học nào!</div>
        @endif

        <script>
            document.getElementById('categoryFilter').addEventListener('change', function() {
                let selectedCategory = this.value;
                document.querySelectorAll('.course-item').forEach(item => {
                    item.style.display = selectedCategory === '' || item.getAttribute('data-category') ===
                        selectedCategory ? 'table-row' : 'none';
                });
            });
        </script>
    </div>
@endsection
