@extends('layouts.master_instructor')

@section('content')
<div class="container-fluid mt-5">
    <h1>Chỉnh sửa bài học</h1>
    <form action="{{ route('instructor.lesson.update', $lesson->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="course_id">Khóa học:</label>
            <select name="course_id" id="course_id" class="form-control">
                @foreach($courses as $course)
                <option value="{{ $course->id }}" {{ $lesson->course_id == $course->id ? 'selected' : '' }}>
                    {{ $course->title }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="title">Tiêu đề:</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ $lesson->title }}">
        </div>
        <div class="form-group">
            <label for="video_url">Video URL:</label>
            <input type="url" name="video_url" id="video_url" class="form-control" value="{{ $lesson->video_url }}">
        </div>
        <div class="form-group">
            <label for="content">Nội dung:</label>
            <textarea name="content" id="content" rows="4" class="form-control">{{ $lesson->content }}</textarea>
        </div>
        <div class="form-group">
            <label for="order_number">Sắp xếp:</label>
            <input type="number" name="order_number" id="order_number" class="form-control" value="{{ $lesson->order_number }}">
        </div>
        <button type="submit" class="btn btn-success mt-3">Update</button>
    </form>
</div>
@endsection