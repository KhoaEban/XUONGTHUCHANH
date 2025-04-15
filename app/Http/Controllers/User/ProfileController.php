<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

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
        $payments = Payment::where('user_id', $user->id)->take(4)->get();
        $enrollments = Enrollment::where('user_id', $user->id)->take(9)->get();
        $quizResults = QuizResult::where('user_id', $user->id)->take(3)->get();
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
}
