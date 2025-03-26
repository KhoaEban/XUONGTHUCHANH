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

            // Điều hướng theo vai trò
            switch ($user->role) {
                case 'admin':
                    return redirect()->route('admin.dashboard');
                case 'instructor':
                    return redirect()->route('instructor.dashboard');
                case 'student':
                    return redirect('/');
                default:
                    Auth::logout();
                    return redirect('/login')->with('error', 'Tài khoản không hợp lệ.');
            }
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
