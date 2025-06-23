<?php

namespace App\Http\Controllers\DashboardSuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Category;
use App\Models\User;
use App\Models\RatingKursus;
use App\Models\Purchase;
use App\Models\Discount;
use App\Models\Rating;
use Carbon\Carbon;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SuperAdminController extends Controller
{
    public function prosesloginSuperAdmin(Request $request)
    {
        // Validasi input dasar
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ], [
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password harus diisi.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput($request->except('password'));
        }

        // Ambil user berdasarkan email
        $user = User::where('email', $request->email)->first();

        // Jika user tidak ditemukan
        if (!$user) {
            return back()->withErrors(['email' => 'Email tidak ditemukan.'])
                ->withInput($request->except('password'));
        }

        // Cek apakah user adalah Super Admin dan role-nya admin
        if ($user->role !== 'admin' || $user->name !== 'Super Admin') {
            return back()->withErrors(['email' => 'Akses hanya diperbolehkan untuk Super Admin.'])
                ->withInput($request->except('password'));
        }

        // Cek password
        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Password salah.'])
                ->withInput($request->except('password'));
        }

        // Login Super Admin
        Auth::guard('admin')->login($user);
        $request->session()->regenerate();

        return redirect()->route('welcome-superadmin');
    }

    public function index(Request $request)
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
        
        // Inisialisasi 12 bulan kosong
        $mentorGrowthData = array_fill(0, 12, 0);
        $pesertaGrowthData = array_fill(0, 12, 0);

        // Ambil data berdasarkan role mentor
        $mentorData = User::select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as user_count'))
                        ->whereYear('created_at', $year)
                        ->where('role', 'mentor')
                        ->groupBy(DB::raw('MONTH(created_at)'))
                        ->orderBy(DB::raw('MONTH(created_at)'))
                        ->get();

        // Ambil data berdasarkan role peserta
        $pesertaData = User::select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as user_count'))
                        ->whereYear('created_at', $year)
                        ->where('role', 'student')
                        ->groupBy(DB::raw('MONTH(created_at)'))
                        ->orderBy(DB::raw('MONTH(created_at)'))
                        ->get();

        // Masukkan data ke array bulan ke-0 s.d 11
        foreach ($mentorData as $data) {
            $mentorGrowthData[$data->month - 1] = $data->user_count;
        }
        foreach ($pesertaData as $data) {
            $pesertaGrowthData[$data->month - 1] = $data->user_count;
        }

        // Nama bulan
        $monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];

        // Ambil daftar tahun dari data pengguna
        $years = User::select(DB::raw('YEAR(created_at) as year'))
                    ->distinct()
                    ->orderBy('year', 'asc')
                    ->pluck('year');
        
        return view('dashboard-superadmin.welcome-superadmin', [
            'jumlahMentor'    => $jumlahMentor,
            'jumlahPeserta'   => $jumlahPeserta,
            'jumlahKursus'    => $jumlahKursus,
            'jumlahKategori'  => $jumlahKategori,
            'mentorGrowthData'    => $mentorGrowthData,
            'pesertaGrowthData'   => $pesertaGrowthData,
            'monthNames'      => $monthNames,
            'years'           => $years,
            'year'            => $year
        ]);
    }    

    public function setting()
    {
        $user = Auth::user();
        return view('dashboard-superadmin.setting-superadmin', compact('user'));
    }

    public function loginsuperadmin()
    {
        return view('auth.login-superadmin');
    }

    public function datamentor(Request $request)
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
        return view('dashboard-superadmin.data-mentor-superadmin', compact('users', 'query'));
    }

    // menampilkan halaman form tambah mentor
    public function tambahmentorbysuperadmin()
    {
        return view('dashboard-superadmin.tambah-mentor-superadmin');
    }

    public function detailmentorsuperadmin($id)
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
    
        return view('dashboard-superadmin.detail-mentor-superadmin', compact('user', 'courses'));
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

        return view('dashboard-superadmin.data-peserta-superadmin', compact('users', 'query'));
    }

    public function detailpeserta($id)
    {
        $user = User::findOrFail($id);
    
        // Ambil semua kursus yang dibeli peserta yang memiliki relasi payment
        $purchasedCourses = Purchase::where('user_id', $id)
            ->whereHas('payment') // hanya yang punya data pembayaran, apapun statusnya
            ->with(['course.category', 'payment']) // pastikan relasi payment juga dibawa
            ->paginate(5);
    
        return view('dashboard-superadmin.detail-peserta-superadmin', compact('user', 'purchasedCourses'));
    }   

    public function kategori(Request $request)
    {
        $search = $request->input('search'); // Ambil input dari searchbar

        $categories = Category::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%");
        })->paginate(5);

        $courses = Course::get();

        return view('dashboard-superadmin.kategori-superadmin', compact('categories', 'courses', 'search'));
    }

    public function tambahkategori()
    {
        return view('dashboard-superadmin.tambah-kategori-superadmin');
    }

    public function editkategori(Category $category)
    {
        return view('dashboard-superadmin.edit-kategori-superadmin', compact('category'));
    }

    public function detailkategori($id)
    {
        $category = Category::with('courses')->where('id', $id)->firstOrFail();
        $courses = $category->courses()->paginate(5);
  
        return view('dashboard-superadmin.detail-kategori-superadmin', compact('category', 'courses'));
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

        // Tambahkan ini:
        $users = User::where('role', 'student')
                ->whereNull('deleted_at')
                ->get();

        return view('dashboard-superadmin.detail-kursus-superadmin', compact('course', 'category', 'participants', 'users'));
    }

    public function diskon(Request $request)
    {
        $search = $request->input('search');

        $discounts = Discount::with('courses') // Ambil relasi courses
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('coupon_code', 'like', '%' . $search . '%')
                        ->orWhere('discount_percentage', 'like', '%' . $search . '%')
                        ->orWhere('start_date', 'like', '%' . $search . '%')
                        ->orWhere('end_date', 'like', '%' . $search . '%');
                });
            })
            ->paginate(5);

        return view('dashboard-superadmin.diskon-superadmin', compact('discounts', 'search'));
    }

    public function tambahdiskon()
    {
        $courses = Course::all(); // Ambil semua data kursus
    
        return view('dashboard-superadmin.tambah-diskon-superadmin', compact('courses'));
    }    

    public function editdiskon($id)
    {
        $discount = Discount::findOrFail($id);
        $courses = Course::all();
        $courseTitles = $discount->courses->pluck('title')->toArray(); // Ambil nama kursus terkait dengan diskon
        $courseIds = $discount->courses->pluck('id')->toArray(); // Ambil ID kursus terkait dengan diskon
        return view('dashboard-superadmin.edit-diskon-superadmin', compact('discount', 'courses', 'courseTitles', 'courseIds'));
    }

    public function rating()
    {
        $ratings = Rating::paginate(5); 

        return view('dashboard-superadmin.rating-superadmin', compact('ratings'));
    }

    public function laporan(Request $request)
    {
        $selectedCourseId = $request->get('course_id', null);
        $selectedMonth = $request->get('month');
        $selectedYear = $request->get('year', Carbon::now()->year);

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

        // Pendapatan per bulan (untuk grafik)
        $monthlyRevenue = Purchase::selectRaw('MONTH(created_at) as month, SUM(harga_course) as total')
            ->where('status', 'success')
            ->where('harga_course', '>', 0)
            ->whereYear('created_at', $selectedYear)
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

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

        $revenues = $purchasesQuery->paginate(10);

        $totalFilteredRevenue = $revenues->sum(function ($purchase) {
            return optional($purchase->payment)->amount;
        });

        $coursesRevenue = Course::all();

        return view('dashboard-superadmin.laporan-superadmin', [
            'revenues' => $revenues,
            'coursesRevenue' => $coursesRevenue,
            'selectedCourseId' => $selectedCourseId,
            'selectedMonth' => $selectedMonth,
            'totalFilteredRevenue' => $totalFilteredRevenue,
            'totalAllRevenue' => $totalAllRevenue,
            'totalRevenue' => $totalRevenue,
            'monthlyRevenue' => $monthlyRevenue,
            'selectedYear' => $selectedYear
        ]);
    }

    public function Notifications()
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
                    'url' => route('detaildata-peserta-superadmin', ['id' => $purchase->user->id]),
                ];
            }
        }
        
        foreach ($mentors as $mentor) {
            $notifications[] = [
                'type' => 'mentor',
                'message' => "Mentor baru mendaftar : {$mentor->name}",
                'id' => 'mentor_' . $mentor->id,
                'url' => route('detaildata-mentor-superadmin'),
            ];
        }
        
        foreach ($courses as $course) {
            $notifications[] = [
                'type' => 'kursus',
                'message' => "Kursus baru ditambahkan oleh {$course->mentor->name} : {$course->title}",
                'id' => 'course_' . $course->id,
                'url' => route('detail-kursus-superadmin', ['id' => $course->category->id]),
            ];
        }         
    
        return response()->json([
            'notifications' => $notifications,
        ]);
    }    
}
