@extends('layouts.sidebar_profile')

@section('content')
    <div class="flex justify-between items-center">
        <h2 class="text-lg font-semibold text-[#0F172A] mb-4">
            Khóa Học Đã Mua
        </h2>
    </div>
    <table class="w-full border-collapse rounded-md overflow-hidden">
        <thead>
            <tr class="bg-[#2563EB] text-white text-xs font-semibold text-left">
                <th class="py-3 px-4 border-r border-blue-600">
                    STT
                </th>
                <th class="py-3 px-4 border-r border-blue-600">
                    Khóa học
                </th>
                <th class="py-3 px-4 border-r border-blue-600">
                    Số tiền
                </th>
                <th class="py-3 px-4 border-r border-blue-600">
                    Phương thức thanh toán
                </th>
                <th class="py-3 px-4 border-r border-blue-600">
                    Trạng thái đăng ký
                </th>
                <th class="py-3 px-4">
                    Ngày thanh toán
                </th>
            </tr>
        </thead>
        <tbody class="text-sm divide-y divide-gray-100">
            @if ($payments->isEmpty())
                <tr class="bg-white text-center text-xs text-gray-700">
                    <td class="py-3 px-4 " colspan="6">Không tìm thấy kết quả</td>
                </tr>
            @else
                @foreach ($payments as $payment)
                    <tr class="bg-white text-center text-xs text-gray-700">
                        <td class="py-3 px-4 ">{{ $loop->iteration }}</td>
                        <td class="py-3 px-4 ">{{ $payment->course->title }}</td>
                        <td class="py-3 px-4 ">{{ number_format($payment->amount) }} VNĐ</td>
                        <td class="py-3 px-4 ">{{ $payment->payment_method }}</td>
                        <td class="py-3 px-4 ">
                            @php
                                $enrollment = $enrollments->where('course_id', $payment->course_id)->first();
                                echo $enrollment ? $enrollment->status : 'Chưa đăng ký';
                            @endphp
                        </td>
                        <td class="py-3 px-4 ">{{ $payment->created_at }}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
@endsection
