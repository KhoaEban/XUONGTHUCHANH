@extends('layouts.master_admin')

@section('content')
    <h2>Quản lý bình luận</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Người bình luận</th>
                    <th>Bài học</th>
                    <th>Nội dung</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($comments as $comment)
                    <tr>
                        <td>{{ $comment->user->name }}</td>
                        <td>{{ $comment->lesson->title }}</td>
                        <td>{{ $comment->content }}</td>
                        <td>
                            <span class="badge {{ $comment->status == 'visible' ? 'bg-success' : 'bg-warning' }}">
                                {{ $comment->status == 'visible' ? 'Hiển thị' : 'Ẩn' }}
                            </span>
                        </td>
                        <td>
                            @if($comment->status == 'visible')
                                <form action="{{ route('admin.comments.hide', $comment->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-warning btn-sm">Ẩn</button>
                                </form>
                            @else
                                <form action="{{ route('admin.comments.show', $comment->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">Hiện</button>
                                </form>
                            @endif

                            <form action="{{ route('admin.comments.destroy', $comment->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Xóa bình luận này?')">
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
