@extends('layouts.master')

@section('content')
    <h2>Sửa bình luận</h2>

    <form action="{{ route('comments.update', $comment->id) }}" method="POST">
        @csrf
        <textarea name="content" required rows="3">{{ $comment->content }}</textarea>
        <button type="submit">Cập nhật</button>
    </form>
@endsection
