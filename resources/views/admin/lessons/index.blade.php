@extends('layouts.master_admin')

@section('content')
    <div class="container-fluid mt-4">
        <h2 class="mb-3">Danh Sách Bài Học</h2>
        <div class="d-flex justify-content-between mb-3">
            <!-- Nút tạo khóa học -->
            <div class="d-flex justify-content-between gap-2">
                <a href="{{ route('admin.lessons.create') }}" class=""
                    style="border: none; background-color: #2185D0; color: white; padding: 10px; font-size: 16px; font-weight: bold;">Thêm
                    Bài Học
                </a>
                {{-- Tìm kiếm --}}
                <form action="{{ route('admin.courses.index') }}" method="GET">
                    <div class="input-group">
                        <input type="text" name="keyword" style="border: 1px solid #ccc; padding: 10px;"
                            placeholder="Tìm kiếm bài học">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                    </div>
                </form>
            </div>
            <div class="d-flex align-items-center gap-2">
                <form action="{{ route('admin.lessons.index') }}" method="GET" style="margin-right: 5px;">
                    {{-- Lọc theo khóa học --}}
                    <select id="categoryFilter" class="text-center"
                        style="margin-left: 10px; border: 1px solid #ccc; padding: 10px 10px;">
                        <option value="">-- Lọc theo Khóa Học --</option>
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->title }}</option>
                        @endforeach
                    </select>
                </form>
                <form action="{{ route('admin.lessons.index') }}" method="GET">
                    <select id="instructorFilter" name="instructor_id" class="text-center"
                        style="margin-left: 10px; border: 1px solid #ccc; padding: 10px 10px;">
                        <option value="">-- Xem khóa học của --</option>
                        @foreach ($instructors as $instructor)
                            <option value="{{ $instructor->id }}"
                                {{ request('instructor_id') == $instructor->id ? 'selected' : '' }}>
                                {{ $instructor->name }}
                            </option>
                        @endforeach
                    </select>
                </form>
                <form action="" method="">
                    <select class="d-inline w-auto" style="margin-left: 10px; border: 1px solid #ccc; padding: 10px 10px;">
                        <option value="">Bulk Actions</option>
                        <option value="delete">Delete</option>
                    </select>
                </form>
            </div>
        </div>

        <table class="table text-center">
            <thead class="">
                <tr>
                    <th>#</th>
                    <th>Hình ảnh</th>
                    <th>Tiêu đề</th>
                    <th>Khóa học</th>
                    <th>Thứ tự bài học</th>
                    <th>Người tạo</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody class="align-middle">
                @foreach ($lessons as $index => $lesson)
                    @if (auth()->user()->role === 'admin' || auth()->user()->id === $lesson->instructor_id)
                        <tr class="course-item" data-category="{{ $lesson->course_id }}"
                            data-instructor="{{ $lesson->instructor->id ?? '' }}">
                            <td>{{ $lesson->id }}</td>

                            {{-- Hiển thị hình ảnh khóa học nếu có --}}
                            <td>
                                @if ($lesson->course->thumbnail)
                                    <img src="{{ asset($lesson->course->thumbnail) }}" alt="Course Image" width="80"
                                        height="50" style="object-fit: cover; border-radius: 5px;">
                                @else
                                    <img src="{{ asset('images/default-thumbnail.jpg') }}" alt="Default Image"
                                        width="80" height="50" style="object-fit: cover; border-radius: 5px;">
                                @endif
                            </td>

                            <td>{{ $lesson->title }}</td>
                            <td>{{ $lesson->course->title ?? 'N/A' }}</td>
                            <td>{{ $lesson->order_number }}</td>
                            <td>{{ $lesson->instructor->name ?? 'N/A' }}</td>

                            <td>
                                <div class="d-flex justify-content-between align-items-center">
                                    <a href="{{ route('admin.lessons.show', $lesson->id) }}" class="text-primary"><i
                                            class="fas fa-eye"></i></a>
                                    <a href="{{ route('admin.lessons.edit', $lesson->id) }}" class="text-warning"><i
                                            class="fas fa-edit"></i></a>
                                    <form action="{{ route('admin.lessons.destroy', $lesson->id) }}" method="POST"
                                        style="display:inline;" onsubmit="return confirm('Bạn có chắc muốn xóa?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="border: none; background-color: transparent;"
                                            class="text-danger"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>

        {{-- Hiển thị thông báo nếu không có bài học nào --}}
        @if ($lessons->isEmpty())
            <div class="alert alert-warning text-center mt-3">Chưa có bài học nào!</div>
        @endif
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const categoryFilter = document.getElementById('categoryFilter');
            const instructorFilter = document.getElementById('instructorFilter');

            function applyFilters() {
                let selectedCategory = categoryFilter.value;
                let selectedInstructor = instructorFilter.value;

                document.querySelectorAll('.course-item').forEach(item => {
                    let itemCategory = item.getAttribute('data-category');
                    let itemInstructor = item.getAttribute('data-instructor');

                    let matchCategory = (selectedCategory === "" || itemCategory === selectedCategory);
                    let matchInstructor = (selectedInstructor === "" || itemInstructor ===
                        selectedInstructor);

                    item.style.display = (matchCategory && matchInstructor) ? 'table-row' : 'none';
                });
            }

            categoryFilter.addEventListener('change', applyFilters);
            instructorFilter.addEventListener('change', applyFilters);
        });
    </script>
@endsection
