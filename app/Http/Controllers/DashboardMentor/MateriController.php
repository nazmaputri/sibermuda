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
use Illuminate\Support\Facades\DB;

class MateriController extends Controller
{
    public function index()
    {
        $materi = Materi::with('videos', 'pdfs', 'course')->get();
        return view('dashboard-mentor.materi', compact('materi'));
    }

    public function create($slug)
    {
        $course = Course::where('slug', $slug)->firstOrFail();
        $materi = new Materi();

        return view('dashboard-mentor.materi-create', compact('course', 'materi'));
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

    public function show($slug, $materiId)
    {
        // Ambil data course
        $course = Course::with('materi')->where('slug', $slug)->firstOrFail();
        $id = $course->id;

        // Ambil data materi yang terkait dengan course tersebut, termasuk video yang terkait
        $materi = Materi::with(['videos', 'course'])
                    ->where('course_id', $id)
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
        return view('dashboard-mentor.materi-detail', compact('materi', 'id', 'materiId', 'course', 'videos'));
    }    
    
    public function store(Request $request, $courseId)
    {
        // 1. Validasi dasar
        $request->validate([
            'judul'     => 'required|string|max:255',
            'deskripsi' => 'required|string',

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
            'deskripsi.required' => 'Deskripsi materi wajib diisi.',
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

        $course = Course::findOrFail($courseId);

        return redirect()
            ->route('courses.show', ['course' => $course->slug])
            ->with('success', 'Materi berhasil ditambahkan.');
    }

    /**
     * Ekstrak ID video YouTube dari URL
     */
    private function extractYoutubeVideoId(string $url): ?string
    {
        $pattern = '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([a-zA-Z0-9_-]{11})%';
        if (preg_match($pattern, $url, $matches)) {
            return $matches[1];
        }
        return null;
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
    
    public function edit($slug, $materiId)
    {
        $course = Course::with('materi')->where('slug', $slug)->firstOrFail();
        $id = $course->id;

        $materi = Materi::where('course_id', $id)->findOrFail($materiId);
        $materi->load(['videos', 'youtube']);

        return view('dashboard-mentor.materi-edit', compact('materi', 'course', 'id'));
    }

    public function nextOrFinish(Materi $materi)
    {
        $userId = auth()->id();

        // Cek apakah progress untuk materi ini sudah ada
        $existingProgress = \App\Models\UserMateriProgress::where('user_id', $userId)
            ->where('materi_id', $materi->id)
            ->first();

        // Jika belum ada, buat progress baru
        if (!$existingProgress) {
            \App\Models\UserMateriProgress::create([
                'user_id'   => $userId,
                'materi_id' => $materi->id,
                'course_id' => $materi->course_id,
                'status'    => 'selesai'
            ]);
        }

        $course = $materi->course;
        $totalMateri = $course->materi()->count();

        $completedMateriCount = \App\Models\UserMateriProgress::where('user_id', $userId)
            ->whereIn('materi_id', $course->materi->pluck('id'))
            ->where('status', 'selesai')
            ->count();

        $progress = $totalMateri > 0 ? ($completedMateriCount / $totalMateri) * 100 : 0;

        $category = strtolower($course->kategori ?? '');

        $isCyberCategory = in_array($category, [
            'cyber security', 'siber', 'cybersecurity', 
            'cyber security', 'cybersecurity', 'cybersecurity', 
            'cyber', 'cyber'
        ]);

        if ($isCyberCategory) {
            $isFinalTaskCompleted = $this->checkFinalTaskCompleted($userId, $course->id);

            if (!$isFinalTaskCompleted && $progress >= 100) {
                $progress = 99;
            }
        } else {
            $isFinalTaskCompleted = true;
        }

        // Cari materi berikutnya
        $nextMateri = $course->materi()->where('id', '>', $materi->id)->orderBy('id')->first();

        if ($nextMateri) {
            return redirect()->route('study-peserta', [
                'slug' => $course->slug,
                'materiId' => $nextMateri->id,
            ])->with('success', 'Materi berhasil diselesaikan!');
        } else {
            // Kalau materi terakhir, redirect ke halaman course atau halaman lain sesuai kebutuhan
            return redirect()->route('daftar-kursus')
                ->with('success', 'Selamat! Anda telah menyelesaikan semua materi.');
        }
    }

    private function checkFinalTaskCompleted($userId, $courseId)
    {
        $certificateStatus = DB::table('final_task_user')
            ->where('user_id', $userId)
            ->where('course_id', $courseId)
            ->value('certificate_status');

        return in_array($certificateStatus, ['completed', 'approved']);
    }

    public function update(Request $request, $courseId, $materiId)
    {
        $request->validate([
            'judul'         => 'required|string|max:255',
            'deskripsi'     => 'nullable|string',

            'title'         => 'nullable|array',
            'title.*'       => 'nullable|string|max:255',

            'description'   => 'nullable|array',
            'description.*' => 'nullable|string|max:500',

            'link'          => 'nullable|array',
            'link.*'        => 'nullable|url',

            'type'          => 'nullable|array',

            'id'            => 'nullable|array',
            'id.*'          => 'nullable|integer',
        ]);

        $materi = Materi::findOrFail($materiId);
        $course = Course::findOrFail($courseId);
        $materi->update([
            'judul'     => $request->judul,
            'deskripsi' => $request->deskripsi,
            'course_id' => $courseId,
        ]);

        $keptVideoIds = [];
        $keptYoutubeIds = [];

        if ($request->filled('link') && $request->filled('type')) {
            foreach ($request->link as $i => $link) {
                $type = $request->type[$i] ?? null;
                $title = $request->title[$i] ?? '';
                $desc = $request->description[$i] ?? '';
                $id = $request->id[$i] ?? null;

                if ($type === 'drive') {
                    $driveId = $this->extractDriveFileId($link);
                    if (!$driveId) continue;

                    if ($id) {
                        $video = MateriVideo::find($id);
                        if ($video) {
                            $video->update([
                                'title'       => $title,
                                'description' => $desc,
                                'link'        => $driveId,
                            ]);
                            $keptVideoIds[] = $video->id;
                        }
                    } else {
                        $video = MateriVideo::create([
                            'materi_id'   => $materiId,
                            'title'       => $title,
                            'description' => $desc,
                            'link'        => $driveId,
                        ]);
                        $keptVideoIds[] = $video->id;
                    }

                } elseif ($type === 'youtube') {
                    $youtubeId = $this->extractYoutubeVideoId($link);
                    if (!$youtubeId) continue;

                    if ($id) {
                        $yt = Youtube::find($id);
                        if ($yt) {
                            $yt->update([
                                'title'       => $title,
                                'description' => $desc,
                                'link'        => $youtubeId,
                            ]);
                            $keptYoutubeIds[] = $yt->id;
                        }
                    } else {
                        $yt = Youtube::create([
                            'materi_id'   => $materiId,
                            'title'       => $title,
                            'description' => $desc,
                            'link'        => $youtubeId,
                        ]);
                        $keptYoutubeIds[] = $yt->id;
                    }
                }
            }
        }

        // Hapus hanya jika tidak disertakan di form
        MateriVideo::where('materi_id', $materiId)->whereNotIn('id', $keptVideoIds)->delete();
        Youtube::where('materi_id', $materiId)->whereNotIn('id', $keptYoutubeIds)->delete();

        return redirect()
        ->route('courses.show', ['course' => $course->slug])
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
    
        // Ambil course berdasarkan ID
        $course = Course::findOrFail($courseId);

        // Redirect menggunakan slug
        return redirect()->route('courses.show', ['course' => $course->slug])
            ->with('success', 'Materi berhasil dihapus!');
        }    
}
