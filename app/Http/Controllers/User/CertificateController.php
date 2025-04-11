<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;
use App\Models\Course;
use App\Models\Enrollment;

class CertificateController extends Controller
{
    public function show($course_id)
    {
        $user = Auth::user();
        $enrollment = Enrollment::where('user_id', $user->id)
            ->where('course_id', $course_id)
            // ->where('status', 'completed')
            ->first();

        if (!$enrollment) {
            abort(403, 'Bạn chưa hoàn thành khóa học này.');
        }

        $course = Course::findOrFail($course_id);

        return view('user.certificate.show', [
            'user' => $user,
            'course' => $course,
            'date' => now()->format('d/m/Y')
        ]);
    }

    public function download($course_id)
    {
        $user = Auth::user();
        $course = Course::findOrFail($course_id);

        $pdf = PDF::loadView('user.certificate.pdf', [
            'user' => $user,
            'course' => $course,
            'date' => now()->format('d/m/Y')
        ])->setPaper('a4', 'landscape');

        return $pdf->download('chung-chi-khoa-hoc.pdf');
    }
}
