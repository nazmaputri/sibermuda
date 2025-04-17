@extends('layouts.dashboard-peserta')

@section('content')
<div class="container mx-auto">
    <!-- Konten Belajar -->
    <div class="bg-white shadow-lg rounded-lg overflow-hidden border border-gray-200">

        <!-- Header Course -->
        <div class="bg-white text-gray-600 p-3 rounded-lg mt-2">
            <h2 class="text-xl text-gray-700 text-center font-semibold capitalize">{{ $course->title }}</h2>
            <p class="text-sm mt-2 text-center text-gray-600 capitalize">Mentor : {{ $course->mentor->name ?? 'Tidak ada mentor' }}</p>
        </div>

        <!-- Silabus Materi -->
        <div class="p-6">
            @foreach ($course->materi as $materi)
            <div class="mb-6">
                <!-- Tombol Materi -->
                <button class="toggle-button w-full text-left bg-gray-50 border hover:bg-gray-100 p-3 rounded-md focus:outline-none flex items-center justify-between" data-target="materi-{{ $materi->id }}">
                    <div class="flex items-center space-x-2">
                        <!-- Ikon File -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-700" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M13.172,2H6C4.9,2,4,2.9,4,4v16c0,1.1,0.9,2,2,2h12c1.1,0,2-0.9,2-2V8.828c0-0.53-0.211-1.039-0.586-1.414l-4.828-4.828 C14.211,2.211,13.702,2,13.172,2z M15,18H9c-0.552,0-1-0.448-1-1v0c0-0.552,0.448-1,1-1h6c0.552,0,1,0.448,1,1v0 C16,17.552,15.552,18,15,18z M15,14H9c-0.552,0-1-0.448-1-1v0c0-0.552,0.448-1,1-1h6c0.552,0,1,0.448,1,1v0 C16,13.552,15.552,14,15,14z M13,9V3.5L18.5,9H13z"></path>
                        </svg>
                        <h4 class="font-semibold text-gray-700 capitalize">{{ $materi->judul }}</h4>
                    </div>
                    <!-- Icon dropdown -->
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 transition-transform duration-300 transform rotate-0 ml-auto dropdown-icon">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>
        
                <!-- Panel Konten Materi -->
                <div id="materi-{{ $materi->id }}" class="materi-content hidden p-4 bg-white rounded-md mt-4 border-t-8 border-t-sky-200 border">
                    <p class="text-gray-700 mb-4">{{ $materi->deskripsi }}</p>
        
                    <!-- Video -->
                    @if ($materi->videos && $materi->videos->count())
                        <div class="mt-4">
                            <h5 class="text-md font-semibold text-gray-700 flex items-center space-x-2 mb-2">
                                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 512 512">
                                    <path d="M464 256A208 208 0 1 0 48 256a208 208 0 1 0 416 0zM0 256a256 256 0 1 1 512 0A256 256 0 1 1 0 256zM188.3 147.1c7.6-4.2 16.8-4.1 24.3 .5l144 88c7.1 4.4 11.5 12.1 11.5 20.5s-4.4 16.1-11.5 20.5l-144 88c-7.4 4.5-16.7 4.7-24.3 .5s-12.3-12.2-12.3-20.9l0-176c0-8.7 4.7-16.7 12.3-20.9z" />
                                </svg>
                                <span>Video</span>
                            </h5>        
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach ($materi->videos as $video)
                                    <div class="border p-4 rounded-md shadow-md">
                                        <h4 class="font-semibold mb-2 text-gray-700">{{ $video->title }}</h4>
                                        @if ($video->link)
                                            <iframe 
                                                src="{{ $video->link }}" 
                                                width="100%" 
                                                height="480" 
                                                allow="autoplay" 
                                                allowfullscreen 
                                                class="rounded-lg shadow-md">
                                            </iframe>
                                        @else
                                            <p class="text-red-500">Video tidak tersedia.</p>
                                        @endif 
                                        <p class="font-semibold mt-5 text-gray-700">{{ $video->description }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            @if ($course->quizzes->isNotEmpty())
            <div class="mt-10 space-y-6">
                @foreach ($course->quizzes as $quiz)
                    <div>
                        <a href="{{ route('quiz.show', $quiz->id) }}"
                            class="quiz-link bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700"
                            data-quiz-title="{{ $quiz->title }}"
                            data-quiz-url="{{ route('quiz.show', $quiz->id) }}"
                            data-quiz-duration="{{ $quiz->duration }}">
                            Mulai Kuis: {{ $quiz->title }}
                        </a>
        
                        @php
                            // Ambil hasil kuis terakhir user untuk kuis ini
                            $userQuizResult = \DB::table('materi_user')
                                ->where('user_id', auth()->id())
                                ->where('courses_id', $course->id)
                                ->where('quiz_id', $quiz->id)
                                ->orderByDesc('completed_at')
                                ->first();
                        @endphp
        
                        @if ($userQuizResult)
                            <div class="mt-4 flex gap-3">
                                <form method="POST" action="{{ route('quiz.retake', $quiz->id) }}">
                                    @csrf
                                    <button type="submit" class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600">
                                        Kerjakan Kuis Lagi
                                    </button>
                                </form>
                            </div>
                        @else
                            <div class="mt-2 text-sm text-red-500">
                                ❌ Kamu belum mengerjakan kuis ini.
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        
            {{-- Riwayat Kuis --}}
            @php
                $quizHistories = \DB::table('materi_user')
                    ->where('user_id', auth()->id())
                    ->where('courses_id', $course->id)
                    ->whereNotNull('quiz_id')
                    ->orderBy('completed_at', 'desc')
                    ->get();
            @endphp
        
            @if ($quizHistories->isNotEmpty())
                <div class="mt-10">
                    <h2 class="text-xl font-semibold mb-4">Riwayat Semua Kuis</h2>
                    <table class="min-w-full border border-gray-200 rounded-lg bg-white shadow">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 border">Judul Kuis</th>
                                <th class="px-4 py-2 border">Nilai</th>
                                <th class="px-4 py-2 border">Tanggal</th>
                                <th class="px-4 py-2 border">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($quizHistories as $history)
                                @php
                                    $quiz = \App\Models\Quiz::find($history->quiz_id);
                                @endphp
                                <tr class="text-center">
                                    <td class="px-4 py-2 border">{{ $quiz->title ?? 'Kuis Tidak Ditemukan' }}</td>
                                    <td class="px-4 py-2 border text-green-600 font-semibold">{{ $history->nilai }}</td>
                                    <td class="px-4 py-2 border">{{ \Carbon\Carbon::parse($history->completed_at)->format('d M Y, H:i') }}</td>
                                    <td class="px-4 py-2 border">
                                        {{-- <a href="{{ route('quiz.result', $quiz->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                                            Review Kuis
                                        </a> --}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        @endif        
                
        @endforeach
            <div class="flex justify-end mt-6">
                <a href="{{ route('daftar-kursus') }}" 
                   class="bg-sky-400 hover:bg-sky-300 font-semibold text-white py-2 px-3 rounded-lg">
                    Kembali
                </a>
            </div>
                <!-- Modal Untuk Membuka Kuis -->
                <div id="quizModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 hidden z-50">
                    <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full sm:px-4 md:px-6 sm:mx-4 md:mx-6">
                        <h3 id="modalTitle" class="text-lg font-semibold mb-4">Konfirmasi</h3>
                        <p id="modalMessage" class="text-gray-700 mb-6"></p>
                        <div class="flex justify-center space-x-4">
                            <button id="cancelButton" class="bg-red-400 font-semibold text-white px-4 py-2 rounded-md hover:bg-red-300 focus:outline-none">
                                Tidak
                            </button>
                            <a id="confirmButton" href="#" class="bg-sky-400 font-semibold text-white px-4 py-2 rounded-md hover:bg-sky-300 focus:outline-none">
                                Ya
                            </a>
                        </div>
                    </div>
                </div>                                                         
                <script>
                    document.addEventListener("DOMContentLoaded", function () {
                        const quizLinks = document.querySelectorAll(".quiz-link");
                        const modal = document.getElementById("quizModal");
                        const modalTitle = document.getElementById("modalTitle");
                        const modalMessage = document.getElementById("modalMessage");
                        const confirmButton = document.getElementById("confirmButton");
                        const cancelButton = document.getElementById("cancelButton");
                        
                        // Menambahkan event listener hanya pada elemen dengan kelas .quiz-link
                        quizLinks.forEach(link => {
                            link.addEventListener("click", function (event) {
                                event.preventDefault(); // Mencegah navigasi langsung ke URL kuis
                                
                                const title = this.dataset.quizTitle;
                                const url = this.dataset.quizUrl;
                                const duration = this.dataset.quizDuration;
                                
                                // Mengupdate konten modal
                                modalTitle.textContent = `Apakah Anda yakin ingin mengambil kuis ini?`;
                                modalMessage.textContent = `Kuis "${title}" membutuhkan waktu ${duration} menit untuk diselesaikan.`;
                                confirmButton.href = url; // Memastikan link kuis diteruskan ke tombol konfirmasi
                                
                                // Menampilkan modal
                                modal.classList.remove("hidden");
                            });
                        });
                        
                        // Menangani tombol "Tidak"
                        cancelButton.addEventListener("click", function () {
                            modal.classList.add("hidden"); // Menyembunyikan modal jika dibatalkan
                        });
                
                        // Menangani event untuk membuka/menutup dropdown kuis
                        const dropdowns = document.querySelectorAll(".quiz-dropdown");
                        dropdowns.forEach(dropdown => {
                            dropdown.addEventListener("click", function () {
                                // Toggle visibility of the dropdown (menampilkan atau menyembunyikan dropdown)
                                this.classList.toggle("hidden");
                            });
                        });
                    });
                </script>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const toggleButtons = document.querySelectorAll(".toggle-button");

        toggleButtons.forEach(button => {
            button.addEventListener("click", function () {
                const targetId = this.getAttribute("data-target");
                const content = document.getElementById(targetId);
                const icon = this.querySelector(".dropdown-icon");

                // Toggle hidden class
                content.classList.toggle("hidden");

                // Tambah/hapus rotate-180 pada ikon SVG
                icon.classList.toggle("rotate-180");
            });
        });
    });
</script>
@endsection
