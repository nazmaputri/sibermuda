<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Course;
use App\Models\MateriVideo;
use App\Models\Materi;
use App\Models\Rating;
use App\Models\User;
use App\Models\RatingKursus;
use App\Models\Discount;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index()
    {
        return view('components.home');
    }

    public function categorylp()
    {
        $category = Category::all();
        return view('components.course', compact('category'));
    }

    public function visi()
    {
        return view('components.visi');
    }

    public function price()
    {
        return view('components.price');
    }

    public function about()
    {
        return view('components.about');
    }

    public function rating()
    {
        return view('components.rating');
    }

    public function tutorialbeli()
    {
        return view('components.tutorial-beli');
    }

    public function tentangkami()
    {
        $mentor = User::where('role', 'mentor')->with('courses')->get();
    
        return view('components.tentang-kami', compact('mentor'));
    }    
    
    public function detail($slug)
    {
        $today = Carbon::now();
    
        // Ambil kursus berdasarkan slug dan relasi diskon yang aktif
        $course = Course::with(['discounts' => function ($query) use ($today) {
            $query->whereDate('start_date', '<=', $today)
                  ->whereDate('end_date', '>=', $today);
        }])->where('slug', $slug)->firstOrFail();
    
        // Cek diskon yang berlaku untuk semua kursus
        $discount = Discount::whereDate('start_date', '<=', $today)
            ->whereDate('end_date', '>=', $today)
            ->where('apply_to_all', true)
            ->first();
    
        // Ambil diskon aktif khusus untuk kursus ini (jika ada)
        $activeDiscount = $course->discounts->first();
    
        // Gunakan diskon khusus jika tersedia
        if ($activeDiscount) {
            $discount = $activeDiscount;
        }
    
        // Waktu mulai & akhir diskon
        if ($discount) {
            $start_datetime = Carbon::parse($discount->start_date . ' ' . $discount->start_time);
            $end_datetime = Carbon::parse($discount->end_date . ' ' . $discount->end_time);
        } else {
            $start_datetime = null;
            $end_datetime = null;
        }
    
        // Ambil rating berdasarkan course_id
        $ratings = RatingKursus::where('course_id', $course->id)->with('user')->get();
    
        // Harga & Diskon
        $originalPrice = $course->price;
        $discountPercentage = $discount ? $discount->discount_percentage : 0;
        $discountedPrice = $originalPrice * (1 - $discountPercentage / 100);
    
        return view('kursus-detail', compact(
            'course', 'ratings', 'discount',
            'start_datetime', 'end_datetime',
            'originalPrice', 'discountPercentage', 'discountedPrice'
        ));
    }
    
    public function category($slug)
    {
        // Mendapatkan kategori dengan kursus yang statusnya 'approved' atau 'published'
        $category = Category::with(['courses' => function ($query) {
            $query->whereIn('status', ['approved', 'published']);
        }])->where('slug', $slug)->firstOrFail();

        // Mengambil kursus dari kategori yang ditemukan
        $courses = $category->courses;

        // Menghitung rata-rata rating untuk setiap kursus
        foreach ($courses as $course) {
            $averageRating = RatingKursus::where('course_id', $course->id)->avg('stars');
            $course->average_rating = min($averageRating ?? 0, 5); // Cegah null

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
        }

        // Mengirimkan data ke view
        return view('category-detail', compact('category', 'courses'));
    }
    
    public function lp()
    {
        $today = Carbon::now();
    
        $discount = Discount::whereDate('start_date', '<=', $today)
            ->whereDate('end_date', '>=', $today)
            ->where('apply_to_all', true)
            ->first();
    
        if ($discount) {
            $start_datetime = Carbon::parse($discount->start_date . ' ' . $discount->start_time);
            $end_datetime = Carbon::parse($discount->end_date . ' ' . $discount->end_time);
        } else {
            $start_datetime = null;
            $end_datetime = null;
        }

        $courses = Course::where('status', 'published')->get();

        $totalMentor = User::where('role', 'mentor')->count();
        $totalStudent = User::where('role', 'student')->count();

        // Menghitung rating rata-rata untuk setiap kursus dari tabel rating_kursus
        foreach ($courses as $course) {
            $course->video_count = MateriVideo::whereIn('materi_id', 
            Materi::where('course_id', $course->id)->pluck('id')
        )->count();

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
        
            $course->quiz_count = $course->quizzes()->count();
            // $course->pdf_count = $course->pdfMaterials()->count();
            
            // Menghitung rata-rata rating dan membatasi maksimal 5
            $averageRating = RatingKursus::where('course_id', $course->id)->avg('stars');
            $course->average_rating = min($averageRating, 5);  // Membatasi nilai rating maksimal 5 
        }

        $category = Category::select('id', 'name', 'slug')->get();
        $ratings = Rating::all();
        
        // Kirim data ke view
        return view('welcome', compact('category', 'courses', 'ratings', 'discount', 'start_datetime', 'end_datetime', 'totalMentor', 'totalStudent'));
    }

}
