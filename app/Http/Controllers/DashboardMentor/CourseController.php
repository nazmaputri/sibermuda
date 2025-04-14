<?php

namespace App\Http\Controllers\DashboardMentor;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Category;
use App\Models\Materi;
use App\Models\MateriVideo;
use App\Models\MateriPdf;
use App\Models\Quiz;
use App\Models\RatingKursus;
use App\Models\NotifikasiMentorDaftar;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        // Ambil ID mentor yang sedang login
        $mentorId = Auth::id();

        // Ambil query pencarian dari input
        $search = $request->input('search');

        $courses = Course::with('category') // Tambahkan eager loading
    ->where('mentor_id', $mentorId)
    ->when($search, function ($query) use ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('title', 'LIKE', "%{$search}%")
              ->orWhere('price', 'LIKE', "%{$search}%")
              ->orWhereHas('category', function ($q2) use ($search) {
                  $q2->where('name', 'LIKE', "%{$search}%");
              });
        });
    })
    ->paginate(10);

        // Kirim data ke view
        return view('dashboard-mentor.kursus', compact('courses', 'search'));
    }

    public function create()
    {
        $mentorId = Auth::id();
        $categories = Category::all();
        return view('dashboard-mentor.kursus-create', compact('categories'));
    }

    public function store(Request $request)
    {
        // Validasi data yang dikirimkan dengan pesan custom
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|integer',
            'price' => 'required|numeric',
            'capacity' => 'nullable|integer',
            'chat' => 'nullable|boolean', // Validasi chat
            'image' => 'required|image|mimes:jpg,png,jpeg|max:2048',
            'start_date' => 'nullable|date|before_or_equal:end_date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ], [
            'title.required' => 'Judul kursus harus diisi.',
            'description.required' => 'Deskripsi kursus harus diisi.',
            'category_id.required' => 'Kategori kursus harus dipilih.',
            'price.required' => 'Harga kursus harus diisi.',
            'image.required' => 'Foto kursus harus diunggah.',
            'start_date.required' => 'Tanggal mulai kursus harus diisi.',
            'end_date.required' => 'Tanggal selesai kursus harus diisi.',
            'start_date.before_or_equal' => 'Tanggal mulai harus sebelum atau sama dengan tanggal selesai.',
            'end_date.after_or_equal' => 'Tanggal selesai harus setelah atau sama dengan tanggal mulai.',
        ]);
        
        // Ambil kategori dari database (opsional, jika hanya untuk validasi)
        $category = Category::find($request->category_id);

        if (!$category) {
            return redirect()->back()->withErrors(['category_id' => 'Kategori yang dipilih tidak ditemukan.']);
        }

        // Buat instance baru untuk kursus
        $course = new Course($request->only('title', 'description', 'price', 'capacity', 'start_date', 'end_date'));
        
        // Menyimpan kategori dan mentor
        $course->category_id = $request->category_id;
        $course->mentor_id = auth()->user()->id;
        
        // Simpan status chat (gunakan boolean untuk memastikan nilainya benar)
        $course->chat = $request->boolean('chat');
        
        // Simpan gambar jika diunggah
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images/kursus', 'public');
            $course->image_path = $path; // Simpan path gambar ke database
        }
        
        // Simpan data ke database
        $course->save();

        $mentor = auth()->user(); // PENTING: definisikan ini dulu
        
        // Redirect ke halaman kursus dengan pesan sukses
        return redirect()->route('courses.index')->with('success', 'Kursus berhasil ditambahkan!');
    }

    public function show($id)
    {
        // Ambil data course beserta relasi materi yang terkait
        $course = Course::with('materi')->findOrFail($id);
        
        // Menggunakan paginasi untuk menampilkan 5 materi per halaman
        $materi = $course->materi()->paginate(5);
    
        // Ambil ID mentor yang sedang login
        $mentorId = Auth::id();
    
        // Ambil rating berdasarkan course_id (bisa disesuaikan jika ingin filter berdasarkan mentor juga)
        $ratings = RatingKursus::where('course_id', $id)
                    ->with('user')
                    ->paginate(5);
    
        // Ambil quiz berdasarkan course_id
        $quizzes = Quiz::where('course_id', $id)->paginate(5);
        
        $finalQuizzes = Quiz::where('course_id', $id)
                    // ->whereNull('materi_id')
                    ->get();

        // Ambil peserta yang pembayaran kursusnya lunas beserta data user-nya
        $participants = Purchase::where('course_id', $id)
                            ->where('status', 'success')
                            ->with('user')
                            ->paginate(5);
    
        // Kembalikan data ke view
        return view('dashboard-mentor.kursus-detail', compact('course', 'quizzes', 'finalQuizzes', 'materi', 'participants', 'ratings'));
    }
    
    public function edit(Course $course)
    {
        $categories = Category::all();
        return view('dashboard-mentor.kursus-edit', compact('course', 'categories'));
    }

    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'category_id' => 'required|integer|exists:categories,id', 
            'capacity' => 'nullable|integer',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'start_date' => 'nullable|date|before_or_equal:end_date',
            'end_date' => 'nullable|date|after_or_equal:start_date', 
            'chat' => 'nullable|boolean',
        ], [
            'title.required' => 'Judul kursus wajib diisi.',
            'description.required' => 'Deskripsi kursus wajib diisi.',
            'price.required' => 'Harga kursus wajib diisi.',
            'category_id.required' => 'Kategori kursus wajib dipilih.',
            'category_id.exists' => 'Kategori yang dipilih tidak valid.',
            'image.required' => 'Gambar kursus wajib diupload.',
            'start_date.required' => 'Tanggal mulai kursus wajib diisi.',
            'end_date.required' => 'Tanggal selesai kursus wajib diisi.',
            'start_date.after_or_equal' => 'Tanggal mulai harus sebelum atau sama dengan tanggal selesai.',
            'end_date.after_or_equal' => 'Tanggal selesai harus setelah atau sama dengan tanggal mulai.',
        ]);
        
    
        // Update data kursus
        $course->title = $validated['title'];
        $course->description = $validated['description'];
        $course->price = $validated['price'];
        $course->category_id = $validated['category_id']; // Simpan ID kategori, bukan nama
        $course->capacity = $validated['capacity'] ?? null;
        $course->start_date = $validated['start_date']; // Update start_date
        $course->end_date = $validated['end_date']; // Update end_date
    
        // Perbarui status fitur chat jika ada di request
        $course->chat = $validated['chat'] ?? false; // Default ke false jika tidak ada input chat
    
        // Periksa apakah ada gambar yang diunggah
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($course->image_path) {
                \Storage::disk('public')->delete($course->image_path);
            }
    
            // Simpan gambar baru
            $course->image_path = $request->file('image')->store('images/kursus', 'public');
        }
    
        // Simpan perubahan ke database
        $course->save();
    
        // Redirect dengan pesan sukses
        return redirect()->route('courses.index')->with('success', 'Kursus berhasil diupdate!');
    }
    
    
    public function destroy(Course $course)
    {
        // Menghapus gambar kursus jika ada
        if ($course->image_path && Storage::disk('public')->exists($course->image_path)) {
            Storage::disk('public')->delete($course->image_path);
        }
    
        // Menghapus semua materi terkait dengan kursus
        if ($course->materi) {
            foreach ($course->materi as $materi) {
                // Menghapus semua materi video terkait (hanya dari database)
                if ($materi->videos) {
                    foreach ($materi->videos as $video) {
                        $video->delete();
                    }
                }

                // Menghapus materi
                $materi->delete();
            }
        }
    
        // Menghapus kursus
        $course->delete();
    
        return redirect()->route('courses.index')->with('success', 'Kursus beserta materi dan kuis berhasil dihapus!');
    }
    
}
