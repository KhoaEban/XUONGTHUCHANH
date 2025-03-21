@extends('layouts.master')

@section('content')
<div class="simulation-container">
    <div class="login-box">
    <img src="{{ asset('image/Screenshot 2025-03-21 143801.png') }}" alt="logo">
        <p class="slogan">HỆ THỐNG QUẢN LÝ HỌC TẬP TRỰC TUYẾN</p>
        <h2>Đăng nhập</h2>

        <div class="form-group">
            <select>
                <option value="so-giao-duc">Tài khoản Sở Giáo dục và Đào tạo TPHCM</option>
            </select>
        </div>

        <div class="form-group">
            <label>
                <input type="radio" name="account-type" value="hoc-sinh" checked> Học sinh
            </label>
            <label>
                <input type="radio" name="account-type" value="giao-vien"> Giáo viên
            </label>
        </div>

        <div class="form-group">
            <select>
                <option value="">Chọn trường</option>
            </select>
        </div>

        <button>ĐỒNG Ý</button>

        <p class="instruction">
            * Sử dụng tài khoản của Sở Giáo dục và Đào tạo TPHCM để đăng nhập.
            <a href="#">Xem hướng dẫn lấy tài khoản đăng nhập</a>
        </p>
    </div>
</div>
<style>

.simulation-container {
    background-image: url('{{ asset('images/simulation-bg.jpg') }}');
    background-size: cover;
    background-position: center;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
}

.login-box {
    background-color: white;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    width: 400px;
    text-align: center;
}

.logo {
    width: 150px;
    margin-bottom: 10px;
}

.slogan {
    font-size: 14px;
    color: #777;
    margin-bottom: 20px;
}

.login-box h2 {
    margin-bottom: 20px;
    color: #333;
}

.form-group {
    margin-bottom: 20px;
    text-align: left;
}

form-group label {
    display: inline-block;
    margin-right: 20px;
    color: #555;
}

.form-group select {
    width: calc(100% - 22px);
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.login-box button {
    background-color: #007bff;
    color: white;
    border: none;
    padding: 12px 20px;
    border-radius: 5px;
    cursor: pointer;
    width: 100%;
}

.instruction {
    font-size: 12px;
    color: #777;
    margin-top: 20px;
}

.instruction a {
    color: #007bff;
}
</style>
@endsection