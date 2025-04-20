<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

use App\Models\Category;
use App\Models\Course;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $courses = Course::all();
        $popularCourses = Course::where('views', '>', 5)->orderBy('views', 'desc')->get();

        $user = Auth::user();
        $purchasedCourses = [];
        if ($user) {
            $user->load('enrollments'); // Eager-load enrollments
            $purchasedCourses = $user->enrollments->pluck('course_id')->toArray();
            Log::info('Purchased Courses for User ' . $user->id . ': ' . json_encode($purchasedCourses));
        }

        return view('user.home', compact('categories', 'courses', 'popularCourses', 'purchasedCourses'));
    }


    public function notifications()
    {
        $user = Auth::user();
        $notifications = $user->unreadNotifications; // Lấy thông báo chưa đọc

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
            // Tìm thông báo thuộc về user hiện tại
            $notification = Auth::user()->notifications()->findOrFail($notificationId);

            // Đánh dấu là đã đọc
            $notification->markAsRead();

            return redirect()->back()->with('success', 'Đã đánh dấu thông báo là đã đọc.');
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Thông báo không tồn tại hoặc không thuộc về bạn.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Đã có lỗi xảy ra: ' . $e->getMessage());
        }
    }
}
