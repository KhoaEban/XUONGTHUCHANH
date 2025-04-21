<!-- resources/views/instructor/courses/progress.blade.php -->
@extends('layouts.master_instructor')

@section('content')
    <div class="container-fluid mt-5">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Theo dõi tiến độ học viên - Khóa học: {{ $course->title }}
                        <a href="{{ route('instructor.dashboard') }}" class="btn btn-secondary float-end">Quay lại</a>
                    </div>

                    <div class="card-body">
                        <!-- Danh sách bài học -->
                        <h5>Danh sách bài học</h5>
                        @if ($course->lessons->isEmpty())
                            <p class="text-muted">Khóa học này chưa có bài học nào.</p>
                        @else
                            <table class="table table-bordered mb-4">
                                <thead>
                                    <tr>
                                        <th>Tiêu đề bài học</th>
                                        <th>Thứ tự</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($course->lessons as $lesson)
                                        <tr>
                                            <td>{{ $lesson->title }}</td>
                                            <td>{{ $lesson->order_number ?? $loop->index + 1 }}</td>
                                            <td>
                                                <a href="{{ route('instructor.courses.comments', [$course->id, $lesson->id]) }}"
                                                    class="btn btn-info btn-sm">Xem bình luận</a>
                                                <a href="{{ route('instructor.quizzes.index') }}?course_id={{ $course->id }}&lesson_id={{ $lesson->id }}"
                                                    class="btn btn-primary btn-sm">Quản lý Quizzes</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif

                        <!-- Danh sách học viên -->
                        <h5>Danh sách học viên</h5>
                        @if (empty($progressData))
                            <p class="text-muted">Chưa có học viên nào tham gia khóa học này.</p>
                        @else
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Tên học viên</th>
                                        <th>Tiến độ (%)</th>
                                        <th>Bài học đã hoàn thành</th>
                                        <th>Kết quả bài kiểm tra</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($progressData as $data)
                                        <tr>
                                            <td>{{ $data['user']->name }} ({{ $data['user']->email }})</td>
                                            <td>{{ number_format($data['progress_percentage'], 2) }}%</td>
                                            <td>{{ $data['completed_lessons'] }} / {{ $data['total_lessons'] }}</td>
                                            <td>
                                                @if ($data['quiz_results']->isEmpty())
                                                    Chưa làm bài kiểm tra nào.
                                                @else
                                                    <ul>
                                                        @foreach ($data['quiz_results'] as $result)
                                                            <li>
                                                                Bài kiểm tra ID: {{ $result->quiz_id }} - Điểm:
                                                                {{ number_format($result->score, 2) }}/10
                                                                ({{ $result->score >= 7 ? 'Đạt' : 'Không đạt' }})
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
