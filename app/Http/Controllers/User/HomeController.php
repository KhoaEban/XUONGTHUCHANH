<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Category;
use App\Models\Course;
use App\Models\Review;
use App\Models\Enrollment;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $courses = Course::all();
        $popularCourses = Course::where('views', '>', 5)->orderBy('views', 'desc')->get();

        $user = Auth::user();
        $purchasedCourses = [];
        $userRatings = [];
        $averageRatings = [];
        $enrollmentCounts = [];

        if ($user) {
            $user->load('enrollments');
            $purchasedCourses = $user->enrollments->pluck('course_id')->toArray();
            Log::info('Purchased Courses for User ' . $user->id . ': ' . json_encode($purchasedCourses));

            $userRatings = Review::where('user_id', $user->id)
                ->where('visible', 1)
                ->pluck('rating', 'course_id')
                ->toArray();
            Log::info('User Ratings for User ' . $user->id . ': ' . json_encode($userRatings));
        }

        // Fetch average ratings for all courses
        $averageRatings = Review::select('course_id')
            ->selectRaw('AVG(rating) as average_rating')
            ->where('visible', 1)
            ->groupBy('course_id')
            ->pluck('average_rating', 'course_id')
            ->toArray();
        Log::info('Average Ratings: ' . json_encode($averageRatings));

        // Fetch enrollment counts for all courses
        $enrollmentCounts = Enrollment::select('course_id')
            ->selectRaw('COUNT(DISTINCT user_id) as user_count')
            ->groupBy('course_id')
            ->pluck('user_count', 'course_id')
            ->toArray();
        Log::info('Enrollment Counts: ' . json_encode($enrollmentCounts));

        return view('user.home', compact('categories', 'courses', 'popularCourses', 'purchasedCourses', 'userRatings', 'averageRatings', 'enrollmentCounts'));
    }

    public function notifications()
    {
        $user = Auth::user();
        $notifications = $user->unreadNotifications;
        return view('user.notifications', compact('notifications'));
    }

    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return redirect()->back()->with('success', 'Đã đánh dấu tất cả thông báo là đã đọc.');
    }

    public function markAsRead($notificationId)
    {
        try {
            $notification = Auth::user()->notifications()->findOrFail($notificationId);
            $notification->markAsRead();
            return redirect()->back()->with('success', 'Đã đánh dấu thông báo là đã đọc.');
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Thông báo không tồn tại hoặc không thuộc về bạn.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Đã có lỗi xảy ra: ' . $e->getMessage());
        }
    }
}
