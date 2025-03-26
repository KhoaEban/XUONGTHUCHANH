@extends('layouts.master_instructor')

@section('content')
<div class="container-fluid">
    <h1>Add Lesson</h1>
    <form action="{{ route('instructor.lesson.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="course_id">Course</label>
            <select name="course_id" id="course_id" class="form-control">
                <option value="" disabled selected>Select a course</option>
                @foreach($courses as $course)
                <option value="{{ $course->id }}">{{ $course->title }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" class="form-control">
        </div>
        <div class="form-group">
            <label for="video_url">Video URL</label>
            <input type="url" name="video_url" id="video_url" class="form-control">
        </div>
        <div class="form-group">
            <label for="content">Content</label>
            <textarea name="content" id="content" class="form-control"></textarea>
        </div>
        <div class="form-group">
            <label for="order_number">Order Number</label>
            <input type="number" name="order_number" id="order_number" class="form-control">
        </div>
        <button type="submit" class="btn btn-success mt-3">Save</button>
    </form>
</div>
@endsection