@extends('layouts.master_instructor')

@section('content')
    <div class="container-fluid mt-5">
        <h2 class="mb-3">Theo dõi tiến độ học viên</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Học viên</th>
                    <th>Quiz</th>
                    <th>Trạng thái</th>
                    <th>Tiến độ</th>
                    <th>Chi tiết</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($progresses as $progress)
                    <tr>
                        <td>{{ $progress->user->name }}</td>
                        <td>{{ $progress->quiz->title }}</td>
                        <td>{{ $progress->score > 0 ? 'Hoàn thành' : 'Chưa hoàn thành' }}</td>
                        <td>{{ $progress->score }}/{{ $progress->total_questions }}</td>
                        <td>
                            <a href="{{ route('instructor.progress.detail', [$progress->user_id, $progress->quiz_id]) }}"
                                class="text-dark">
                                <i class="fas fa-eye" title="Chi tiết tiến độ"></i>
                            </a>
                        </td>
                        <td>
                            @if ($progress->score == 0)
                                <form
                                    action="{{ route('instructor.progress.notify', [$progress->user_id, $progress->quiz_id]) }}"
                                    method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-warning btn-sm">Nhắc nhở</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
