@extends('layouts.sidebar_profile')

@section('content')
    <div class="flex justify-between items-start mb-6">
        <h2 class="font-bold text-base leading-6">
            THÔNG TIN
        </h2>
    </div>

    <div class="flex flex-col sm:flex-row sm:items-start gap-6">
        <div class="flex flex-col items-center sm:items-start">
            <div class="relative">
                @if ($user->avatar)
                    <img alt="avatar" class="rounded-full w-20 h-20 object-cover border border-[#2563eb]" height="80"
                        src="{{ asset($user->avatar) }}" width="80" />
                @else
                    <img alt="avatar" class="rounded-full w-20 h-20 object-cover border border-[#2563eb]" height="80"
                        src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random"
                        width="80" />
                @endif
            </div>
        </div>
        <div class="flex-1 grid grid-cols-1 sm:grid-cols-[max-content_1fr] gap-y-3 gap-x-6 text-[#6b7280]">
            <div>
                Tên tài khoản
                <span class="text-[#dc2626]">*</span>
            </div>
            <div class="font-semibold text-[#111827]">
                {{ $user->name }}
            </div>
            <div>
                Địa chỉ Email
                <span class="text-[#dc2626]">*</span>
            </div>
            <div class="font-semibold text-[#111827]">
                {{ $user->email }}
            </div>
            <div>
                Ngày tham gia
            </div>
            <div class="font-semibold text-[#111827]">
                {{ $user->created_at->format('d/m/Y') }}
            </div>
        </div>
    </div>

    <!-- Khóa học đang học -->
    <h2 class="font-bold text-base leading-6 mt-6">
        Khóa học đang học
    </h2>

    @if ($enrollments->isEmpty())
        <p class="text-gray-500">Bạn chưa đăng ký khóa học nào.</p>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mt-4">
            @foreach ($enrollments as $enrollment)
                <div class="bg-white shadow-md rounded-lg p-3">
                    <img src="{{ asset($enrollment->course->thumbnail) }}"
                        style="width: 100%; height: 200px; object-fit: cover;" class="mb-2"
                        alt="{{ $enrollment->course->title }}">
                    <h3 class="font-semibold text-lg text-[#111827]">{{ $enrollment->course->title }}</h3>
                    <p class="text-sm text-gray-600">Tiến độ: {{ $enrollment->progressPercentage }}%</p>
                    <p class="text-sm text-gray-600">Ngày đăng ký:
                        {{ \Carbon\Carbon::parse($enrollment->enrolled_at)->format('d/m/Y') }}</p>
                    <a href="{{ route('profile.progress.detail', $enrollment->course->id) }}"
                        class="text-[#2563eb] hover:underline">
                        Xem chi tiết
                    </a>
                </div>
            @endforeach
        </div>
    @endif
@endsection
