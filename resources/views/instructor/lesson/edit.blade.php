@extends('layouts.master')

@section('content')
<div class="container">
    <h1>Edit Lesson</h1>
    <form action="{{ route('instructor.lesson.update', $lesson->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="course_id">Course</label>
            <select name="course_id" id="course_id" class="form-control">
                @foreach($courses as $course)
                <option value="{{ $course->id }}" {{ $lesson->course_id == $course->id ? 'selected' : '' }}>
                    {{ $course->title }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ $lesson->title }}">
        </div>
        <div class="form-group">
            <label for="video_url">Video URL</label>
            <input type="url" name="video_url" id="video_url" class="form-control" value="{{ $lesson->video_url }}">
        </div>
        <div class="form-group">
            <label for="content">Content</label>
            <textarea name="content" id="content" class="form-control">{{ $lesson->content }}</textarea>
        </div>
        <div class="form-group">
            <label for="order_number">Order Number</label>
            <input type="number" name="order_number" id="order_number" class="form-control" value="{{ $lesson->order_number }}">
        </div>
        <button type="submit" class="btn btn-success mt-3">Update</button>
    </form>
</div>
@endsection
