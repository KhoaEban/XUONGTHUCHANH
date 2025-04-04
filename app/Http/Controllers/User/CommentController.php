<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\CommentLike;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    // Thêm bình luận
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:500',
            'lesson_id' => 'required|exists:lessons,id',
            'parent_id' => 'nullable|exists:comments,id', // Cho phép phản hồi bình luận
        ]);

        // Kiểm tra nếu người dùng là giảng viên hoặc học viên
        if (!auth()->user()->isTeacher() && !auth()->check()) {
            return redirect()->back()->with('error', 'Bạn không có quyền bình luận.');
        }

        $comment = new Comment();
        $comment->content = $request->content;
        $comment->user_id = Auth::id();

        $comment->lesson_id = $request->lesson_id;
        $comment->parent_id = $request->parent_id;
        $comment->save();

        return redirect()->back()->with('success', 'Bình luận đã được đăng!');
    }


    public function like($id)
    {
        $comment = Comment::findOrFail($id);

        // Kiểm tra nếu người dùng đã like bình luận này
        $like = CommentLike::where('comment_id', $id)
            ->where('user_id', auth()->id())
            ->first();

        if ($like) {
            // Nếu đã like, bỏ like
            $like->delete();
            $comment->decrement('likes_count');
            return back()->with('success', 'Bạn đã bỏ like bình luận này.');
        } else {
            // Nếu chưa like, thêm like
            CommentLike::create([
                'user_id' => auth()->id(),
                'comment_id' => $id,
            ]);
            $comment->increment('likes_count');
            return back()->with('success', 'Đã thích bình luận!');
        }
    }



    // Hiển thị form sửa bình luận
    public function edit($id)
    {
        $comment = Comment::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        return view('comments.edit', compact('comment'));
    }

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
    public function show($id)
    {
        $course = Course::findOrFail($id);
        $lesson = $course->lessons->first();

        // Lấy bình luận mới nhất trước, với phân trang nếu cần
        $comments = $lesson->comments()->orderBy('created_at', 'desc')->paginate(10);  // 10 bình luận mỗi trang

        return view('courses.show', compact('course', 'comments'));
    }



    // Xóa bình luận
    public function destroy($id)
    {
        $comment = Comment::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $comment->delete();

        return back()->with('success', 'Bình luận đã bị xóa.');
    }
}
