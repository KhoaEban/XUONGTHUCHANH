@extends('layouts.master')

@section('content')
    <div class="container">
        <h2>Thông báo</h2>
        @if ($notifications->isEmpty())
            <p>Không có thông báo nào.</p>
        @else
            <ul class="list-group">
                @foreach ($notifications as $notification)
                    <li class="list-group-item {{ $notification->read_at ? 'bg-light' : 'bg-warning' }}">
                        <p>{{ $notification->data['message'] }}</p>
                        <a href="{{ $notification->data['action_url'] }}" class="btn btn-primary btn-sm">Xem chi tiết</a>
                        @if (!$notification->read_at)
                            <form action="{{ route('user.notifications.mark-as-read', $notification->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-secondary btn-sm">Đánh dấu đã đọc</button>
                            </form>
                        @endif
                        <small class="text-muted">Gửi lúc: {{ $notification->created_at->format('d/m/Y H:i') }}</small>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection