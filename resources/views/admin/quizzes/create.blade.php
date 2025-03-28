@extends('layouts.master_admin')

@section('content')
    <div class="container-fluid">
        <button class="btn btn-secondary mb-3"><a href="{{ route('admin.quizzes.index') }}" class="text-white"><i
                    class="fas fa-arrow-left me-1"></i> Quay lại</a></button>
        <div class="py-3 mb-3" style="background-color: #2184d057">
            <p class="text-decoration-underline m-0 px-2" style="color: #15274F">Thêm bài học</p>
        </div>
        <form action="{{ route('admin.quizzes.store') }}" method="POST">
            @csrf
            <label>Course ID:</label>
            <input type="number" name="course_id" required>
            <label>Title:</label>
            <input type="text" name="title" required>
            <button type="submit">Save</button>
        </form>
    </div>
@endsection
