@extends('layouts.master_admin')

@section('content')
<div class="container mt-4">
    <h2 class="text-center">Chỉnh sửa thông tin người dùng</h2>

    <form action="{{ route('admin.user.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Tên:</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}">
            @error('name')
                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Email:</label>
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}">
            @error('email')
                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Vai trò:</label>
            <select name="role" class="form-control @error('role') is-invalid @enderror">
                <option value="student" {{ old('role', $user->role) == 'student' ? 'selected' : '' }}>Học viên</option>
                <option value="instructor" {{ old('role', $user->role) == 'instructor' ? 'selected' : '' }}>Giảng viên</option>
                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Quản trị viên</option>
            </select>
            @error('role')
                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">Cập nhật</button>
        <a href="{{ route('admin.user.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection
