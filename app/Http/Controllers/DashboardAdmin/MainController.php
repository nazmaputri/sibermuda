<?php

namespace App\Http\Controllers\DashboardAdmin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{

    public function index() {
        $users = User::all();
        return view('layouts.dashboard-admin');
    }

    public function getNotifications()
    {
        // Notifikasi: Pembayaran kursus yang belum dicek admin (status pending)
        $payments = Payment::with('purchase.course', 'purchase.user')
        ->where('transaction_status', 'pending')
        ->get();

        // Notifikasi: Mentor yang mendaftar dan statusnya masih pending (belum diverifikasi)
        $mentors = User::where('role', 'mentor')
                        ->where('status', 'pending')
                        ->get();

        // Notifikasi: Kursus baru oleh mentor yang statusnya masih pending
        $courses = Course::where('status', 'pending')->get();

        $notifications = [];

        foreach ($payments as $payment) {
            $purchase = $payment->purchase;

            if ($purchase && $purchase->user && $purchase->course) {
                $notifications[] = [
                    'type' => 'pembelian',
                    'message' => "User <span class='font-medium'>{$purchase->user->name}</span> membeli kursus <span class='font-medium'>{$purchase->course->title}</span>",
                    'id' => 'payment_' . $payment->id,
                    'url' => route('detaildata-peserta', ['id' => $purchase->user->id]),
                ];
            }
        }

        foreach ($mentors as $mentor) {
            $notifications[] = [
                'type' => 'mentor',
                'message' => "Mentor baru mendaftar : {$mentor->name}",
                'id' => 'mentor_' . $mentor->id,
                'url' => route('datamentor-admin'),
            ];
        }

        foreach ($courses as $course) {
            $notifications[] = [
                'type' => 'kursus',
                'message' => "Kursus baru ditambahkan oleh {$course->mentor->name} : {$course->title}",
                'id' => 'course_' . $course->id,
                'url' => route('categories.show', ['id' => $course->category->id]),
            ];
        }

        return response()->json([
            'notifications' => $notifications,
        ]);
    }

    public function show(Request $request)
    {
        $jumlahMentor = User::where('role', 'mentor')->count();
        $jumlahPeserta = User::where('role', 'student')->count();
        $jumlahKursus = Course::count();
        $jumlahKategori = Category::count();

        $year = $request->input('year', date('Y'));

        $currentYear = date('Y');
        $years = collect(range($currentYear, $currentYear - 2))
                    ->sortDesc()
                    ->values();

        $userGrowth = User::select(
                            DB::raw('MONTH(created_at) as month'),
                            DB::raw('COUNT(*) as user_count')
                        )
                        ->whereYear('created_at', $year)
                        ->groupBy(DB::raw('MONTH(created_at)'))
                        ->orderBy(DB::raw('MONTH(created_at)'), 'asc')
                        ->get();

        $monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];

        $userGrowthData = array_fill(0, 12, 0);

        foreach ($userGrowth as $data) {
            $userGrowthData[$data->month - 1] = $data->user_count;
        }

        $years = User::select(DB::raw('YEAR(created_at) as year'))
                    ->distinct()
                    ->orderBy('year', 'asc')
                    ->pluck('year');

        return view('dashboard-admin.main', [
            'jumlahMentor'    => $jumlahMentor,
            'jumlahPeserta'   => $jumlahPeserta,
            'jumlahKursus'    => $jumlahKursus,
            'jumlahKategori'  => $jumlahKategori,
            'userGrowthData'  => $userGrowthData,
            'monthNames'      => $monthNames,
            'years'           => $years,
            'year'            => $year
        ]);
    }

}
