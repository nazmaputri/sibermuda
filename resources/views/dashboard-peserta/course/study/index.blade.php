@extends('layouts.dashboard-peserta')
@section('title', 'Belajar')
@section('content')

<div class="mb-3 flex justify-start">
    <a href="{{ route('daftar-kursus') }}" class="text-midnight font-semibold p-1 bg-white border border-gray-200 rounded-full transition-transform duration-300 ease-in-out transform hover:scale-105">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
        </svg>
    </a>
</div>

<!-- Pembungkus kontainer utama -->
<div class="container mx-auto border border-gray-200 rounded-md"
    x-data="{ selected: '{{ $materiAktif->id ?? $course->materi->first()->id }}', sidebarOpen: false, isLargeScreen: window.matchMedia('(min-width: 1024px)').matches }"
    x-init="
         // Listener resize untuk update isLargeScreen secara real-time
         window.addEventListener('resize', () => {
             isLargeScreen = window.matchMedia('(min-width: 1024px)').matches
         });">

    <!-- Header Kursus -->
    <div class="bg-white text-gray-600 pt-1 rounded-lg mt-2">
        <h2 class="md:text-xl text-md text-center font-medium capitalize">{{ $course->title }}</h2>
        <p class="text-sm mt-2 text-center text-gray-600 capitalize">Mentor : {{ $course->mentor->name ?? 'Tidak ada mentor' }}</p>
    </div>

    <!-- Tombol Toggle Sidebar (Hanya Mobile/Tablet) sampai line 57-->
    <div class="block lg:hidden text-right mt-2 ml-2">
        <button @click="sidebarOpen = !sidebarOpen"
                class="bg-sky-400 hover:bg-sky-300 text-white px-1.5 py-1.5 rounded mr-2 flex items-center gap-2">

            <!-- Ikon Menu (hamburger) -->
            <template x-if="!sidebarOpen">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                    class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75Z
                            m.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0ZM3.75 12h.007v.008H3.75V12Z
                            m.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm-.375 5.25h.007v.008H3.75v-.008Z
                            m.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                </svg>
            </template>

            <!-- Ikon Close (X) -->
            <template x-if="sidebarOpen">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                    class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M6 18L18 6M6 6l12 12" />
                </svg>
            </template>

        </button>
    </div>

    <!-- Layout Grid sampai line 470 -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-2 mt-2">

        <!-- Konten Materi : Video, Kuis dan Final Task Kursus sampai line 358 -->
        <div class="lg:col-span-3">
            <!-- Konten Materi Video Kursus sampai line 148 -->
            @foreach ($course->materi as $materi)
            <div x-show="selected == '{{ $materi->id }}'" x-transition class="bg-white rounded-md p-4 mx-2 border border-gray-200"> <!-- tambah class relative aja kalau mau responsive -->
                <h3 class="text-md font-medium text-gray-700 mb-2">{{ $materi->judul }}</h3>
                <p class="text-gray-700 mb-4">{{ $materi->deskripsi }}</p>

                @if($materi->videos->isEmpty() && $materi->youtube->isEmpty())
                    <p class="text-gray-700 text-sm">Tidak ada video untuk materi ini.</p>
                @else
                    @php
                        $allVideos = collect($materi->videos)->map(function($v) {
                            $v->source = 'gdrive';
                            return $v;
                        })->merge(
                            collect($materi->youtube)->map(function($v) {
                                $v->source = 'youtube';
                                return $v;
                            })
                        );
                    @endphp

                    <div class="mt-4 space-y-4">
                        @foreach ($allVideos as $i => $video)
                            <div x-data="{ open: false }"
                                :class="open ? 'border-gray-300' : 'border-gray-200'"
                                class="bg-white border rounded-lg p-2.5 flex flex-col self-start transition-colors duration-300">
                                <div @click="open = !open" class="flex items-center justify-between cursor-pointer">
                                    <div class="flex items-center space-x-2">
                                        <span class="text-gray-700 font-medium text-sm">{{ $i + 1 }}.</span>
                                        <h3 class="text-sm font-medium text-gray-700">{{ $video->title ?: 'Tidak ada judul video' }}</h3>
                                    </div>
                                    <svg :class="{ 'rotate-180': open }" class="w-5 h-5 text-gray-400 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>

                                <div x-show="open" x-collapse class="mt-4 overflow-hidden">
                                    @if ($video->link)
                                        @if ($video->source === 'gdrive')
                                            <iframe
                                                src="https://drive.google.com/file/d/{{ $video->link }}/preview"
                                                width="100%" height="480"
                                                allow="autoplay"
                                                allowfullscreen
                                                class="rounded-lg shadow-md">
                                            </iframe>
                                        @elseif ($video->source === 'youtube')
                                            <iframe
                                                width="100%" height="480"
                                                src="https://www.youtube.com/embed/{{ $video->link }}"
                                                frameborder="0"
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                allowfullscreen
                                                class="rounded-lg shadow-md">
                                            </iframe>
                                        @endif
                                    @else
                                        <p class="text-gray-700 text-sm">Video tidak tersedia.</p>
                                    @endif

                                    <p class="text-gray-700 mt-2 text-sm">{{ $video->description ?: 'Tidak ada deskripsi video' }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                {{-- Button Selanjutnya / Selesai --}}
                <form method="POST" action="{{ route('materi.nextOrFinish', ['materi' => $materi->id]) }}" class="flex justify-end mt-6">
                    @csrf
                    <button type="submit" class="group flex items-center bg-sky-400 hover:bg-sky-300 text-white text-sm font-medium px-4 py-2 rounded transition">
                        @if ($loop->last)
                            Selesai
                        @else
                            Selanjutnya
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="ml-2 h-4 w-4 transform transition-transform duration-200 group-hover:translate-x-1"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        @endif
                    </button>
                </form>
            </div>
            @endforeach

           <!-- Konten Final Task sampai line 240 -->
            {{-- @if($finalTask)
                <div x-show="selected === 'final-task'" x-transition class="bg-white rounded-md p-4 mx-2 border border-gray-200">
                    <h3 class="text-lg font-medium text-center text-gray-700 mb-4">Tugas Akhir</h3>

                    <div class="space-y-2 text-sm text-gray-700">
                        <div class="flex flex-wrap">
                            <span class="font-medium w-16 min-w-[0]">Judul</span><span class="mr-1">:</span>
                            <span class="">{{ $finalTask->judul }}</span>
                        </div>
                        <div class="flex flex-wrap">
                            <span class="font-medium w-16 min-w-[0]">Deskripsi</span><span class="mr-1">:</span>
                            <span class="">{{ $finalTask->desc }}</span>
                        </div>
                    </div>

                    <!-- Cek apakah tugas sudah dikerjakan -->
                    @php
                        $isCompleted = DB::table('final_task_user')->where('user_id', Auth::id())->where('final_task_id', $finalTask->id)->exists();
                    @endphp

                    @if($isCompleted)
                        <!-- Jika sudah dikerjakan, tampilkan tombol yang dinonaktifkan -->
                        <div class="mt-4">
                            <button class="bg-gray-400 text-white text-sm px-2 py-2 rounded cursor-not-allowed" disabled>
                                Sudah Dikerjakan
                            </button>
                        </div>

                        <!-- Tampilkan tabel riwayat pengerjaan tugas akhir -->
                        <div class="mt-4">
                            <h4 class="text-md font-medium text-gray-700 mb-2">Riwayat Pengerjaan Tugas Akhir</h4>
                            <div class="overflow-x-auto">
                            <div class="min-w-full w-64">
                                <table class="min-w-full border-separate border-spacing-0">
                                    <thead>
                                        <tr class="bg-gray-100 text-gray-600 text-sm">
                                            <th class="py-2 border-b border-l border-t border-gray-200 rounded-tl-lg">Judul</th>
                                            <th class="py-2 border-b border-t border-gray-200">Deskripsi</th>
                                            <th class="py-2 border-t border-b border-gray-200">Tanggal</th>
                                            <th class="py-2 border-b border-r border-t border-gray-200 rounded-tr-lg">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @if($finalTask && $finalTaskHistory)
                                        <tr class="bg-white hover:bg-gray-50">
                                            <td class="px-4 py-2 text-gray-600 text-sm border-b border-l border-gray-200">
                                                {{ $finalTaskHistory->title }}
                                            </td>
                                            <td class="px-4 py-2 text-gray-600 text-sm border-b border-gray-200">
                                                {{ $finalTaskHistory->description }}
                                            </td>
                                            <td class="px-4 py-2 text-gray-600 text-sm border-b border-gray-200">
                                                {{ \Carbon\Carbon::parse($finalTaskHistory->created_at)->translatedFormat('d F Y, H:i') }}
                                            </td>
                                            <td class="px-4 py-2 text-sm border-b border-r border-gray-200
                                                @if($finalTaskHistory->certificate_status === 'pending') text-yellow-500
                                                @elseif($finalTaskHistory->certificate_status === 'approved') text-green-500
                                                @else text-gray-600 @endif">
                                                {{ $finalTaskHistory->certificate_status ?? 'Belum Ada' }}
                                            </td>
                                        </tr>
                                    @elseif($finalTask && !$finalTaskHistory)
                                        <tr>
                                            <td colspan="4" class="text-center py-4 text-gray-700">Belum ada riwayat tugas akhir yang dikerjakan.</td>
                                        </tr>
                                    @else
                                        <tr>
                                            <td colspan="4" class="text-center py-4 text-gray-700">Belum ada tugas akhir untuk kursus ini.</td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                            </div>
                        </div>
                    @else
                        <!-- Jika belum dikerjakan, tampilkan tombol untuk mengerjakan tugas -->
                        <div class="mt-4">
                            <a href="{{ route('finaltask-user', ['course' => $course->id, 'finalTaskId' => $finalTask->id]) }}"
                                class="bg-green-400 text-white text-sm px-2 py-2 rounded hover:bg-green-300">
                                Kerjakan Tugas Akhir
                            </a>
                        </div>
                    @endif
                </div>
            @else
                <div x-show="selected === 'final-task'" x-transition class="bg-white shadow rounded-md p-4 m-2 border text-center text-gray-700 text-sm">
                    Tugas akhir belum tersedia.
                </div>
            @endif --}}

            <!-- Konten Kuis sampai line 357 -->
            @if ($course->quizzes->isEmpty())
                <div x-show="selected === 'quiz'" x-transition class="bg-white rounded-md p-4 mx-2 border border-gray-200">
                    <h3 class="text-lg font-medium text-gray-700 mb-4">Daftar Kuis</h3>
                    <p class="text-gray-500 text-sm">Kuis belum tersedia saat ini.</p>
                </div>
            @else
                <div x-show="selected === 'quiz'" x-transition class="bg-white rounded-md p-4 mx-2 border border-gray-200">
                    <h3 class="text-lg font-medium text-gray-700 mb-4">Daftar Kuis</h3>

                @foreach ($course->quizzes as $quiz)
                    <div class="mb-4">
                        @php
                            $userQuizResult = \DB::table('materi_user')
                                ->where('user_id', auth()->id())
                                ->where('courses_id', $course->id)
                                ->where('quiz_id', $quiz->id)
                                ->orderByDesc('completed_at')
                                ->first();
                        @endphp

                        @if ($userQuizResult)
                            <form method="POST" action="{{ route('quiz.retake', $quiz->id) }}" class="quiz-retake" data-title="{{ $quiz->title }}">
                                @csrf
                                <button type="submit" class="bg-amber-400 text-white px-2 py-1 rounded hover:bg-amber-300 text-sm">
                                    Kerjakan Kuis Lagi
                                </button>
                            </form>
                        @else
                            <a href="{{ route('quiz.show', $quiz->id) }}"
                            class="quiz-link bg-blue-400 text-white px-2 py-1 rounded hover:bg-blue-300 text-sm"
                            data-quiz-title="{{ $quiz->title }}"
                            data-quiz-url="{{ route('quiz.show', $quiz->id) }}"
                            data-quiz-duration="{{ $quiz->duration }}">
                                Mulai Kuis
                            </a>
                            <p class="text-sm text-red-500 mt-2">❌ Kamu belum mengerjakan kuis ini.</p>
                        @endif
                    </div>
                @endforeach

                @php
                    $quizHistories = \DB::table('materi_user')
                        ->where('user_id', auth()->id())
                        ->where('courses_id', $course->id)
                        ->whereNotNull('quiz_id')
                        ->orderBy('completed_at', 'desc')
                        ->get();

                    $limitedHistories = $quizHistories->take(3);
                @endphp

                @if ($quizHistories->isNotEmpty())
                <div class="mt-6" x-data="{ showModal: false }">
                    <h2 class="text-md text-gray-700 font-medium mb-4">Riwayat Kuis</h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full border-separate border-spacing-0 text-sm text-center">
                            <thead class="bg-gray-100 text-gray-600">
                                <tr>
                                    <th class="px-4 py-2 border-t border-l border-b border-gray-200 rounded-tl-lg text-sm">Judul</th>
                                    <th class="px-4 py-2 border-t border-b border-gray-200 text-sm">Nilai</th>
                                    <th class="px-4 py-2 border-t border-b border-r rounded-tr-lg border-gray-200 text-sm">Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($limitedHistories as $history)
                                    @php $quiz = \App\Models\Quiz::find($history->quiz_id); @endphp
                                    <tr class="bg-white hover:bg-gray-50 text-gray-600">
                                        <td class="px-4 py-2 border-b border-l border-gray-200 text-sm">{{ $quiz->title ?? 'Kuis Tidak Ditemukan' }}</td>
                                        <td class="px-4 py-2 border-b border-gray-200 font-medium text-sm {{ $history->nilai < 75 ? 'text-red-500' : 'text-green-500' }}">
                                            {{ $history->nilai }}
                                        </td>
                                        <td class="px-4 py-2 border-b border-r border-gray-200 text-sm">{{ \Carbon\Carbon::parse($history->completed_at)->translatedFormat('d F Y, H:i') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if ($quizHistories->count() > 3)
                    <div class="mt-4 text-right">
                        <button @click="showModal = true" class="bg-white text-gray-700 text-sm font-medium border border-gray-200 hover:bg-zinc-100 px-3 py-1.5 rounded-md">
                            Selengkapnya
                        </button>
                    </div>

                    <!-- Modal Jika Riwayat Kuis lebih dari 3 sampai line 351 -->
                    <div x-show="showModal" class="fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center" x-cloak>
                        <div class="bg-white p-6 rounded-lg w-full max-w-3xl mx-3 shadow-lg overflow-y-auto max-h-[80vh]">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-semibold text-gray-700">Riwayat Kuis</h3>
                                <button @click="showModal = false" class="text-gray-600 hover:text-red-500 text-xl">&times;</button>
                            </div>
                            <table class="min-w-full border-separate border-spacing-0 text-sm text-center">
                                <thead class="bg-gray-100 text-gray-600">
                                    <tr>
                                        <th class="px-4 py-2 border-t border-l border-b border-gray-200 rounded-tl-lg text-sm">Judul</th>
                                        <th class="px-4 py-2 border-t border-b border-gray-200 text-sm">Nilai</th>
                                        <th class="px-4 py-2 border-t border-b border-r border-gray-200 rounded-tr-lg text-sm">Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($quizHistories as $history)
                                        @php $quiz = \App\Models\Quiz::find($history->quiz_id); @endphp
                                        <tr class="bg-white hover:bg-gray-50 text-gray-600">
                                            <td class="px-4 py-2 border-b border-l border-gray-200 text-sm">{{ $quiz->title ?? 'Kuis Tidak Ditemukan' }}</td>
                                            <td class="px-4 py-2 border-b border-gray-200 font-medium text-sm {{ $history->nilai < 75 ? 'text-red-500' : 'text-green-500' }}">
                                                {{ $history->nilai }}
                                            </td>
                                            <td class="px-4 py-2 border-b border-r border-gray-200 text-sm">{{ \Carbon\Carbon::parse($history->completed_at)->translatedFormat('d F Y, H:i') }}</td>
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
            @endif
        </div>

        <!-- Sidebar Materi -->
        <div
            class="lg:col-span-1 bg-white lg:mr-2 px-1 border border-gray-200 rounded-md scrollbar-hide"
            :class="{
                'fixed top-20 mt-9 right-0 w-64 max-h-[70vh] shadow-lg z-20 p-4 overflow-y-auto': !isLargeScreen && sidebarOpen,
                'hidden': !isLargeScreen && !sidebarOpen,
                'lg:block lg:max-h-[50vh] lg:overflow-y-auto': isLargeScreen
            }"
            x-transition
            @click.outside="if (!isLargeScreen) sidebarOpen = false">

            <!-- Menu Daftar Materi di sidebar -->
            <h3 class="text-md font-medium text-gray-700 mb-2 text-center mt-4">Daftar Materi</h3>
            @foreach ($course->materi as $index => $materi)
                @php
                    // Materi sudah selesai?
                    $isCompleted = in_array($materi->id, $completedMateriIds);

                    // Materi sebelumnya sudah selesai? (biar gak lompat-lompat)
                    $prevMateriCompleted = $index === 0 ? true : in_array($course->materi[$index - 1]->id, $completedMateriIds);

                    // Materi ini terkunci kalau prevMateriCompleted false
                    $isLocked = !$prevMateriCompleted;
                @endphp

                <div class="group space-y-1">
                    <button
                        @if ($isLocked)
                            disabled
                            class="w-full text-left px-3 py-2 text-sm rounded text-gray-400 cursor-not-allowed"
                        @else
                            @click="selected = '{{ $materi->id }}'; if(window.innerWidth < 1024) sidebarOpen = false"
                            class="w-full text-left px-3 py-2 text-sm rounded hover:bg-gray-100 text-gray-600 transform transition-all duration-300 ease-in-out group-hover:translate-x-1"
                            :class="{ 'bg-gray-100 font-medium text-gray-700': selected === '{{ $materi->id }}' }"
                        @endif
                    >
                        &bull; {{ $materi->judul }}
                    </button>
                </div>
            @endforeach

             @php
                $allowedCategories = ['cyber security', 'siber', 'cybersecurity', 'Cyber Security', 'CyberSecurity', 'Cybersecurity', 'cyber', 'Cyber'];
                $courseCategory = strtolower($course->category->name ?? '');
                $isCyberCategory = in_array($courseCategory, $allowedCategories);
            @endphp

            <!-- Menu Kuis di sidebar -->
                <hr class="my-2">
                <div class="group">
                    <button
                        @if (!$allMateriCompleted)
                            disabled
                            class="w-full flex text-sm text-left px-3 py-2 rounded text-gray-400 cursor-not-allowed items-center"
                        @else
                            @click="selected = 'quiz'; if(window.innerWidth < 1024) sidebarOpen = false"
                            class="w-full flex text-sm text-left px-3 py-2 rounded hover:bg-gray-100 items-center text-gray-600"
                            :class="{ 'bg-gray-100 font-medium text-gray-700': selected === 'quiz' }"
                        @endif
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor"
                            class="w-5 h-5 transform transition-all duration-300 ease-in-out group-hover:translate-x-1">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                        </svg>
                        <span class="ml-1">Kuis</span>
                    </button>
                </div>

            <!-- Menu Tugas Akhir di sidebar-->
            {{-- @if ($isCyberCategory)
                @if ($finalTask)
                    <hr class="my-2">
                    <div class="group">
                        <button
                            @if (!$allMateriCompleted)
                                disabled
                                class="w-full flex text-sm text-left px-3 py-2 rounded text-gray-400 cursor-not-allowed items-center"
                            @else
                                @click="selected = 'final-task'; if(window.innerWidth < 1024) sidebarOpen = false"
                                class="w-full flex text-sm text-left px-3 py-2 rounded hover:bg-gray-100 items-center text-gray-600"
                                :class="{ 'bg-gray-100 font-medium text-gray-700': selected === 'final-task' }"
                            @endif
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor"
                                class="w-5 h-5 transform transition-all duration-300 ease-in-out group-hover:translate-x-1">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 8.25H7.5a2.25 2.25 0 0 0-2.25 2.25v9a2.25 2.25 0 0 0 2.25 2.25h9a2.25 2.25 0 0 0 2.25-2.25v-9a2.25 2.25 0 0 0-2.25-2.25H15m0-3-3-3m0 0-3 3m3-3V15" />
                            </svg>
                            <span class="ml-1">Tugas Akhir</span>
                        </button>
                    </div>
                @else
                    <div class="flex items-center space-x-2 text-gray-600 mt-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5m6 4.125 2.25 2.25m0 0 2.25 2.25M12 13.875l2.25-2.25M12 13.875l-2.25 2.25M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                        </svg>
                        <p class="text-sm">Tugas akhir belum tersedia</p>
                    </div>
                @endif
            @endif --}}
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
                confirmButtonColor: '#4CAF50',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, mulai kuis',
                cancelButtonText: 'Tidak',
                customClass: {
                    popup: 'text-sm',
                    confirmButton: 'bg-green-400 hover:bg-green-300 text-white rounded-sm px-4 py-2 mx-2',
                    cancelButton: 'bg-red-400 hover:bg-red-300 text-white rounded-sm px-4 py-2 mx-2',
                },
                reverseButtons: true,
                buttonsStyling: false,
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
                cancelButtonText: 'Batal',
                confirmButtonText: 'Ya, kerjakan lagi',
                customClass: {
                    popup: 'text-sm',
                    confirmButton: 'bg-green-400 hover:bg-green-300 text-white rounded-sm px-4 py-2 mx-2',
                    cancelButton: 'bg-red-400 hover:bg-red-300 text-white rounded-sm px-4 py-2 mx-2',
                },
                buttonsStyling: false,
                reverseButtons: true,
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
