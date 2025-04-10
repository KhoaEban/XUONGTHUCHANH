@extends('layouts.master_admin')
@section('content')
<a href="{{ route('quiz_results.completed') }}" class="btn btn-success mb-3">
    🔍 Xem học viên đã hoàn thành 100%
</a>

<table class="table">
    <thead>
        <tr>
            <th>Học viên</th>
            <th>Bài học</th>
            <th>Điểm</th>
            <th>Hoàn thành</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($results as $result)
            <tr>
                <td>{{ $result->user->name }}</td>
                <td>{{ $result->quiz->title }}</td>
                <td>{{ $result->score }}/{{ $result->total_questions }} ({{ $result->percent }}%)</td>
                <td>
                    @if ($result->percent >= 50)
                        <span class="badge bg-success">✔ Đã hoàn thành</span>
                    @else
                        <span class="badge bg-warning text-dark">⏳ Chưa hoàn thành</span>
                    @endif
                </td>
                <td>
                    <form action="{{ route('admin.quiz_results.destroy', $result->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Bạn có chắc muốn xóa kết quả này?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">
                            <i class="fas fa-trash-alt"></i> Xóa
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection