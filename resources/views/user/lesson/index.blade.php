@extends('layouts.master')

@section('content')
    <div class="container-fluid mt-5">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h1>{{ $lesson->title }}</h1>
                <iframe width="100%" height="400" src="{{ $lesson->video_url }}" frameborder="0" allowfullscreen></iframe>
                <p>{{ $lesson->content }}</p>

                <h2>Khóa học: <a href="{{ route('courses.show', $course->id) }}">{{ $course->title }}</a></h2>

                <h3>Các khóa học liên quan</h3>
                <ul>
                    @foreach ($relatedCourses as $related)
                        <li><a href="{{ route('courses.show', $related->id) }}">{{ $related->title }}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection
