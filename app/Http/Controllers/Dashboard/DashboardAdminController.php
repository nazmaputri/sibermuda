<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use App\Http\Controllers\DashboardMentor\CourseController;
use App\Models\Course;
use App\Models\Category;
use App\Models\User;
use App\Models\Role;
use App\Models\Payment;
use App\Models\Rating;
use App\Models\RatingKursus;
use App\Models\Purchase;
use App\Models\NotifikasiMentorDaftar;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Mail\HelloMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UserImport;
use App\Exports\PurchasesExport;
use Carbon\Carbon;
use Illuminate\Support\Str;

class DashboardAdminController extends Controller
{

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
            // Skip jika sudah pernah membeli kursus ini
            $existing = Purchase::where('user_id', $userId)
                ->where('course_id', $courseId)
                ->first();

            if ($existing) {
                continue;
            }

            $manualTransactionId = 'manual-' . Carbon::now()->format('Ymd') . '-' . Str::random(6);

            // Tambahkan ke tabel purchases
            Purchase::create([
                'user_id' => $userId,
                'course_id' => $courseId,
                'harga_course' => 0,
                'transaction_id' => $manualTransactionId,
                'status' => 'success',
            ]);

            // Tambahkan ke tabel payments
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

    public function getNotifications()
    {
        // Notifikasi: Pembayaran kursus yang belum dicek admin (status pending)
        $payments = Payment::with('purchase.course', 'purchase.user')
        ->where('transaction_status', 'pending')
        ->get();
    
        // Notifikasi: Mentor yang mendaftar dan statusnya masih pending (belum diverifikasi)
        $mentors = User::where('role', 'mentor')
                        ->where('status', 'pending') // Pastikan kolom status ini ada
                        ->get();
    
        // Notifikasi: Kursus baru oleh mentor yang statusnya masih pending
        $courses = Course::where('status', 'pending')->get(); // Gunakan kolom status
    
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

    public function approve($categoryId, $courseId)
    {
        $course = Course::findOrFail($courseId);
        $course->status = 'approved';
        $course->save();
    
        return redirect()->route('categories.show', $categoryId)->with('success', 'Kursus disetujui!');
    }    

    public function toggleActive(Request $request)
    {
        // Validasi input ID
        $request->validate([
            'id' => 'required|exists:users,id',
            'status' => 'required|in:active,inactive',
        ]);

        // Ambil user berdasarkan ID
        $user = User::findOrFail($request->id);

        // Pastikan hanya mentor yang bisa diubah statusnya
        if ($user->role !== 'mentor') {
            return response()->json(['error' => 'User ini bukan mentor'], 403);
        }

        // Update status mentor
        $user->status = $request->status;
        $user->save();

        return response()->json(['success' => 'Status mentor diperbarui', 'status' => $user->status]);
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xls,xlsx'
        ]);

        Excel::import(new UserImport, $request->file('file'));

        return redirect()->back()->with('success', 'Data user berhasil diimport.');
    }

    public function publish($categoryId, $courseId)
    {
        $course = Course::findOrFail($courseId);
        $course->status = 'published';
        $course->save();

        return redirect()->route('categories.show', $categoryId)->with('success', 'Kursus dipublikasikan!');
    }
 

    public function hiddencourse($categoryId, $courseId)
    {
        $course = Course::findOrFail($courseId);
        $course->status = 'nopublished';
        $course->save();

        return redirect()->route('categories.show', $categoryId)->with('success', 'Kursus batal dipublikasikan!');
    }

    public function rating()
    {
        $ratings = Rating::paginate(5); 

        return view('dashboard-admin.rating', compact('ratings'));
    }

    public function displayRating($id)
    {
        $ratings = Rating::findOrFail($id);  
        if (!$ratings) {
            // Jika rating tidak ditemukan, redirect ke halaman sebelumnya dengan pesan error
            return redirect()->route('rating-admin')->with('error', 'Rating tidak ditemukan');
        }
        return view('components.rating', compact('ratings'));  
    }

    public function index() {
        $users = User::all(); 
        return view('layouts.dashboard-admin');
    }

    public function detailmentor($id)
    {
        $user = User::findOrFail($id);
    
        // Ambil kursus yang dimiliki oleh mentor berdasarkan ID user
        $courses = Course::where('mentor_id', $id)->paginate(5);

        // Loop untuk menghitung rata-rata rating tiap kursus
        foreach ($courses as $course) {
            // Menghitung rata-rata rating untuk kursus ini
            $averageRating = RatingKursus::where('course_id', $course->id)->avg('stars');

            // Pastikan rating tidak lebih dari 5 dan dibulatkan ke 1 desimal
            $course->average_rating = $averageRating ? round(min($averageRating, 5), 1) : 'Belum ada rating';
        }
    
        return view('dashboard-admin.detail-mentor', compact('user', 'courses'));
    }    

    public function mentor(Request $request)
    {
        // Ambil query pencarian dari input
        $query = $request->input('search');

        // Filter data mentor berdasarkan role dan query pencarian
        $users = User::where('role', 'mentor') // Pastikan hanya role mentor
            ->when($query, function ($q) use ($query) {
                $q->where(function ($subQuery) use ($query) {
                    $subQuery->where('name', 'LIKE', "%{$query}%")
                        ->orWhere('status', 'LIKE', "%{$query}%");
                });
            })
            ->paginate(5); // Pagination 5 per halaman

        // Mengirim data mentor dan query ke view
        return view('dashboard-admin.data-mentor', compact('users', 'query'));
    }

    public function detailpeserta($id)
    {
        $user = User::findOrFail($id);
    
        // Ambil semua kursus yang dibeli peserta yang memiliki relasi payment
        $purchasedCourses = Purchase::where('user_id', $id)
            ->whereHas('payment') // hanya yang punya data pembayaran, apapun statusnya
            ->with(['course.category', 'payment']) // pastikan relasi payment juga dibawa
            ->paginate(5);
    
        return view('dashboard-admin.detail-peserta', compact('user', 'purchasedCourses'));
    }    

    public function peserta(Request $request)
    {
        // Ambil query pencarian dari input
        $query = $request->input('search');

        // Filter data peserta berdasarkan role, query pencarian, dan exclude soft deleted
        $users = User::where('role', 'student')
            ->whereNull('deleted_at') // pastikan tidak menampilkan user yang sudah soft delete
            ->when($query, function ($q) use ($query) {
                $q->where(function ($subQuery) use ($query) {
                    $subQuery->where('name', 'LIKE', "%{$query}%")
                        ->orWhere('email', 'LIKE', "%{$query}%");
                });
            })
            ->paginate(5);

        return view('dashboard-admin.data-peserta', compact('users', 'query'));
    }

    public function show(Request $request)
    {
        $jumlahMentor = User::where('role', 'mentor')->count();
        $jumlahPeserta = User::where('role', 'student')->count(); 
        $jumlahKursus = Course::count();
        $jumlahKategori = Category::count();
    
         // Ambil tahun filter (default tahun sekarang)
        $year = $request->input('year', date('Y'));

        // === Ubah di sini: bikin array 3 tahun terakhir ===
        $currentYear = date('Y');
        // Buat range [tahun sekarang, tahun-1, tahun-2]
        $years = collect(range($currentYear, $currentYear - 2))
                    ->sortDesc()   // atau ->sort() kalau mau urut naik
                    ->values();    // reset keys
        
        // Ambil data jumlah pengguna yang mendaftar setiap bulan di tahun tertentu
        $userGrowth = User::select(
                            DB::raw('MONTH(created_at) as month'),
                            DB::raw('COUNT(*) as user_count')
                        )
                        ->whereYear('created_at', $year) // Filter berdasarkan tahun
                        ->groupBy(DB::raw('MONTH(created_at)'))
                        ->orderBy(DB::raw('MONTH(created_at)'), 'asc')
                        ->get();
        
        // Nama bulan
        $monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];
        
        // Inisialisasi data untuk grafik
        $userGrowthData = array_fill(0, 12, 0);
        
        // Isi data pengguna yang terdaftar di bulan yang sesuai
        foreach ($userGrowth as $data) {
            $userGrowthData[$data->month - 1] = $data->user_count; // Month-1 untuk indexing dari 0
        }
        
        // Ambil daftar tahun dari data pengguna
        $years = User::select(DB::raw('YEAR(created_at) as year'))
                    ->distinct()
                    ->orderBy('year', 'asc')
                    ->pluck('year');
        
        return view('dashboard-admin.welcome', [
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

    public function detailkursus($categoryId, $courseId)
    {
        $category = Category::with('courses')->findOrFail($categoryId);
        $course = Course::with('finalTask')->findOrFail($courseId);

        $user = auth()->user();
        $participants = Purchase::where('course_id', $courseId)
                        ->where('status', 'success')
                        ->whereHas('user', function ($query) {
                            $query->whereNull('deleted_at');
                        })
                        ->with('user')
                        ->paginate(5);

        $totalPeserta = Purchase::where('course_id', $courseId)
                ->where('status', 'success')
                ->whereHas('user', function ($query) {
                    $query->whereNull('deleted_at');
                })
                ->count();

        // Tambahkan ini:
        $users = User::where('role', 'student')
                ->whereNull('deleted_at')
                ->get();

        return view('dashboard-admin.detail-kursus', compact('course', 'category', 'participants', 'users', 'totalPeserta'));
    }

    public function updateStatus($id)
    {
        $user = User::findOrFail($id);

        // Periksa apakah status saat ini 'pending'
        if (in_array($user->status, ['pending', 'inactive'])) {
            // Ubah status menjadi 'active'
            $user->status = 'active';
            $user->save();

            // Kirim email ke user
            Mail::to($user->email)->send(new HelloMail($user->name));

            return redirect()->back()->with('success', 'Status mentor berhasil di perbaharui dan email telah terkirim!');
        }

        return redirect()->back()->with('info', 'User berhasil diaktifkan.');
    }

    // update status mentor menjadi pending (+oleh intan)
    public function updateStatusToInactive($id)
    {
        $user = User::findOrFail($id);

        // Periksa apakah status saat ini bukan 'pending'
        if ($user->status !== 'inactive') {
            // Ubah status menjadi 'inactive'
            $user->status = 'inactive';
            $user->save();

            return redirect()->back()->with('success', 'Status mentor berhasil diperbarui menjadi nonaktif!');
        }

        return redirect()->back()->with('info', 'User sudah dalam status nonanctive.');
    }
    
    public function export(Request $request)
    {
        $courseId = $request->query('course_id');
        $month    = $request->query('month');
        $fileName = 'pendapatan_' . now()->format('Ymd_His') . '.xlsx';
    
        return Excel::download(new PurchasesExport($courseId, $month), $fileName);
    }    

    public function laporan(Request $request)
    {
        $selectedCourseId = $request->get('course_id', null);
        $selectedMonth = $request->get('month');

        $allPurchases = Purchase::where('status', 'success')
                            ->where('harga_course', '>', 0)
                            ->with('payment')
                            ->get();

        $bulan = Carbon::now()->month;
        $tahun = Carbon::now()->year;

        $totalRevenue = $allPurchases->filter(function ($purchase) use ($bulan, $tahun) {
            return $purchase->created_at &&
                $purchase->created_at->month == $bulan &&
                $purchase->created_at->year == $tahun;
        })->sum('harga_course');

        $totalAllRevenue = $allPurchases->sum('harga_course');

        // Query utama dengan user yang bisa saja sudah di-softdelete
        $purchasesQuery = Purchase::where('status', 'success')
            ->where('harga_course', '>', 0) // ⛔ Exclude pembelian manual
            ->with([
                'course',
                'payment',
                'user' => function ($query) {
                    $query->withTrashed(); // tetap tampilkan user yang sudah dihapus
                }
            ])
            ->orderBy('created_at', 'desc');

        if ($selectedCourseId) {
            $purchasesQuery->where('course_id', $selectedCourseId);
        }

        if ($selectedMonth) {
            $purchasesQuery->whereMonth('created_at', $selectedMonth);
        }

        $revenues = $purchasesQuery->paginate(10);

        $totalFilteredRevenue = $revenues->sum(function ($purchase) {
            return optional($purchase->payment)->amount;
        });

        $coursesRevenue = Course::all();

        return view('dashboard-admin.laporan', [
            'revenues' => $revenues,
            'coursesRevenue' => $coursesRevenue,
            'selectedCourseId' => $selectedCourseId,
            'totalFilteredRevenue' => $totalFilteredRevenue,
            'selectedMonth' => $selectedMonth,
            'totalAllRevenue' => $totalAllRevenue,
            'totalRevenue' => $totalRevenue
        ]);
    }

    // menampilkan halaman form tambah mentor
    public function tambahmentor()
    {
        return view('dashboard-admin.tambah-mentor');
    }

    // menampilkan halaman form tambah peserta
    public function tambahpeserta()
    {
        return view('dashboard-admin.tambah-peserta');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
    
        return redirect()->route('datamentor-admin')->with('success', 'User berhasil dihapus.');
    }    

    public function deletePeserta($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
    
        return redirect()->route('datapeserta-admin')->with('success', 'User berhasil dihapus.');
    }

}
