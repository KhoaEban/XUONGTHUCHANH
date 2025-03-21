<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SupportRequest; // Tạo Mail class nếu cần

class SupportController extends Controller
{
    public function index()
    {
        return view('user.support');
    }

    public function submit(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'email' => 'nullable|email',
            'message' => 'required',
        ]);

        $data = $request->all();

        // Xử lý file nếu có
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('support_files', $fileName); // Lưu file vào storage/app/support_files
            $data['file_path'] = 'support_files/' . $fileName;
        }

        // Gửi email thông báo (tùy chọn)
        // Mail::to('admin@example.com')->send(new SupportRequest($data));

        return redirect()->route('user.support')->with('success', 'Yêu cầu hỗ trợ đã được gửi thành công!');
    }
}