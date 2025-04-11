@extends('layouts.master')

@section('content')
    <style>
        @media print {
            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            body {
                -webkit-print-color-adjust: exact !important;
                color-adjust: exact !important;
                background: #f5f5f5 !important;
            }
        }
        @font-face {
            font-family: 'DejaVuSans';
            src: url('https://cdnjs.cloudflare.com/ajax/libs/dejavu/2.37/ttf/DejaVuSans.ttf') format('truetype');
        }

        body {
            font-family: 'DejaVuSans', Arial, sans-serif;
            margin: 0;
            background-color: #f5f5f5;
            justify-content: center;
            min-height: 100vh;
        }

        .container {
            display: flex;
            max-width: 1500px;
            width: 100%;
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        /* Certificate Section */
        .certificate-section {
            flex: 2;
            padding: 30px;
            border-right: 1px solid #eee;
            background-color: #fff;
            position: relative;
        }

        .certificate-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .logo {
            height: 40px;
        }

        .certificate-ids {
            font-size: 12px;
            color: #666;
            text-align: right;
        }

        .certificate-title {
            color: #666;
            font-size: 16px;
            text-transform: uppercase;
            margin-bottom: 20px;
            letter-spacing: 1px;
        }

        .course-name {
            font-size: 60px;
            font-weight: bold;
            margin-bottom: 30px;
            line-height: 1.2;
        }

        .instructor {
            margin-bottom: 100px;
        }

        .instructor-label {
            font-size: 14px;
            color: #666;
        }

        .instructor-name {
            font-weight: bold;
        }

        .student-info {
            border-top: 1px solid #eee;
            padding-top: 20px;
        }

        .student-name {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .date-length {
            display: flex;
            gap: 40px;
        }

        .info-label {
            font-size: 14px;
            color: #666;
            margin-right: 5px;
        }

        /* Info Panel Section */
        .info-panel {
            flex: 1;
            padding: 30px;
            background-color: #fff;
        }

        .recipient-section {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 30px;
        }

        .avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: #333;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            font-weight: bold;
        }

        .recipient-name {
            font-size: 18px;
            font-weight: bold;
        }

        .panel-heading {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 15px;
            color: #333;
        }

        .course-card {
            background-color: #ff6633;
            color: white;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            margin-bottom: 20px;
        }

        .course-icon {
            background-color: white;
            border-radius: 8px;
            padding: 10px;
            display: inline-block;
            margin-bottom: 10px;
        }

        .course-info-title {
            font-weight: bold;
            margin-top: 10px;
            font-size: 18px;
        }

        .course-details {
            margin-top: 10px;
        }

        .instructor-info {
            font-size: 14px;
            margin-bottom: 5px;
        }

        .rating {
            display: flex;
            align-items: center;
            gap: 5px;
            margin-bottom: 5px;
        }

        .stars {
            color: #f4c150;
        }

        .course-stats {
            font-size: 14px;
            color: #666;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .btn {
            flex: 1;
            padding: 10px;
            border-radius: 4px;
            text-align: center;
            font-weight: bold;
            cursor: pointer;
        }

        .btn-download {
            background-color: #f5f5f5;
            color: #8710d8;
            border: 1px solid #8710d8;
        }

        .btn-share {
            background-color: #f5f5f5;
            color: #8710d8;
            border: 1px solid #8710d8;
        }

        .update-info {
            font-size: 14px;
            color: #666;
        }

        .highlight {
            color: #8710d8;
            cursor: pointer;
        }

        /* chứng chỉ */
        .certificate-container {
            width: 800px;
            height: 600px;
            background-color: white;
            border: 1px solid #e0e0e0;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
        }

        .top-corner {
            position: absolute;
            top: 0;
            left: 0;
            width: 200px;
            height: 200px;
            background-color: #2563eb;
            clip-path: polygon(0 0, 0% 100%, 100% 0);
            z-index: 1;
        }

        .bottom-corner {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 200px;
            height: 200px;
            background-color: #2563eb;
            clip-path: polygon(100% 100%, 0% 100%, 100% 0);
            z-index: 1;
        }

        .logo-area {
            position: absolute;
            top: 40px;
            left: 40px;
            color: white;
            z-index: 2;
        }

        .certificate-content {
            text-align: center;
            padding: 30px;
            margin-top: 10px;
            position: relative;
            z-index: 1;
        }

        .title {
            font-size: 32px;
            color: #333;
            margin-bottom: 60px;
            font-weight: bold;
        }

        .recipient-name {
            font-size: 48px;
            color: #2563eb;
            margin-bottom: 20px;
        }

        .course-details {
            font-size: 18px;
            color: #555;
            margin-bottom: 20px;
        }

        .course-name {
            font-size: 28px;
            font-weight: bold;
            color: #333;
            margin-top: 10px;
            margin-bottom: 80px;
        }

        .footer {
            display: flex;
            justify-content: space-between;
            padding: 0 80px;
            margin-top: 40px;
        }

        .date-section {
            text-align: left;
        }

        .verification-section {
            text-align: left;
        }

        .signature-section {
            text-align: right;
        }

        .line {
            width: 150px;
            border-top: 1px solid #333;
            margin-bottom: 10px;
        }

        .footer-text {
            font-size: 14px;
            color: #555;
        }
    </style>
    <br>
    <br>
    <div class="container">
        <!-- Certificate Section -->
        <div class="certificate-section">

            <div class="certificate-container">
                <div class="top-corner"></div>
                <div class="bottom-corner"></div>

                <div class="certificate-content">
                <div>
                    <img src="{{ asset('image/images.png') }}" alt="Udemy Logo" class="logo">
                    <img src="{{ asset('image/logo-3.png') }}" alt="FPT Polytechnic Logo" class="logo">
                </div>
                <br>
                    <h1 class="title">CERTIFICATE OF COMPLETION</h1>

                    <p class="recipient-name">{{ $user->name }}</p>

                    <p class="course-details">Đã hoàn thành khóa học trực tuyến</p>
                    <p class="course-name">{{ $course->title }}</p>
                </div>

                <div class="footer">
                    <div class="date-section">
                        <div class="line"></div>
                        <p class="footer-text">Date {{ date('Y-m-d') }}</p>
                    </div>

                    <div class="verification-section">
                        <p class="footer-text">Verify at {{ $user->email }}</p>
                        <p class="footer-text">ABCD1234</p>
                    </div>

                    <div class="signature-section">
                        <div class="line"></div>
                        <p class="footer-text">Signature</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Info Panel Section -->
        <div class="info-panel">
            <div class="panel-heading">Certificate Recipient:</div>
            <div class="recipient-section">
                <img class="avatar" src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random"
                    alt="">
                <div class="recipient-name">{{ $user->name }}</div>
            </div>

            <div class="panel-heading">About the Course:</div>
            <div class="course-card">
                <div class="course-icon">
                    <img src="{{ asset($course->thumbnail ?? 'images/default-thumbnail.jpg') }}"
                        style="width: 100%; height: 180px;" alt="Course Icon">
                </div>
                <div class="course-info-title">{{ $course->title }}</div>
                <div
                    style="margin-top: 20px; font-size: 16px; color: #444; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                    {{ $course->description }}
                </div>
            </div>

            <div class="course-details">
                <div class="course-info-title">{{ $course->title }}</div>
                <div class="instructor-info">{{ $course->instructor->name }}</div>
                <div class="rating">
                    <div class="rating-number">4.9</div>
                    <div class="stars">★★★★★</div>
                    <div>(466)</div>
                </div>
                <div class="course-stats">11 total mins · 19 lectures</div>
            </div>

            <div class="action-buttons">
                <a class="btn btn-download" href="{{ route('certificate.download', $course->id) }}">
                    <span>↓</span> Download
                </a>
                <div class="btn btn-share">
                    <span>←</span> Share
                </div>
            </div>

            <div class="update-info">
                Update your certificate <span class="highlight">with your correct name or preferred language</span>
            </div>
        </div>
    </div>

@endsection
