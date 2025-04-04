@extends('layouts.master_admin')

@section('content')
    <h2>Quản lý bình luận</h2>
    @if (session('success'))
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
                @foreach ($comments as $comment)
                    <tr>
                        <td>{{ $comment->user->name }}</td>
                        <td>{{ $comment->lesson->title }}</td>
                        <td>{{ $comment->content }}</td>
                        <td>
                            <form action="{{ route('admin.comments.updateStatus', $comment->id) }}" method="POST"
                                class="d-inline">
                                @csrf
                                @method('PUT')
                                <select name="status" class="form-control form-control-sm d-inline-block w-auto"
                                    onchange="this.form.submit()">
                                    <option value="active" {{ $comment->status == 'active' ? 'selected' : '' }}> Hiển thị
                                    </option>
                                    <option value="pending" {{ $comment->status == 'pending' ? 'selected' : '' }}>Chờ duyệt
                                    </option>
                                    <option value="spam" {{ $comment->status == 'spam' ? 'selected' : '' }}>Spam</option>
                                    <option value="deleted" {{ $comment->status == 'deleted' ? 'selected' : '' }}>Đã xóa
                                    </option>
                                </select>
                            </form>
                        </td>
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
