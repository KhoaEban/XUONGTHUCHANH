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
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f8fafc;
        color: #333;
    }

    h1 {
        margin: 30px 0;
        font-size: 32px;
        font-weight: 600;
        text-align: center;
        color: #2c3e50;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        background-color: #fff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 0 10px rgba(0,0,0,0.05);
        margin-bottom: 30px;
    }

    thead {
        background-color: #f1f5f9;
    }

    th, td {
        padding: 16px;
        text-align: left;
        border-bottom: 1px solid #e2e8f0;
        vertical-align: middle;
    }

    th {
        font-size: 14px;
        font-weight: 600;
        color: #4b5563;
    }

    td {
        font-size: 14px;
        color: #374151;
    }

    tr:hover {
        background-color: #f9fafb;
    }

    form {
        display: inline-block;
        margin: 0 4px;
    }

    button {
        padding: 8px 12px;
        background-color: #ef4444;
        color: #fff;
        border: none;
        border-radius: 6px;
        font-size: 13px;
        cursor: pointer;
        transition: background-color 0.2s ease;
    }

    button:hover {
        background-color: #dc2626;
    }

    select {
        padding: 6px 10px;
        border-radius: 6px;
        border: 1px solid #cbd5e1;
        background-color: #fff;
        color: #1e293b;
        font-size: 13px;
        transition: border-color 0.2s ease;
    }

    select:hover,
    select:focus {
        border-color: #60a5fa;
        outline: none;
    }

    /* Responsive */
    @media screen and (max-width: 768px) {
        table, thead, tbody, th, td, tr {
            display: block;
        }

        thead {
            display: none;
        }

        tr {
            margin-bottom: 15px;
            background-color: white;
            padding: 12px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }

        td {
            position: relative;
            padding-left: 50%;
        }

        td:before {
            position: absolute;
            top: 50%;
            left: 16px;
            transform: translateY(-50%);
            font-weight: bold;
            white-space: nowrap;
            color: #6b7280;
        }

        td:nth-of-type(1)::before { content: "Người dùng"; }
        td:nth-of-type(2)::before { content: "Khóa học"; }
        td:nth-of-type(3)::before { content: "Nội dung"; }
        td:nth-of-type(4)::before { content: "Đánh giá"; }
        td:nth-of-type(5)::before { content: "Hiển thị"; }
        td:nth-of-type(6)::before { content: "Hành động"; }
    }
</style>
