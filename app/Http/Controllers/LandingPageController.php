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
use App\Models\Purchase;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index()
    {
        return view('landing-page.home');
    }

    public function category()
    {
        $category = Category::all();
        return view('landing-page.course.index', compact('category'));
    }

    public function visi()
    {
        return view('landing-page.visi');
    }

    public function ratingAll()
    {
        return view('landing-page.rating');
    }

    public function buyingTutor()
    {
        return view('landing-page.buying-tutor');
    }

    public function news()
    {
        return view('landing-page.news.index');
    }

    public function newsShow($slug)
    {
        return view('landing-page.news.show', compact('slug'));
    }

    public function bootcamp()
    {
        return view('landing-page.bootcamp');
    }

    public function sertiverify()
    {
        return view('landing-page.serti-verify');
    }

    public function affiliate()
    {
        return view('landing-page.affiliate');
    }

    public function about()
    {
        $mentor = User::where('role', 'mentor')
            ->where('status', 'active')
            ->with('courses')
            ->get();

        return view('landing-page.about', compact('mentor'));
    }

    public function rating(Request $request)
    {
        $minChars = $request->get('min_chars', 100);

        $ratings = Rating::where('display', true)
            ->get()
            ->filter(function ($rating) use ($minChars) {
                $charCount = strlen(str_replace(' ', '', $rating->comment));
                return $charCount >= $minChars;
            })
            ->sortByDesc('created_at')
            ->values();

        $totalTestimonials = $ratings->count();
        $averageRating = $ratings->avg('rating') ?? 0;

        return view('landing-page.course.rating', compact('ratings', 'totalTestimonials', 'averageRating', 'minChars'));
    }

    public function price()
    {
        $totalPeserta = Purchase::where('course_id', $courseId)
            ->where('status', 'success')
            ->whereHas('user', function ($query) {
                $query->whereNull('deleted_at');
            })
            ->count();

        $discount = Discount::whereDate('start_date', '<=', $today)
            ->whereDate('end_date', '>=', $today)
            ->where('apply_to_all', true)
            ->first();

        $activeDiscount = $course->discounts->first();

        if ($activeDiscount) {
            $discount = $activeDiscount;
        }

        if ($discount) {
            $start_datetime = Carbon::parse($discount->start_date . ' ' . $discount->start_time);
            $end_datetime = Carbon::parse($discount->end_date . ' ' . $discount->end_time);
        } else {
            $start_datetime = null;
            $end_datetime = null;
        }

        $ratings = RatingKursus::where('course_id', $course->id)->with('user')->get();

        $originalPrice = $course->price;
        $discountPercentage = $discount ? $discount->discount_percentage : 0;
        $discountedPrice = $originalPrice * (1 - $discountPercentage / 100);

        return view('landing-page.course.price', compact(
            'totalPeserta',
            'discount',
            'start_datetime',
            'end_datetime',
            'originalPrice',
            'discountPercentage',
            'discountedPrice'
        ));
    }

    public function detail($slug)
    {
        $today = Carbon::now();

        $course = Course::with(['discounts' => function ($query) use ($today) {
            $query->whereDate('start_date', '<=', $today)
                ->whereDate('end_date', '>=', $today);
        }])->where('slug', $slug)->firstOrFail();

        $discount = Discount::whereDate('start_date', '<=', $today)
            ->whereDate('end_date', '>=', $today)
            ->where('apply_to_all', true)
            ->first();

        $activeDiscount = $course->discounts->first();

        if ($activeDiscount) {
            $discount = $activeDiscount;
        }

        if ($discount) {
            $start_datetime = Carbon::parse($discount->start_date . ' ' . $discount->start_time);
            $end_datetime = Carbon::parse($discount->end_date . ' ' . $discount->end_time);
        } else {
            $start_datetime = null;
            $end_datetime = null;
        }

        $ratings = RatingKursus::where('course_id', $course->id)->with('user')->get();

        $originalPrice = $course->price;
        $discountPercentage = $discount ? $discount->discount_percentage : 0;
        $discountedPrice = $originalPrice * (1 - $discountPercentage / 100);

        return view('course-show', compact(
            'course',
            'ratings',
            'discount',
            'start_datetime',
            'end_datetime',
            'originalPrice',
            'discountPercentage',
            'discountedPrice'
        ));
    }

    public function categoryShow($slug)
    {
        $category = Category::with(['courses' => function ($query) {
            $query->whereIn('status', ['approved', 'published']);
        }])->where('slug', $slug)->firstOrFail();

        $courses = $category->courses;

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

            if ($activeDiscount) {
                $discountPercentage = $activeDiscount->discount_percentage;
                $discountedPrice = $course->price - ($course->price * $discountPercentage / 100);
                $course->discounted_price = $discountedPrice;
            } else {
                $course->discounted_price = null;
            }
        }

        return view('category-show', compact('category', 'courses'));
    }

    public function main()
    {
        $now = Carbon::now();

        $discount = Discount::where('apply_to_all', true)
            ->where(function ($query) use ($now) {
                $query->where(function ($q) use ($now) {
                    $q->whereRaw("STR_TO_DATE(CONCAT(start_date, ' ', start_time), '%Y-%m-%d %H:%i:%s') <= ?", [$now])
                        ->whereRaw("STR_TO_DATE(CONCAT(end_date, ' ', end_time), '%Y-%m-%d %H:%i:%s') >= ?", [$now]);
                });
            })
            ->first();

        if ($discount) {
            $start_datetime = Carbon::parse($discount->start_date . ' ' . $discount->start_time);
            $end_datetime = Carbon::parse($discount->end_date . ' ' . $discount->end_time);
        } else {
            $start_datetime = null;
            $end_datetime = null;
        }

        $courses = Course::where('status', 'published')->get();

        $totalMentor = User::where('role', 'mentor')
            ->where('status', 'active')
            ->count();
        $totalStudent = User::where('role', 'student')->count();

        foreach ($courses as $course) {
            $course->video_count = MateriVideo::whereIn(
                'materi_id',
                Materi::where('course_id', $course->id)->pluck('id')
            )->count();

            $course->total_participants = Purchase::where('course_id', $course->id)
                ->where('status', 'success')
                ->whereHas('user', function ($query) {
                    $query->whereNull('deleted_at');
                })
                ->count();

            $activeDiscount = Discount::where('apply_to_all', false)
                ->whereHas('courses', function ($q) use ($course) {
                    $q->where('course_id', $course->id);
                })
                ->where(function ($query) use ($now) {
                    $query->whereRaw("STR_TO_DATE(CONCAT(start_date, ' ', start_time), '%Y-%m-%d %H:%i:%s') <= ?", [$now])
                        ->whereRaw("STR_TO_DATE(CONCAT(end_date, ' ', end_time), '%Y-%m-%d %H:%i:%s') >= ?", [$now]);
                })
                ->first();

            if ($activeDiscount) {
                $discountPercentage = $activeDiscount->discount_percentage;
                $course->discounted_price = $course->price - ($course->price * $discountPercentage / 100);
            } else {
                $course->discounted_price = null;
            }

            $course->quiz_count = $course->quizzes()->count();
            $averageRating = RatingKursus::where('course_id', $course->id)->avg('stars');
            $course->average_rating = min($averageRating ?? 0, 5);
        }

        $categories = Category::select('id', 'name', 'slug')->get();
        $ratings = Rating::all();

        return view('main', compact(
            'categories',
            'courses',
            'ratings',
            'discount',
            'start_datetime',
            'end_datetime',
            'totalMentor',
            'totalStudent'
        ));
    }
}
