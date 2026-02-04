<?php

namespace App\Http\Controllers\DashboardAffiliate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MainController extends Controller
{
    /**
     * Menampilkan Beranda Affiliate
     */
    public function index()
    {
        $user = Auth::user();

        // Ambil data affiliate dari tabel users (asumsi ada kolom affiliate_code di users)
        $affiliateCode = $user->affiliate_code ?? strtoupper(substr(md5($user->id), 0, 8));

        // Total Komisi dari tabel payments yang berhasil melalui referral affiliate ini
        $totalKomisi = DB::table('payments')
            ->where('affiliate_user_id', $user->id)
            ->where('status', 'paid')
            ->sum('affiliate_commission') ?? 0;

        // Komisi Bulan Ini
        $komisiBulanIni = DB::table('payments')
            ->where('affiliate_user_id', $user->id)
            ->where('status', 'paid')
            ->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->sum('affiliate_commission') ?? 0;

        // Total Referral Berhasil (jumlah user yang mendaftar dengan kode referral)
        $totalReferral = DB::table('users')
            ->where('referred_by', $user->id)
            ->count();

        // Total Referral yang sudah membeli (konversi)
        $totalKonversi = DB::table('payments')
            ->where('affiliate_user_id', $user->id)
            ->where('status', 'paid')
            ->distinct('user_id')
            ->count('user_id');

        // Link Affiliate
        $affiliateLink = url('/register?ref=' . $affiliateCode);

        // Aktivitas Terbaru (5 transaksi terakhir)
        $aktivitasTerbaru = DB::table('payments')
            ->join('users', 'payments.user_id', '=', 'users.id')
            ->join('courses', 'payments.course_id', '=', 'courses.id')
            ->where('payments.affiliate_user_id', $user->id)
            ->where('payments.status', 'paid')
            ->select(
                'payments.id',
                'payments.created_at',
                'payments.affiliate_commission as komisi',
                DB::raw("CONCAT(users.name, ' membeli kursus \"', courses.title, '\"') as deskripsi")
            )
            ->orderBy('payments.created_at', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard-affiliate.main', compact(
            'affiliateCode',
            'affiliateLink',
            'totalKomisi',
            'komisiBulanIni',
            'totalReferral',
            'totalKonversi',
            'aktivitasTerbaru'
        ));
    }
}
