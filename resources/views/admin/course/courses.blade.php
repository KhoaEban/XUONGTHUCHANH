@extends('layouts.master_admin')

@section('content')
<div class="container">
    <h2>Danh sách khóa học của Giảng viên</h2>
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Tên khóa học</th>
                <th>Mô tả</th>
                <th>Ngày tạo</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($courses as $course)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $course->name }}</td>
                <td>{{ $course->description }}</td>
                <td>{{ $course->created_at->format('d/m/Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
