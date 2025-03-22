@extends('layouts.master_admin')
@section('conten')
    <h1>Quản lý khoa học</h1>
    <div class="row">
        <div class="col-md-12">
            <a href="{{ route('admin.course.create') }}" class="btn btn-primary">Tạo khoa học</a>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Ten khoa hoc</th>
                        <th>Ngay tao</th>
                        <th>Ngay cap nhat</th>
                        <th>Tac vu</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($courses as $course)
                        <tr>
                            <td>{{ $course->id }}</td>
                            <td>{{ $course->name }}</td>
                            <td>{{ $course->created_at }}</td>
                            <td>{{ $course->updated_at }}</td>
                            <td>
                                <a href="{{ route('admin.course.edit', $course->id) }}" class="btn btn-primary">Sửa</a>
                                <form action="{{ route('admin.course.destroy', $course->id) }}" method="POST"
                                    style="display: inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>