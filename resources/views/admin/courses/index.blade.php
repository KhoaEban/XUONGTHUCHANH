@extends('layouts.master_admin')

@section('content')
    <div class="container-fluid">


        <h2 class="mb-3">Danh sách Khóa Học</h2>
        <div class="d-flex justify-content-between mb-3">
            <!-- Nút tạo khóa học -->
            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.courses.create') }}" class=""
                    style="border: none; background-color: #2185D0; color: white; padding: 10px; font-size: 16px; font-weight: bold;">Tạo
                    khóa học
                </a>
            </div>
            <div class="d-flex align-items-center gap-2">
                <!-- Tìm kiếm -->
                <form action="{{ route('admin.courses.index') }}" method="GET" class="d-flex align-items-center">
                    <input type="text" name="search" placeholder="Tìm kiếm khóa học" value="{{ request('search') }}"
                        class="d-inline w-auto"
                        style="border: none; border: 1px solid #6C757D; color: #000000; padding: 10px; font-size: 14px;"
                        onchange="this.form.submit()">
                </form>

                <!-- Lọc theo danh mục -->
                <form action="{{ route('admin.courses.index') }}" method="GET">
                    <select name="category_id" class="d-inline w-auto"
                        style="border: none; border: 1px solid #6C757D; color: #000000; padding: 10px; font-size: 14px;"
                        onchange="this.form.submit()">
                        <option value="">Tất cả danh mục</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </form>

                <!-- Sắp xếp thứ tự -->
                <form action="{{ route('admin.courses.index') }}" method="GET">
                    <select name="sort_order" class="d-inline w-auto"
                        style="border: none; border: 1px solid #6C757D; color: #000000; padding: 10px; font-size: 14px;"
                        onchange="this.form.submit()">
                        <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>Giảm dần</option>
                        <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>Tăng dần</option>
                    </select>
                </form>

                {{-- Xem khóa học của giảng viên đã tạo --}}
                <form action="{{ route('admin.courses.index') }}" method="GET" style="margin-right: 5px;">
                    <select name="instructor_id" class="d-inline w-auto"
                        style="border: none; border: 1px solid #6C757D; color: #000000; padding: 10px; font-size: 14px;"
                        onchange="this.form.submit()">
                        <option value="">-- Lọc theo --</option>
                        @foreach ($instructors as $instructor)
                            <option value="{{ $instructor->id }}"
                                {{ request('instructor_id') == $instructor->id ? 'selected' : '' }}>
                                {{ $instructor->name }}
                            </option>
                        @endforeach
                    </select>
                </form>
                <form action="" method="">
                    <select class="d-inline w-auto"
                        style="border: none; border: 1px solid #6C757D; color: #000000; padding: 10px; font-size: 14px;">
                        <option value="">Bulk Actions</option>
                        <option value="delete">Delete</option>
                    </select>
                    {{-- <button type="submit"
                        style="border: none; background-color: #6C757D; color: white; padding: 10px; font-size: 14px;">Apply</button> --}}
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table">
                    <thead class="text-center">
                        <tr>
                            <th>#</th>
                            <th>Hình ảnh</th>
                            <th>Tiêu đề</th>
                            <th>Mô tả</th>
                            <th>Danh mục</th>
                            <th>Giá</th>
                            <th>Người tạo</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle text-center">
                        @foreach ($courses as $index => $course)
                            @if (auth()->user()->role === 'admin' || auth()->user()->id === $course->instructor_id)
                                <tr class="course-item" data-category="{{ $course->category_id }}">
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        @if ($course->thumbnail)
                                            <img src="{{ asset($course->thumbnail) }}" alt="{{ $course->title }}"
                                                width="80">
                                        @else
                                            <img src="{{ asset('uploads/default.png') }}" alt="Default Image"
                                                width="80">
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('courses.show', $course->slug) }}">{{ $course->title }}</a>
                                    </td>
                                    <td>{{ Str::limit($course->description, 50) }}</td>
                                    <td>{{ $course->category->name ?? 'Chưa có danh mục' }}</td>
                                    <td class="text-danger fw-bold">{{ number_format($course->price, 0, ',', '.') }} VNĐ
                                    </td>
                                    <td>{{ $course->instructor->name }}</td>
                                    <td>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <a class="text-info" href="{{ route('admin.courses.show', $course->id) }}"><i
                                                    class="fa fa-eye"></i></a>
                                            <a class="text-warning" href="{{ route('admin.courses.edit', $course->id) }}">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.courses.destroy', $course->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button class="border-0 bg-transparent text-danger" type="submit"
                                                    onclick="return confirm('Bạn có chắc muốn xóa không?')"><i
                                                        class="fa fa-trash"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>

                <!-- Phân trang -->
                <div class="d-flex justify-content-end">
                    {{ $courses->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
