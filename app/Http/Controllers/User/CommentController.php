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
            'lesson_id' => 'required|exists:lessons,id',
            'content' => 'required|string|max:1000',
        ]);

        Comment::create([
            'user_id' => Auth::id(),
            'lesson_id' => $request->lesson_id,
            'content' => $request->content,
        ]);

        return back()->with('success', 'Bình luận đã được thêm.');
    }

    // Hiển thị form sửa bình luận
    public function edit($id)
    {
        $comment = Comment::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        return view('comments.edit', compact('comment'));
    }

    // Cập nhật bình luận
    public function update(Request $request, Comment $comment)
{
    // Kiểm tra quyền sở hữu bình luận
    if ($comment->user_id !== Auth::id())        {
        return response()->json(['message' => 'Bạn không có quyền sửa bình luận này.'], 403);
    }

    $request->validate([
        'content' => 'required|string|max:500',
    ]);

    $comment->update([
        'content' => $request->content,
    ]);

    return response()->json(['message' => 'Cập nhật bình luận thành công!', 'content' => $comment->content]);
}


    // Xóa bình luận
    public function destroy($id)
    {
        $comment = Comment::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $comment->delete();

        return back()->with('success', 'Bình luận đã bị xóa.');
    }
}
