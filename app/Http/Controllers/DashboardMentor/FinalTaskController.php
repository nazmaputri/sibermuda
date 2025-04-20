<?php

namespace App\Http\Controllers\DashboardMentor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\FinalTask;
use App\Models\FinalTaskUser;

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
        $submissions = FinalTaskUser::with('user')->get();
        $finalTask = FinalTask::findOrFail($taskId);
        $course    = Course::findOrFail($courseId);
   
        return view('dashboard-mentor.finaltask-detail', compact('finalTask','course', 'submissions'));
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

    public function user($course, $finalTaskId)
    {
        // Mengambil data Course dan Final Task berdasarkan slug atau ID (sesuaikan dengan struktur database)
        $course = Course::findOrFail($course); 
        $finalTask = FinalTask::findOrFail($finalTaskId);

        return view('dashboard-peserta.finaltask-user', compact('finalTask', 'course'));
    }

    public function storeUser(Request $request)
    {
        // Validasi inputan
        $request->validate([
            'final_task_id' => 'required|exists:final_tasks,id',
            'user_id' => 'required|exists:users,id',
            'course_id' => 'required|exists:courses,id',  // Validasi untuk course_id
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        // Ambil data dari request
        $data = $request->only([
            'final_task_id',
            'user_id',
            'course_id', // Ambil course_id
            'title',
            'description', // Deskripsi dari Summernote
            'certificate_status', // status sertifikat
        ]);
    
        // Jika ada foto yang diupload
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('final-task-photos', 'public');
        }
    
        // Simpan data ke tabel final_task_user
        FinalTaskUser::create($data);
    
        // Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Tugas akhir berhasil diupload.');
    }

    public function confirm($id)
    {
        $submission = FinalTaskUser::findOrFail($id);
        $submission->certificate_status = 'approved';
        $submission->save();

        return redirect()->back()->with('success', 'Sertifikat berhasil dikonfirmasi.');
    }
}
