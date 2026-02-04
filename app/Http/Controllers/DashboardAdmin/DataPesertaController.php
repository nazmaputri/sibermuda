<?php

namespace App\Http\Controllers\DashboardAdmin;

use App\Http\Controllers\Controller;
use App\Imports\UserImport;
use App\Models\User;
use App\Models\Purchase;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Maatwebsite\Excel\Excel;

class DataPesertaController extends Controller
{
    /**
     * Menampilkan daftar peserta
     */
    public function index(Request $request)
    {
        $query = $request->input('search');

        $users = User::where('role', 'student')
            ->whereNull('deleted_at')
            ->when($query, function ($q) use ($query) {
                $q->where(function ($subQuery) use ($query) {
                    $subQuery->where('name', 'LIKE', "%{$query}%")
                        ->orWhere('email', 'LIKE', "%{$query}%");
                });
            })
            ->paginate(50);

        return view('dashboard-admin.data-peserta.index', compact('users', 'query'));
    }

    /**
     * Menampilkan form tambah peserta
     */
    public function create()
    {
        return view('dashboard-admin.data-peserta.create');
    }

    /**
     * Menampilkan detail peserta
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        $purchasedCourses = Purchase::where('user_id', $id)
            ->whereHas('payment')
            ->with(['course.category', 'payment'])
            ->paginate(5);

        return view('dashboard-admin.data-peserta.show', compact('user', 'purchasedCourses'));
    }

    /**
     * Menghapus peserta
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('data-peserta.index')->with('success', 'User berhasil dihapus.');
    }

    /**
     * Import peserta manual ke kursus
     */
    public function importManual(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
        ]);

        $courseId = $request->course_id;
        $userIds = $request->user_ids;

        foreach ($userIds as $userId) {
            $existing = Purchase::where('user_id', $userId)
                ->where('course_id', $courseId)
                ->first();

            if ($existing) {
                continue;
            }

            $manualTransactionId = 'manual-' . Carbon::now()->format('Ymd') . '-' . Str::random(6);

            Purchase::create([
                'user_id' => $userId,
                'course_id' => $courseId,
                'harga_course' => 0,
                'transaction_id' => $manualTransactionId,
                'status' => 'success',
            ]);

            Payment::create([
                'user_id' => $userId,
                'transaction_id' => $manualTransactionId,
                'payment_type' => 'manual',
                'transaction_status' => 'success',
                'amount' => 0,
            ]);
        }

        return redirect()->back()->with('success', 'Peserta manual berhasil diimport.');
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xls,xlsx'
        ]);

        Excel::import(new UserImport, $request->file('file'));

        return redirect()->back()->with('success', 'Data user berhasil diimport.');
    }
}
