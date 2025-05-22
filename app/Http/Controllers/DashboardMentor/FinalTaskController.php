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

    public function detail($courseId, $taskId)
    {
        $finalTask = FinalTask::where('id', $taskId)
                    ->where('course_id', $courseId)
                    ->firstOrFail();

        $course = Course::findOrFail($courseId);

        $submissions = FinalTaskUser::with('user')
                        ->where('final_task_id', $finalTask->id)
                        ->orderBy('created_at', 'desc') // Urutkan dari yang terbaru
                        ->paginate(10); // Pagination 10 data per halaman

        return view('dashboard-mentor.finaltask-detail', compact('finalTask','course', 'submissions'));
    }

    // Menampilkan detail jawaban tugas akhir yang dikumpulkan oleh user tertentu
    public function detailByUser($courseId, $taskId, $userId)
    {
        $submission = FinalTaskUser::with('user')
            ->where('final_task_id', $taskId)
            ->where('user_id', $userId)
            ->firstOrFail();

        $finalTask = FinalTask::findOrFail($taskId);
        $course    = Course::findOrFail($courseId);

        return view('dashboard-mentor.finaltask-detail-submission', compact('submission', 'finalTask', 'course'));
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

        $course = Course::findOrFail($request->course_id);

        // Redirect ke halaman detail kursus atau ke halaman lain setelah berhasil
        return redirect()->route('courses.show', ['course' => $course->slug])
            ->with('success', 'Tugas akhir berhasil ditambahkan.');
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
    
        $course = Course::findOrFail($request->course_id);

        // Redirect ke halaman detail kursus atau ke halaman lain setelah berhasil
        return redirect()->route('courses.show', ['course' => $course->slug])
            ->with('success', 'Tugas akhir berhasil diperbarui.');
    }    

    public function destroy($course, $id)
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
        $request->validate([
            'final_task_id' => 'required|exists:final_tasks,id',
            'user_id' => 'required|exists:users,id',
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'photo.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi untuk setiap foto
        ], [
            'final_task_id.required' => 'ID tugas akhir wajib diisi.',
            'final_task_id.exists' => 'ID tugas akhir tidak ditemukan.',
            
            'user_id.required' => 'ID pengguna wajib diisi.',
            'user_id.exists' => 'ID pengguna tidak ditemukan.',
            
            'course_id.required' => 'ID kursus wajib diisi.',
            'course_id.exists' => 'ID kursus tidak ditemukan.',
            
            'title.required' => 'Judul wajib diisi.',
            'title.string' => 'Judul harus berupa teks.',
            'title.max' => 'Judul tidak boleh lebih dari 255 karakter.',
            
            'description.required' => 'Deskripsi wajib diisi.',
            'description.string' => 'Deskripsi harus berupa teks.',
            
            'photo.*.nullable' => 'Foto bersifat opsional.',
            'photo.*.image' => 'File yang diunggah harus berupa gambar.',
            'photo.*.mimes' => 'Format gambar yang diperbolehkan adalah jpeg, png, jpg, atau gif.',
            'photo.*.max' => 'Ukuran gambar tidak boleh lebih dari 2MB.',
        ]);

        // Ambil data dari request
        $data = $request->only([
            'final_task_id',
            'user_id',
            'course_id',
            'title',
            'description',
            'certificate_status',
        ]);

        // Jika ada foto yang diupload (disimpan dalam bentuk array agar bisa lebih dari 1 foto)
        if ($request->hasFile('photo')) {
            $photos = $request->file('photo');
            $photoPaths = [];

            // Looping melalui file yang dipilih dan simpan path-nya
            foreach ($photos as $file) {
                // Menyimpan foto di storage dan mendapatkan path
                $photoPaths[] = $file->store('final-task-photos', 'public');
            }

            // Simpan semua path foto sebagai array
            $data['photo'] = $photoPaths; // Menyimpan dalam bentuk array
        }

        // Simpan data ke tabel final_task_user
        FinalTaskUser::create($data);
        
        $course = Course::findOrFail($request->course_id);

        // Redirect ke route study-peserta dengan pesan sukses
        return redirect()->route('study-peserta', ['slug' => $course->slug])
                ->with('success', 'Tugas akhir berhasil diupload.');
    }

    public function confirm($id)
    {
        $submission = FinalTaskUser::findOrFail($id);
        $submission->certificate_status = 'approved';
        $submission->save();

        return redirect()->back()->with('success', 'Sertifikat berhasil dikonfirmasi.');
    }
}
