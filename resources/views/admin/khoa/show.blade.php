@extends('layouts.master_admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Khoa Details') }}</div>

                <div class="card-body">
                    <p><strong>Ma Khoa:</strong> {{ $khoa->MaKhoa }}</p>
                    <p><strong>Ten Khoa:</strong> {{ $khoa->TenKhoa }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
