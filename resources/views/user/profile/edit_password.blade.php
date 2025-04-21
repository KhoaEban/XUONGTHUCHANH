@extends('layouts.sidebar_profile')

@section('content')
<div class="container">
    <h2 class="mb-4">Thay đổi Mật khẩu</h2>

    <form method="POST" action="{{ route('user.change.password.update') }}">
        @csrf

        <div class="mb-3">
            <label for="current_password" class="form-label">Mật khẩu hiện tại:</label>
            <input id="current_password" type="password" class="form-control @error('current_password') is-invalid @enderror" name="current_password" required>
            @error('current_password') <span class="invalid-feedback">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Mật khẩu mới:</label>
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
            @error('password') <span class="invalid-feedback">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label for="password-confirm" class="form-label">Xác nhận mật khẩu:</label>
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
        </div>

        <button type="submit" class="btn btn-primary">Đổi mật khẩu</button>
    </form>
</div>
@endsection
