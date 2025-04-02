@extends('layouts.master')

@section('content')
    <div class="container mt-5 text-center">
        <h1 class="text-danger">Thanh toán thất bại!</h1>
        <p>Đã xảy ra lỗi trong quá trình thanh toán. Vui lòng thử lại hoặc chọn phương thức thanh toán khác.</p>
        <a href="{{ route('course.payment', ['slug' => session('course_slug')]) }}" class="btn btn-warning mt-3">Thử lại</a>
        <a href="/" class="btn btn-primary mt-3">Chọn phương thức khác</a>
    </div>
@endsection
