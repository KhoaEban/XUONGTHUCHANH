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

    .video-list h4, span {
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
                    <iframe id="lesson-video" width="100%" height="500" src="{{ $course->lessons->first()->video_url ?? '' }}" 
                        title="YouTube video player" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        referrerpolicy="strict-origin-when-cross-origin" allowfullscreen loading="lazy">
                    </iframe>
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
                    <p>Đánh giá khóa học sẽ cập nhật sau.</p>
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
                                <li onclick="loadLesson('{{ $lesson->video_url }}', '{{ $lesson->title }}')">
                                    <img src="{{ asset($course->thumbnail ?? 'images/default-thumbnail.jpg') }}" alt="Video">
                                    <div class="d-flex align-items-center">
                                        <span>{{ $lesson->order_number }}.</span><h4 class="m-0">{{ $lesson->title }}</h4>
                                        @if ($lesson->completed)
                                            <p>✅</p>
                                        @endif
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
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
                document.getElementById("lesson-title").innerText = title;
                document.getElementById("lesson-video").src = videoUrl;
            }
        </script>
    </div>
@endsection
