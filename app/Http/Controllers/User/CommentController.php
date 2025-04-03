<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    // Thêm bình luận
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:500',
            'lesson_id' => 'required|exists:lessons,id',
            'parent_id' => 'nullable|exists:comments,id', // cho phép bình luận trả lời
        ]);

        $comment = new Comment();
        $comment->content = $request->content;
        $comment->user_id = Auth::id();
        $comment->lesson_id = $request->lesson_id;
        $comment->parent_id = $request->parent_id;
        $comment->save();

        return redirect()->back()->with('success', 'Bình luận đã được đăng!');
    }

    // Hiển thị form sửa bình luận
    public function edit($id)
    {
        $comment = Comment::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        return view('comments.edit', compact('comment'));
    }

    // Cập nhật bình luận
    // Cập nhật bình luận
    public function update(Request $request, $id)
    {
        // Lấy bình luận theo id và kiểm tra quyền của người dùng
        $comment = Comment::where('id', $id)->where('user_id', Auth::id())->first();

        if (!$comment) {
            return redirect()->back()->with('error', 'Không tìm thấy bình luận hoặc bạn không có quyền sửa.');
        }

        // Validate nội dung bình luận
        $request->validate([
            'content' => 'required|string|max:500',
        ]);

        // Cập nhật bình luận
        $comment->content = $request->content;
        $comment->save();

        // Quay lại trang và thông báo thành công
        return redirect()->back()->with('success', 'Bình luận đã được cập nhật.');
    }




    // Xóa bình luận
    public function destroy($id)
    {
        $comment = Comment::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $comment->delete();

        return back()->with('success', 'Bình luận đã bị xóa.');
    }
}
