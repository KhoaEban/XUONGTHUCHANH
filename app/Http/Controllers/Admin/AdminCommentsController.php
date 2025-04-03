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

    public function hide($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->update(['status' => 'hidden']);
        return back()->with('success', 'Bình luận đã bị ẩn.');
    }

    public function show($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->update(['status' => 'visible']);
        return back()->with('success', 'Bình luận đã hiển thị lại.');
    }


    public function destroy($id)
    {
        Comment::findOrFail($id)->delete();
        return back()->with('success', 'Bình luận đã bị xóa.');
    }
}
