@extends('layouts.master_admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Sửa khoa</div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.khoa.update', $khoa->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="MaKhoa">{{ __('Ma Khoa') }}</label>
                            <input type="text" class="form-control" id="MaKhoa" name="MaKhoa" value="{{ $khoa->MaKhoa }}" required>
                        </div>

                        <div class="form-group">
                            <label for="TenKhoa">{{ __('Ten Khoa') }}</label>
                            <input type="text" class="form-control" id="TenKhoa" name="TenKhoa" value="{{ $khoa->TenKhoa }}" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
