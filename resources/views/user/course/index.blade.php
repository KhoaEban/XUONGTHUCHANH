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
    <!-- Phần Video Chính -->
    <div class="row">
        <div class="col-md-8">
            <div class="main-content">
                <div class="video-container">
                    <video controls poster="video-thumbnail.jpg">
                        <source src="video.mp4" type="video/mp4">
                        Trình duyệt của bạn không hỗ trợ video.
                    </video>
                </div>
                <div class="video-info">
                    <h2>VIDEO TƯƠNG TÁC - MÔN TOÁN</h2>
                    <p><span class="author">Trần Xuân Anh Huy</span> • 8406 lượt xem</p>
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
                    <p>✔ Tiên phong hướng dẫn và tối ưu bền vững của việc xây dựng học liệu số E-Learning</p>
                    <h3>Giới thiệu khóa học</h3>
                    <p>Buổi tập huấn "XÂY DỰNG VÀ LƯU TRỮ HỌC LIỆU SỐ E-LEARNING" là chương trình phát triển năng lực công
                        nghệ và
                        chuyển đổi số.</p>
                </div>
                <div id="noidung" class="tab-content">
                    <p>Nội dung khóa học sẽ cập nhật sau.</p>
                </div>
                <div id="tailieu" class="tab-content">
                    <p>Danh sách tài liệu sẽ cập nhật sau.</p>
                </div>
                <div id="thongtin" class="tab-content">
                    <p>Thông tin giảng viên sẽ cập nhật sau.</p>
                </div>
                <div id="danhgia" class="tab-content">
                    <p>Đánh giá khóa học sẽ cập nhật sau.</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Phần Danh Sách Bài Giảng -->
            <div class="sidebar-course">
                <h3>GIỚI THIỆU HỆ THỐNG LMS360 E-LEARNING</h3>
                <ul class="video-list">
                    <li>
                        <img src="video1-thumbnail.jpg" alt="Video 1">
                        <div>
                            <h4>VIDEO TƯƠNG TÁC - MÔN TOÁN</h4>
                            <p>Trần Xuân Anh Huy</p>
                        </div>
                    </li>
                    <li>
                        <img src="video2-thumbnail.jpg" alt="Video 2">
                        <div>
                            <h4>VIDEO THỜI SỰ</h4>
                            <p>Trần Kiến An</p>
                        </div>
                    </li>
                    <li>
                        <img src="video3-thumbnail.jpg" alt="Video 3">
                        <div>
                            <h4>Bộ đề thi môn Toán THPT 2025</h4>
                            <p>Trần Văn Đại</p>
                        </div>
                    </li>
                    <!-- Thêm các mục video khác tương tự -->
                </ul>
            </div>

            <!-- Các khóa học gợi ý -->
            <div class="related-courses">
                <h3>CÁC KHOÁ HỌC GỢI Ý</h3>
                <ul class="video-list">
                    <li>
                        <img src="video1-thumbnail.jpg" alt="Video 1">
                        <div>
                            <h4>VIDEO TƯƠNG TÁC - MÔN TOÁN</h4>
                            <p>Trần Xuân Anh Huy</p>
                        </div>
                    </li>
                    <li>
                        <img src="video2-thumbnail.jpg" alt="Video 2">
                        <div>
                            <h4>VIDEO THỜI SỰ</h4>
                            <p>Trần Kiến An</p>
                        </div>
                    </li>
                    <li>
                        <img src="video3-thumbnail.jpg" alt="Video 3">
                        <div>
                            <h4>Bộ đề thi môn Toán THPT 2025</h4>
                            <p>Trần Văn Đại</p>
                        </div>
                    </li>
                    <!-- Thêm các mục video khác tương tự -->
                </ul>
            </div>
        </div>
    </div>



    <script>
        function openTab(evt, tabName) {
            var i, tabContent, tabButtons;

            // Ẩn tất cả nội dung tab
            tabContent = document.getElementsByClassName("tab-content");
            for (i = 0; i < tabContent.length; i++) {
                tabContent[i].style.display = "none";
            }

            // Xóa class "active" khỏi tất cả nút tab
            tabButtons = document.getElementsByClassName("tab-button");
            for (i = 0; i < tabButtons.length; i++) {
                tabButtons[i].className = tabButtons[i].className.replace(" active", "");
            }

            // Hiển thị nội dung tab được chọn và đánh dấu nút active
            document.getElementById(tabName).style.display = "block";
            evt.currentTarget.className += " active";
        }

        // Mặc định hiển thị tab đầu tiên
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementsByClassName("tab-content")[0].style.display = "block";
        });
    </script>
@endsection
