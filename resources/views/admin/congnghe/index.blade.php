@extends('layouts.master_admin')

@section('title', 'Chi tiết cong nghe')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"> {{ __('Công nghê') }} </div>

                    <div class="card-body">
                        @if (session('ssuccess'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        @if (auth()->user()->role == 'admin')
                            <a href="{{ route('admin.congnghe.create') }}" class="btn btn-primary mb-3">Thêm công nghệ</a>
                        @endif
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Mã Công nghệ</th>
                                    <th>Tên Công nghệ</th>
                                    <th>Khoa</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($congnghes as $congghe)
                                    <tr>
                                        <td>{{ $congghe->id }}</td>
                                        <td>{{ $congghe->MaCongNghe }}</td>
                                        <td>{{ $congghe->TenCongNghe }}</td>
                                        <td>{{ $congghe->khoa->TenKhoa }}</td>
                                        <td>
                                            <a href="{{ route('admin.congnghe.edit', $congghe->id) }}"
                                                class="btn btn-warning">Sửa</a>
                                            <form method="POST"action="{{ route('admin.congnghe.destroy', $congghe->id) }}"
                                                style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Xóa</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </di>
        </div>
    </div>

@endsection
