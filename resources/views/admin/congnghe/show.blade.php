@extends('layouts.master_admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"> {{ __('Cong Nghe Details') }} </div>

                <div class="card-body">
                    <p><strong>Mã Công nghệ</strong>{{ $congNghe->MaCongNghe }}</p>
                    <p><strong>Ten Công nghệ</strong>{{ $congNghe->TenCongNghe }}</p>
                    <p><strong>Khoa</strong>{{ $congNghe->khoa->TenKhoa }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
