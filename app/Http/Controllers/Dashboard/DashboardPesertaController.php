<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Controllers\DashboardMentor\CourseController;
use App\Http\Controllers\DashboardAdmin\CategoryController;
use App\Models\Category;
use App\Models\Course;
use App\Models\Purchase;
use App\Models\FinalTask;
use App\Models\RatingKursus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardPesertaController extends Controller
{
    public function detail($id)
    {
        // Ambil satu data kursus berdasarkan ID
        $course = Course::find($id);

        // Jika kursus tidak ditemukan, kembalikan halaman 404
        if (!$course) {
            return abort(404);
        }

        // Cek apakah user sudah memberikan rating untuk kursus ini
        $hasRated = DB::table('rating_kursus')
            ->where('course_id', $id)
            ->where('user_id', auth()->id())
            ->exists();

        // Kirim data kursus dan status rating ke view
        return view('dashboard-peserta.kursus-detail', compact('course', 'hasRated'));
    }

    public function index() {
        return view('layouts.dashboard-peserta');
    }

    public function show()
    {
        $userId = auth()->id();

        $courses = Course::whereIn('id', function ($query) use ($userId) {
            $query->select('course_id')
                ->from('purchases')
                ->where('user_id', $userId)
                ->where('status', 'success');
        })->get();

        $totalKursus = $courses->count();

        Carbon::setLocale('id'); 
        $currentDateTime = Carbon::now();  // Mengambil tanggal dan waktu sekarang
        $currentDateTimeFormatted = $currentDateTime->format('l, H:i');  // Format: Hari, Jam

        $canDownloadCertificates = [];

        $cyberKeywords = [
            'cyber security', 'siber', 'cybersecurity', 
            'cyber', 'Cyber Security', 'CyberSecurity', 
            'Cybersecurity', 'Cyber'
        ];

        foreach ($courses as $course) {
            $isAllowed = false;

            $categoryName = strtolower($course->category->name ?? '');

            // Cek apakah kategori termasuk cybersecurity
            $isCyberSecurity = collect($cyberKeywords)
                ->map(fn($item) => strtolower($item))
                ->contains($categoryName);

            if ($isCyberSecurity) {
                // Butuh persetujuan mentor
                $certificateStatus = DB::table('final_task_user')
                    ->where('user_id', $userId)
                    ->where('course_id', $course->id)
                    ->value('certificate_status');

                $isAllowed = $certificateStatus === 'approved';
            } else {
                // Non-cybersecurity: cek nilai
                $nilai = DB::table('materi_user')
                    ->where('user_id', $userId)
                    ->where('courses_id', $course->id)
                    ->value('nilai');

                $isAllowed = $nilai !== null && $nilai >= 75;
            }

            $canDownloadCertificates[$course->id] = $isAllowed;

            // Menghitung rata-rata rating untuk kursus ini
                $averageRating = RatingKursus::where('course_id', $course->id)->avg('stars');
                
                // Membatasi rating maksimal 5
                $averageRating = min($averageRating, 5);
            
                // Menyimpan rata-rata rating untuk kursus
                $course->average_rating = $averageRating;
                
                // Menghitung jumlah bintang penuh, setengah, dan kosong
                $fullStars = floor($averageRating); // Bintang penuh
                $halfStar = $averageRating - $fullStars >= 0.5; // Bintang setengah
                $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0); // Bintang kosong
            
                // Menyimpan jumlah bintang untuk ditampilkan di view
                $course->rating_full_stars = $fullStars;
                $course->rating_half_star = $halfStar;
                $course->rating_empty_stars = $emptyStars;
        }

        // Hitung total sertifikat yang tersedia
        $totalSertifikat = collect($canDownloadCertificates)->filter()->count();

        return view('dashboard-peserta.welcome', compact('courses', 'canDownloadCertificates', 'totalKursus', 'totalSertifikat', 'currentDateTimeFormatted'));
    }
    
    public function chat() {
        return view('dashboard-peserta.chat');
    }

    public function kursus($id, $categoryId)
    {
        // Ambil data kursus
        $course = Course::findOrFail($id);
        
        // Ambil kategori yang terkait dengan kursus ini
        $category = Category::findOrFail($categoryId);
    
        // Cek apakah user sudah membeli kursus ini melalui tabel purchases
        $hasPurchased = Purchase::where('course_id', $course->id)
                                ->where('user_id', auth('student')->id())
                                ->where('status', 'success')
                                ->exists();

        // Ambil rating berdasarkan course_id dan mentor_id (untuk menampilkan rating kursus berdasarkan kursus nya)
        $rating = RatingKursus::where('course_id', $id)->with('user')->get();
    
        // Ambil status pembelian dari tabel purchases
        $paymentStatus = null;
        if ($hasPurchased) {
            $course->is_purchased = true;
        } else {
            $purchase = Purchase::where('course_id', $course->id)
                                ->where('user_id', auth('student')->id())
                                ->first();
            if ($purchase) {
                $paymentStatus = $purchase->status;
            }
        }
    
        // Kirim data kursus dan kategori ke view
        return view('dashboard-peserta.detail', compact('course', 'paymentStatus', 'hasPurchased', 'category', 'rating'));
    }
    
    
    public function study($id)
    {
        // Ambil course dan materinya
        $course = Course::with('materi')->findOrFail($id);

        // Ambil riwayat kuis user yang terkait course ini
        $quizHistories = \DB::table('materi_user')
            ->where('user_id', auth()->id())
            ->where('courses_id', $id)
            ->whereNotNull('quiz_id')
            ->orderBy('completed_at', 'desc')
            ->get();

        // Ambil Final Task terkait course jika perlu
        $finalTask = FinalTask::where('course_id', $id)->first();  // Ambil final task yang terkait dengan course

        // Kirim data ke view
        return view('dashboard-peserta.study', compact('course', 'quizHistories', 'finalTask'));
    }

    public function kursusTerdaftar()
    {
        // Mendapatkan ID user yang sedang login
        $userId = auth()->id();
    
        // Mengambil kursus yang sudah dibeli oleh user dengan status pembayaran 'success'
        $courses = Course::whereIn('id', function ($query) use ($userId) {
            $query->select('course_id')
                  ->from('purchases')
                  ->where('user_id', $userId)
                  ->where('status', 'success');
        })->get();
    
        // Mengecek apakah chat aktif pada setiap kursus
        foreach ($courses as $course) {
            // Jika chat aktif, maka akan ditandai
            $course->isChatActive = $course->chat == 1;
        }
    
        return view('dashboard-peserta.kursus', compact('courses'));
    }
    

    public function video() {
        return view('dashboard-peserta.video');
    }

    public function quiz() {
        return view('dashboard-peserta.quiz');
    }

    public function kategori(Request $request) {
        // Ambil semua kategori untuk dropdown
        $categories = Category::all();
        
        // Jika ada kategori yang dipilih, ambil kursus berdasarkan kategori tersebut
        if ($request->has('kategori') && $request->kategori != '') {
            $courses = Course::where('category_id', $request->kategori)->get(); // Ambil kursus berdasarkan kategori yang dipilih
        } else {
            // Jika tidak ada kategori yang dipilih, tampilkan semua kursus
            $courses = Course::all();
        }

        foreach ($courses as $course) {
            // Menghitung rata-rata rating untuk kursus ini
            $averageRating = RatingKursus::where('course_id', $course->id)->avg('stars');
                    
            // Membatasi rating maksimal 5
            $averageRating = min($averageRating, 5);
        
            // Menyimpan rata-rata rating untuk kursus
            $course->average_rating = $averageRating;
            
            // Menghitung jumlah bintang penuh, setengah, dan kosong
            $fullStars = floor($averageRating); // Bintang penuh
            $halfStar = $averageRating - $fullStars >= 0.5; // Bintang setengah
            $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0); // Bintang kosong
        
            // Menyimpan jumlah bintang untuk ditampilkan di view
            $course->rating_full_stars = $fullStars;
            $course->rating_half_star = $halfStar;
            $course->rating_empty_stars = $emptyStars;
        }
    
        return view('dashboard-peserta.categories', compact('categories', 'courses'));
    }

    public function showCategoryDetail($categoryId)
    {
        // Ambil kategori berdasarkan ID
        $category = Category::findOrFail($categoryId);
    
        // Ambil semua kursus berdasarkan kategori
        $courses = Course::where('category_id', $category->id)->get();
    
        // Iterasi setiap kursus untuk menghitung rating
        foreach ($courses as $course) {
            // Menghitung rata-rata rating untuk kursus ini
            $averageRating = RatingKursus::where('course_id', $course->id)->avg('stars');
    
            // Membatasi rating maksimal 5
            $averageRating = min($averageRating, 5);
    
            // Menyimpan rata-rata rating ke properti kursus
            $course->average_rating = $averageRating;
    
            // Menghitung jumlah bintang penuh, setengah, dan kosong
            $fullStars = floor($averageRating); // Bintang penuh
            $halfStar = $averageRating - $fullStars >= 0.5; // Bintang setengah
            $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0); // Bintang kosong
    
            // Menyimpan jumlah bintang untuk ditampilkan di view
            $course->rating_full_stars = $fullStars;
            $course->rating_half_star = $halfStar;
            $course->rating_empty_stars = $emptyStars;
        }
    
        // Return data ke view
        return view('dashboard-peserta.categories-detail', compact('category', 'courses'));
    }
    
}
