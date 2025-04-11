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

    /* Sidebar Container */
    .sidebar-course .card {
        border: none;
        border-radius: 0;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        max-height: 500px;
        overflow-y: auto;
    }

    .course-progress {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 20px;
    }

    .course-progress h4 {
        font-size: 18px;
        margin: 0;
    }

    .course-progress p {
        font-size: 14px;
        margin: 0;
    }

    .progress-bar-container {
        width: 350px;
        height: 10px;
        background: #ddd;
        border-radius: 5px;
        overflow: hidden;
    }

    .progress-bar {
        height: 100%;
        background: #007bff;
        width: 0;
        transition: width 0.5s ease;
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
    }

    .progress-ring__circle-bg {
        stroke: #e0e0e0;
    }

    .progress-text {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 12px;
        /* Kích thước chữ vừa phải cho 40px */
        font-weight: bold;
        color: #333;
    }

    .progress-title {
        text-align: center;
    }

    .divider {
        border-bottom: 1px dashed #8b8b8b;
        margin: 0;
        /* Add some margin for spacing */
    }

    /* Card Body */
    .sidebar-course .card-body {
        padding: 15px 20px;
        /* Reduce padding to save space */
    }

    /* Heading */
    .sidebar-course h3 {
        font-size: 20px;
        /* Slightly smaller heading */
        margin-bottom: 10px;
        /* Reduce margin */
    }

    /* Video List */
    .video-list {
        list-style: none;
        padding: 0 15px;
        margin: 0;
        /* Remove default margin */
    }

    .video-list li {
        display: flex;
        align-items: center;
        padding: 8px;
        /* Reduce padding for compactness */
        cursor: pointer;
        transition: background 0.3s;
    }

    .video-list li:hover {
        background: #f1f1f1;
    }

    .video-list img {
        width: 50px;
        /* Smaller thumbnail */
        height: 30px;
        /* Reduced height */
        object-fit: cover;
        margin-right: 10px;
        border-radius: 4px;
    }

    .video-list .d-flex {
        flex: 1;
        gap: 5px;
        /* Reduce spacing between elements */
    }

    .video-list span {
        font-size: 14px;
        /* Smaller order number */
    }

    .video-list h4 {
        font-size: 14px;
        /* Smaller title */
        margin: 0;
        line-height: 1.2;
        /* Tighten line height */
    }

    .video-list p {
        margin: 0;
        font-size: 12px;
        /* Smaller checkmark */
    }

    /* Quiz List */
    .quiz-list {
        list-style: none;
        padding-left: 20px;
        /* Indent slightly */
        margin: 0;
        display: none;
        /* Hidden by default, shown via JS */
    }

    .quiz-list li {
        padding: 5px 0;
        /* Reduce padding */
        font-size: 13px;
        /* Smaller text */
    }

    .quiz-item {
        border-bottom: 1px solid #c5c4c4;
    }

    .quiz-link {
        color: #333;
        text-decoration: none;
    }

    .quiz-link:hover {
        color: #007bff;
    }

    .complete-button {
        background-color: #007bff;
        color: #fff;
        border: none;
        padding: 10px 20px;
        cursor: pointer;
        margin-top: 20px;
        width: 100%;
    }

    .star-rating {
        display: flex;
        direction: rtl;
        /* Đảo ngược thứ tự sao để sao 5 ở bên trái */
        justify-content: flex-end;
    }

    .star-rating input[type="radio"] {
        display: none;
        /* Ẩn input radio */
    }

    .star-rating label.star {
        font-size: 2rem;
        /* Kích thước sao */
        color: #ccc;
        /* Màu mặc định của sao (xám) */
        cursor: pointer;
        transition: color 0.2s;
        /* Hiệu ứng chuyển màu mượt mà */
    }

    /* Khi hover vào sao, tất cả sao từ vị trí đó trở về bên phải sẽ sáng lên */
    .star-rating label.star:hover,
    .star-rating label.star:hover~label.star {
        color: #f39c12;
        /* Màu vàng khi hover */
    }

    /* Khi chọn sao, tất cả sao từ vị trí đó trở về bên phải sẽ sáng lên */
    .star-rating input[type="radio"]:checked~label.star {
        color: #f39c12;
        /* Màu vàng khi được chọn */
    }

    .video-item:active .fa-play {
        /* khi nhấm sẽ xoay 160 độ */
        transform: rotate(90deg);
    }

    .video-item:hover .fa-play {
        /* khi nhấm sẽ xoay 160 độ */
        transform: rotate(90deg);
    }

    .video-item .fa-play {
        transition: transform 0.3s ease-in-out;
    }
</style>
@section('content')
    <div class="row">
        @if ($course->lessons->isNotEmpty())
            <div class="col-md-8">
                <div class="main-content p-0">
                    <div id="video-container">
                        <iframe id="lesson-video" width="100%" height="500"
                            src="{{ $course->lessons->first()->video_url ?? '' }}" title="YouTube video player"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            referrerpolicy="strict-origin-when-cross-origin" allowfullscreen loading="lazy">
                        </iframe>
                    </div>

                    <div class="video-info">
                        <h3 id="lesson-title">{{ $course->lessons->first()->title ?? '' }}</h3>
                        <p><span class="author">Giảng viên: {{ $course->instructor->name ?? 'Đang cập nhật' }}</span></p>
                    </div>

                    <button class="complete-button" id="complete-button"
                        onclick="markLessonComplete({{ $course->id }}, getCurrentLessonId())">
                        Đánh dấu hoàn thành bài học <span
                            id="complete-lesson-title">{{ $course->lessons->first()->title ?? '' }}</span>
                    </button>

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
                                        <a href="{{ route('course.lessons.show', $lesson->id) }}"
                                            onclick="loadLesson('{{ $lesson->video_url }}', '{{ $lesson->title }}', {{ $lesson->id }})">
                                            {{ $lesson->title }} - ({{ gmdate('H:i:s', $lesson->duration) }})
                                            @if ($lesson->completed)
                                                ✅
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
                            <div class="row g-0 ">
    <!-- Left side with average rating -->
    <div class="col-md-3 text-center p-4 border-end">
      <div class="fs-1 fw-bold mb-2">
        <span class="text-warning me-2">★</span>{{ number_format($averageRating, 1) }}/5
      </div>
      <div class="text-muted">{{ $ratingCount }} Đánh giá và nhận xét</div>
    </div>

    <!-- Right side with rating bars -->
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
            <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $percent }}%"></div>
          </div>
          <div style="min-width: 50px; text-align: right;">{{ number_format($percent, 0) }}%</div>
        </div>
      @endfor
    </div>
  </div>
</div>

<div class="card">
  <div class="card-body p-0">
    <div class="row g-0">
      <!-- Left side with average rating -->
      <div class="col-md-3 text-center p-4 border-end">
        <div class="fs-1 fw-bold mb-2">
          <span class="text-warning me-2">★</span>5/5
        </div>
        <div class="text-muted">2 Đánh giá và nhận xét</div>
      </div>

      <!-- Right side with rating bars -->
      <div class="col-md-9 p-4">
        <!-- 5 Stars -->
        <div class="d-flex align-items-center mb-3">
          <div class="me-3" style="min-width: 100px;">
            <span class="text-warning">★★★★★</span>
          </div>
          <div class="progress flex-grow-1 me-3" style="height: 8px;">
            <div class="progress-bar bg-warning" role="progressbar" style="width: 100%"></div>
          </div>
          <div style="min-width: 50px; text-align: right;">100%</div>
        </div>

        <!-- 4 Stars -->
        <div class="d-flex align-items-center mb-3">
          <div class="me-3" style="min-width: 100px;">
            <span class="text-warning">★★★★</span><span class="text-secondary">★</span>
          </div>
          <div class="progress flex-grow-1 me-3" style="height: 8px;">
            <div class="progress-bar bg-warning" role="progressbar" style="width: 0%"></div>
          </div>
          <div style="min-width: 50px; text-align: right;">0%</div>
        </div>

        <!-- 3 Stars -->
        <div class="d-flex align-items-center mb-3">
          <div class="me-3" style="min-width: 100px;">
            <span class="text-warning">★★★</span><span class="text-secondary">★★</span>
          </div>
          <div class="progress flex-grow-1 me-3" style="height: 8px;">
            <div class="progress-bar bg-warning" role="progressbar" style="width: 0%"></div>
          </div>
          <div style="min-width: 50px; text-align: right;">0%</div>
        </div>

        <!-- 2 Stars -->
        <div class="d-flex align-items-center mb-3">
          <div class="me-3" style="min-width: 100px;">
            <span class="text-warning">★★</span><span class="text-secondary">★★★</span>
          </div>
          <div class="progress flex-grow-1 me-3" style="height: 8px;">
            <div class="progress-bar bg-warning" role="progressbar" style="width: 0%"></div>
          </div>
          <div style="min-width: 50px; text-align: right;">0%</div>
        </div>

        <!-- 1 Star -->
        <div class="d-flex align-items-center">
          <div class="me-3" style="min-width: 100px;">
            <span class="text-warning">★</span><span class="text-secondary">★★★★</span>
          </div>
          <div class="progress flex-grow-1 me-3" style="height: 8px;">
            <div class="progress-bar bg-warning" role="progressbar" style="width: 0%"></div>
          </div>
          <div style="min-width: 50px; text-align: right;">0%</div>
        </div>
      </div>
    </div>
  </div>
</div>

                            <!-- Form đánh giá -->
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
                                                    <input type="radio" id="star{{ $i }}" name="rating"
                                                        value="{{ $i }}" required />
                                                    <label for="star{{ $i }}" class="star">★</label>
                                                @endfor
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <textarea name="comment" class="form-control" rows="3" placeholder="Chia sẻ cảm nhận của bạn về khóa học..."
                                                required></textarea>
                                        </div>
                                        <button type="submit" class="bg-primary text-white py-2 px-4 border-0">Gửi đánh
                                            giá</button>
                                    </form>
                                @else
                                    <p class="text-success">Bạn đã đánh giá khóa học này.</p>
                                @endif

                                <!-- Hiển thị các đánh giá -->
                                @if ($reviews->count())
                                    <div class="mt-4">
                                        @foreach ($reviews as $review)
                                            <div class="review-item mb-3 p-3 border rounded bg-light">
                                                <strong>{{ $review->user->name }}</strong>
                                                <div class="stars mb-1">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <span
                                                            style="color: {{ $i <= $review->rating ? '#f39c12' : '#ccc' }}">★</span>
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
                                <p class="mt-3">Vui lồng đăng nhập để đánh giá khóa học.</p>

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
                            <div class="progress-circle">
                                <svg class="progress-ring" width="40" height="40">
                                    <circle class="progress-ring__circle-bg" stroke="#e0e0e0" stroke-width="5"
                                        fill="transparent" r="17" cx="20" cy="20" />
                                    <circle class="progress-ring__circle" stroke="#4CAF50" stroke-width="5"
                                        fill="transparent" r="17" cx="20" cy="20"
                                        style="stroke-dasharray: {{ 106 * ($progressPercentage / 100) }}, 106;" />
                                </svg>
                                <div class="progress-text">{{ $progressPercentage }}%</div>
                            </div>
                        </div>

                        @if ($progressPercentage == 100)
                            <a href="{{ route('certificate.show', $course->id) }}"
                                class="bg-dark text-white py-2 px-4 border-0 text-center text-decoration-none"
                                style="width: 170px; margin-left: 370px; margin-top: 5px; margin-bottom: 15px">
                                Nhận chứng chỉ
                            </a>
                        @endif
                        <div class="divider"></div>
                        <div class="card-body">
                            <h3><i class="fas fa-book-open ud-icon"></i> Nội dung khóa học</h3>
                            <ul class="video-list">
                                @foreach ($course->lessons as $lesson)
                                    <li onclick="loadLesson('{{ $lesson->video_url }}', '{{ $lesson->title }}', {{ $lesson->id }})"
                                        class="video-item d-flex align-items-center">
                                        <i class="fas fa-play ud-icon"></i>
                                        <div class="lesson-info">
                                            <div class="d-flex align-items-center">
                                                <span>{{ $lesson->order_number }}.</span>
                                                <h4 class="m-0">{{ $lesson->title }}</h4>
                                                @if ($lesson->completed)
                                                    <p>✅</p>
                                                @endif
                                            </div>
                                        </div>
                                    </li>
                                    <ul class="quiz-list" id="quiz-list-{{ $lesson->id }}" class="quiz-list">
                                        @foreach ($lesson->quizzes as $quiz)
                                            <li class="quiz-item">
                                                <a class="quiz-link text-decoration-none text-dark"
                                                    href="{{ route('quizzes.show', $quiz->id) }}">
                                                    {{ $quiz->title }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endforeach
                            </ul>
                        </div>
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
    <script>
        // Khởi tạo biến currentLessonId
        let currentLessonId = {{ $course->lessons->first()->id ?? 0 }};

        function loadLesson(videoUrl, title, lessonId) {
            // Cập nhật ngay lập tức tiêu đề và video
            document.getElementById("lesson-title").innerText = title;
            document.getElementById("lesson-video").src = videoUrl;

            // Cập nhật tiêu đề trên nút "Đánh dấu hoàn thành"
            document.getElementById("complete-lesson-title").innerText = title;

            // Cập nhật currentLessonId
            currentLessonId = lessonId;

            // Cập nhật lesson_id trong form bình luận
            document.getElementById("comment-lesson-id").value = lessonId;

            // Ẩn tất cả danh sách quiz trước đó
            document.querySelectorAll(".quiz-list").forEach(el => el.style.display = "none");

            // Hiển thị danh sách quiz của bài học được chọn
            let quizList = document.getElementById(`quiz-list-${lessonId}`);
            if (quizList) {
                quizList.style.display = "block";
            }

            // Gửi yêu cầu AJAX để lấy thông tin chi tiết của bài học
            $.ajax({
                url: `/lessons/${lessonId}`,
                type: "GET",
                success: function(lesson) {
                    // Cập nhật các tab
                    $("#gioithieu p").html(lesson.content);
                    $("#noidung").html(`<ul>
                        @foreach ($course->lessons as $lessonItem)
                            <li>
                                <a href="#" onclick="loadLesson('{{ $lessonItem->video_url }}', '{{ $lessonItem->title }}', {{ $lessonItem->id }})">
                                    {{ $lessonItem->title }} - ({{ gmdate('H:i:s', $lessonItem->duration) }})
                                    @if ($lessonItem->completed)
                                        ✅
                                    @endif
                                </a>
                            </li>
                        @endforeach
                    </ul>`);
                    $("#tailieu").html(lesson.resources);
                    $("#thongtin").html(lesson.instructor_info);
                    $("#danhgia").html(lesson.comments);
                },
                error: function(xhr) {
                    console.error('Lỗi khi tải bài học:', xhr);
                    alert('Đã có lỗi xảy ra khi tải bài học. Vui lòng thử lại.');
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

        function getCurrentLessonId() {
            return currentLessonId;
        }

        function markLessonComplete(courseId, lessonId) {
            if (!lessonId) {
                alert('Không thể xác định bài học hiện tại.');
                return;
            }
            fetch(`/user/courses/${courseId}/lessons/${lessonId}/complete`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        let lessonItem = document.querySelector(`.video-list li[onclick*="${lessonId}"]`);
                        if (lessonItem && !lessonItem.classList.contains('completed')) {
                            lessonItem.classList.add('completed');
                            let completedIcon = document.createElement('p');
                            completedIcon.classList.add('ml-2', 'm-0');
                            completedIcon.innerText = '✅';
                            let titleDiv = lessonItem.querySelector('.d-flex');
                            if (titleDiv) {
                                titleDiv.appendChild(completedIcon);
                            }
                            updateCourseProgress(courseId);
                        }
                        alert(data.message);
                    } else {
                        alert(data.message);
                    }
                })
                .catch((error) => {
                    console.error('Lỗi đánh dấu bài học hoàn thành:', error);
                    alert('Đã có lỗi xảy ra khi đánh dấu bài học là hoàn thành.');
                });
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
                        document.getElementById('course-progress-bar').style.width = data.progressPercentage + '%';
                        document.getElementById('progress-percentage').innerText = data.progressPercentage + '%';
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
