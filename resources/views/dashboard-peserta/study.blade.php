@extends('layouts.dashboard-peserta')

@section('content')

<div class="mb-3 flex justify-start">
    <a href="{{ route('daftar-kursus') }}" class="text-midnight font-semibold p-1 bg-white border border-gray-200 rounded-full transition-transform duration-300 ease-in-out transform hover:scale-105">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
        </svg>
    </a>
</div>

<div class="container mx-auto border border-gray-200 rounded-md" 
     x-data="{ selected: '{{ $course->materi->first()->id ?? null }}', sidebarOpen: false }">
     
    <!-- Header Course -->
    <div class="bg-white text-gray-600 pt-1 rounded-lg mt-2">
        <h2 class="text-xl text-center font-semibold capitalize">{{ $course->title }}</h2>
        <p class="text-sm mt-2 text-center text-gray-600 capitalize">Mentor: {{ $course->mentor->name ?? 'Tidak ada mentor' }}</p>
    </div>

    <!-- Tombol Toggle Sidebar (Mobile) -->
    <div class="block lg:hidden text-right mt-2 ml-2">
        <button @click="sidebarOpen = !sidebarOpen" 
                class="bg-sky-400 hover:bg-sky-300 text-white px-2 py-2 rounded mr-2 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" 
                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" 
                    d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0ZM3.75 12h.007v.008H3.75V12Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm-.375 5.25h.007v.008H3.75v-.008Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
            </svg>
            <!-- <span x-text="sidebarOpen ? 'Tutup Daftar Materi' : 'Buka Daftar Materi'"></span> -->
        </button>
    </div>

    <!-- Layout Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-2 mt-2">

        <!-- Konten Materi -->
        <div class="lg:col-span-3">
            @foreach ($course->materi as $materi)
            <div x-show="selected == '{{ $materi->id }}'" x-transition class="bg-white shadow rounded-md p-4 m-2 border">
                <h3 class="text-lg font-semibold text-gray-700 mb-2">{{ $materi->judul }}</h3>
                <p class="text-gray-700 mb-4">{{ $materi->deskripsi }}</p>

                <!-- Video -->
                @if ($materi->videos && $materi->videos->count())
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-6">
                    @foreach ($materi->videos as $video)
                    <div class="border p-4 rounded-md shadow-md">
                        <h4 class="font-semibold mb-2 text-gray-700">{{ $video->title }}</h4>
                        @if ($video->link)
                        <iframe 
                            src="{{ $video->link }}" 
                            width="100%" 
                            height="250" 
                            allow="autoplay" 
                            allowfullscreen 
                            class="rounded-lg shadow-md">
                        </iframe>
                        @else
                        <p class="text-red-500">Video tidak tersedia.</p>
                        @endif 
                        <p class="font-semibold mt-3 text-gray-700">{{ $video->description }}</p>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
            @endforeach

            <!-- Konten Kuis -->
            @if ($course->quizzes->isNotEmpty())
            <div x-show="selected === 'quiz'" x-transition class="bg-white shadow rounded-md p-4 m-2 border">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Daftar Kuis</h3>
                @foreach ($course->quizzes as $quiz)
                <div class="mb-4">
                    <a href="{{ route('quiz.show', $quiz->id) }}"
                        class="quiz-link bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700"
                        data-quiz-title="{{ $quiz->title }}"
                        data-quiz-url="{{ route('quiz.show', $quiz->id) }}"
                        data-quiz-duration="{{ $quiz->duration }}">
                        Mulai Kuis: {{ $quiz->title }}
                    </a>

                    @php
                        $userQuizResult = \DB::table('materi_user')
                            ->where('user_id', auth()->id())
                            ->where('courses_id', $course->id)
                            ->where('quiz_id', $quiz->id)
                            ->orderByDesc('completed_at')
                            ->first();
                    @endphp

                    @if ($userQuizResult)
                    <form method="POST" action="{{ route('quiz.retake', $quiz->id) }}" class="mt-2 quiz-retake" data-title="{{ $quiz->title }}">
                        @csrf
                        <button type="submit" class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600">
                            Kerjakan Kuis Lagi
                        </button>
                    </form>

                    @else
                    <p class="text-sm text-red-500 mt-2">❌ Kamu belum mengerjakan kuis ini.</p>
                    @endif
                </div>
                @endforeach

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
                    <h2 class="text-md text-gray-700 font-semibold mb-4">Riwayat Semua Kuis</h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full border-separate border-spacing-0 text-sm text-center">
                            <thead class="bg-gray-100 text-gray-600">
                                <tr>
                                    <th class="px-4 py-2 border-t border-l border-b border-gray-200 rounded-tl-lg">Judul Kuis</th>
                                    <th class="px-4 py-2 border-t border-b border-gray-200">Nilai</th>
                                    <th class="px-4 py-2 border-t border-b border-gray-200">Tanggal</th>
                                    <th class="px-4 py-2 border-t border-b border-r border-gray-200 rounded-tr-lg">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($quizHistories as $history)
                                    @php
                                        $quiz = \App\Models\Quiz::find($history->quiz_id);
                                    @endphp
                                    <tr class="bg-white hover:bg-gray-50 text-gray-600">
                                        <td class="px-4 py-2 border-b border-l border-gray-200">{{ $quiz->title ?? 'Kuis Tidak Ditemukan' }}</td>
                                        <td class="px-4 py-2 border-b border-gray-200 text-green-600 font-semibold">{{ $history->nilai }}</td>
                                        <td class="px-4 py-2 border-b border-gray-200">{{ \Carbon\Carbon::parse($history->completed_at)->format('d M Y, H:i') }}</td>
                                        <td class="px-4 py-2 border-b border-r border-gray-200 text-blue-600"></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
            </div>
            @endif
        </div>

        <!-- Sidebar Materi (Responsive) -->
        <div 
            class="lg:col-span-1 lg:block lg:mr-2 lg:my-2 bg-white px-1 border border-gray-200 rounded-md overflow-y-auto"
            :class="{ 'fixed top-20 mt-9 right-0 w-64 max-h-[70vh] shadow-lg z-20 p-4 overflow-y-auto': sidebarOpen && window.innerWidth < 1024 }"
            x-show="sidebarOpen || window.innerWidth >= 1024"
            x-transition>
            
            <!-- Daftar Materi -->
            <h3 class="text-md font-semibold text-gray-700 mb-2 text-center mt-4">Daftar Materi</h3>
            @foreach ($course->materi as $materi)
            <button @click="selected = '{{ $materi->id }}'; if(window.innerWidth < 1024) sidebarOpen = false" 
                    class="w-full text-left px-3 py-2 rounded hover:bg-gray-100 text-gray-600"
                    :class="{ 'bg-gray-200 font-semibold text-gray-700': selected === '{{ $materi->id }}' }">
                📘 {{ $materi->judul }}
            </button>
            @endforeach

            <!-- Kuis -->
            @if ($course->quizzes->isNotEmpty())
            <hr class="my-2">
            <button @click="selected = 'quiz'; if(window.innerWidth < 1024) sidebarOpen = false" 
                    class="w-full text-left px-3 py-2 rounded hover:bg-gray-100"
                    :class="{ 'bg-indigo-100 font-semibold text-indigo-700': selected === 'quiz' }">
                📝 <span class="text-gray-600">Kuis</span>
            </button>
            @endif

            <!-- Tombol tutup (mobile) -->
            <!-- <div class="block lg:hidden mt-4">
                <button @click="sidebarOpen = false" 
                        class="w-full bg-red-500 text-white py-2 px-4 rounded">
                    Tutup Sidebar
                </button>
            </div> -->
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

    // handle popup konfirmasi kerjakan kuis dan kerjakan ulang kuis
    document.addEventListener("DOMContentLoaded", function () {
    const quizLinks = document.querySelectorAll(".quiz-link");
    const retakeForms = document.querySelectorAll(".quiz-retake");

    // Handle quiz start button
    quizLinks.forEach(link => {
        link.addEventListener("click", function (event) {
            event.preventDefault();
            const title = this.dataset.quizTitle;
            const url = this.dataset.quizUrl;
            const duration = this.dataset.quizDuration;

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: `Kuis "${title}" membutuhkan waktu ${duration} menit untuk diselesaikan.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, mulai kuis',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
        });
    });

    // Handle quiz retake form
    retakeForms.forEach(form => {
        form.addEventListener("submit", function (event) {
            event.preventDefault();
            const title = form.dataset.title;

            Swal.fire({
                title: 'Kerjakan Ulang Kuis?',
                text: `Apakah Anda yakin ingin mengulang kuis "${title}"?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, kerjakan lagi',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
</script>
@endsection
