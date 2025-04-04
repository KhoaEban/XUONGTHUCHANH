<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác nhận đăng ký khóa học</title>
</head>
<body>
    <h1>Chào {{ $user->name }},</h1>
    <p>Bạn đã đăng ký thành công khóa học: <strong>{{ $course->title }}</strong>.</p>
    <p>Chúc bạn học tập hiệu quả!</p>
    <p>Trân trọng,<br>Đội ngũ hỗ trợ</p>
</body>
</html>
