@extends('layouts.sidebar_profile')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Chỉnh sửa thống tin</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('user.profile.update') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group mb-3 row">
                                <label for="name" class="col-md-2 col-form-label text-md-right">Tên:</label>

                                <div class="col-md-10">
                                    <input id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ $user->name }}" required autocomplete="name" autofocus>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group mb-3 row">
                                <label for="email" class="col-md-2 col-form-label text-md-right">Email:</label>

                                <div class="col-md-10">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ $user->email }}" required autocomplete="email" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group mb-3 row">
                                <label for="password" class="col-md-2 col-form-label text-md-right">Mật khẩu:</label>

                                <div class="col-md-10">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="new-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group mb-3 row">
                                <label for="password-confirm" class="col-md-3 col-form-label text-md-right">Xác nhận mật
                                    khẩu:</label>

                                <div class="col-md-9">
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="form-group mb-3 row">
                                <label for="avatar" class="col-md-2 col-form-label text-md-right">Avatar:</label>

                                <div class="col-md-10">
                                    <input id="avatar" type="file"
                                        class="form-control @error('avatar') is-invalid @enderror" name="avatar">

                                    @error('avatar')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Lưu
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<script>
    @if (session('success'))
        Swal.fire({
            title: 'Cập nhật thành công!',
            text: '{{ session('success') }}',
            icon: 'success',
            confirmButtonText: 'Đóng'
        });
    @endif
</script>
