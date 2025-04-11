<h5 class="mb-3">{{ $lesson->comments->count() }} Bình luận</h5>
@foreach ($comments->where('parent_id', null)->sortByDesc('created_at') as $comment)
    <li class="list-group-item @if ($comment->user->isTeacher()) comment-teacher @endif">
        <div class="card">
            <div class="card-body">
                <div class="user-info d-flex align-items-center">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($comment->user->name) }}&background=random"
                        class="avatar rounded-circle me-2" alt="{{ $comment->user->name }}">
                    <div class="d-flex justify-content-between w-100">
                        <div>
                            <strong>{{ $comment->user->name }}</strong>
                            @if ($comment->user->isTeacher())
                                <span class="badge bg-primary ms-2">Giảng viên</span>
                            @elseif ($comment->user->isAdmin())
                                <span class="badge bg-danger ms-2">Quản trị viên</span>
                            @endif
                            <span class="text-muted ms-2">{{ $comment->created_at->diffForHumans() }}</span>
                        </div>

                        @auth
                            @if (auth()->id() == $comment->user_id)
                                <div class="dropdown d-end">
                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                                        id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        … <!-- Ba chấm icon -->
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li>
                                            <button class="dropdown-item" onclick="openEditForm({{ $comment->id }})">
                                                <i class="fas fa-edit"></i> Sửa
                                            </button>
                                        </li>
                                        <li>
                                            <form action="{{ route('comments.destroy', $comment->id) }}" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Bạn có chắc chắn muốn xóa bình luận này?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item">
                                                    <i class="fas fa-trash"></i> Xóa
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            @endif
                        @endauth
                    </div>
                </div>

                <p id="comment-content-{{ $comment->id }}" class="mt-2">
                    {{ $comment->content }}
                </p>

                @auth
                    <div id="edit-form-{{ $comment->id }}" class="mt-2" style="display: none;">
                        <form action="{{ route('comments.update', $comment->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <textarea name="content" class="form-control" rows="3">{{ $comment->content }}</textarea>
                            <button type="submit" class="btn btn-primary mt-2">Cập nhật</button>
                            <button type="button" class="btn btn-secondary mt-2"
                                onclick="closeEditForm({{ $comment->id }})">Hủy</button>
                        </form>
                    </div>
                @endauth

                <form action="{{ route('comments.like', $comment->id) }}" method="POST" class="d-inline like-form">
                    @csrf
                    @if ($comment->liked_by_user)
                        <button type="submit" class="btn btn-sm btn-primary like-btn">
                            <i class="fas fa-thumbs-up"></i> Đã Thích
                            @if ($comment->likes_count > 0)
                                ({{ $comment->likes_count }})
                            @endif
                        </button>
                    @else
                        <button type="submit" class="btn btn-sm btn-outline-primary like-btn">
                            <i class="far fa-thumbs-up"></i> Thích
                            @if ($comment->likes_count > 0)
                                ({{ $comment->likes_count }})
                            @endif
                        </button>
                    @endif
                </form>

                @auth
                    <button class="btn btn-sm btn-outline-primary like-btn" onclick="showReplyForm({{ $comment->id }})"><i
                            class="far fa-comment-dots"></i> Trả lời</button>

                    <div id="reply-form-{{ $comment->id }}" class="mt-2" style="display:none;">
                        <form action="{{ route('comments.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="lesson_id" value="{{ $lesson->id }}">
                            <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                            <textarea name="content" class="form-control" rows="3" placeholder="Nhập câu trả lời của bạn..." required></textarea>
                            <button type="submit" class="btn btn-sm btn-outline-primary like-btn">Gửi trả lời</button>
                        </form>
                    </div>
                @endauth

                <div id="replies-{{ $comment->id }}" class="replies-list ms-4 ps-2 border-start">
                    @foreach ($comment->replies as $reply)
                        <div class="reply-item mt-3">
                            <div class="d-flex">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($reply->user->name) }}&background=random"
                                    class="avatar rounded-circle me-2" width="32" height="32"
                                    alt="{{ $reply->user->name }}">
                                <div class="reply-content">
                                    <div class="d-flex align-items-center">
                                        <strong class="me-2">{{ $reply->user->name }}</strong>
                                        @if ($reply->user->isTeacher())
                                            <span class="badge bg-primary">Giảng viên</span>
                                        @elseif ($reply->user->isAdmin())
                                            <span class="badge bg-danger">Quản trị viên</span>
                                        @endif
                                        <small
                                            class="text-muted ms-2 me-2">{{ $reply->created_at->diffForHumans() }}</small>
                                        <div>
                                            @if (auth()->id() == $reply->user_id)
                                                <div class="dropdown d-end">
                                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle"
                                                        type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
                                                        aria-expanded="false">
                                                        … <!-- Ba chấm icon -->
                                                    </button>
                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <li>
                                                            <button class="dropdown-item"
                                                                onclick="openEditForm({{ $reply->id }})">
                                                                <i class="fas fa-edit"></i> Sửa
                                                            </button>
                                                        </li>
                                                        <li>
                                                            <form action="{{ route('comments.destroy', $reply->id) }}"
                                                                method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="dropdown-item"><i
                                                                        class="fas fa-trash"></i> Xóa</button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    @auth
                                        <div id="edit-form-{{ $reply->id }}" class="mt-2" style="display: none;">
                                            <form action="{{ route('comments.update', $reply->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <textarea name="content" class="form-control" rows="3">{{ $reply->content }}</textarea>
                                                <button type="submit" class="btn btn-primary mt-2">Cập nhật</button>
                                                <button type="button" class="btn btn-secondary mt-2"
                                                    onclick="closeEditForm({{ $reply->id }})">Hủy</button>
                                            </form>
                                        </div>
                                    @endauth

                                    <div class="d-flex align-items-center gap-2 mt-1 mb-2">
                                        @if ($reply->parent && $reply->parent->user)
                                            <p class="text-muted small">
                                                <i class="fas fa-reply me-1"></i> Trả lời
                                                <strong>{{ $reply->parent->user->name }}:</strong>
                                            </p>
                                        @endif
                                        <p class="markdown-content">
                                            {{ $reply->content }}
                                        </p>
                                    </div>

                                    <div class="reply-actions">
                                        <form action="{{ route('comments.like', $reply->id) }}" method="POST"
                                            class="d-inline like-form">
                                            @csrf
                                            @if ($reply->liked_by_user)
                                                <button type="submit" class="btn btn-sm btn-primary like-btn">
                                                    <i class="fas fa-thumbs-up"></i> Đã Thích
                                                    @if ($reply->likes_count > 0)
                                                        ({{ $reply->likes_count }})
                                                    @endif
                                                </button>
                                            @else
                                                <button type="submit"
                                                    class="btn btn-sm btn-outline-primary like-btn">
                                                    <i class="far fa-thumbs-up"></i> Thích
                                                    @if ($reply->likes_count > 0)
                                                        ({{ $reply->likes_count }})
                                                    @endif
                                                </button>
                                            @endif
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </li>
@endforeach
