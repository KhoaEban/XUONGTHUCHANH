<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Models\User;

class AuthController extends Controller
{

    public function index(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('home');
        }

        $query = User::query();

        // Lọc theo vai trò
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Tìm kiếm theo tên hoặc email
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        // Lấy danh sách người dùng
        $users = $query->paginate(10);

        return view('admin.user.index', compact('users'));
    }

    public function edit($id)
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('home');
        }

        $user = User::findOrFail($id);
        return view('admin.user.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('home');
        }

        $errors = [];

        if (!$request->filled('name')) {
            $errors['name'] = 'Tên không được để trống.';
        }

        if (!$request->filled('email') || !filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email không hợp lệ.';
        } elseif (User::where('email', $request->email)->where('id', '!=', $id)->exists()) {
            $errors['email'] = 'Email này đã tồn tại.';
        }

        if (!$request->filled('role') || !in_array($request->role, ['student', 'instructor', 'admin'])) {
            $errors['role'] = 'Vai trò không hợp lệ.';
        }

        if (!empty($errors)) {
            return redirect()->back()->withErrors($errors)->withInput();
        }

        User::where('id', $id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        return redirect()->route('admin.user.index')->with('success', 'Cập nhật thành công!');
    }

    public function trackUserActivity()
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('home');
        }

        // Lấy danh sách người dùng & thông tin hoạt động
        $users = User::select('id', 'name', 'email', 'role', 'last_login_at')
            ->orderBy('last_login_at', 'desc')
            ->paginate(10);

        return view('admin.user.activity', compact('users'));
    }
    public function blockUser($id)
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('home');
        }

        $user = User::findOrFail($id);
        $user->update(['status' => 'blocked']);

        return redirect()->route('admin.user.index')->with('success', 'Người dùng đã bị khóa.');
    }

    public function deleteUser($id)
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('home');
        }

        User::findOrFail($id)->delete();

        return redirect()->route('admin.user.index')->with('success', 'Người dùng đã bị xóa.');
    }

    // Hiển thị form đăng nhập
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Xử lý đăng nhập
    public function login(Request $request)
    {
        $errors = [];

        if (!$request->filled('email') || !filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email không hợp lệ.';
        }

        if (!$request->filled('password') || strlen($request->password) < 6) {
            $errors['password'] = 'Mật khẩu phải có ít nhất 6 ký tự.';
        }

        if (!empty($errors)) {
            return redirect()->back()->withErrors($errors)->withInput();
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Điều hướng theo vai trò
            return match ($user->role) {
                'admin' => redirect()->route('admin.dashboard'),
                'instructor' => redirect()->route('instructor.dashboard'),
                'student' => redirect('/'),
                default => Auth::logout() && redirect('/login')->with('error', 'Tài khoản không hợp lệ.')
            };
        }

        return back()->withErrors(['email' => 'Email hoặc mật khẩu không chính xác'])->withInput();
    }

    // Hiển thị form đăng ký
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Xử lý đăng ký
    public function register(Request $request)
    {
        $errors = [];

        if (!$request->filled('name')) {
            $errors['name'] = 'Tên không được để trống.';
        }

        if (!$request->filled('email') || !filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email không hợp lệ.';
        } elseif (User::where('email', $request->email)->exists()) {
            $errors['email'] = 'Email này đã tồn tại.';
        }

        if (!$request->filled('password') || strlen($request->password) < 6) {
            $errors['password'] = 'Mật khẩu phải có ít nhất 6 ký tự.';
        }

        if (!$request->filled('password_confirmation') || $request->password_confirmation !== $request->password) {
            $errors['password_confirmation'] = 'Xác nhận mật khẩu không khớp.';
        }

        if (!$request->filled('role') || !in_array($request->role, ['student', 'instructor'])) {
            $errors['role'] = 'Vai trò không hợp lệ.';
        }

        if (!empty($errors)) {
            return redirect()->back()->withErrors($errors)->withInput();
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
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
