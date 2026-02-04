<?php

namespace App\Http\Controllers\DashboardAdmin;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use App\Models\Course;
use App\Exports\PurchasesExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class LaporanController extends Controller
{
    /**
     * Menampilkan laporan pendapatan dengan fitur filter
     */
    public function index(Request $request)
    {
        $selectedCourseId = $request->get('course_id', null);
        $selectedMonth = $request->get('month');

        $purchasesQuery = Purchase::where('status', 'success')
            ->where('harga_course', '>', 0)
            ->with([
                'course',
                'payment',
                'user' => function ($query) {
                    $query->withTrashed();
                }
            ])
            ->orderBy('created_at', 'desc');

        if ($selectedCourseId) {
            $purchasesQuery->where('course_id', $selectedCourseId);
        }

        if ($selectedMonth) {
            $purchasesQuery->whereMonth('created_at', $selectedMonth);
        }

        $revenues = $purchasesQuery->paginate(50);

        $totalFilteredRevenue = (clone $purchasesQuery)->sum('harga_course');

        $totalAllRevenue = Purchase::where('status', 'success')
            ->where('harga_course', '>', 0)
            ->sum('harga_course');

        $bulan = Carbon::now()->month;
        $tahun = Carbon::now()->year;
        $totalRevenue = Purchase::where('status', 'success')
            ->where('harga_course', '>', 0)
            ->whereMonth('created_at', $bulan)
            ->whereYear('created_at', $tahun)
            ->sum('harga_course');

        $coursesRevenue = Course::all();

        return view('dashboard-admin.laporan.index', [
            'revenues' => $revenues,
            'coursesRevenue' => $coursesRevenue,
            'selectedCourseId' => $selectedCourseId,
            'selectedMonth' => $selectedMonth,
            'totalFilteredRevenue' => $totalFilteredRevenue,
            'totalAllRevenue' => $totalAllRevenue,
            'totalRevenue' => $totalRevenue
        ]);
    }

    /**
     * Export laporan pendapatan ke Excel
     */
    public function export(Request $request)
    {
        $courseId = $request->query('course_id');
        $month = $request->query('month');
        $fileName = 'pendapatan_' . now()->format('Ymd_His') . '.xlsx';

        return Excel::download(new PurchasesExport($courseId, $month), $fileName);
    }
}
