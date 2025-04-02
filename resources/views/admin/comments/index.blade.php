@extends('layouts.master_admin')

@section('content')
    <h2>Quản lý bình luận</h2>
    @if(session('success'))
        <p style="color: green">{{ session('success') }}</p>
    @endif
    <table border="1">
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
                    <td>{{ $comment->status == 'visible' ? 'Hiển thị' : 'Ẩn' }}</td>
                    <td>
                        @if($comment->status == 'visible')
                            <form action="{{ route('admin.comments.hide', $comment->id) }}" method="POST">
                                @csrf
                                <button type="submit">Ẩn</button>
                            </form>
                        @else
                            <form action="{{ route('admin.comments.show', $comment->id) }}" method="POST">
                                @csrf
                                <button type="submit">Hiện</button>
                            </form>
                        @endif
                        <form action="{{ route('admin.comments.destroy', $comment->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Xóa bình luận này?')">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $comments->links() }}
@endsection
