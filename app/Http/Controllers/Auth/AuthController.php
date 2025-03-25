<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Models\User;

class AuthController extends Controller
{

    public function index()
    {
        if (Auth::user()->role != 'admin') {
            return redirect()->route('home');
        }
        // Lấy tất cả user
        $users = User::paginate(5);

        return view('admin.user.index', compact('users'));
    }


    // Hiển thị form đăng nhập
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Xử lý đăng nhập
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Kiểm tra quyền và điều hướng
            if ($user->role == 'admin') {
                return redirect()->route('admin.dashboard'); // Chuyển đến trang admin
            } elseif ($user->role == 'instructor') {
                return redirect()->route('instructor.home'); // Chuyển đến trang teacher
            } elseif ($user->role == 'student') {
                return redirect()->route('user.home'); // Chuyển đến trang student
            }

            return redirect()->route('home'); // Mặc định chuyển về trang home nếu không có quyền cụ thể
        }

        return back()->withErrors(['email' => 'Email hoặc mật khẩu không chính xác']);
    }

    // Hiển thị form đăng ký
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Xử lý đăng ký
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|same:password',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Đăng ký thành công! Hãy đăng nhập.');
    }

    // Xử lý đăng xuất
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
