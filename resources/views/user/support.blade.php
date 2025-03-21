@extends('layouts.master')

@section('content')
<div class="popup-container">
    <div class="popup">
        <h2>THÔNG TIN LIÊN HỆ</h2>
        <p>Bạn đang gặp khó khăn trong việc học tập và giảng dạy trên hệ thống LMS360? Hãy để lại thông tin, đội ngũ CSKH chúng tôi sẽ liên hệ lại sớm nhất.</p>
        <div class="content-container"> <form action="{{ route('user.support.submit') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="text" name="name" placeholder="Họ tên (bắt buộc)" required><br>
                <input type="tel" name="phone" placeholder="Số điện thoại (bắt buộc)" required><br>
                <input type="email" name="email" placeholder="Email"><br>
                <textarea name="message" placeholder="Nội dung cần hỗ trợ (bắt buộc)" required></textarea><br>
                <input type="file" name="file" id="file-upload"><br>
                <button type="button" class="close-btn">Đóng</button>
                <button type="submit" class="submit-btn">Gửi</button>
            </form>
            <div class="contact-info">
                <p>Bách Khoa Technology (tài khoản DA)</p>
                <p>admin@bachkhoatech.vn - 0903030246</p>
                <p><a href="#">Fanpage LMS 360 e-Learning</a></p>
                <p><a href="#">Group Cộng đồng giáo viên sáng tạo LMS360</a></p>
                <img src="{{ asset('image/Screenshot 2025-03-21 140731.png') }}" alt="QR Code">
            </div>
        </div>
    </div>
</div>
</body>
</html>
<style>
.popup-container {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
}

.popup {
    background-color: white;
    padding: 30px;
    border-radius: 8px;
    width: 800px; /* Tăng kích thước popup để chứa cả form và contact-info */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.popup h2 {
    text-align: center;
    margin-bottom: 30px;
    color: #333;
    font-size: 28px;
    font-weight: bold;
}

.popup p {
    margin-bottom: 30px;
    color: #555;
    line-height: 1.7;
}

.content-container {
    display: grid;
    grid-template-columns: 1fr 1fr; /* Chia thành hai cột bằng nhau */
    gap: 30px; /* Tăng khoảng cách giữa hai cột */
}

.popup form {
    display: flex;
    flex-direction: column;
}

.popup form label {
    margin-bottom: 5px;
    color: #333;
    font-weight: bold;
}

.popup form input[type="text"],
.popup form input[type="tel"],
.popup form input[type="email"],
.popup form textarea {
    width: 100%;
    padding: 12px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 16px;
    box-sizing: border-box;
}

.popup form textarea {
    height: 150px;
    resize: vertical;
}

.popup form input[type="file"] {
    margin-bottom: 20px;
}

.popup form .close-btn,
.popup form .submit-btn {
    padding: 15px 30px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 18px;
    font-weight: bold;
    margin-top: 20px;
}

.popup form .close-btn {
    background-color: #e0e0e0;
    color: #333;
}

.popup form .submit-btn {
    background-color: #007bff;
    color: white;
}

.popup .contact-info {
    text-align: left; /* Căn trái thông tin liên hệ */
}

.popup .contact-info p {
    margin-bottom: 10px;
    font-size: 16px;
}

.popup .contact-info a {
    color: #007bff;
    text-decoration: none;
    font-size: 16px;
}

.popup .contact-info a:hover {
    text-decoration: underline;
}

.popup .contact-info img {
    width: 200px; /* Tăng kích thước hình ảnh QR code */
    margin-top: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}
</style>
@endsection