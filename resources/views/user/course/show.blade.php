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
                        <iframe id="lesson-video" width="100%" height="500"
                            src="{{ asset('images/default-thumbnail.jpg') }}" title="YouTube video player" frameborder="0"
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
                    <button class="tab-button" onclick="openTab(event, 'danhgia')">Đánh giá</button>
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
    <h4>Đánh giá khóa học</h4>

    @auth
    <form action="{{ route('comments.store') }}" method="POST">
        @csrf
        <input type="hidden" name="lesson_id" value="{{ $course->lessons->first()->id }}">
        <div class="mb-3">
            <textarea name="content" class="form-control" rows="3" placeholder="Viết đánh giá..." required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Gửi đánh giá</button>
    </form>
    @else
    <p>Vui lòng <a href="{{ route('login') }}">đăng nhập</a> để gửi đánh giá.</p>
    @endauth

    <ul class="list-group mt-3">
    @foreach ($course->lessons->first()->comments as $comment)
    <li class="list-group-item d-flex justify-content-between align-items-start">
        <div>
            <strong>{{ $comment->user->name }}</strong>
            <span class="text-muted">{{ $comment->created_at->diffForHumans() }}</span>
            <p id="comment-content-{{ $comment->id }}">{{ $comment->content }}</p>
        </div>

        @auth
        @if (auth()->id() == $comment->user_id)
        <div class="d-flex">
            <!-- Nút sửa -->
            <button class="btn btn-sm btn-warning me-2" onclick="editComment({{ $comment->id }})">Sửa</button>

            <!-- Nút xóa -->
            <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa bình luận này?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
            </form>
        </div>
        @endif
        @endauth
    </li>
    @endforeach
</ul>

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
                                            <a class="quiz-link text-decoration-none text-dark" href="{{ route('quizzes.show', $quiz->id) }}">{{ $quiz->title }}</a>
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

<script>
      function editComment(commentId) {
        let contentElement = document.getElementById(`comment-content-${commentId}`);
        let oldContent = contentElement.innerText;
        let newContent = prompt("Chỉnh sửa bình luận:", oldContent);

        if (newContent !== null && newContent.trim() !== "") {
            fetch(`/comments/${commentId}`, {
                method: "PATCH",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ content: newContent })
            })
            .then(response => response.json())
            .then(data => {
                if (data.message) {
                    contentElement.innerText = data.content;
                    alert("Cập nhật bình luận thành công!");
                } else {
                    alert("Có lỗi xảy ra, vui lòng thử lại.");
                }
            })
            .catch(error => console.error("Lỗi:", error));
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
