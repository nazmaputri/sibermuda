<?php

namespace App\Http\Controllers\DashboardMentor;

use App\Http\Controllers\Controller;
use App\Models\Materi;
use App\Models\MateriVideo;
use App\Models\MateriPdf;
use App\Models\YouTube;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\Answer;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MateriController extends Controller
{
    public function index()
    {
        $materi = Materi::with('videos', 'pdfs', 'course')->get();
        return view('dashboard-mentor.materi', compact('materi'));
    }

    public function create($courseId)
    {
        $course = Course::findOrFail($courseId);
    
        return view('dashboard-mentor.materi-create', compact('course'));
    }    

    public function togglePreview($id)
    {
        $materi = Materi::findOrFail($id);

        // Reset semua preview di kursus yang sama
        Materi::where('courses_id', $materi->courses_id)->update(['is_preview' => false]);

        // Set yang ini jadi preview
        $materi->is_preview = true;
        $materi->save();

        return back()->with('success', 'Materi preview berhasil diatur.');
    }      

    public function show($courseId, $materiId)
    {
        // Ambil data course
        $course = Course::findOrFail($courseId);
    
        // Ambil data materi yang terkait dengan course tersebut, termasuk video yang terkait
        $materi = Materi::with(['videos', 'course'])
                    ->where('course_id', $courseId)
                    ->findOrFail($materiId);
    
        // Ambil video terkait dengan materi
        $videos = $materi->videos;
    
        // Ekstrak ID video dari link Google Drive
        foreach ($videos as $video) {
            // Ekstrak ID dari link Google Drive
            if (preg_match('/\/d\/(.*?)\//', $video->link, $matches)) {
                $video->video_id = $matches[1];  // Menyimpan ID video ke properti sementara
            } else {
                $video->video_id = null;  // Jika ID tidak ditemukan
            }
        }
    
        // Kirim data ke view
        return view('dashboard-mentor.materi-detail', compact('materi', 'courseId', 'materiId', 'course', 'videos'));
    }    
    
    public function store(Request $request, $courseId)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'title' => 'required|array',
            'title.*' => 'required|string|max:255',
            'description' => 'required|array',
            'description.*' => 'required|string|max:500',
            'link' => 'required|array',
            'link.*' => 'required|url',
        ], [
            'judul.required' => 'Judul materi wajib diisi.',
            'judul.string' => 'Judul harus berupa teks.',
            'judul.max' => 'Judul tidak boleh lebih dari 255 karakter.',
        
            'deskripsi.string' => 'Deskripsi harus berupa teks.',
        
            'title.required' => 'Judul video wajib diisi.',
            'title.string' => 'Judul video harus berupa teks.',
            'title.max' => 'Judul video tidak boleh lebih dari 255 karakter.',
        
            'description.string' => 'Deskripsi video harus berupa teks.',
        
            'link.required' => 'Link video wajib diisi.',
            'link.url' => 'Link harus berupa URL yang valid.',
        ]);        

        // Simpan data ke tabel `materis`
        $materi = Materi::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'course_id' => $courseId,
            'is_preview' => false, // atau sesuai kebutuhanmu
        ]);

       // Loop untuk menyimpan data materi video
        foreach ($request->title as $index => $title) {
            MateriVideo::create([
                'title' => $title,
                'description' => $request->description[$index],
                'link' => $request->link[$index],
                'materi_id' => $materi->id,  // Pastikan $materi->id sudah di-set sebelumnya
            ]);
        }
    
        // Kembali ke halaman kursus dengan pesan sukses
        return redirect()->route('courses.show', ['course' => $courseId])
                         ->with('success', 'Materi berhasil ditambahkan');
    }    
    
    public function edit($courseId, $materiId)
    {
        $course = Course::findOrFail($courseId);
        $materi = Materi::where('course_id', $courseId)->findOrFail($materiId);
        $materi->load('videos'); 
    
        return view('dashboard-mentor.materi-edit', compact('materi', 'course'));
    }

    public function update(Request $request, $courseId, $materiId)
    {
        // Validasi data utama
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'videos' => 'required|array|min:1',
            'videos.*.title' => 'required|string|max:255',
            'videos.*.description' => 'nullable|string',
            'videos.*.link' => 'required|url',
        ]);

        // Update data Materi utama
        $materi = Materi::findOrFail($materiId);
        $materi->update([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'course_id' => $courseId,
        ]);

        $existingVideos = MateriVideo::where('materi_id', $materiId)->get();

        // Ambil semua data video yang dikirim
        $incomingVideos = $request->videos;

        // Simpan ID video yang masih ada (untuk keperluan hapus sisanya)
        $keptVideoIds = [];

        foreach ($incomingVideos as $videoData) {
            // Cek apakah kombinasi title/link ini sudah ada (bisa juga pakai ID jika dikirim)
            $video = $existingVideos->firstWhere('link', $videoData['link']);

            if ($video) {
                // Update existing
                $video->update([
                    'title' => $videoData['title'],
                    'description' => $videoData['description'],
                    'link' => $videoData['link'],
                ]);
                $keptVideoIds[] = $video->id;
            } else {
                // Create new
                $newVideo = MateriVideo::create([
                    'materi_id' => $materi->id,
                    'title' => $videoData['title'],
                    'description' => $videoData['description'],
                    'link' => $videoData['link'],
                ]);
                $keptVideoIds[] = $newVideo->id;
            }
        }

        // Hapus video yang tidak ada dalam input terbaru
        MateriVideo::where('materi_id', $materiId)
            ->whereNotIn('id', $keptVideoIds)
            ->delete();

        return redirect()->route('courses.show', ['course' => $courseId])
                        ->with('success', 'Materi berhasil diperbarui.');
    }

    public function destroy($courseId, $materiId)
    {
        $materi = Materi::findOrFail($materiId);

        // Hapus video terkait (tidak perlu cek file karena hanya data biasa)
        foreach ($materi->videos as $video) {
            $video->delete();
        }
    
        // Tidak menghapus PDF, jadi bagian ini dihapus
    
        // Hapus materi
        $materi->delete();
    
        return redirect()->route('courses.show', ['course' => $courseId])
            ->with('success', 'Materi beserta link video materi berhasil dihapus!');
    }    

}
