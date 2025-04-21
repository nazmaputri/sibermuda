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
        Materi::where('course_id', $materi->course_id)->update(['is_preview' => false]);

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
        // 1. Validasi dasar
        $request->validate([
            'judul'     => 'required|string|max:255',
            'deskripsi' => 'nullable|string',

            // Google Drive fields
            'title'         => 'nullable|array',
            'title.*'       => 'nullable|string|max:255',
            'description'   => 'nullable|array',
            'description.*' => 'nullable|string|max:500',
            'link'          => 'nullable|array',
            'link.*'        => 'nullable|url',

            // YouTube fields
            'youtube_title'        => 'nullable|array',
            'youtube_title.*'      => 'nullable|string|max:255',
            'youtube_description'  => 'nullable|array',
            'youtube_description.*'=> 'nullable|string|max:500',
            'youtube_link'         => 'nullable|array',
            'youtube_link.*'       => 'nullable|url',
        ], [
            'judul.required' => 'Judul materi wajib diisi.',
            'link.*.url'     => 'Link Google Drive harus berupa URL yang valid.',
            'youtube_link.*.url' => 'Link YouTube harus berupa URL yang valid.',
        ]);

        // 2. Buat Materi
        $materi = Materi::create([
            'judul'     => $request->judul,
            'deskripsi' => $request->deskripsi,
            'course_id' => $courseId,
            'is_preview'=> false,
        ]);

        // 3. Simpan Google Drive Materi jika ada isian
        if ($request->filled('link')) {
            foreach ($request->link as $i => $driveLink) {
                if ($driveLink) {
                    $driveId = $this->extractDriveFileId($driveLink);
                    MateriVideo::create([
                        'materi_id'   => $materi->id,
                        'title'       => $request->title[$i] ?? '',
                        'description' => $request->description[$i] ?? '',
                        'link'        => $driveId,
                    ]);
                }
            }
        }

        // 4. Simpan YouTube jika ada isian
        if ($request->filled('youtube_link')) {
            foreach ($request->youtube_link as $i => $ytLink) {
                if ($ytLink) {
                    $youtubeId = $this->extractYoutubeVideoId($ytLink);
                    Youtube::create([
                        'materi_id'   => $materi->id,
                        'title'       => $request->youtube_title[$i] ?? '',
                        'description' => $request->youtube_description[$i] ?? '',
                        'link'        => $youtubeId,
                    ]);
                }
            }
        }

        return redirect()
            ->route('courses.show', $courseId)
            ->with('success', 'Materi berhasil ditambahkan.');
    }

    /**
     * Ekstrak ID video YouTube dari URL
     */
    private function extractYoutubeVideoId(string $url): ?string
    {
        // akan menangkap 11 karakter ID video
        preg_match(
            '/(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/.*v=|youtu\.be\/)([a-zA-Z0-9_-]{11})/',
            $url, $m
        );
        return $m[1] ?? null;
    }

    /**
     * Ekstrak ID file Google Drive dari URL
     */
    private function extractDriveFileId(string $url): ?string
    {
        preg_match(
            '/drive\.google\.com\/file\/d\/([a-zA-Z0-9_-]+)/',
            $url, $m
        );
        return $m[1] ?? null;
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
