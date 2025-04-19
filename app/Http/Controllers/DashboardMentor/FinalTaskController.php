<?php

namespace App\Http\Controllers\DashboardMentor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\FinalTask;

class FinalTaskController extends Controller
{
    // Form tambah tugas akhir
    public function create($courseId)
    {
        $courses = Course::all();
        return view('dashboard-mentor.finaltask-create', compact('courses', 'courseId'));
    }

    // Form detail
    public function detail($courseId, $taskId)
    {
        $finalTask = FinalTask::findOrFail($taskId);
        $course    = Course::findOrFail($courseId);
   
        return view('dashboard-mentor.finaltask-detail', compact('finalTask','course'));
    }

    // Form edit
    public function edit($courseId, $taskId)
    {
        $finalTask = FinalTask::findOrFail($taskId);
        $course    = Course::findOrFail($courseId);

        return view('dashboard-mentor.finaltask-edit', compact('finalTask', 'course'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        // Ambil course_id dari request atau route
        $courseId = $request->route('courseId');

        // Menambahkan course_id ke data yang disimpan dengan nama kolom yang sesuai di database
        FinalTask::create([
            'judul' => $request->input('title'),       // Kolom judul
            'desc' => $request->input('description'),   // Kolom desc
            'course_id' => $courseId,                   // Menambahkan course_id
        ]);

        // Redirect ke halaman detail kursus atau ke halaman lain setelah berhasil
        return redirect()->route('courses.show', ['course' => $courseId])->with('success', 'Tugas akhir berhasil ditambahkan.');
    }

    // Update
    public function update(Request $request, $courseId, $id)
    {
        // validasi
        $request->validate([
            'judul'     => 'required|string|max:255',
            'desc'      => 'required|string',
            'course_id' => 'required|exists:courses,id',
        ]);
    
        // ambil tugas akhir berdasarkan ID ke‑2
        $finalTask = FinalTask::findOrFail($id);
    
        // update fields
        $finalTask->update([
            'judul'     => $request->input('judul'),
            'desc'      => $request->input('desc'),
            'course_id' => $courseId, // atau $request->input('course_id')
        ]);
    
        // redirect ke halaman detail tugas akhir
        return redirect()
            ->route('courses.show', ['course' => $courseId])
            ->with('success', 'Tugas akhir berhasil diperbarui.');
    }    

    // Hapus
    public function destroy($id)
    {
        $finalTask = FinalTask::findOrFail($id);
        $finalTask->delete();

        return back()->with('success', 'Tugas akhir berhasil dihapus.');
    }
}
