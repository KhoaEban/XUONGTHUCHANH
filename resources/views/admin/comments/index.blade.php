@extends('layouts.master_admin')

@section('content')
    <h2>Quản lý bình luận</h2>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Người bình luận</th>
                    <th>Bài học</th>
                    <th>Nội dung</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($comments as $comment)
                    <tr>
                        <td>{{ $comment->user->name }}</td>
                        <td>{{ $comment->lesson->title }}</td>
                        <td>{{ $comment->content }}</td>
                        <td>
                            <form action="{{ route('admin.comments.destroy', $comment->id) }}" method="POST"
                                class="d-inline" onsubmit="return confirm('Xóa bình luận này?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="pagination-container">
        {{ $comments->links('pagination::bootstrap-5') }}
    </div>
@endsection
