<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class AdminCommentsController extends Controller
{
    public function index()
    {
        $comments = Comment::with('user', 'lesson')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.comments.index', compact('comments'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:active,pending,spam,deleted',
        ]);

        $comment = Comment::findOrFail($id);
        $comment->update(['status' => $request->status]);

        return back()->with('success', 'Trạng thái bình luận đã được cập nhật.');
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->update(['status' => 'deleted']);
        $comment->delete();

        return back()->with('success', 'Bình luận đã được đánh dấu là xóa.');
    }
}