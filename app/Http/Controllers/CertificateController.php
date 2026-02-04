<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Purchase;
use App\Models\Course;
use App\Models\MateriUSer;
use App\Models\FinalTaskUser;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    
    public function certificate($courseId)
    {
        $userId = auth()->id();

        // Cek apakah user sudah disetujui oleh mentor
        $finalTask = FinalTaskUser::where('user_id', $userId)
            ->where('course_id', $courseId)
            ->where('certificate_status', 'approved')
            ->first();

        if (!$finalTask) {
            return redirect()->back()->with('error', 'Sertifikat belum tersedia. Menunggu persetujuan dari mentor.');
        }

        // Ambil data kursus
        $course = Course::with(['category:id,name', 'mentor:id,name'])->findOrFail($courseId);
        $categoryName = strtolower($course->category->name);

        // Daftar kategori yang dianggap Cybersecurity
        $cyberCategories = [
            'cyber security', 'siber', 'cybersecurity', 'Cyber Security', 'CyberSecurity', 'Cybersecurity', 'cyber', 'Cyber'
        ];

        // Normalisasi kategori (hapus spasi dan huruf kecil semua untuk kecocokan yang lebih kuat)
        $normalizedCategory = str_replace(' ', '', $categoryName);

        // Bandingkan dengan kategori yang dianggap Cybersecurity
        $isCybersecurity = in_array($normalizedCategory, array_map(function ($val) {
            return str_replace(' ', '', strtolower($val));
        }, $cyberCategories));

        // Ambil tanggal penyelesaian
        if ($isCybersecurity) {
            // Dari final_task_user
            $completionDate = $finalTask->completed_at;
        } else {
            // Dari materi_user (yang completed_at terbaru)
            $lastCompleted = DB::table('materi_user')
                ->where('user_id', $userId)
                ->where('courses_id', $courseId)
                ->whereNotNull('completed_at')
                ->orderByDesc('completed_at')
                ->first();

            $completionDate = $lastCompleted->completed_at ?? null;
        }

        $data = [
            'participant_name'      => auth()->user()->name,
            'course_title'          => $course->title,
            'course_category'       => $course->category->name,
            'course_start_date'     => Carbon::parse($course->start_date)->format('d M Y'),
            'course_end_date'       => Carbon::parse($course->end_date)->format('d M Y'),
            'mentor_name'           => $course->mentor->name ?? 'Tidak Diketahui',
            'signature_title_left'  => 'Direktur Kursus',
            'signature_title_right' => 'Mentor Kursus',
            'completion_date'       => $completionDate ? Carbon::parse($completionDate)->format('d M Y') : 'Belum Selesai',
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

        // Ambil data pembelian
        $purchase = Purchase::where('user_id', $userId)
            ->where('course_id', $courseId)
            ->where('status', 'success')
            ->firstOrFail();

        $course = $purchase->course;

        // Ambil tanggal kelulusan dari materi_user (kuis) yang nilainya >= 75
        $completionDate = DB::table('materi_user')
            ->where('user_id', $userId)
            ->where('courses_id', $courseId)
            ->where('nilai', '>=', 75)
            ->orderBy('created_at', 'asc') // ambil yang paling awal
            ->value('created_at');

        // Format tanggal
        $completionDateFormatted = $completionDate
            ? \Carbon\Carbon::parse($completionDate)->translatedFormat('d F Y')
            : 'Tanggal Tidak Diketahui';

        // Data sertifikat
        $data = [
            'participant_name'       => $purchase->user->name,
            'course_title'           => $course->title,
            'course_category'        => $course->category->name,
            'course_start_date'      => Carbon::parse($course->start_date)->format('d M Y'),
            'course_end_date'        => Carbon::parse($course->end_date)->format('d M Y'),
            'mentor_name'            => $course->mentor->name ?? 'Tidak Diketahui',
            'completion_date'        => $completionDateFormatted,
            'signature_title_left'   => 'Direktur Kursus',
            'signature_title_right'  => 'Mentor Kursus',
            'is_pdf'                 => true
        ];

        // Buat PDF sertifikat
        $pdf = Pdf::loadView('dashboard-mentor.sertifikat', $data)
                ->setPaper('a4', 'landscape');

        return $pdf->download('certificate.pdf');
    }
    
}
