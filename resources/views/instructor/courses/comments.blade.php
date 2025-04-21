@extends('layouts.master_instructor')

@section('content')
    <div class="container-fluid mt-5">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Quản lý bình luận - Bài học: {{ $lesson->title }} (Khóa học: {{ $course->title }})
                        <a href="{{ route('instructor.courses.progress', $course->id) }}"
                            class="btn btn-secondary float-end">Quay lại</a>
                    </div>

                    <div class="card-body">
                        @if ($lesson->comments->isEmpty())
                            <p class="text-muted">Chưa có bình luận nào cho bài học này.</p>
                        @else
                            @foreach ($lesson->comments as $comment)
                                <div class="border p-3 mb-3">
                                    <p><strong>{{ $comment->user->name }}</strong> ({{ $comment->user->email }}) -
                                        {{ $comment->created_at->format('d/m/Y H:i') }}</p>
                                    <p>{{ $comment->content }}</p>

                                    <!-- Hiển thị các trả lời -->
                                    @if ($comment->replies->isNotEmpty())
                                        <div class="ms-4">
                                            @foreach ($comment->replies as $reply)
                                                <div class="border p-2 mb-2">
                                                    <p><strong>{{ $reply->user->name }}</strong> -
                                                        {{ $reply->created_at->format('d/m/Y H:i') }}</p>
                                                    <p>{{ $reply->content }}</p>

                                                    <!-- Nếu reply thuộc về giảng viên, hiển thị nút Sửa và Xóa -->
                                                    @if ($reply->user_id == Auth::id())
                                                        <div class="mt-2">
                                                            <button type="button" class="btn btn-warning btn-sm"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#editReplyModal-{{ $reply->id }}">Sửa</button>
                                                            <form
                                                                action="{{ route('instructor.courses.comments.delete', [$course->id, $lesson->id, $reply->id]) }}"
                                                                method="POST" style="display: inline-block;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger btn-sm"
                                                                    onclick="return confirm('Bạn có chắc muốn xóa câu trả lời này?')">Xóa</button>
                                                            </form>
                                                        </div>

                                                        <!-- Modal để chỉnh sửa câu trả lời -->
                                                        <div class="modal fade" id="editReplyModal-{{ $reply->id }}"
                                                            tabindex="-1"
                                                            aria-labelledby="editReplyModalLabel-{{ $reply->id }}"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title"
                                                                            id="editReplyModalLabel-{{ $reply->id }}">
                                                                            Chỉnh sửa câu trả lời</h5>
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal"
                                                                            aria-label="Close"></button>
                                                                    </div>
                                                                    <form
                                                                        action="{{ route('instructor.courses.comments.update', [$course->id, $lesson->id, $reply->id]) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        @method('PATCH')
                                                                        <div class="modal-body">
                                                                            <div class="mb-3">
                                                                                <textarea name="content" class="form-control" rows="3" required>{{ $reply->content }}</textarea>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary"
                                                                                data-bs-dismiss="modal">Đóng</button>
                                                                            <button type="submit"
                                                                                class="btn btn-primary">Lưu thay
                                                                                đổi</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif

                                    <!-- Hiển thị form trả lời nếu giảng viên chưa trả lời -->
                                    @if (!$comment->replies->contains('user_id', Auth::id()))
                                        <form
                                            action="{{ route('instructor.courses.comments.reply', [$course->id, $lesson->id]) }}"
                                            method="POST" class="mt-2">
                                            @csrf
                                            <input type="hidden" name="comment_id" value="{{ $comment->id }}">
                                            <div class="mb-3">
                                                <textarea name="content" class="form-control" rows="2" placeholder="Nhập câu trả lời..." required></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-primary btn-sm">Trả lời</button>
                                        </form>
                                    @endif
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
