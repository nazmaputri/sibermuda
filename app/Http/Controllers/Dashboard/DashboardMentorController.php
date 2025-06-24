<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Controllers\DashboardMentor\CourseController;
use App\Http\Controllers\DashboardAdmin\CategoryController;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use App\Models\Category;
use App\Models\Course;
use App\Models\Materi;
use App\Models\User;
use App\Models\RatingKursus;
use App\Models\Purchase;
use App\Models\FinaltaskUser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class DashboardMentorController extends Controller
{
    public function getPendingNotifications()
    {
        // Notifikasi: User telah menyelesaikan tugas akhir tapi status sertifikat belum dikonfirmasi admin
        $finalTasks = FinalTaskUser::with('user', 'course')
                        ->where('certificate_status', 'pending')
                        ->get();

        foreach ($finalTasks as $task) {
            $finalTaskId = $task->finalTask ? $task->finalTask->id : null;
            if ($finalTaskId) {
                $notifications[] = [
                    'type' => 'finaltask',
                    'message' => "User <span class='font-medium'>{$task->user->name}</span> menyelesaikan tugas akhir di kursus <span class='font-medium'>{$task->course->title}</span>",
                    'id' => 'finaltask_' . $task->id,
                    'url' => route('finaltask.detail', ['course' => $task->course_id, 'id' => $finalTaskId]),
                ];
            }
        }

        return response()->json($notifications);
    }

    public function index() {
        $mentorId = Auth::id();
        return view('layouts.dashboard-mentor');
    }

    public function rating()
    {
        $mentorId = Auth::id();
        $courses = Course::where('mentor_id', $mentorId)->get(); // Filter kursus berdasarkan mentor yang login
        return view('dashboard-mentor.rating', compact('courses'));
    }    

    public function ratingDetail($id)
    {
        $mentorId = Auth::id();
        $course = Course::where('id', $id)->where('mentor_id', $mentorId)->firstOrFail(); // Pastikan kursus milik mentor
        $ratings = RatingKursus::where('course_id', $id)->with('user')->get(); // Ambil rating kursus

        return view('dashboard-mentor.rating-detail', compact('course', 'ratings'));
    }

    public function show()
    {
        $mentorId = Auth::id();

        $purchases = Purchase::with('course')
            ->where('status', 'success')
            ->whereHas('course', fn ($q) => $q->where('mentor_id', $mentorId))
            ->whereHas('user')
            ->whereYear('created_at', now()->year)
            ->get();

        // Label bulan
        $labels = collect(range(1, 12))->map(fn($m) => Carbon::create(null, $m)->format('M'))->toArray();

        $monthlyTotal = array_fill(0, 12, 0);
        $tooltipData = array_fill(0, 12, []);
        $currentYear = now()->year;

        foreach ($purchases as $purchase) {
            $monthIdx = Carbon::parse($purchase->created_at)->month - 1;
            $monthlyTotal[$monthIdx]++;

            $courseTitle = $purchase->course->title;
            if (!isset($tooltipData[$monthIdx][$courseTitle])) {
                $tooltipData[$monthIdx][$courseTitle] = 0;
            }
            $tooltipData[$monthIdx][$courseTitle]++;
        }

        return view('dashboard-mentor.welcome', [
            'labels' => $labels,
            'monthlyTotal' => $monthlyTotal,
            'tooltipData' => $tooltipData,
            'currentYear' => $currentYear, // ← tambahkan ini
            // tetap bisa kirim data dashboard lainnya juga:
            'jumlahPeserta' => $purchases->unique('user_id')->count(),
            'jumlahKursus' => Course::where('mentor_id', $mentorId)->count(),
            'jumlahMateri' => Materi::whereHas('course', fn ($q) => $q->where('mentor_id', $mentorId))->count()
        ]);
    }
   
    public function tambahmateri() {
        $mentorId = Auth::id();
        return view('dashboard-mentor.materi-create');
    }

    public function datapeserta() {
        $mentorId = Auth::id();
        $users = User::where ('role', 'student')->get(); 
        return view('dashboard-mentor.data-peserta', compact('users'));
    }

    public function laporan(Request $request)
    {
        $mentorId = Auth::id();
        $currentYear = $request->input('year', date('Y'));

        // Data untuk grafik pendapatan bulanan
        $payments = DB::table('purchases')
            ->join('courses', 'purchases.course_id', '=', 'courses.id')
            ->selectRaw('MONTH(purchases.created_at) as month, SUM(courses.price * 0.98) as total')
            ->where('courses.mentor_id', $mentorId)
            ->where('purchases.status', 'success')
            ->whereYear('purchases.created_at', $currentYear)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $months = collect(range(1, 12))->map(function ($month) {
            return Carbon::create()->month($month)->translatedFormat('F');
        });

        $revenueData = $months->map(function ($monthName, $index) use ($payments) {
            $payment = $payments->firstWhere('month', $index + 1);
            return $payment ? $payment->total : 0;
        });

        // Tambahan: Detail pendapatan per kursus
        $coursePayments = DB::table('purchases')
            ->join('courses', 'purchases.course_id', '=', 'courses.id')
            ->selectRaw('courses.id, courses.title, MONTH(purchases.created_at) as month, SUM(courses.price * 0.98) as total')
            ->where('courses.mentor_id', $mentorId)
            ->where('purchases.status', 'success')
            ->whereYear('purchases.created_at', $currentYear)
            ->groupBy('courses.id', 'courses.title', 'month')
            ->orderBy('courses.title')
            ->get();

            $totalRevenueYear = DB::table('purchases')
            ->join('courses', 'purchases.course_id', '=', 'courses.id')
            ->where('courses.mentor_id', $mentorId)
            ->where('purchases.status', 'success')
            ->whereYear('purchases.created_at', $currentYear)
            ->sum(DB::raw('courses.price * 0.98'));
        

        // Format data jadi array per kursus
        $coursesRevenue = [];
        
        foreach ($coursePayments as $payment) {
            $coursesRevenue[$payment->id]['title'] = $payment->title;
            $coursesRevenue[$payment->id]['monthly'][$payment->month] = $payment->total;
        }

        // Ubah ke collection & urutkan total tertinggi
        $coursesRevenue = collect($coursesRevenue)->sortByDesc(function ($item) {
            return array_sum($item['monthly'] ?? []);
        })->values(); // reset index

        // Pagination manual
        $perPage = 5;
        $page = $request->get('page', 1);
        $paginatedCoursesRevenue = new LengthAwarePaginator(
            $coursesRevenue->forPage($page, $perPage),
            $coursesRevenue->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        $years = range(date('Y'), date('Y') - 2);

        return view('dashboard-mentor.laporan', compact(
            'revenueData',
            'months',
            'years',
            'currentYear',
            'coursesRevenue',
            'totalRevenueYear',
            'paginatedCoursesRevenue'
        ));
    }
}
