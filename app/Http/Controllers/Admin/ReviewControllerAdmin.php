<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;

class ReviewControllerAdmin extends Controller
{
    public function index()
    {
        $reviews = Review::with('user', 'course')->latest()->paginate(10);
        return view('admin.reviews.index', compact('reviews'));
    }

    public function toggleVisibility(Request $request, $id)
{
    $review = Review::findOrFail($id);
    $review->visible = $request->input('visible') == 1;
    $review->save();

    return redirect()->back()->with('success', 'Trạng thái hiển thị đã được cập nhật.');
}



    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();

        return redirect()->back()->with('success', 'Đánh giá đã được xóa.');
    }
}