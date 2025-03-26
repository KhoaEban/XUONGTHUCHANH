@extends('layouts.master')

<style>
    /* Phần video chính */
    .main-content {
        flex: 3;
        background: white;
        padding: 20px;
        border-radius: 10px;
    }

    .video-container video {
        width: 100%;
        border-radius: 10px;
    }

    .video-info h2 {
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

    /* Phần danh sách bài giảng */
    .sidebar-course {
        flex: 1;
        margin-left: 20px;
        background: white;
        padding: 20px;
        border-radius: 10px;
    }

    .sidebar-course h3 {
        font-size: 18px;
        margin-bottom: 15px;
    }

    .related-courses {
        flex: 1;
        margin-left: 20px;
        background: white;
        padding: 20px;
        border-radius: 10px;
    }

    .related-courses h3 {
        font-size: 18px;
        margin-bottom: 15px;
    }

    .video-list {
        list-style: none;
    }

    .video-list li {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
        cursor: pointer;
    }

    .video-list img {
        width: 80px;
        height: 60px;
        border-radius: 5px;
        margin-right: 10px;
    }

    .video-list h4 {
        font-size: 14px;
    }

    .video-list p {
        font-size: 12px;
        color: #777;
    }
</style>

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="main-content">
                <div class="video-container">
                    <video controls poster="{{ asset('images/video-thumbnail.jpg') }}">
                        <source src="{{ $course->lessons->first()->video_url ?? '' }}" type="video/mp4">
                        Trình duyệt của bạn không hỗ trợ video.
                    </video>
                </div>
                <div class="video-info">
                    <h2>{{ $course->title }}</h2>
                    <p><span class="author">Giảng viên: {{ $course->teacher_name ?? 'Đang cập nhật' }}</span></p>
                </div>
                <div class="tabs">
                    <button class="tab-button active" onclick="openTab(event, 'gioithieu')">Giới thiệu</button>
                    <button class="tab-button" onclick="openTab(event, 'noidung')">Nội dung khóa học</button>
                    <button class="tab-button" onclick="openTab(event, 'tailieu')">Tài liệu</button>
                    <button class="tab-button" onclick="openTab(event, 'thongtin')">Thông tin giảng viên</button>
                    <button class="tab-button" onclick="openTab(event, 'danhgia')">Đánh giá</button>
                </div>
                <div id="gioithieu" class="tab-content active">
                    <h3>Bạn sẽ học được những gì?</h3>
                    <p>✔ {{ $course->description }}</p>
                </div>
                <div id="noidung" class="tab-content">
                    <ul>
                        @foreach ($course->lessons as $lesson)
                            <li>
                                <a href="#" onclick="loadLesson('{{ $lesson->video_url }}', '{{ $lesson->title }}')">
                                    {{ $lesson->title }} - ({{ gmdate('i:s', $lesson->duration) }})
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
                    <p>Giảng viên: {{ $course->teacher_name ?? 'Đang cập nhật' }}</p>
                </div>
                <div id="danhgia" class="tab-content">
                    <p>Đánh giá khóa học sẽ cập nhật sau.</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="sidebar-course">
                <h3>Nội dung khóa học</h3>
                <ul class="video-list">
                    @foreach ($course->lessons as $lesson)
                        <li onclick="loadLesson('{{ $lesson->video_url }}', '{{ $lesson->title }}')">
                            <img src="{{ asset('images/video-thumbnail.jpg') }}" alt="Video">
                            <div>
                                <h4>{{ $lesson->title }}</h4>
                                <p>{{ gmdate('i:s', $lesson->duration) }}</p>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <script>
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
            document.querySelector('.video-container video source').src = videoUrl;
            document.querySelector('.video-container video').load();
            document.querySelector('.video-info h2').innerText = title;
        }
    </script>
@endsection
