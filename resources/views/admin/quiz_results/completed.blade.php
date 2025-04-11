@extends('layouts.master_admin')

@section('content')
<div class="container">
    <h2>Danh sách học viên đã hoàn thành 100% bài tập</h2>

    <a href="{{ route('quiz_results.index') }}" class="btn btn-secondary mb-3">⬅ Quay lại tất cả kết quả</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Học viên</th>
                <th>Bài học</th>
                <th>Điểm</th>
                <th>Hoàn thành</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($results as $result)
                <tr>
                    <td>{{ $result->user->name }}</td>
                    <td>{{ $result->quiz->title }}</td>
                    <td>{{ $result->score }}/{{ $result->total_questions }} ({{ $result->percent }}%)</td>
                    <td><span class="badge bg-success">✔ Hoàn thành</span></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection