<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Certificate of Completion</title>
    <style>
        * {
            box-sizing: border-box;
        }

        @import url('https://fonts.googleapis.com/css2?family=Roboto&display=swap');

        body {

            font-family: 'DejaVu Sans', sans-serif;
            margin: 0;
            background-color: #f5f5f5;
            justify-content: center;
            min-height: 100vh;
        }


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
</head>

<body>
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
</body>

</html>
