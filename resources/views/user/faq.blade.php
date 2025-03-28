@extends('layouts.master')

@section('content')
    <div class="faq-container">
        <div class="faq-header">
            <h1>Câu hỏi thường gặp</h1>
            <div class="search_box">
                <input type="text" placeholder="Tìm câu hỏi thường gặp">
                <button>Tìm kiếm</button>
            </div>
        </div>
        <div class="faq-content">
            <div class="faq-section">
                <h2>TÀI KHOẢN HỌC SINH</h2>
                <div class="faq-category">
                    <h3>Bài giảng</h3>
                    <ul>
                        <li>Hoàn thành câu hỏi tương tác video nhưng không hiện điểm</li>
                        <li>Để hiển thị % hoàn thành khóa học</li>
                        <li>Học sinh đã xem và tải tài liệu về nhưng vẫn không hiện % hoàn thành khóa học</li>
                        <li>Học sinh không vào xem khóa học được</li>
                        <li>Học sinh xem trên điện thoại bài có 2 trang xem được 1 trang</li>
                    </ul>
                </div>
                <div class="faq-category">
                    <h3>Đăng nhập</h3>
                    <ul>
                        <li>Học sinh không đăng nhập được vì không có mật khẩu</li>
                    </ul>
                </div>
                <div class="faq-category">
                    <h3>Quản lý điểm</h3>
                    <ul>
                        <li>Cách nộp bài tự luận trên tài khoản Học sinh</li>
                        <li>Cách xem lại điểm trắc nghiệm trên tài khoản Học sinh</li>
                        <li>Cách kiểm tra điểm tự luận trên tài khoản Học sinh</li>
                    </ul>
                </div>
            </div>
            <div class="faq-section">
                <h2>TÀI KHOẢN GIÁO VIÊN</h2>
                <div class="faq-category">
                    <h3>Tạo bài giảng</h3>
                    <ul>
                        <li>Upload file Power Point</li>
                        <li>Giới hạn khi upload file</li>
                        <li>Mất dấu sao nộp bài cuối video tương tác</li>
                        <li>Giáo viên tạo bài tập tự luận</li>
                        <li>Đưa video lên hệ thống nhưng hiện Unknown</li>
                        <li>Cách đăng tải bài giảng xuất từ Ispring Suit lên hệ thống LMS360</li>
                        <li>Làm sao để tải về file bài giảng và up lên hệ thống?</li>
                    </ul>
                </div>
                <div class="faq-category">
                    <h3>Tài khoản</h3>
                    <ul>
                        <li>Cách cho học sinh vào xem bài học</li>
                        <li>Cách đổi mật khẩu trên trang LMS360</li>
                    </ul>
                </div>
                <div class="faq-category">
                    <h3>Quản lý điểm</h3>
                    <ul>
                        <li>Sau khi hoàn thành bài, điểm có được thống kê theo lớp không?</li>
                        <li>Làm câu hỏi tương tác video nhưng không hiện điểm trắc nghiệm</li>
                    </ul>
                </div>
                <div class="faq-category">
                    <h3>Duyệt học liệu</h3>
                    <ul>
                        <li>Là TTCM nhưng đăng nhập vào hệ thống thì không có phần duyệt bài</li>
                        <li>Sau khi duyệt bài thì khóa học không mất đi trong menu duyệt học liệu số</li>
                        <li>Duyệt bài đưa lên kho học liệu số của TCM Trường Cộng đồng sẽ do ai là người duyệt?</li>
                        <li>Quy trình duyệt học liệu số của TTCM và BGH</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <style>
.faq-container {
    width: 80%;
    margin: 20px auto;
    font-family: sans-serif;
}

.faq-header {
    text-align: center;
    margin-bottom: 20px;
    background-color: #f0f0f0;
    padding: 20px;
    border-radius: 8px;
}

.faq-header h1 {
    font-size: 28px;
    font-weight: bold;
    color: #333;
}

.search_box {
    display: flex;
    justify-content: center;
    margin-top: 10px;
}

.search_box input[type="text"] {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    width: 300px;
}

.search_box button {
    padding: 10px 20px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.faq-content {
    display: flex;
    justify-content: space-between;
}

.faq-section {
    width: 48%;
    background-color: #f8f8f8;
    padding: 20px;
    border-radius: 8px;
}

.faq-section h2 {
    font-size: 24px;
    margin-bottom: 15px;
    color: #333;
    background-color: #4CAF50; /* Màu nền xanh lá cây cho tiêu đề section */
    color: white; /* Màu chữ trắng cho tiêu đề section */
    padding: 10px; /* Thêm padding cho tiêu đề section */
    border-radius: 5px; /* Bo tròn góc cho tiêu đề section */
}

.faq-category {
    margin-bottom: 20px;
}

.faq-category h3 {
    font-size: 20px;
    margin-bottom: 10px;
    color: #333;
}

.faq-category ul {
    list-style: none;
    padding: 0;
}

.faq-category li {
    margin-bottom: 5px;
    color: #555;
    padding: 10px;
    border-bottom: 1px solid #eee;
}

.faq-category li:last-child {
    border-bottom: none;
}

.faq-category li::before {
    content: "●"; /* Icon chấm tròn */
    color: #4CAF50;
    margin-right: 5px;
}
</style>
@endsection