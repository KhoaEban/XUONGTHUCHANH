@extends('layouts.master_admin')

@section('content')
    <h1>Quản lý đánh giá</h1>

    <table>
        <thead>
            <tr>
                <th>Người dùng</th>
                <th>Khóa học</th>
                <th>Nội dung</th>
                <th>Đánh giá</th>
                <th>Hiển thị</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reviews as $review)
                <tr>
                    <td>{{ $review->user->name ?? 'N/A' }}</td>
                    <td>{{ $review->course->title ?? 'N/A' }}</td>
                    <td>{{ $review->comment }}</td>

                    {{-- Hiển thị rating dạng sao --}}
                    <td>
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= $review->rating)
                                ⭐
                            @else
                                ☆
                            @endif
                        @endfor
                    </td>

                    <td>{{ $review->visible ? 'Hiển thị' : 'Ẩn' }}</td>

                    <td>
                        {{-- Dropdown Ẩn/Hiện --}}
                        <form action="{{ route('reviews.toggle_visibility', $review->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <select name="visible" onchange="this.form.submit()">
                                <option value="1" {{ $review->visible ? 'selected' : '' }}>Hiển thị</option>
                                <option value="0" {{ !$review->visible ? 'selected' : '' }}>Ẩn</option>
                            </select>
                        </form>

                        {{-- Xóa --}}
                        <form action="{{ route('reviews.destroy', $review->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $reviews->links() }}
@endsection

<style>
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        font-size: 14px;
    }

    th, td {
        padding: 12px;
        border: 1px solid #ddd;
        text-align: left;
    }

    th {
        background-color: #f4f4f4;
    }

    form {
        display: inline-block;
        margin: 0 4px;
    }

    button {
        padding: 6px 10px;
        border: none;
        background-color: #3490dc;
        color: white;
        border-radius: 4px;
        cursor: pointer;
    }

    button:hover {
        background-color: #2779bd;
    }

    h1 {
        margin-top: 20px;
        font-size: 24px;
    }

    select {
        padding: 5px;
        border-radius: 4px;
        border: 1px solid #ccc;
    }
</style>