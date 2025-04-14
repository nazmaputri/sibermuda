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


class DashboardAdminController extends Controller
{
    public function approve($id, $name)
    {
        $course = Course::findOrFail($id);
        $course->status = 'approved';
        $course->save();
    
        return redirect()->route('categories.show', $name)->with('success', 'Kursus disetujui!');
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

    public function publish($id, $name)
    {
        $course = Course::findOrFail($id);
        $course->status = 'published';
        $course->save();

        return redirect()->route('categories.show', $name)->with('success', 'Kursus dipublikasikan!');
    }

    public function hiddencourse($id, $name)
    {
        $course = Course::findOrFail($id);
        $course->status = 'nopublished';
        $course->save();

        return redirect()->route('categories.show', $name)->with('success', 'Kursus batal dipublikasikan!');
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
    
        // Ambil kursus yang telah dibeli peserta berdasarkan pembayaran sukses
        $purchasedCourses = Purchase::where('user_id', $id)
            ->whereHas('payment', function ($query) {
                $query->where('transaction_status', 'success');
            })
            ->with('course.category')
            ->paginate(5);
    
        return view('dashboard-admin.detail-peserta', compact('user', 'purchasedCourses'));
    }    

    public function peserta(Request $request)
    {
        // Ambil query pencarian dari input
        $query = $request->input('search');
    
        // Filter data peserta berdasarkan role dan query pencarian
        $users = User::where('role', 'student') // Hanya role 'student'
            ->when($query, function ($q) use ($query) {
                $q->where(function ($subQuery) use ($query) {
                    $subQuery->where('name', 'LIKE', "%{$query}%")
                        ->orWhere('email', 'LIKE', "%{$query}%");
                });
            })
            ->paginate(5); // Pagination 5 per halaman
    
        // Kirim data ke view
        return view('dashboard-admin.data-peserta', compact('users', 'query'));
    }    

    public function show(Request $request)
    {
        $jumlahMentor = User::where('role', 'mentor')->count();
        $jumlahPeserta = User::where('role', 'student')->count(); 
        $jumlahKursus = Course::count();
    
        // Ambil tahun dari request atau default ke tahun saat ini
        $year = $request->input('year', date('Y'));
        
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
        $monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        
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
            'userGrowthData'  => $userGrowthData,
            'monthNames'      => $monthNames,
            'years'           => $years,
            'year'            => $year
        ]);
    }    

    public function detailkursus($id, $name = null) 
    {
        // Jika $name diberikan, maka ambil kategori berdasarkan nama tersebut
        if ($name) {
            $category = Category::with('courses')->where('name', $name)->firstOrFail();
        } else {
            // Jika tidak ada $name, ambil kategori kursus berdasarkan kursus ID
            $course = Course::findOrFail($id);
            $category = $course->category; // Ambil kategori dari relasi di model Course
        }

        // Ambil kursus berdasarkan ID
        $course = Course::findOrFail($id);

        // Ambil user yang sedang login
        $user = auth()->user();

        // Ambil peserta yang telah membayar dengan status sukses
        $participants = Purchase::where('user_id', $user->id)
                                ->where('status', 'success')
                                ->where('course_id', $id)
                                ->paginate(5);

        // Mengembalikan tampilan dengan data yang diperlukan
        return view('dashboard-admin.detail-kursus', compact('course', 'category', 'participants'));
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
    
    public function laporan(Request $request)
    {
        $year = $request->input('year', date('Y'));
        $selectedCourseId = $request->input('course_id'); // dari filter dropdown
    
        // Ambil data pembayaran sukses + relasi ke purchases dan courses
        $paymentsQuery = Payment::with(['user', 'purchase.course'])
            ->where('transaction_status', 'settlement') // status sukses
            ->whereYear('created_at', $year);
    
        if ($selectedCourseId) {
            $paymentsQuery->whereHas('purchase', function ($q) use ($selectedCourseId) {
                $q->where('course_id', $selectedCourseId);
            });
        }
    
        $payments = $paymentsQuery->get();
    
        // Siapkan array grafik pendapatan per kursus per bulan
        $coursesRevenue = [];
        $monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $totalRevenue = 0;
    
        foreach ($payments as $payment) {
            $course = $payment->purchase->course ?? null;
            if (!$course) continue;
    
            $month = (int) $payment->created_at->format('n'); // bulan 1-12
            $courseId = $course->id;
            $amount = (float) $payment->amount;
    
            if (!isset($coursesRevenue[$courseId])) {
                $coursesRevenue[$courseId] = [
                    'title' => $course->title,
                    'monthly' => array_fill(1, 12, 0)
                ];
            }
    
            $coursesRevenue[$courseId]['monthly'][$month] += $amount;
            $totalRevenue += $amount;
        }
    
        // Ambil semua pembelian (untuk tabel)
        $revenues = Purchase::with(['user', 'course', 'payment'])
            ->whereHas('payment', function ($q) {
                $q->where('transaction_status', 'settlement');
            })
            ->when($selectedCourseId, function ($q) use ($selectedCourseId) {
                $q->where('course_id', $selectedCourseId);
            })
            ->orderBy('created_at', 'desc')
            ->get();
    
        // Data dropdown semua kursus
        $allCourses = Course::all();
    
        return view('dashboard-admin.laporan', [
            'coursesRevenue' => $coursesRevenue,
            'monthNames' => $monthNames,
            'totalRevenue' => $totalRevenue,
            'revenues' => $revenues,
            'selectedCourseId' => $selectedCourseId,
            'year' => $year,
            'courses' => $allCourses,
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
