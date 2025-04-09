<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;
use App\Models\CommentLike;
use App\Models\Course;


class CommentController extends Controller
{
    // Thêm bình luận
    public function store(Request $request)
    {
        $comment = Comment::create([
            'user_id' => Auth::id(),
            'lesson_id' => $request->lesson_id,
            'content' => $request->content,
            'parent_id' => $request->parent_id
        ]);

        if ($request->ajax()) {
            return response()->json([
                'id' => $comment->id,
                'content' => $comment->content,
                'user' => ['name' => Auth::user()->name],
                'created_at' => $comment->created_at->diffForHumans()
            ], 200, [], JSON_UNESCAPED_UNICODE);
        }

        // Trả về kết quả bình thường khi không phải AJAX
        return redirect()->back();
    }

    public function like($commentId)
    {
        $comment = Comment::findOrFail($commentId);

        $like = CommentLike::where('comment_id', $comment->id)
            ->where('user_id', Auth::id())
            ->first();

        if ($like) {
            // Nếu đã like → hủy like
            $like->delete();
        } else {
            // Nếu chưa like → tạo like mới
            CommentLike::create([
                'user_id' => Auth::id(),
                'comment_id' => $comment->id,
            ]);
        }

        // Cập nhật lại likes_count dựa trên số lượng bản ghi trong CommentLike
        $comment->likes_count = CommentLike::where('comment_id', $comment->id)->count();
        $comment->save();

        // Lấy slug của khóa học từ bài học
        $lesson = $comment->lesson;
        $course = $lesson->course;

        return redirect()->route('course.show', ['slug' => $course->slug]);
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

    public function getComments($lesson_id)
    {
        $comments = Comment::where('lesson_id', $lesson_id)
            ->orderBy('created_at', 'desc')
            ->with('user') // Lấy thông tin người dùng để hiển thị
            ->get();

        return response()->json($comments);
    }

    public function destroy($commentId)
    {
        $comment = Comment::findOrFail($commentId);

        // Xóa tất cả lượt thích liên quan
        CommentLike::where('comment_id', $comment->id)->delete();

        // Cập nhật lại likes_count
        $comment->likes_count = 0;
        $comment->save();

        // Xóa bình luận
        $comment->delete();

        return redirect()->back();
    }
}
