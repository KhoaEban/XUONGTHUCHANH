@extends('layouts.master_instructor')

@section('content')
    <div class="container-fluid mt-5">
        <h2>Theo dõi tiến độ học viên</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Học viên</th>
                    <th>Quiz</th>
                    <th>Trạng thái</th>
                    <th>Điểm</th>
                    <th>Chi tiết</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($progresses as $progress)
                    <tr>
                        <td>{{ $progress->user->name }}</td>
                        <td>{{ $progress->quiz->title }}</td>
                        <td>{{ $progress->status }}</td>
                        <td>{{ $progress->score }}</td>
                        <td>
                            <a href="{{ route('instructor.progress.detail', [$progress->user_id, $progress->quiz_id]) }}"
                                class="btn btn-info btn-sm">Xem chi tiết</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
