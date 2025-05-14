<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Controllers\DashboardMentor\CourseController;
use App\Http\Controllers\DashboardAdmin\CategoryController;
use App\Models\Category;
use App\Models\Course;
use App\Models\Purchase;
use App\Models\FinalTask;
use App\Models\Discount;
use App\Models\RatingKursus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardPesertaController extends Controller
{
    public function navbarNotifikasi()
    {
        $userId = auth()->id();

        $successPurchases = Purchase::where('user_id', $userId)
            ->where('status', 'success')
            ->with('course') // ambil relasi course
            ->latest()
            ->take(10)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'course_title' => $item->course->title ?? '-', // pastikan kolomnya `title` atau sesuaikan
                    'updated_at' => $item->updated_at,
                ];
            });

        return response()->json($successPurchases);
    }

    public function detail($slug)
    {
        // Ambil course berdasarkan slug
        $course = Course::where('slug', $slug)->first();

        // Jika kursus tidak ditemukan, kembalikan halaman 404
        if (!$course) {
            return abort(404);
        }

        // Cek apakah user sudah memberikan rating untuk kursus ini
        $hasRated = DB::table('rating_kursus')
            ->where('course_id', $course->id)
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

        Carbon::setLocale('en'); 
        $currentDateTime = Carbon::now();  // Mengambil tanggal dan waktu sekarang
        $currentDateTimeFormatted = $currentDateTime->translatedFormat('l, d F Y H:i:s');

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
                    // Non-cybersecurity: ambil nilai tertinggi
                    $nilai = DB::table('materi_user')
                        ->where('user_id', $userId)
                        ->where('courses_id', $course->id)
                        ->max('nilai'); // <-- ini penting
                
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

    public function kursus($slug, $categorySlug = null)
    {
        // Cari course berdasarkan slug → ambil id
        $course = Course::where('slug', $slug)->firstOrFail();
        $id = $course->id;

        // Cari category berdasarkan slug → ambil id
        $category = null;
        if ($categorySlug) {
            $category = Category::where('slug', $categorySlug)->firstOrFail();
            $categoryId = $category->id;
        }

        // Cek apakah user sudah membeli kursus ini
        $hasPurchased = Purchase::where('course_id', $id)
                                ->where('user_id', auth('student')->id())
                                ->where('status', 'success')
                                ->exists();

        $initialLimit = 3;
        $rating = RatingKursus::where('course_id', $id)
                    ->with('user')
                    ->take($initialLimit)
                    ->get();

        $totalCount = RatingKursus::where('course_id', $id)->count();

        $paymentStatus = null;
        if ($hasPurchased) {
            $course->is_purchased = true;
        } else {
            $purchase = Purchase::where('course_id', $id)
                                ->where('user_id', auth('student')->id())
                                ->first();
            if ($purchase) {
                $paymentStatus = $purchase->status;
            }
        }

        return view('dashboard-peserta.detail', compact('course', 'paymentStatus', 'hasPurchased', 'category', 'rating', 'id', 'totalCount'));
    }

    // Untuk AJAX saat load lebih banyak rating di halaman detail kursus (role peserta)
    public function loadMoreRating(Request $request)
    {
        $offset = $request->input('offset');
        $courseId = $request->input('course_id');

        $moreRating = RatingKursus::where('course_id', $courseId)
                        ->with('user')
                        ->skip($offset)
                        ->take(3)
                        ->get();

        $view = view('partials.rating_card', ['rating' => $moreRating])->render();

        return response()->json(['html' => $view]);
    }
    
   public function study($slug)
    {
        // Ambil course berdasarkan slug, lalu ambil id-nya
        $course = Course::with('materi')->where('slug', $slug)->firstOrFail();
        $id = $course->id; // ← ambil ID-nya untuk query lain

        // Ambil riwayat kuis user
        $quizHistories = \DB::table('materi_user')
            ->where('user_id', auth()->id())
            ->where('courses_id', $id)
            ->whereNotNull('quiz_id')
            ->orderBy('completed_at', 'desc')
            ->get();

        // Ambil Final Task terkait course
        $finalTask = FinalTask::where('course_id', $id)->first();

        // Ambil Final Task History jika ada
        $finalTaskHistory = null;
        if ($finalTask) {
            $finalTaskHistory = \DB::table('final_task_user')
                ->where('user_id', auth()->id())
                ->where('course_id', $id)
                ->where('final_task_id', $finalTask->id)
                ->first();
        }

        return view('dashboard-peserta.study', compact('course', 'quizHistories', 'finalTask', 'finalTaskHistory'));
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
            // Cek diskon aktif untuk kursus ini
            $activeDiscount = Discount::where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->where(function ($query) use ($course) {
                $query->where('apply_to_all', false)
                    ->whereHas('courses', function ($q) use ($course) {
                        $q->where('course_id', $course->id);
                    });
            })
            ->first();

            // Hitung harga setelah diskon jika diskon hanya berlaku pada kursus tertentu
            if ($activeDiscount) {
            $discountPercentage = $activeDiscount->discount_percentage;
            $discountedPrice = $course->price - ($course->price * $discountPercentage / 100);
            $course->discounted_price = $discountedPrice;
            } else {
            // Jika diskon berlaku untuk semua (apply_to_all = true), jangan tampilkan harga diskon
            $course->discounted_price = null;
            }

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
