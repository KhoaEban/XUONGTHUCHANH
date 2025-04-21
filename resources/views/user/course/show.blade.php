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
    /* Style cho sidebar */
    .sidebar-course .card {
        border: none;
        border-radius: 0;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        max-height: 500px;
        overflow-y: auto;
    }
    .video-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .video-item {
        display: flex;
        align-items: center;
        padding: 10px 20px;
        cursor: pointer;
        transition: background 0.3s;
    }
    .video-item:hover {
        background: #f5f5f5;
    }
    .video-item.active {
        background: #e6f7ff; /* Xanh dương nhạt dựa trên #0099cc */
    }
    .video-item.active::before {
        content: '';
        display: inline-block;
        width: 8px;
        height: 8px;
        background: white;
        border-radius: 50%;
        margin-right: 8px;
    }
    .lesson-checkbox {
        margin-right: 10px;
    }
    .lesson-checkbox .fas {
        color: #008040; /* Xanh lá đậm */
        font-size: 16px;
    }
    .lesson-info {
        flex: 1;
    }
    .lesson-title {
        font-size: 14px;
        color: #333;
        margin: 0;
    }
    .lesson-meta {
        font-size: 12px;
        color: #777;
        margin-top: 2px;
    }
    .lesson-meta .fas {
        margin-right: 5px;
        color: #008040; /* Xanh lá đậm */
    }
    .download-button {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 10px 20px;
        margin: 10px 20px;
        border: 1px solid #008040; /* Viền xanh lá đậm */
        border-radius: 5px;
        color: #008040; /* Chữ xanh lá đậm */
        text-decoration: none;
        font-size: 14px;
    }
    .download-button .fas {
        margin-right: 5px;
    }
    .download-button:hover {
        background: #e6f7ff; /* Xanh dương nhạt khi hover */
    }
    /* Style cho phần tiến độ */
    .course-progress {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 10px 20px;
    }
    .course-progress h4 {
        font-size: 18px;
        margin: 0;
        margin-bottom: 10px;
    }
    .progress-circle {
        position: relative;
        width: 40px;
        height: 40px;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .progress-ring__circle {
        transition: 0.35s stroke-dasharray;
        transform: rotate(-90deg);
        transform-origin: 50% 50%;
        stroke: #008040; /* Xanh lá đậm */
    }
    .progress-ring__circle-bg {
        stroke: #e0e0e0; /* Giữ xám nhạt */
    }
    .progress-text {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 12px;
        font-weight: bold;
        color: #333;
    }
    /* Style cho nút Nhận chứng chỉ trong dropdown */
    .certificate-button-container {
        position: relative;
        display: inline-block;
    }
    .certificate-dropdown {
        position: absolute;
        top: 100%;
        left: 50%;
        transform: translateX(-50%);
        background: #fff;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        border-radius: 8px;
        padding: 5px 0;
        display: none;
        z-index: 10;
    }
    .certificate-button-container:hover .certificate-dropdown {
        display: block;
    }
    .certificate-button {
        display: flex;
        align-items: center;
        padding: 8px 15px;
        background: #008040; /* Xanh lá đậm */
        border-radius: 20px;
        color: white;
        font-weight: bold;
        font-size: 14px;
        text-decoration: none;
        white-space: nowrap;
        transition: background 0.3s;
    }
    .certificate-button:hover {
        background: #00a86b; /* Xanh lá sáng hơn khi hover */
    }
    .certificate-button .icon-wrapper {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 20px;
        height: 20px;
        background: #0099cc; /* Xanh dương nhạt */
        border-radius: 50%;
        margin-right: 8px;
    }
    .certificate-button .fas {
        color: white;
        font-size: 12px;
    }
    .certificate-button .fa-chevron-down {
        margin-left: 8px;
    }
    .divider {
        border-bottom: 1px dashed #8b8b8b;
        margin: 0;
    }
    /* Style cho danh sách quiz */
    .quiz-list {
        list-style: none;
        padding: 0 20px 0 50px;
        margin: 0;
        display: none;
    }
    .quiz-item {
        padding: 8px 0;
        display: flex;
        align-items: center;
        font-size: 13px;
        color: #333;
        border-bottom: 1px solid #eee;
    }
    .quiz-item:last-child {
        border-bottom: none;
    }
    .quiz-item .fas {
        color: #008040; /* Xanh lá đậm */
        margin-right: 8px;
    }
    .quiz-link {
        color: #333;
        text-decoration: none;
        transition: color 0.3s;
    }
    .quiz-link:hover {
        color: #0099cc; /* Xanh dương nhạt khi hover */
    }
    .star-rating {
        display: flex;
        direction: rtl;
        justify-content: flex-end;
    }
    .star-rating input[type="radio"] {
        display: none;
    }
    .star-rating label.star {
        font-size: 2rem;
        color: #ccc;
        cursor: pointer;
        transition: color 0.2s;
    }
    .star-rating label.star:hover,
    .star-rating label.star:hover~label.star {
        color: #f39c12;
    }
    .star-rating input[type="radio"]:checked~label.star {
        color: #f39c12;
    }
</style>

@section('content')
    <div class="row">
        @if ($course->lessons->isNotEmpty())
            <div class="col-md-8">
                <div class="main-content p-0">
                    <div id="video-container">
                        <iframe id="lesson-video" width="100%" height="500"
                            src="{{ $course->lessons->first()->video_url ? $course->lessons->first()->video_url . '?enablejsapi=1' : '' }}"
                            title="YouTube video player" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            referrerpolicy="strict-origin-when-cross-origin" allowfullscreen loading="lazy">
                        </iframe>
                    </div>

                    <div class="video-info">
                        <h3 id="lesson-title">{{ $course->lessons->first()->title ?? '' }}</h3>
                        <p><span class="author">{{ $course->instructor->name ?? 'Đang cập nhật' }}</span></p>
                    </div>

                    <div class="">
                        <div class="tabs">
                            <button class="tab-button active" onclick="openTab(event, 'gioithieu')">Giới thiệu</button>
                            <button class="tab-button" onclick="openTab(event, 'noidung')">Nội dung khóa học</button>
                            <button class="tab-button" onclick="openTab(event, 'tailieu')">Tài liệu</button>
                            <button class="tab-button" onclick="openTab(event, 'thongtin')">Thông tin giảng viên</button>
                            <button class="tab-button" onclick="openTab(event, 'binhluan')">Bình luận</button>
                            <button class="tab-button" onclick="openTab(event, 'danhgia')">Đánh giá</button>
                        </div>
                        <div id="gioithieu" class="tab-content active">
                            <p class="px-3">{!! nl2br(e($course->lessons->first()->content)) !!}</p>
                        </div>
                        <div id="noidung" class="tab-content">
                            <ul>
                                @foreach ($course->lessons as $lesson)
                                    <li>
                                        <a href="#" onclick="loadLesson('{{ $lesson->video_url }}', '{{ $lesson->title }}', {{ $lesson->id }})">
                                            {{ $lesson->title }} - ({{ gmdate('H:i:s', $lesson->duration) }})
                                            @if (in_array($lesson->id, $completedLessons))
                                                <i class="fas fa-check-square"></i>
                                            @endif
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
                        <div id="binhluan" class="tab-content">
                            <h4>Bình luận</h4>
                            @auth
                                <form id="comment-form" action="{{ route('comments.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="lesson_id" id="comment-lesson-id"
                                        value="{{ $course->lessons->first()->id }}">
                                    <div class="mb-3">
                                        <textarea name="content" class="form-control" rows="3" placeholder="Viết bình luận..." required></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Gửi bình luận</button>
                                </form>
                            @else
                                <p>Vui lòng <a href="{{ route('login') }}">đăng nhập</a> để gửi bình luận.</p>
                            @endauth
                            <ul class="list-group mt-3" id="comments-list">
                                @include('user.course.partials.comments', [
                                    'comments' => $comments,
                                    'lesson' => $course->lessons->first(),
                                ])
                            </ul>
                        </div>
                        <div id="danhgia" class="tab-content container my-4">
                            <h4>Đánh giá</h4>
                            <div class="card">
                                <div class="card-body p-0">
                                    <div class="row">
                                        <div class="col-md-3 text-center p-4 border-end">
                                            <div class="fs-1 fw-bold mb-2">
                                                <span class="text-warning me-2">★</span>{{ number_format($averageRating, 1) }}/5
                                            </div>
                                            <div class="text-muted">{{ $ratingCount }} Đánh giá và nhận xét</div>
                                        </div>
                                        <div class="col-md-9 p-4">
                                            @for ($i = 5; $i >= 1; $i--)
                                                @php
                                                    $count = $ratingSummary[$i] ?? 0;
                                                    $percent = $ratingCount > 0 ? ($count / $ratingCount) * 100 : 0;
                                                @endphp
                                                <div class="d-flex align-items-center mb-3">
                                                    <div class="me-3" style="min-width: 100px;">
                                                        @for ($j = 1; $j <= 5; $j++)
                                                            <span class="{{ $j <= $i ? 'text-warning' : 'text-secondary' }}">★</span>
                                                        @endfor
                                                    </div>
                                                    <div class="progress flex-grow-1 me-3" style="height: 8px;">
                                                        <div class="progress-bar bg-warning" role="progressbar"
                                                            style="width: {{ $percent }}%"></div>
                                                    </div>
                                                    <div style="min-width: 50px; text-align: right;">
                                                        {{ number_format($percent, 0) }}%</div>
                                                </div>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @auth
                                @php
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
                                                    <label for="star{{ $i }}" class="star">★</label>
                                                @endfor
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <textarea name="comment" class="form-control" rows="3" placeholder="Chia sẻ cảm nhận của bạn về khóa học..." required></textarea>
                                        </div>
                                        <button type="submit" class="bg-primary text-white py-2 px-4 border-0">Gửi đánh giá</button>
                                    </form>
                                @else
                                    <p class="text-success mt-3">Bạn đã đánh giá khóa học này.</p>
                                @endif
                                @if ($reviews->count())
                                    <div class="mt-4">
                                        @foreach ($reviews as $review)
                                            <div class="review-item mb-3 p-3 border rounded bg-light">
                                                <strong>{{ $review->user->name }}</strong>
                                                <div class="stars mb-1">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <span style="color: {{ $i <= $review->rating ? '#f39c12' : '#ccc' }}">★</span>
                                                    @endfor
                                                </div>
                                                <p class="mb-0">{{ $review->comment }}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="mt-3">Chưa có đánh giá nào.</p>
                                @endif
                            @else
                                <p class="mt-3">Vui lòng đăng nhập để đánh giá khóa học.</p>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="sidebar-course m-0">
                    <div class="card">
                        <div class="course-progress">
                            <h4 class="progress-title mt-2">Tiến độ</h4>
                            <div class="progress-circle certificate-button-container">
                                <svg class="progress-ring" width="40" height="40">
                                    <circle class="progress-ring__circle-bg" stroke="#e0e0e0" stroke-width="5"
                                        fill="transparent" r="17" cx="20" cy="20" />
                                    <circle class="progress-ring__circle" stroke="#008040" stroke-width="5"
                                        fill="transparent" r="17" cx="20" cy="20"
                                        style="stroke-dasharray: {{ 106 * ($progressPercentage / 100) }}, 106;" />
                                </svg>
                                <div class="progress-text">{{ $progressPercentage }}%</div>
                                <div class="certificate-dropdown" id="certificate-dropdown">
                                    <!-- Nút chứng chỉ sẽ được thêm động bằng JavaScript -->
                                </div>
                            </div>
                        </div>
                        <div class="divider"></div>
                        <ul class="video-list">
                            @foreach ($course->lessons as $lesson)
                                <li onclick="loadLesson('{{ $lesson->video_url }}', '{{ $lesson->title }}', {{ $lesson->id }})"
                                    class="video-item {{ $lesson->id == $course->lessons->first()->id ? 'active' : '' }}"
                                    data-lesson-id="{{ $lesson->id }}">
                                    <span class="lesson-checkbox">
                                        @if (in_array($lesson->id, $completedLessons))
                                            <i class="fas fa-check-square"></i>
                                        @else
                                            <i class="far fa-square"></i>
                                        @endif
                                    </span>
                                    <div class="lesson-info">
                                        <p class="lesson-title">{{ $lesson->order_number }}. {{ $lesson->title }}</p>
                                        <p class="lesson-meta">
                                            <i class="fas fa-file-alt"></i>
                                            {{ gmdate('i', $lesson->duration) }} phút
                                        </p>
                                    </div>
                                </li>
                                <ul class="quiz-list" id="quiz-list-{{ $lesson->id }}">
                                    @foreach ($lesson->quizzes as $quiz)
                                        <li class="quiz-item">
                                            <i class="fas fa-question-circle"></i>
                                            <a class="quiz-link text-decoration-none"
                                                href="{{ route('quizzes.show', $quiz->id) }}">
                                                {{ $quiz->title }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endforeach
                        </ul>
                        <a href="#" class="download-button">
                            <i class="fas fa-file-download"></i>
                            Tải nguồn <i class="fas fa-chevron-down"></i>
                        </a>
                    </div>
                </div>
            </div>
        @else
            <div class="m-auto">
                <h3 class="text-center">Khóa học này hiện không có bài học nào.</h3>
                <p class="text-center">Vui lòng quay lại sau. <a href="{{ url('/') }}"
                        class="text-primary text-decoration-none">Quay lại trang chủ</a></p>
            </div>
        @endif
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://www.youtube.com/iframe_api"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let player;
        let currentLessonId = {{ $course->lessons->first()->id ?? 0 }};

        function onYouTubeIframeAPIReady() {
            player = new YT.Player('lesson-video', {
                events: {
                    'onStateChange': onPlayerStateChange
                }
            });
        }

        function onPlayerStateChange(event) {
            if (event.data == YT.PlayerState.ENDED) {
                let isCompleted = $(`#quiz-list-${currentLessonId}`).prev('.video-item').find('.lesson-checkbox').find('.fa-check-square').length > 0;
                if (!isCompleted) {
                    $.ajax({
                        url: `/user/courses/{{ $course->id }}/lessons/${currentLessonId}/complete`,
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Hoàn thành!',
                                text: response.message,
                                timer: 2000
                            });
                            $(`#quiz-list-${currentLessonId}`).prev('.video-item').find('.lesson-checkbox').html('<i class="fas fa-check-square"></i>');
                            updateCourseProgress('{{ $course->id }}');
                            refreshLessonList();
                        },
                        error: function(xhr) {
                            console.error('Lỗi khi đánh dấu bài học:', xhr);
                            Swal.fire({
                                icon: 'error',
                                title: 'Lỗi',
                                text: 'Không thể đánh dấu bài học hoàn thành. Vui lòng thử lại.',
                            });
                        }
                    });
                }
            }
        }

        function loadLesson(videoUrl, title, lessonId) {
            document.getElementById("lesson-title").innerText = title;
            let videoSrc = videoUrl.includes('?') ? videoUrl + '&enablejsapi=1' : videoUrl + '?enablejsapi=1';
            document.getElementById("lesson-video").src = videoSrc;
            currentLessonId = lessonId;
            document.getElementById("comment-lesson-id").value = lessonId;
            document.querySelectorAll(".quiz-list").forEach(el => el.style.display = "none");
            let quizList = document.getElementById(`quiz-list-${lessonId}`);
            if (quizList) {
                quizList.style.display = "block";
            }
            document.querySelectorAll('.video-item').forEach(item => {
                item.classList.remove('active');
                if (parseInt(item.getAttribute('data-lesson-id')) === lessonId) {
                    item.classList.add('active');
                }
            });
            $.ajax({
                url: `/lessons/${lessonId}`,
                type: "GET",
                success: function(lesson) {
                    $("#gioithieu p").html(lesson.content);
                    refreshLessonList();
                    $("#tailieu").html(lesson.resources);
                    $("#thongtin").html(lesson.instructor_info);
                    $("#danhgia").html(lesson.comments);
                },
                error: function(xhr) {
                    console.error('Lỗi khi tải bài học:', xhr);
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi',
                        text: 'Đã có lỗi xảy ra khi tải bài học. Vui lòng thử lại.',
                    });
                }
            });
        }

        function refreshLessonList() {
            $.ajax({
                url: `/user/courses/{{ $course->id }}/progress`,
                type: 'GET',
                success: function(data) {
                    $("#noidung").html(`
                        <ul>
                            @foreach ($course->lessons as $lesson)
                                <li>
                                    <a href="#" onclick="loadLesson('{{ $lesson->video_url }}', '{{ $lesson->title }}', {{ $lesson->id }})">
                                        {{ $lesson->title }} - ({{ gmdate('H:i:s', $lesson->duration) }})
                                        ${data.completedLessons.includes({{ $lesson->id }}) ? '<i class="fas fa-check-square"></i>' : ''}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    `);
                    document.querySelectorAll('.video-item').forEach(item => {
                        let lessonId = parseInt(item.getAttribute('data-lesson-id'));
                        let checkbox = item.querySelector('.lesson-checkbox');
                        if (data.completedLessons.includes(lessonId)) {
                            checkbox.innerHTML = '<i class="fas fa-check-square"></i>';
                        } else {
                            checkbox.innerHTML = '<i class="far fa-square"></i>';
                        }
                    });
                },
                error: function(xhr) {
                    console.error('Lỗi khi làm mới danh sách bài học:', xhr);
                }
            });
        }

        function openEditForm(id) {
            document.getElementById('edit-form-' + id).style.display = 'block';
            const content = document.getElementById('comment-content-' + id);
            if (content) {
                content.style.display = 'none';
            }
        }

        function closeEditForm(id) {
            document.getElementById('edit-form-' + id).style.display = 'none';
            const content = document.getElementById('comment-content-' + id);
            if (content) {
                content.style.display = 'block';
            }
        }

        function showReplyForm(commentId) {
            var replyForm = document.getElementById('reply-form-' + commentId);
            var currentDisplay = replyForm.style.display;
            if (currentDisplay === "none" || currentDisplay === "") {
                document.querySelectorAll('.reply-form').forEach(function(form) {
                    form.style.display = "none";
                });
                replyForm.style.display = "block";
            } else {
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

        function updateCourseProgress(courseId) {
            fetch(`/user/courses/${courseId}/progress`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.progressPercentage !== undefined) {
                        const progressCircle = document.querySelector('.progress-ring__circle');
                        const circumference = 106;
                        const offset = circumference * (data.progressPercentage / 100);
                        progressCircle.style.strokeDasharray = `${offset}, ${circumference}`;
                        document.querySelector('.progress-text').innerText = `${data.progressPercentage}%`;
                        if (data.progressPercentage === 100) {
                            const dropdown = document.getElementById('certificate-dropdown');
                            const existingLink = dropdown.querySelector('a');
                            if (!existingLink) {
                                const certificateLink = document.createElement('a');
                                certificateLink.href = '{{ route('certificate.show', $course->id) }}';
                                certificateLink.className = 'certificate-button';
                                certificateLink.innerHTML = `
                                    <span class="icon-wrapper">
                                        <i class="fas fa-trophy"></i>
                                    </span>
                                    Nhận giấy chứng nhận
                                    <i class="fas fa-chevron-down"></i>
                                `;
                                dropdown.appendChild(certificateLink);
                            }
                        }
                    }
                })
                .catch(error => console.error('Lỗi khi lấy tiến độ khóa học:', error));
        }

        document.addEventListener('DOMContentLoaded', function() {
            updateCourseProgress('{{ $course->id }}');
            document.querySelectorAll('.quiz-list').forEach(el => el.style.display = 'none');
            let firstLessonId = '{{ $course->lessons->first()->id ?? null }}';
            if (firstLessonId) {
                let firstQuizList = document.getElementById(`quiz-list-${firstLessonId}`);
                if (firstQuizList) {
                    firstQuizList.style.display = 'block';
                }
            }
        });
    </script>
@endsection