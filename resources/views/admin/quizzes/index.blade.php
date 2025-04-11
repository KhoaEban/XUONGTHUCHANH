@extends('layouts.master_admin')

@section('content')
    <div class="container-fluid mt-4">
        <h2 class="mb-3">Danh Sách Quizzes</h2>
        <div class="d-flex justify-content-between mb-3">
            <div class="d-flex justify-content-between gap-2">
                <a href="{{ route('admin.quizzes.create') }}" class=""
                    style="border: none; background-color: #2185D0; color: white; padding: 10px; font-size: 16px; font-weight: bold; text-decoration: none;">Thêm
                    Quizzes
                </a>
                {{-- Tìm kiếm --}}
                <form action="#" method="GET">
                    <div class="input-group">
                        <input type="text" name="keyword" style="border: 1px solid #ccc; padding: 10px;"
                            placeholder="Tìm kiếm bài học">
                        <button type="submit" class="btn btn-dark"><i class="fas fa-search"></i></button>
                    </div>
                </form>
            </div>
            <div class="d-flex align-items-center gap-2">
                <form action="#" method="GET">
                    <select id="courseFilter" name="course_id" class="text-center"
                        style="margin-left: 10px; border: 1px solid #ccc; padding: 10px 10px;">
                        <option value="">-- Lọc theo khóa học --</option>
                    </select>
                </form>
                <form action="#" method="GET" style="margin-right: 5px;">
                    <select id="lessonFilter" name="lesson_id" class="text-center"
                        style="margin-left: 10px; border: 1px solid #ccc; padding: 10px 10px;">
                        <option value="">-- Lọc theo Bài học --</option>
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
                    <th>Mã Khóa học</th>
                    <th>Mã bài học</th>
                    <th>Tiêu đề</th>
                    <th>Slug</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody class="align-middle">
                @foreach ($quizzes as $quiz)
                    <tr>
                        <td>{{ $quiz->id }}</td>
                        <td>{{ $quiz->course_id }}</td>
                        <td>{{ $quiz->lesson_id }}</td>
                        <td>{{ $quiz->title }}</td>
                        <td>{{ $quiz->slug }}</td>
                        <td>
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('admin.questions.create', ['quiz_id' => $quiz->id]) }}"><i class="fas fa-plus" title="thêm câu hỏi"></i></a>
                                <a href="{{ route('admin.quizzes.edit', $quiz->id) }}" class="text-warning"><i
                                        class="fas fa-edit" title="sửa quiz"></i></a>
                                <form action="{{ route('admin.quizzes.destroy', $quiz->id) }}" method="POST"
                                    style="display:inline;" onsubmit="return confirm('Bạn có chắc muốn xóa?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="border: none; background-color: transparent;"
                                        class="text-danger"><i class="fas fa-trash" title="xóa quiz"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Hiển thị thông báo nếu không có bài học nào --}}
        @if ($quizzes->isEmpty())
            <div class="alert alert-warning text-center mt-3">Chưa có bài học nào!</div>
        @endif
    </div>
@endsection