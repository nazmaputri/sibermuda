@extends('layouts.dashboard-admin')
@section('title', 'Detail Kursus')
@section('content')

<!-- Tombol Kembali -->
<div class="flex justify-start mb-2">
    <a href="{{ route('categories.show', $category->id) }}" class="text-midnight font-semibold p-1 bg-white border border-gray-200 rounded-full transition-transform duration-300 ease-in-out transform hover:scale-105 inline-flex items-center">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
        </svg>
    </a>
</div>

<div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
    <!-- Card Informasi Kursus -->
    <div class="flex flex-col lg:flex-row mb-4">
        <div class="w-full lg:w-1/3 mb-4 lg:mb-0">
            <img src="{{ asset('storage/' . $course->image_path) }}" alt="{{ $course->title }}" class="rounded-lg w-80 h-35">
        </div>
        <!-- Informasi Kursus -->
        <div class="ml-4 w-2/3 md:ml-4 mt-1 space-y-1">
            <h2 class="text-md font-semibold text-gray-700 mb-2 capitalize">{{ $course->title }}</h2>
            <p class="text-gray-700 mb-2 text-sm">{{ $course->description }}</p>
            <p class="text-gray-600 text-sm">Mentor : <span class="capitalize">{{ $course->mentor->name }}<span></p>
            <p class="text-gray-600 text-sm">Harga : <span class="text-red-500">Rp {{ number_format($course->price, 0, ',', '.') }}</span></p>
            <p class="text-gray-600 text-sm">Kapasitas : {{ $course->capacity }} peserta</p> 
            <p class="text-gray-600 text-sm">Tanggal Mulai : {{ $course->start_date }}</p>
            <p class="text-gray-600 text-sm">Masa Aktif : {{ $course->duration }}</p>
        </div>
    </div>

    <!-- Silabus -->
    <div class="mt-10">
        <h3 class="text-lg font-semibold text-gray-700 mb-6 border-b-2 border-gray-300 pb-2">Materi Kursus</h3>
        <div class="space-y-6">
            @if($course->materi->isEmpty())
                <p class="text-gray-600 text-center mt-1 text-sm">Kursus ini belum ada materi apapun.</p>
            @else
            @foreach($course->materi as $materi)
            <div class="bg-white border border-gray-200 p-4 rounded-lg shadow-sm">
                <div x-data="{ open: false }">
                    <!-- Judul Materi dengan Toggle Dropdown -->
                    <div @click="open = !open" class="flex justify-between items-center cursor-pointer">
                        <!-- Menambahkan nomor urut di sebelah kiri judul -->
                        <span class="text-gray-700 font-semibold mr-2">
                            {{ sprintf('%02d', $loop->iteration) }}.
                        </span>
                        
                        <h4 class="text-md font-semibold text-gray-700 flex-1 capitalize">{{ $materi->judul }}</h4>
                                                
                        <!-- Tombol Toggle -->
                        <svg :class="open ? 'transform rotate-180' : ''" class="w-5 h-5 text-gray-600 transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>

                    <!-- Deskripsi Materi -->
                    <p class="text-gray-600 mb-2 mt-2" x-show="open" x-transition>{{ $materi->deskripsi }}</p>

                    <!-- Video (Tampilkan hanya jika open adalah true) -->
                    <div x-show="open" x-transition>
                        @if($materi->videos->isEmpty() && $materi->youtube->isEmpty())
                        <p class="text-gray-700">Tidak ada video untuk materi ini.</p>
                        @else
                            <ul class="mt-4 space-y-4">
                                {{-- Google Drive Videos --}}
                                @foreach ($materi->videos as $video)
                                    <li class="bg-gray-100 p-4 rounded-lg shadow-sm">
                                        <h3 class="font-semibold text-gray-800">{{ $video->title }}</h3>
                                        <p class="text-gray-600">{{ $video->description ?: 'Tidak ada deskripsi video' }}</p>
            
                                        @if ($video->link)
                                            <iframe
                                                src="https://drive.google.com/file/d/{{ $video->link }}/preview"
                                                width="100%" height="480"
                                                allow="autoplay"
                                                allowfullscreen
                                                class="rounded-lg shadow-md">
                                            </iframe>
                                        @else
                                            <p class="text-red-500">Video Google Drive tidak tersedia.</p>
                                        @endif
                                    </li>
                                @endforeach
            
                                {{-- YouTube Videos --}}
                                @foreach ($materi->youtube as $yt)
                                    <li class="bg-gray-100 p-4 rounded-lg shadow-sm">
                                        <h3 class="font-semibold text-gray-800">{{ $yt->title }}</h3>
                                        <p class="text-gray-600">{{ $yt->description ?: 'Tidak ada deskripsi video' }}</p>
            
                                        @if ($yt->link)
                                            <iframe
                                                width="100%" height="480"
                                                src="https://www.youtube.com/embed/{{ $yt->link }}"
                                                frameborder="0"
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                allowfullscreen
                                                class="rounded-lg shadow-md">
                                            </iframe>
                                        @else
                                            <p class="text-red-500">Video YouTube tidak tersedia.</p>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                    @endif                             
                    </div>

                    <!-- Kuis -->
                    <div x-show="open" x-transition>
                        {{-- @if($materi->quizzes->count())
                        <div class="mt-4">
                            <h5 class="text-md font-semibold text-gray-800">📝 Kuis</h5>
                                <ul class="list-disc list-inside">
                                    @foreach($materi->quizzes as $quiz)
                                    <li>
                                    <a href="{{ route('quizzes.show', $quiz->id) }}" class="text-sky-400 hover:underline">
                                        {{ $quiz->title }}
                                    </a>
                                    </li>
                                    @endforeach
                                </ul>
                        </div>
                        @else
                            <p class="text-gray-600 mt-4">Belum ada kuis untuk materi ini.</p>
                                @endif --}}
                    </div>
                </div>
            </div>
            @endforeach
            @endif
        </div>
    </div>
</div>

    <!-- Tabel Peserta Terdaftar -->
    <div class="bg-white mt-6 p-6 rounded-lg shadow-md border border-gray-200">
        <h3 class="text-lg font-semibold mb-4 inline-block pb-1 text-gray-700">Peserta Terdaftar</h3>
            <div class="overflow-x-auto">
                <div class="min-w-full w-64">
                <table class="min-w-full border-separate border-spacing-0" id="courseTable">
                    <thead>
                        <tr class="bg-gray-100 text-gray-600 text-sm">
                            <th class="py-2 px-2 border-b border-l border-t border-gray-200  rounded-tl-lg">No</th>
                            <th class="py-2 px-4 border-b border-t border-gray-200">Nama</th>
                            <th class="py-2 px-4 border-b border-t border-gray-200">Email</th>
                            <th class="py-2 border-b border-r border-t border-gray-200  rounded-tr-lg">Status Pembayaran</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($participants as $index => $participant)
                        <tr class="bg-white hover:bg-gray-50 user-row text-sm">
                            <td class="py-2 px-4 text-center text-gray-600 text-sm border-b border-l border-gray-200">{{ $index + 1 }}</td>
                            <td class="py-2 px-4 text-gray-600 text-sm border-b border-gray-200">{{ $participant->user->name }}</td>
                            <td class="py-2 px-4 text-gray-600 text-sm border-b border-gray-200">{{ $participant->user->email }}</td>
                            <td class="py-2 text-center text-green-500 text-sm border-b border-r border-gray-200">{{ $participant->transaction_status }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="py-2 text-center text-sm text-gray-600 border-l border-b border-r border-gray-200">Belum ada peserta terdaftar.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                </div>
                <div class="mt-4">
                    {{ $participants->links() }}
                </div>
            </div> 
    </div>
@endsection
