<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use App\Models\User;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Category;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\Answer;
use App\Models\QuizResult;
use App\Models\Payment;
use App\Models\Enrollment;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $payments = Payment::where('user_id', $user->id)->get();
        $enrollments = Enrollment::where('user_id', $user->id)->get();
        $quizResults = QuizResult::where('user_id', $user->id)->get();
        return view('user.profile.index', compact('user', 'payments', 'enrollments', 'quizResults'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('user.profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        // Validate input data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Update user information
        $user->name = $request->name;
        $user->email = $request->email;

        // Update password if provided
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            $image = $request->file('avatar');
            $imageName = time() . '-' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/avatars'), $imageName); // Updated upload path
            $avatarPath = 'uploads/avatars/' . $imageName; // Updated path for saving
            $user->avatar = $avatarPath; // Store the avatar in the user's profile
        }

        // Save user information to the database
        $user->save();

        return redirect()->route('user.profile.edit')->with('success', 'Cập nhật thông tin thành công');
    }
}
