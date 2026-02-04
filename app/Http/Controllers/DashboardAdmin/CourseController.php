<?php

namespace App\Http\Controllers\DashboardAdmin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;
use App\Models\Purchase;
use App\Models\User;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Menampilkan detail kursus beserta peserta
     */
    public function show($categoryId, $courseId)
    {
        $category = Category::with('courses')->findOrFail($categoryId);
        $course = Course::with('finalTask')->findOrFail($courseId);

        $participants = Purchase::where('course_id', $courseId)
            ->where('status', 'success')
            ->whereHas('user', function ($query) {
                $query->whereNull('deleted_at');
            })
            ->with('user')
            ->paginate(50);

        $totalPeserta = Purchase::where('course_id', $courseId)
            ->where('status', 'success')
            ->whereHas('user', function ($query) {
                $query->whereNull('deleted_at');
            })
            ->count();

        $users = User::where('role', 'student')
            ->whereNull('deleted_at')
            ->get();

        return view('dashboard-admin.course.show', compact('course', 'category', 'participants', 'users', 'totalPeserta'));
    }
}
