@extends('layouts.master')

<style>
    .main-content {
        flex: 3;
        background: white;
        padding: 20px;
        border-radius: 10px;
    }

    .video-container iframe {
        width: 100%;
        height: 500px;
        border-radius: 10px;
    }

    .video-info h3 {
        margin-top: 10px;
        font-size: 22px;
    }

    .video-info p {
        color: #777;
        font-size: 14px;
    }

    .tabs {
        display: flex;
        margin-top: 20px;
        border-bottom: 2px solid #ddd;
    }

    .tab-button {
        padding: 10px 15px;
        border: none;
        background: none;
        cursor: pointer;
        font-size: 14px;
    }

    .tab-button.active {
        border-bottom: 2px solid blue;
        font-weight: bold;
    }

    .tab-content {
        display: none;
        padding: 20px 0;
    }

    .tab-content.active {
        display: block;
    }

    .sidebar-course {
        flex: 1;
        margin-left: 20px;
        background: white;
        padding: 20px;
        border-radius: 10px;
    }

    .video-list {
        list-style: none;
        padding: 0;
        margin: 0;
        overflow-y: scroll;
        max-height: 500px;
        scrollbar-width: thin;
        scrollbar-color: #000000;
        background: #f1f1f1;
        display: flex;
        flex-direction: column;
        gap: 10px;
        padding: 10px;
        border-radius: 5px;
    }

    .video-list li {
        display: flex;
        align-items: center;
        cursor: pointer;
    }

    .video-list img {
        width: 100px;
        /* height: 60px; */
        border-radius: 5px;
        margin-right: 10px;
    }

    .video-list h4,
    span {
        font-size: 14px;
        margin-right: 5px;
    }

    .video-list p {
        font-size: 12px;
        color: #777;
    }

    .star-rating {
        direction: rtl;
        /* Đảo ngược thứ tự sao để giống Shopee */
        display: inline-block;
        font-size: 30px;
        color: #ccc;
        /* Màu mặc định cho sao chưa chọn */
    }

    .star-rating input {
        display: none;
        /* Ẩn input radio */
    }

    .star-rating label {
        cursor: pointer;
        color: #ccc;
        transition: color 0.2s;
    }

    .star-rating input:checked~label,
    .star-rating label:hover,
    .star-rating label:hover~label {
        color: #ffbb00;
        /* Màu vàng khi chọn hoặc hover */
    }

    .review-item {
        border-bottom: 1px solid #eee;
        padding: 15px 0;
    }

    .review-item .stars {
        color: #ffbb00;
        /* Màu sao đã đánh giá */
        font-size: 18px;
    }

    .btn-submit {
        background-color: #ee4d2d;
        /* Màu đỏ cam giống Shopee */
        border: none;
        padding: 10px 20px;
        color: white;
        font-weight: bold;
    }

    .btn-submit:hover {
        background-color: #f57224;
    }
</style>

@section('content')
<div class="row">
    <div class="col-md-8 ">
        <div class="main-content p-0">
            <div id="video-container">
                <iframe id="lesson-video" width="100%" height="500"
                    src="{{ $course->lessons->first()->video_url ?? '' }}" title="YouTube video player" frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    referrerpolicy="strict-origin-when-cross-origin" allowfullscreen loading="lazy">
                </iframe>
                {{-- @if ($course->lessons->first()->video_url)
                    <iframe id="lesson-video" width="100%" height="500"
                        src="{{ preg_replace('/^(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]+)/', 'https://www.youtube.com/embed/$1', $course->lessons->first()->video_url) }}?controls=0&rel=0&showinfo=0&modestbranding=1&iv_load_policy=3&fs=1"
                title="{{ $course->lessons->first()->title }}" frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen>
                </iframe>
                @else
                <iframe id="lesson-video" width="100%" height="500" src="{{ asset('images/default-thumbnail.jpg') }}"
                    title="YouTube video player" frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen>
                </iframe>
                @endif --}}
            </div>

            <div class="video-info">
                <h3 id="lesson-title">{{ $course->lessons->first()->title ?? '' }}</h3>
                <p><span class="author">Giảng viên: {{ $course->instructor->name ?? 'Đang cập nhật' }}</span></p>
            </div>

            <div class="tabs">
                <button class="tab-button active" onclick="openTab(event, 'gioithieu')">Giới thiệu</button>
                <button class="tab-button" onclick="openTab(event, 'noidung')">Nội dung khóa học</button>
                <button class="tab-button" onclick="openTab(event, 'tailieu')">Tài liệu</button>
                <button class="tab-button" onclick="openTab(event, 'thongtin')">Thông tin giảng viên</button>
                <button class="tab-button" onclick="openTab(event, 'danhgia')">Bình luận</button>
                <button class="tab-button" onclick="openTab(event, 'binhluan')">đánh giá</button>
            </div>

            <div id="gioithieu" class="tab-content active">
                <p class="px-3">{!! nl2br(e($course->lessons->first()->content)) !!}</p>
            </div>
            <div id="noidung" class="tab-content">
                <ul>
                    @foreach ($course->lessons as $lesson)
                    <li>
                        <a href="#" onclick="loadLesson('{{ $lesson->video_url }}', '{{ $lesson->title }}')">
                            {{ $lesson->title }} - ({{ gmdate('H:i:s', $lesson->duration) }})
                            {{-- @if ($lesson->completed)
                                    ✅
                                    @endif --}}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
            <div id="tailieu" class="tab-content">
                <p>Danh sách tài liệu sẽ cập nhật sau.</p>
            </div>
            <div id="thongtin" class="tab-content">
                <p>Giảng viên: {{ $course->instructor->name ?? 'Đang cập nhật' }}</p>
            </div>
            <div id="danhgia" class="tab-content">
                <h4>Bình luận khóa học</h4>
                @auth
                <form id="comment-form" action="{{ route('comments.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="lesson_id" value="{{ $course->lessons->first()->id }}">
                    <div class="mb-3">
                        <textarea name="content" class="form-control" rows="3" placeholder="Viết đánh giá..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Gửi Bình luận</button>
                </form>
                @else
                <p>Vui lòng <a href="{{ route('login') }}">đăng nhập</a> để gửi bình luận.</p>
                @endauth

                <ul class="list-group mt-3">
                    <h5 class="mb-3">{{ $course->lessons->first()->comments->count() }} Bình luận</h5>
                    @foreach ($course->lessons->first()->comments->where('parent_id', null)->sortByDesc('created_at') as $comment)
                    <li class="list-group-item @if ($comment->user->isTeacher()) comment-teacher @endif">
                        <div class="card">
                            <div class="card-body">
                                <div class="user-info d-flex align-items-center">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($comment->user->name) }}&background=random"
                                        class="avatar rounded-circle me-2" alt="{{ $comment->user->name }}">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <strong>{{ $comment->user->name }}</strong>
                                            @if ($comment->user->isTeacher())
                                            <span class="badge bg-primary ms-2">Giảng viên</span>
                                            @endif
                                            <span
                                                class="text-muted ms-2">{{ $comment->created_at->diffForHumans() }}</span>
                                        </div>

                                        @auth
                                        @if (auth()->id() == $comment->user_id)
                                        <!-- Icon 3 chấm và Dropdown -->
                                        <div class="dropdown d-end">
                                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle"
                                                type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                &#x2026; <!-- Ba chấm icon -->
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <!-- Nút sửa -->
                                                <li>
                                                    <button class="dropdown-item"
                                                        onclick="openEditForm({{ $comment->id }})">
                                                        <i class="fas fa-edit"></i> Sửa
                                                    </button>
                                                </li>
                                                <!-- Nút xóa -->
                                                <li>
                                                    <form
                                                        action="{{ route('comments.destroy', $comment->id) }}"
                                                        method="POST" class="d-inline"
                                                        onsubmit="return confirm('Bạn có chắc chắn muốn xóa bình luận này?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item">
                                                            <i class="fas fa-trash"></i> Xóa</button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                        @endif
                                        @endauth
                                    </div>
                                </div>

                                <p id="comment-content-{{ $comment->id }}" class="mt-2">{{ $comment->content }}
                                </p>

                                <!-- Form sửa bình luận -->
                                @auth
                                @if (auth()->id() == $comment->user_id)
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
                                @endif
                                @endauth


                                <!-- Nút Thích -->
                                <form action="{{ route('comments.like', $comment->id) }}" method="POST"
                                    class="d-inline like-form">
                                    @csrf
                                    @if ($comment->likes()->where('user_id', Auth::id())->exists())
                                    <!-- Nếu người dùng đã like -->
                                    <button type="submit" class="btn btn-sm btn-outline-primary like-btn">
                                        <i class="fas fa-thumbs-up"></i> Đã Thích
                                        ({{ $comment->likes_count }})
                                    </button>
                                    @else
                                    <!-- Nếu người dùng chưa like -->
                                    <button type="submit" class="btn btn-sm btn-outline-primary like-btn">
                                        <i class="far fa-thumbs-up"></i> Thích ({{ $comment->likes_count }})
                                    </button>
                                    @endif
                                </form>

                                <!-- Nút trả lời -->
                                @auth
                                @if (Auth::id() == $comment->user_id || Auth::user()->isTeacher())
                                <button class="btn btn-sm btn-outline-primary like-btn"
                                    onclick="showReplyForm({{ $comment->id }})"><i
                                        class="far fa-comment-dots"></i> Trả
                                    lời</button>

                                <div id="reply-form-{{ $comment->id }}" class="mt-2"
                                    style="display:none;">
                                    <form action="{{ route('comments.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="lesson_id"
                                            value="{{ $course->lessons->first()->id }}">
                                        <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                        <textarea name="content" class="form-control" rows="3" placeholder="Nhập câu trả lời của bạn..." required></textarea>
                                        <button type="submit"
                                            class="btn btn-sm btn-outline-primary like-btn">Gửi trả
                                            lời</button>
                                    </form>
                                </div>
                                @endif
                                @endauth
                                <div id="replies-{{ $comment->id }}"
                                    class="replies-list ms-4 ps-2 border-start">
                                    @foreach ($comment->replies as $reply)
                                    <div class="reply-item mt-3">
                                        <div class="d-flex">
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($reply->user->name) }}&background=random"
                                                class="avatar rounded-circle me-2" width="32"
                                                height="32" alt="{{ $reply->user->name }}">
                                            <div class="reply-content">
                                                <div class="d-flex align-items-center">
                                                    <strong class="me-2">{{ $reply->user->name }}</strong>
                                                    @if ($reply->user->isTeacher())
                                                    <span class="badge bg-primary">Giảng viên</span>
                                                    @endif
                                                    <small
                                                        class="text-muted ms-2">{{ $reply->created_at->diffForHumans() }}</small>
                                                </div>
                                                <p class="markdown-content mt-1 mb-2">{{ $reply->content }}
                                                </p>

                                                <div class="reply-actions">
                                                    <form action="{{ route('comments.like', $comment->id) }}"
                                                        method="POST" class="d-inline like-form">
                                                        @csrf
                                                        <button type="submit"
                                                            class="btn btn-sm btn-outline-primary like-btn">
                                                            <i class="far fa-thumbs-up"></i> Thích
                                                            ({{ $comment->likes_count }})
                                                        </button>
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
                </ul>
            </div>
            <div id="binhluan" class="tab-content container my-4">
                <h4>Đánh giá khóa học</h4>
                <!-- Form đánh giá -->
                @auth
                @php
                // Kiểm tra xem người dùng đã đánh giá khóa học chưa
                $reviewed = $course->reviews->where('user_id', auth()->id())->first();
                @endphp
                @if (!$reviewed)
                <form id="rating-form" action="{{ route('ratings.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="course_id" value="{{ $course->id }}">
                    <div class="mb-3">
                        <label for="rating" class="form-label">Chọn số sao:</label>
                        <div class="star-rating mb-2">
                            @for ($i = 5; $i >= 1; $i--)
                            <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" required />
                            <label for="star{{ $i }}">★</label>
                            @endfor
                        </div>
                    </div>
                    <div class="mb-3">
                        <textarea name="comment" class="form-control" rows="3" placeholder="Chia sẻ cảm nhận của bạn về khóa học..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-submit">Gửi đánh giá</button>
                </form>
                @else
                    <p class="text-success">Bạn đã đánh giá khóa học này.</p>
                @endif
                <!-- Hiển thị các đánh giá -->
                @foreach ($course->reviews as $review)
                <div class="review-item">
                    <strong>{{ $review->user->name }}</strong>
                    <div class="stars">
                        @for ($i = 1; $i <= 5; $i++)
                            <span>{{ $i <= $review->rating ? '★' : '☆' }}</span>
                            @endfor
                    </div>
                    <p>{{ $review->comment }}</p>
                </div>
                @endforeach
                @else
                <p>Vui lòng <a href="{{ route('login') }}">đăng nhập</a> để gửi đánh giá.</p>
                @endauth
            </div>

        </div>
    </div>

    <div class="col-md-4">
        <div class="sidebar-course m-0">
            <div class="card">
                <div class="card-body">
                    <h3>Nội dung khóa học</h3>
                    <ul class="video-list">
                        @foreach ($course->lessons as $lesson)
                        <li
                            onclick="loadLesson('{{ $lesson->video_url }}', '{{ $lesson->title }}', {{ $lesson->id }})">
                            <img src="{{ asset($course->thumbnail ?? 'images/default-thumbnail.jpg') }}"
                                alt="Video">
                            <div class="d-flex align-items-center">
                                <span>{{ $lesson->order_number }}.</span>
                                <h4 class="m-0">{{ $lesson->title }}</h4>
                                @if ($lesson->completed)
                                <p>✅</p>
                                @endif
                            </div>
                        </li>

                        <!-- Danh sách bài kiểm tra -->
                        <ul class="quiz-list" id="quiz-list-{{ $lesson->id }}" class="quiz-list">
                            @foreach ($lesson->quizzes as $quiz)
                            <li class="quiz-item border-bottom">
                                <a class="quiz-link text-decoration-none text-dark"
                                    href="{{ route('quizzes.show', $quiz->id) }}">{{ $quiz->title }}</a>
                            </li>
                            @endforeach
                        </ul>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function loadCourseLessons(courseId) {
        $.ajax({
            url: `/courses/${courseId}/lessons`,
            type: "GET",
            success: function(data) {
                let lessonList = $(".video-list");
                lessonList.empty(); // Xóa danh sách cũ

                data.forEach(lesson => {
                    lessonList.append(`
                    <li onclick="loadLesson('${lesson.video_url}', '${lesson.title}', ${lesson.id})">
                        <img src="${lesson.thumbnail || 'images/default-thumbnail.jpg'}" alt="Video">
                        <div class="d-flex align-items-center">
                            <span>${lesson.order_number}.</span>
                            <h4 class="m-0">${lesson.title}</h4>
                        </div>
                    </li>
                `);
                });
            }
        });
    }

    function loadLesson(videoUrl, title, lessonId) {
        $.ajax({
            url: `/lessons/${lessonId}`,
            type: "GET",
            success: function(lesson) {
                $("#lesson-title").text(lesson.title);
                $("#lesson-video").attr("src", lesson.video_url);
                $("#gioithieu p").html(lesson.content);
            }
        });
    }


    function openEditForm(commentId) {
        // Ẩn tất cả form sửa
        document.querySelectorAll('.edit-form').forEach(function(form) {
            form.style.display = 'none';
        });

        // Hiển thị form sửa của bình luận đã chọn
        let form = document.getElementById(`edit-form-${commentId}`);
        if (form) {
            form.style.display = 'block';
        }
    }

    function showReplyForm(commentId) {
        var replyForm = document.getElementById('reply-form-' + commentId);
        var currentDisplay = replyForm.style.display;
        // Kiểm tra nếu bình luận đang ẩn, mới cho phép hiển thị
        if (currentDisplay === "none" || currentDisplay === "") {
            // Ẩn tất cả các form trả lời khác
            document.querySelectorAll('.reply-form').forEach(function(form) {
                form.style.display = "none";
            });
            // Hiển thị form trả lời cho bình luận hiện tại
            replyForm.style.display = "block";
        } else {
            // Ẩn form trả lời khi nó đang hiển thị
            replyForm.style.display = "none";
        }
    }

    function showReplyForm(commentId) {
        var replyForm = document.getElementById('reply-form-' + commentId);
        var currentDisplay = replyForm.style.display;
        // Kiểm tra nếu bình luận đang ẩn, mới cho phép hiển thị
        if (currentDisplay === "none" || currentDisplay === "") {
            // Ẩn tất cả các form trả lời khác
            document.querySelectorAll('.reply-form').forEach(function(form) {
                form.style.display = "none";
            });
            // Hiển thị form trả lời cho bình luận hiện tại
            replyForm.style.display = "block";
        } else {
            // Ẩn form trả lời khi nó đang hiển thị
            replyForm.style.display = "none";
        }
    }


    function openTab(evt, tabName) {
        var i, tabContent, tabButtons;

        tabContent = document.getElementsByClassName("tab-content");
        for (i = 0; i < tabContent.length; i++) {
            tabContent[i].style.display = "none";
        }

        tabButtons = document.getElementsByClassName("tab-button");
        for (i = 0; i < tabButtons.length; i++) {
            tabButtons[i].className = tabButtons[i].className.replace(" active", "");
        }

        document.getElementById(tabName).style.display = "block";
        evt.currentTarget.className += " active";
    }

    function loadLesson(videoUrl, title) {
        document.getElementById("lesson-title").innerText = title;
        document.getElementById("lesson-video").src = videoUrl;
    }

    function loadLesson(videoUrl, title, lessonId) {
        document.getElementById("lesson-title").innerText = title;
        document.getElementById("lesson-video").src = videoUrl;

        // Ẩn tất cả danh sách quiz trước đó
        document.querySelectorAll(".quiz-list").forEach(el => el.style.display = "none");

        // Hiển thị danh sách quiz của bài học được chọn
        let quizList = document.getElementById(`quiz-list-${lessonId}`);
        if (quizList) {
            quizList.style.display = "block";
        }
    }
</script>
