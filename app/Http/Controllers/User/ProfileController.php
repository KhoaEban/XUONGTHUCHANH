<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

use App\Models\User;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Category;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\CourseProgress;
use App\Models\QuizResult;
use App\Models\Payment;
use App\Models\Enrollment;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $payments = Payment::where('user_id', $user->id)->take(4)->get();
        $enrollments = Enrollment::where('user_id', $user->id)->with('course')->take(9)->get();
        $quizResults = QuizResult::where('user_id', $user->id)->take(3)->get();

        $enrollmentCounts = Enrollment::select('course_id')
            ->selectRaw('COUNT(DISTINCT user_id) as user_count')
            ->groupBy('course_id')
            ->pluck('user_count', 'course_id')
            ->toArray();

        // Lấy tiến độ của từng khóa học
        foreach ($enrollments as $enrollment) {
            $progress = CourseProgress::where('user_id', $user->id)
                ->where('course_id', $enrollment->course->id)
                ->first();

            $enrollment->progressPercentage = $progress
                ? $progress->getProgressPercentage()
                : 0; // Nếu không có dữ liệu, trả về 0%
        }

        Log::info('Enrollment Counts: ' . json_encode($enrollmentCounts));

        return view('user.profile.index', compact('user', 'payments', 'enrollments', 'quizResults', 'enrollmentCounts'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('user.profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:3|confirmed',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        if ($request->hasFile('avatar')) {
            $image = $request->file('avatar');
            $imageName = time() . '-' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/avatars'), $imageName);
            $avatarPath = 'uploads/avatars/' . $imageName;
            $user->avatar = $avatarPath;
        }

        $user->save();

        return redirect()->route('user.profile.edit')->with('success', 'Cập nhật thông tin thành công');
    }

    public function editPassword()
    {
        return view('user.profile.edit_password');
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => 'required|string|min:6',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if (!password_verify($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không chính xác']);
        }

        $user->password = bcrypt($request->password);
        $user->save();

        return redirect()->route('user.change.password')->with('success', 'Mật khẩu đã được thay đổi thành công!');
    }

    public function showCourseProgress($id)
    {
        $user = Auth::user();
        $course = Course::findOrFail($id);
        $enrollment = Enrollment::where('user_id', $user->id)->where('course_id', $id)->firstOrFail();

        $lessons = Lesson::where('course_id', $id)->get();
        $completedLessons = $enrollment->completed_lessons ?? [];

        $quizResults = QuizResult::where('user_id', $user->id)->whereHas('quiz', function ($query) use ($id) {
            $query->where('course_id', $id);
        })->get();

        return view('user.profile.course_detail', compact('user', 'course', 'enrollment', 'lessons', 'completedLessons', 'quizResults'));
    }
}
