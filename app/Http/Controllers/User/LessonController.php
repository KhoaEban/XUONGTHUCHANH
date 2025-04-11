<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\Course;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function index()
    {
        $lesson = Lesson::all();
        return view('user.course.show', compact('lesson'));
    }

    public function show(Request $request, $id)
    {
        $lesson = Lesson::with(['comments.user', 'course.instructor'])->findOrFail($id);

        if ($request->ajax()) {
            return response()->json([
                'title' => $lesson->title,
                'video_url' => $lesson->video_url,
                'content' => $lesson->content,
                'comments' => $lesson->comments->map(function ($comment) {
                    return [
                        'id' => $comment->id,
                        'content' => $comment->content,
                        'created_at' => $comment->created_at,
                        'user' => [
                            'name' => $comment->user->name,
                            'is_teacher' => $comment->user->isTeacher(),
                        ],
                    ];
                })->toArray(),
            ]);
        }

        return view('lesson.show', compact('lesson'));
    }

    public function getLessons($slug)
    {
        $lessons = Lesson::where('course_id', $slug)->orderBy('order_number')->get();
        return response()->json($lessons);
    }
}
