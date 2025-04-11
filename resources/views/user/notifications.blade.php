@extends('layouts.master')

<style>
    .bg_warning {
        background-color: #ffc1072c !important;
    }

</style>
@section('content')
    <div class="container mt-5">
        <h2>Thông báo</h2>
        @if ($notifications->isEmpty())
            <p>Không có thông báo nào.</p>
        @else
            <ul class="list-group">
                @foreach ($notifications as $notification)
                    <li class="list-group-item {{ $notification->read_at ? 'bg-light' : 'bg_warning' }}">
                        <p class="py-3">{{ $notification->data['message'] }}</p>
                        <div class="d-flex align-items-center justify-content-between gap-2">
                            <div class="d-flex align-items-center gap-2">
                                <a href="{{ $notification->data['action_url'] }}" class="bg-primary text-white py-2 px-4 border-0 text-decoration-none">Xem chi tiết</a>
                                @if (!$notification->read_at)
                                    <form action="{{ route('user.notifications.mark-as-read', $notification->id) }}" method="POST"
                                        class="d-inline m-0">
                                        @csrf
                                        <button type="submit" class="bg-secondary text-white py-2 px-4 border-0">Đánh dấu đã đọc</button>
                                    </form>
                                @endif
                            </div>
                            <small class="text-dark">Gửi lúc: {{ $notification->created_at->format('d/m/Y H:i') }}</small>
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection
