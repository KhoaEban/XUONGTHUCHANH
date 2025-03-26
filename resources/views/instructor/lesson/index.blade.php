@extends('layouts.master')

@section('content')
<div class="container">
    <h1>Lessons</h1>
    <a href="{{ route('instructor.lesson.create') }}" class="btn btn-primary mb-3">Add Lesson</a>
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Course</th>
                <th>Title</th>
                <th>Order</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($lessons as $lesson)
            <tr>
                <td>{{ $lesson->id }}</td>
                <td>{{ $lesson->course->title ?? 'N/A' }}</td>
                <td>{{ $lesson->title }}</td>
                <td>{{ $lesson->order_number }}</td>
                <td>
                    <a href="{{ route('instructor.lesson.edit', $lesson->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('instructor.lesson.destroy', $lesson->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
