<?php
namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        $exists = Review::where('user_id', Auth::id())
            ->where('course_id', $request->course_id)
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'Bạn đã đánh giá khóa học này rồi.');
        }

        Review::create([
            'user_id' => Auth::id(),
            'course_id' => $request->course_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->back()->with('success', 'Cảm ơn bạn đã đánh giá!');
    }

}