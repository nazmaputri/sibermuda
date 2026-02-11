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

        // Data Dummy untuk sementara
        $affiliateCode = strtoupper(substr(md5($user->id), 0, 8));
        $affiliateLink = url('/register?ref=' . $affiliateCode);

        // Dummy Stats
        $totalKomisi = 2500000; // Rp 2.500.000
        $komisiBulanIni = 750000; // Rp 750.000
        $totalReferral = 15; // 15 referral
        $totalKonversi = 8; // 8 yang sudah beli

        // Dummy Aktivitas Terbaru
        $aktivitasTerbaru = collect([
            (object)[
                'id' => 1,
                'deskripsi' => 'Budi Santoso membeli kursus "Web Development Mastery"',
                'komisi' => 150000,
                'created_at' => Carbon::now()->subHours(2)
            ],
            (object)[
                'id' => 2,
                'deskripsi' => 'Siti Nurhaliza membeli kursus "Digital Marketing untuk Pemula"',
                'komisi' => 100000,
                'created_at' => Carbon::now()->subHours(5)
            ],
            (object)[
                'id' => 3,
                'deskripsi' => 'Ahmad Dhani membeli kursus "UI/UX Design Fundamental"',
                'komisi' => 120000,
                'created_at' => Carbon::now()->subDay(1)
            ],
            (object)[
                'id' => 4,
                'deskripsi' => 'Rina Wati membeli kursus "Python Programming"',
                'komisi' => 180000,
                'created_at' => Carbon::now()->subDays(2)
            ],
            (object)[
                'id' => 5,
                'deskripsi' => 'Joko Widodo membeli kursus "Data Science dengan R"',
                'komisi' => 200000,
                'created_at' => Carbon::now()->subDays(3)
            ],
        ]);

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


    /**
     * Menampilkan Halaman Laporan Affiliate
     */
    public function laporan(Request $request)
    {
        $user = Auth::user();

        // Filter tahun
        $year = $request->get('year', Carbon::now()->year);
        $years = range(Carbon::now()->year, Carbon::now()->year - 3);

        // Dummy Stats
        $totalKomisi = 2500000;
        $komisiBulanIni = 750000;
        $totalKlik = 245;
        $totalKonversi = 15;
        $konversiRate = ($totalKonversi / $totalKlik) * 100;

        // Dummy Data Grafik Komisi per Bulan
        $monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $komisiPerBulan = [50000, 80000, 120000, 150000, 200000, 180000, 250000, 300000, 280000, 320000, 400000, 750000];

        // Dummy Data Grafik Klik & Konversi
        $klikPerBulan = [15, 18, 22, 25, 28, 24, 30, 32, 28, 35, 40, 45];
        $konversiPerBulan = [1, 1, 2, 2, 2, 1, 3, 3, 2, 3, 4, 5];

        // Dummy Riwayat Transaksi (lebih lengkap)
        $transaksiTerbaru = collect([
            (object)[
                'id' => 1,
                'invoice' => 'INV-2025-001',
                'pembeli_nama' => 'Budi Santoso',
                'kursus_nama' => 'Web Development Mastery',
                'harga' => 1500000,
                'komisi' => 150000,
                'persentase' => 10,
                'status' => 'paid',
                'created_at' => Carbon::now()->subHours(2)
            ],
            (object)[
                'id' => 2,
                'invoice' => 'INV-2025-002',
                'pembeli_nama' => 'Siti Nurhaliza',
                'kursus_nama' => 'Digital Marketing untuk Pemula',
                'harga' => 1000000,
                'komisi' => 100000,
                'persentase' => 10,
                'status' => 'paid',
                'created_at' => Carbon::now()->subHours(5)
            ],
            (object)[
                'id' => 3,
                'invoice' => 'INV-2025-003',
                'pembeli_nama' => 'Ahmad Dhani',
                'kursus_nama' => 'UI/UX Design Fundamental',
                'harga' => 1200000,
                'komisi' => 120000,
                'persentase' => 10,
                'status' => 'paid',
                'created_at' => Carbon::now()->subDay(1)
            ],
            (object)[
                'id' => 4,
                'invoice' => 'INV-2025-004',
                'pembeli_nama' => 'Rina Wati',
                'kursus_nama' => 'Python Programming',
                'harga' => 1800000,
                'komisi' => 180000,
                'persentase' => 10,
                'status' => 'pending',
                'created_at' => Carbon::now()->subDays(2)
            ],
            (object)[
                'id' => 5,
                'invoice' => 'INV-2025-005',
                'pembeli_nama' => 'Joko Widodo',
                'kursus_nama' => 'Data Science dengan R',
                'harga' => 2000000,
                'komisi' => 200000,
                'persentase' => 10,
                'status' => 'paid',
                'created_at' => Carbon::now()->subDays(3)
            ],
            (object)[
                'id' => 6,
                'invoice' => 'INV-2025-006',
                'pembeli_nama' => 'Dewi Lestari',
                'kursus_nama' => 'Mobile App Development',
                'harga' => 1700000,
                'komisi' => 170000,
                'persentase' => 10,
                'status' => 'paid',
                'created_at' => Carbon::now()->subDays(5)
            ],
            (object)[
                'id' => 7,
                'invoice' => 'INV-2025-007',
                'pembeli_nama' => 'Andi Wijaya',
                'kursus_nama' => 'Backend Development dengan Laravel',
                'harga' => 1600000,
                'komisi' => 160000,
                'persentase' => 10,
                'status' => 'paid',
                'created_at' => Carbon::now()->subDays(7)
            ],
            (object)[
                'id' => 8,
                'invoice' => 'INV-2025-008',
                'pembeli_nama' => 'Lisa Blackpink',
                'kursus_nama' => 'React JS untuk Pemula',
                'harga' => 1300000,
                'komisi' => 130000,
                'persentase' => 10,
                'status' => 'paid',
                'created_at' => Carbon::now()->subDays(10)
            ],
            (object)[
                'id' => 9,
                'invoice' => 'INV-2025-009',
                'pembeli_nama' => 'Bambang Pamungkas',
                'kursus_nama' => 'Machine Learning Dasar',
                'harga' => 2200000,
                'komisi' => 220000,
                'persentase' => 10,
                'status' => 'failed',
                'created_at' => Carbon::now()->subDays(12)
            ],
            (object)[
                'id' => 10,
                'invoice' => 'INV-2025-010',
                'pembeli_nama' => 'Susi Pudjiastuti',
                'kursus_nama' => 'Cloud Computing dengan AWS',
                'harga' => 2500000,
                'komisi' => 250000,
                'persentase' => 10,
                'status' => 'paid',
                'created_at' => Carbon::now()->subDays(15)
            ],
        ]);

        // Top 5 Kursus Terlaris
        $kursusTop = collect([
            (object)[
                'nama' => 'Web Development Mastery',
                'total_terjual' => 12,
                'total_komisi' => 1800000
            ],
            (object)[
                'nama' => 'Digital Marketing untuk Pemula',
                'total_terjual' => 8,
                'total_komisi' => 800000
            ],
            (object)[
                'nama' => 'Python Programming',
                'total_terjual' => 7,
                'total_komisi' => 1260000
            ],
            (object)[
                'nama' => 'UI/UX Design Fundamental',
                'total_terjual' => 6,
                'total_komisi' => 720000
            ],
            (object)[
                'nama' => 'Data Science dengan R',
                'total_terjual' => 5,
                'total_komisi' => 1000000
            ],
        ]);

        return view('dashboard-affiliate.laporan.index', compact(
            'totalKomisi',
            'komisiBulanIni',
            'totalKlik',
            'totalKonversi',
            'konversiRate',
            'monthNames',
            'komisiPerBulan',
            'klikPerBulan',
            'konversiPerBulan',
            'transaksiTerbaru',
            'kursusTop',
            'year',
            'years'
        ));
    }

    /**
     * Menampilkan Halaman Penarikan Dana
     */
    public function penarikan()
    {
        $user = Auth::user();

        // Dummy Data
        $saldoTersedia = 2500000; // Total komisi yang sudah paid
        $saldoPending = 180000; // Komisi yang masih pending
        $minimalPenarikan = 100000;

        // Riwayat Penarikan
        $riwayatPenarikan = collect([
            (object)[
                'id' => 1,
                'nomor_penarikan' => 'WD-2025-001',
                'jumlah' => 500000,
                'metode' => 'Bank Transfer - BCA',
                'nomor_rekening' => '1234567890',
                'status' => 'completed',
                'tanggal_request' => Carbon::now()->subDays(3),
                'tanggal_proses' => Carbon::now()->subDays(2),
                'keterangan' => 'Penarikan berhasil diproses'
            ],
            (object)[
                'id' => 2,
                'nomor_penarikan' => 'WD-2025-002',
                'jumlah' => 750000,
                'metode' => 'E-Wallet - GoPay',
                'nomor_rekening' => '081234567890',
                'status' => 'processing',
                'tanggal_request' => Carbon::now()->subDays(1),
                'tanggal_proses' => null,
                'keterangan' => 'Sedang diproses oleh admin'
            ],
            (object)[
                'id' => 3,
                'nomor_penarikan' => 'WD-2025-003',
                'jumlah' => 300000,
                'metode' => 'Bank Transfer - Mandiri',
                'nomor_rekening' => '9876543210',
                'status' => 'completed',
                'tanggal_request' => Carbon::now()->subDays(10),
                'tanggal_proses' => Carbon::now()->subDays(8),
                'keterangan' => 'Penarikan berhasil diproses'
            ],
            (object)[
                'id' => 4,
                'nomor_penarikan' => 'WD-2025-004',
                'jumlah' => 200000,
                'metode' => 'E-Wallet - OVO',
                'nomor_rekening' => '081298765432',
                'status' => 'rejected',
                'tanggal_request' => Carbon::now()->subDays(15),
                'tanggal_proses' => Carbon::now()->subDays(14),
                'keterangan' => 'Nomor rekening tidak valid'
            ],
        ]);

        return view('dashboard-affiliate.penarikan.index', compact(
            'saldoTersedia',
            'saldoPending',
            'minimalPenarikan',
            'riwayatPenarikan'
        ));
    }

    /**
     * Menampilkan Halaman Referral
     */
    public function referral()
    {
        $user = Auth::user();

        // Dummy Stats
        $totalReferral = 15;
        $referralAktif = 8;
        $referralInaktif = 7;

        // Dummy Daftar Referral
        $daftarReferral = collect([
            (object)[
                'id' => 1,
                'nama' => 'Budi Santoso',
                'email' => 'budi@email.com',
                'tanggal_daftar' => Carbon::now()->subDays(5),
                'total_pembelian' => 2,
                'total_komisi' => 300000,
                'status' => 'active',
                'last_purchase' => Carbon::now()->subDays(2)
            ],
            (object)[
                'id' => 2,
                'nama' => 'Siti Nurhaliza',
                'email' => 'siti@email.com',
                'tanggal_daftar' => Carbon::now()->subDays(10),
                'total_pembelian' => 1,
                'total_komisi' => 100000,
                'status' => 'active',
                'last_purchase' => Carbon::now()->subDays(5)
            ],
            (object)[
                'id' => 3,
                'nama' => 'Ahmad Dhani',
                'email' => 'ahmad@email.com',
                'tanggal_daftar' => Carbon::now()->subDays(15),
                'total_pembelian' => 3,
                'total_komisi' => 450000,
                'status' => 'active',
                'last_purchase' => Carbon::now()->subDays(1)
            ],
            (object)[
                'id' => 4,
                'nama' => 'Rina Wati',
                'email' => 'rina@email.com',
                'tanggal_daftar' => Carbon::now()->subDays(20),
                'total_pembelian' => 0,
                'total_komisi' => 0,
                'status' => 'inactive',
                'last_purchase' => null
            ],
            (object)[
                'id' => 5,
                'nama' => 'Joko Widodo',
                'email' => 'joko@email.com',
                'tanggal_daftar' => Carbon::now()->subDays(25),
                'total_pembelian' => 1,
                'total_komisi' => 200000,
                'status' => 'active',
                'last_purchase' => Carbon::now()->subDays(3)
            ],
            (object)[
                'id' => 6,
                'nama' => 'Dewi Lestari',
                'email' => 'dewi@email.com',
                'tanggal_daftar' => Carbon::now()->subDays(30),
                'total_pembelian' => 2,
                'total_komisi' => 340000,
                'status' => 'active',
                'last_purchase' => Carbon::now()->subDays(7)
            ],
            (object)[
                'id' => 7,
                'nama' => 'Andi Wijaya',
                'email' => 'andi@email.com',
                'tanggal_daftar' => Carbon::now()->subDays(35),
                'total_pembelian' => 0,
                'total_komisi' => 0,
                'status' => 'inactive',
                'last_purchase' => null
            ],
        ]);

        return view('dashboard-affiliate.referral.index', compact(
            'totalReferral',
            'referralAktif',
            'referralInaktif',
            'daftarReferral'
        ));
    }

    /**
     * Menampilkan Halaman Marketing Tools
     */
    public function tools()
    {
        $user = Auth::user();

        $affiliateCode = strtoupper(substr(md5($user->id), 0, 8));
        $affiliateLink = url('/register?ref=' . $affiliateCode);

        // Dummy Data Banner
        $banners = collect([
            (object)[
                'id' => 1,
                'nama' => 'Banner 728x90',
                'ukuran' => '728x90',
                'image' => 'https://via.placeholder.com/728x90/3B82F6/FFFFFF?text=Banner+728x90',
                'kategori' => 'Leaderboard'
            ],
            (object)[
                'id' => 2,
                'nama' => 'Banner 300x250',
                'ukuran' => '300x250',
                'image' => 'https://via.placeholder.com/300x250/3B82F6/FFFFFF?text=Banner+300x250',
                'kategori' => 'Medium Rectangle'
            ],
            (object)[
                'id' => 3,
                'nama' => 'Banner 160x600',
                'ukuran' => '160x600',
                'image' => 'https://via.placeholder.com/160x600/3B82F6/FFFFFF?text=Banner+160x600',
                'kategori' => 'Skyscraper'
            ],
            (object)[
                'id' => 4,
                'nama' => 'Banner 300x600',
                'ukuran' => '300x600',
                'image' => 'https://via.placeholder.com/300x600/3B82F6/FFFFFF?text=Banner+300x600',
                'kategori' => 'Half Page'
            ],
        ]);

        // Template Social Media
        $templates = collect([
            (object)[
                'id' => 1,
                'platform' => 'Instagram',
                'judul' => 'Template Instagram Story',
                'konten' => "🚀 Mau upgrade skill?

    Join kursus online terbaik sekarang!
    ✅ Materi lengkap
    ✅ Mentor berpengalaman
    ✅ Sertifikat resmi

    Daftar pakai kode: {$affiliateCode}
    Link: {$affiliateLink}

    #BelajarOnline #UpgradeSkill"
            ],
            (object)[
                'id' => 2,
                'platform' => 'Facebook',
                'judul' => 'Template Facebook Post',
                'konten' => "Hai teman-teman! 👋

    Aku mau rekomendasiin platform kursus online yang keren banget!

    Kenapa harus join?
    ✨ Materi selalu update
    ✨ Harga terjangkau
    ✨ Bisa belajar kapan aja
    ✨ Dapet sertifikat

    Buruan daftar sekarang pakai kode referral aku: {$affiliateCode}

    Klik link ini: {$affiliateLink}"
            ],
            (object)[
                'id' => 3,
                'platform' => 'Twitter/X',
                'judul' => 'Template Twitter',
                'konten' => "Upgrade skill kamu sekarang! 🚀

    ✅ Kursus berkualitas
    ✅ Instruktur expert
    ✅ Harga bersahabat

    Daftar sekarang dengan kode: {$affiliateCode}
    {$affiliateLink}

    #OnlineLearning #UpgradeSkill"
            ],
            (object)[
                'id' => 4,
                'platform' => 'WhatsApp',
                'judul' => 'Template WhatsApp',
                'konten' => "Halo! 😊

    Aku mau share platform kursus online yang bagus nih. Cocok banget buat kamu yang mau belajar hal baru atau upgrade skill.

    Keuntungannya:
    - Materi lengkap dan mudah dipahami
    - Bisa akses selamanya
    - Ada sertifikat
    - Harga affordable

    Kalau kamu tertarik, bisa daftar pakai kode referral aku: *{$affiliateCode}*

    Link pendaftaran: {$affiliateLink}

    Yuk buruan daftar! 🚀"
            ],
        ]);

        return view('dashboard-affiliate.tools.index', compact(
            'affiliateCode',
            'affiliateLink',
            'banners',
            'templates'
        ));
    }

    /**
     * Menampilkan Halaman Panduan
     */
    public function panduan()
    {
        return view('dashboard-affiliate.panduan.index');
    }
}
