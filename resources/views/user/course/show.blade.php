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
        position: sticky; /* Để sidebar cố định khi cuộn */
        top: 20px;
        height: fit-content; /* Điều chỉnh chiều cao theo nội dung */
    }

    .course-progress {
        background-color: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
        text-align: center;
    }

    .progress-bar-container {
        background-color: #e9ecef;
        border-radius: 5px;
        height: 10px;
        margin-bottom: 10px;
        overflow: hidden;
    }

    .progress-bar {
        background-color: #28a745;
        height: 100%;
        width: 0%; /* Giá trị này sẽ được cập nhật bởi JavaScript */
        border-radius: 5px;
    }

    .progress-text {
        font-size: 0.9em;
        color: #495057;
    }

    .video-list {
        list-style: none;
        padding: 0;
        margin: 0;
        overflow-y: auto;
        max-height: 400px; /* Điều chỉnh chiều cao tối đa của danh sách video */
        scrollbar-width: thin;
        scrollbar-color: #000000 transparent;
        background: #f1f1f1;
        display: flex;
        flex-direction: column;
        gap: 10px;
        padding: 10px;
        border-radius: 5px;
    }

    .video-list::-webkit-scrollbar {
        width: 6px;
    }

    .video-list::-webkit-scrollbar-track {
        background: transparent;
    }

    .video-list::-webkit-scrollbar-thumb {
        background-color: #aaa;
        border-radius: 3px;
    }

    .video-list li {
        display: flex;
        align-items: center;
        cursor: pointer;
        background-color: white;
        border-radius: 5px;
        padding: 8px;
        border: 1px solid #ddd;
    }

    .video-list li.completed {
        background-color: #e6ffe6; /* Màu nền cho bài học đã hoàn thành */
        border-color: #c3e6cb;
    }

    .video-list img {
        width: 60px;
        height: 40px;
        border-radius: 5px;
        margin-right: 10px;
        object-fit: cover;
    }

    .video-list h4,
    span {
        font-size: 14px;
        margin-right: 5px;
    }

    .video-list p {
        font-size: 12px;
        color: #777;
        margin-bottom: 0;
    }

    .complete-button {
        background-color: #007bff;
        color: white;
        border: none;
        padding: 8px 12px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 14px;
        margin-top: 10px;
        display: block;
        width: 100%;
        text-align: center;
    }

    .complete-button:hover {
        background-color: #0056b3;
    }

    .quiz-list {
        list-style: none;
        padding-left: 20px;
        margin-top: 5px;
    }

    .quiz-item {
        padding: 5px 0;
    }

    .quiz-link {
        display: block;
    }
</style>

PHP

@extends('layouts.master')

<style>
    /* ... (CSS styles giữ nguyên) ... */
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
                </div>

                <div class="video-info">
                    <h3 id="lesson-title">{{ $course->lessons->first()->title ?? '' }}</h3>
                    <p><span class="author">Giảng viên: {{ $course->instructor->name ?? 'Đang cập nhật' }}</span></p>
                </div>

                <button class="complete-button" onclick="markLessonComplete({{ $course->id }}, getCurrentLessonId())">Đánh dấu hoàn thành</button>

                <div class="tabs">
                    <button class="tab-button active" onclick="openTab(event, 'gioithieu')">Giới thiệu</button>
                    <button class="tab-button" onclick="openTab(event, 'noidung')">Nội dung khóa học</button>
                    <button class="tab-button" onclick="openTab(event, 'tailieu')">Tài liệu</button>
                    <button class="tab-button" onclick="openTab(event, 'thongtin')">Thông tin giảng viên</button>
                    <button class="tab-button" onclick="openTab(event, 'danhgia')">Đánh giá</button>
                </div>

                <div id="gioithieu" class="tab-content active">
                    <p class="px-3">{!! nl2br(e($course->lessons->first()->content ?? 'Nội dung giới thiệu sẽ được cập nhật.')) !!}</p>
                </div>
                <div id="noidung" class="tab-content">
                    <ul class="video-list">
                        @foreach ($course->lessons as $lesson)
                            <li class="{{ in_array($lesson->id, $completedLessons) ? 'completed' : '' }}"
                                onclick="loadLesson('{{ $lesson->video_url }}', '{{ $lesson->title }}', {{ $lesson->id }})">
                                <img src="{{ asset($lesson->thumbnail ?? $course->thumbnail ?? 'images/default-thumbnail.jpg') }}"
                                     alt="Video">
                                <div class="d-flex align-items-center">
                                    <span>{{ $lesson->order_number }}.</span>
                                    <h4 class="m-0">{{ $lesson->title }}</h4>
                                    @if (in_array($lesson->id, $completedLessons))
                                        <p class="ml-2">✅</p>
                                    @endif
                                </div>
                                <ul class="quiz-list" id="quiz-list-{{ $lesson->id }}" style="display:none;">
                                    @foreach ($lesson->quizzes as $quiz)
                                        <li class="quiz-item border-bottom">
                                            <a class="quiz-link text-decoration-none text-dark" href="{{ route('quizzes.show', $quiz->id) }}">{{ $quiz->title }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div id="tailieu" class="tab-content">
                    <p>Danh sách tài liệu sẽ cập nhật sau.</p>
                </div>
                <div id="thongtin" class="tab-content">
                    <p>Giảng viên: {{ $course->instructor->name ?? 'Đang cập nhật' }}</p>
                    <p>Thông tin khác về giảng viên (nếu có).</p>
                </div>
                <div id="danhgia" class="tab-content">
                    <p>Đánh giá khóa học sẽ cập nhật sau.</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="sidebar-course m-0">
                <div class="card">
                    <div class="card-body">
                        <div class="course-progress">
                            <h4>Tiến độ khóa học</h4>
                            <div class="progress-bar-container">
                                <div class="progress-bar" id="course-progress-bar" style="width: {{ $progressPercentage }}%;"></div>
                            </div>
                            <p class="progress-text" id="progress-percentage">{{ $progressPercentage }}%</p>
                        </div>
                        <h3>Nội dung khóa học</h3>
                        <ul class="video-list">
                            @foreach ($course->lessons as $lesson)
                                <li
                                    onclick="loadLesson('{{ $lesson->video_url }}', '{{ $lesson->title }}', {{ $lesson->id }})"
                                    class="{{ in_array($lesson->id, $completedLessons) ? 'completed' : '' }}">
                                    <img src="{{ asset($lesson->thumbnail ?? $course->thumbnail ?? 'images/default-thumbnail.jpg') }}"
                                         alt="Video">
                                    <div class="d-flex align-items-center">
                                        <span>{{ $lesson->order_number }}.</span>
                                        <h4 class="m-0">{{ $lesson->title }}</h4>
                                        @if (in_array($lesson->id, $completedLessons))
                                            <p class="ml-2">✅</p>
                                        @endif
                                    </div>
                                    <ul class="quiz-list" id="quiz-list-{{ $lesson->id }}" style="display:none;">
                                        @foreach ($lesson->quizzes as $quiz)
                                            <li class="quiz-item border-bottom">
                                                <a class="quiz-link text-decoration-none text-dark" href="{{ route('quizzes.show', $quiz->id) }}">{{ $quiz->title }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    var currentLessonId = '{{ $course->lessons->first()->id ?? 0 }}';

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

    function loadLesson(videoUrl, title, lessonId) {
        document.getElementById("lesson-title").innerText = title;
        document.getElementById("lesson-video").src = videoUrl;
        currentLessonId = lessonId;

        document.querySelectorAll(".quiz-list").forEach(el => el.style.display = "none");

        let quizList = document.getElementById(`quiz-list-${lessonId}`);
        if (quizList) {
            quizList.style.display = "block";
        }
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
            if (data.message) {
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
                document.getElementById('progress-percentage').innerText = data.progressPercentage + '%'; // Cập nhật phần trăm
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