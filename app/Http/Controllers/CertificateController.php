<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Purchase;
use App\Models\Course;
use App\Models\MateriUSer;
use App\Models\FinalTaskUser;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    
    public function certificate($courseId)
    {
        $userId = auth()->id();
    
        // Cek apakah user sudah disetujui oleh mentor (certificate_status = 'approved')
        $finalTask = FinalTaskUser::where('user_id', $userId)
            ->where('course_id', $courseId)
            ->where('certificate_status', 'approved')
            ->first();
    
        if (!$finalTask) {
            return redirect()->back()->with('error', 'Sertifikat belum tersedia. Menunggu persetujuan dari mentor.');
        }
    
        // Ambil data kursus untuk ditampilkan di sertifikat
        $course = Course::with(['category:id,name','mentor:id,name'])->findOrFail($courseId);

        $data = [
            'participant_name'      => auth()->user()->name,
            'course_title'          => $course->title,
            'course_category'       => $course->category->name,
            'course_start_date'     => Carbon::parse($course->start_date)->format('d M Y'),
            'course_end_date'       => Carbon::parse($course->end_date)->format('d M Y'),
            'mentor_name'           => $course->mentor->name ?? 'Tidak Diketahui',
            'signature_title_left'  => 'Direktur Kursus',
            'signature_title_right' => 'Mentor Kursus',
            // ← tambahkan ini:
            'course'                => $course,
          ];
    
        return view('dashboard-peserta.certificate-detail', $data);
    }
    
    // Menampilkan Sertifikat
    public function showCertificate($courseId)
    {
        $userId = auth()->id(); // Mendapatkan ID user yang login

        // Ambil data course berdasarkan courseId
        $course = Course::findOrFail($courseId);

        // Data untuk sertifikat
        $data = [
            'participant_name'       => $userId ? auth()->user()->name : 'Nama Peserta Tidak Diketahui',  // Nama peserta
            'course_title'           => $course->title,
            'course_category'        => $course->category->name,
            'course_start_date'      => $course->start_date,
            'course_end_date'        => $course->end_date,
            'mentor_name'            => $course->mentor->name ?? 'Tidak Diketahui',
            'signature_title_left'   => 'Direktur Kursus',
            'signature_title_right'  => 'Mentor Kursus',
        ];

        // Mengembalikan view untuk sertifikat
        return view('dashboard-mentor.sertifikat', $data);
    }
    
    // Mengunduh Sertifikat
    public function downloadCertificate($courseId)
    {
        $userId = auth()->id();
    
        // Ambil data pembelian dari tabel purchases
        $purchase = Purchase::where('user_id', $userId)
                            ->where('course_id', $courseId)
                            ->where('status', 'success') // pastikan status pembelian sukses
                            ->firstOrFail();
    
        $course = $purchase->course;
    
        // Data untuk sertifikat
        $data = [
            'participant_name'       => $purchase->user->name,
            'course_title'           => $course->title,
            'course_category'        => $course->category->name,
            'course_start_date'      => $course->start_date,
            'course_end_date'        => $course->end_date,
            'mentor_name'            => $course->mentor->name ?? 'Tidak Diketahui',
            'signature_title_left'   => 'Direktur Kursus',
            'signature_title_right'  => 'Mentor Kursus',
            'is_pdf'                 => true // ← agar image tampil saat diunduh
        ];
    
        // Buat PDF menggunakan DOMPDF
        $pdf = Pdf::loadView('dashboard-mentor.sertifikat', $data)
                  ->setPaper('a4', 'landscape');
    
        return $pdf->download('certificate.pdf');
    }
    
}
