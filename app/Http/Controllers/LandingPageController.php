<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Course;
use App\Models\MateriVideo;
use App\Models\Materi;
use App\Models\Rating;
use App\Models\RatingKursus;
use App\Models\Discount;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function detail($id)
    {
        $today = Carbon::now();
    
        $discount = Discount::whereDate('start_date', '<=', $today)
            ->whereDate('end_date', '>=', $today)
            ->first();
    
        if ($discount) {
            $start_datetime = Carbon::parse($discount->start_date . ' ' . $discount->start_time);
            $end_datetime = Carbon::parse($discount->end_date . ' ' . $discount->end_time);
        } else {
            $start_datetime = null;
            $end_datetime = null;
        }
    
        $ratings = RatingKursus::where('course_id', $id)->with('user')->get();
        $course = Course::with(['mentor', 'category'])->findOrFail($id);
    
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

    public function category($name)
    {
        // Mendapatkan kategori dengan kursus yang statusnya 'approved' atau 'published'
        $category = Category::with(['courses' => function ($query) {
            $query->whereIn('status', ['approved', 'published']);
        }])->where('name', $name)->firstOrFail();
    
        // Mengambil kursus dari kategori yang ditemukan
        $courses = $category->courses;
    
        // Menghitung rata-rata rating untuk setiap kursus
        foreach ($courses as $course) {
            // Menghitung rata-rata rating dan membatasi maksimal 5
            $averageRating = RatingKursus::where('course_id', $course->id)->avg('stars');
            $course->average_rating = min($averageRating, 5);  // Membatasi nilai rating maksimal 5
        }
    
        // Mengirimkan data ke view
        return view('category-detail', compact('category', 'courses'));
    }    
    
    public function lp()
    {
        $today = Carbon::now();
    
        $discount = Discount::whereDate('start_date', '<=', $today)
            ->whereDate('end_date', '>=', $today)
            ->first();
    
        if ($discount) {
            $start_datetime = Carbon::parse($discount->start_date . ' ' . $discount->start_time);
            $end_datetime = Carbon::parse($discount->end_date . ' ' . $discount->end_time);
        } else {
            $start_datetime = null;
            $end_datetime = null;
        }

        $courses = Course::where('status', 'published')->get();

        // Menghitung rating rata-rata untuk setiap kursus dari tabel rating_kursus
        foreach ($courses as $course) {
            $course->video_count = MateriVideo::whereIn('materi_id', 
            Materi::where('course_id', $course->id)->pluck('id')
        )->count();
        
            $course->quiz_count = $course->quizzes()->count();
            // $course->pdf_count = $course->pdfMaterials()->count();
            
            // Menghitung rata-rata rating dan membatasi maksimal 5
            $averageRating = RatingKursus::where('course_id', $course->id)->avg('stars');
            $course->average_rating = min($averageRating, 5);  // Membatasi nilai rating maksimal 5 
        }

        $categories = Category::all();
        $ratings = Rating::all();
        
        // Kirim data ke view
        return view('welcome', compact('categories', 'courses', 'ratings', 'discount', 'start_datetime', 'end_datetime'));
    }

}
