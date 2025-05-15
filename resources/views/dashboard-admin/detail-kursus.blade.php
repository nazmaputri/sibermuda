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
        <div class="md:ml-4 md:w-2/3 w-full mt-1 space-y-1">
            <h2 class="text-lg font-semibold text-gray-700 mb-2 capitalize">{{ $course->title }}</h2>
            <p class="text-gray-700 mb-2 text-sm">{{ $course->description }}</p>
                <div class="flex flex-wrap">
                    <span class="w-24 text-sm text-gray-700">Mentor</span><span class="mr-1">:</span>
                    <span class="text-gray-700 text-sm">{{ Str::limit($course->mentor->name ?? 'Tidak Ada Mentor', 25, '...') }}</span>
                </div>
                <div class="flex flex-wrap">
                    <span class="w-24 text-sm text-gray-700">Harga</span><span class="mr-1">:</span>
                    <span class="text-gray-700 text-sm">Rp {{ number_format($course->price, 0, ',', '.') }}</span>
                </div>
                <div class="flex flex-wrap">
                    <span class="w-24 text-sm text-gray-700">Masa Aktif</span><span class="mr-1">:</span>
                    <span class="text-gray-700 text-sm">{{ $course->duration }}</span>
                </div>
            <!-- <p class="text-gray-600 text-sm">Kapasitas : {{ $course->capacity }} peserta</p>  -->
            <!-- <p class="text-gray-600 text-sm">Tanggal Mulai : {{ $course->start_date }}</p> -->
        </div>
    </div>

    <!-- Silabus -->
    <div class="mt-10">
        <h3 class="text-md font-semibold text-gray-700 mb-6 border-b-2 border-gray-300 pb-2">Materi Kursus</h3>
        <div class="space-y-6">
            @if($course->materi->isEmpty())
                <div class="col-span-full text-center items-center justify-center flex flex-col">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 mb-1 text-gray-600">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5m6 4.125 2.25 2.25m0 0 2.25 2.25M12 13.875l2.25-2.25M12 13.875l-2.25 2.25M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                    </svg>
                    <p class="text-gray-600 text-center text-sm">Belum ada materi untuk kursus ini.</p>
                </div>
            @else
            @foreach($course->materi as $materi)
            <div class="bg-white border border-gray-200 p-2.5 rounded-lg shadow-sm">
                <div x-data="{ open: false }">
                    <!-- Judul Materi dengan Toggle Dropdown -->
                    <div @click="open = !open" class="flex justify-between items-center cursor-pointer">
                        <!-- Menambahkan nomor urut di sebelah kiri judul -->
                        <span class="text-gray-700 text-sm font-medium mr-2">
                            {{ sprintf('%02d', $loop->iteration) }}.
                        </span>
                        
                        <h4 class="text-sm font-medium text-gray-700 flex-1 capitalize">{{ $materi->judul }}</h4>
                                                
                        <!-- Tombol Toggle -->
                        <svg :class="open ? 'transform rotate-180' : ''" class="w-5 h-5 text-gray-600 transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>

                    <!-- Deskripsi Materi -->
                    <p class="text-gray-700 text-sm mb-2 mt-2" x-show="open" x-transition>{{ $materi->deskripsi }}</p>

                    <!-- Video (Tampilkan hanya jika open adalah true) -->
                    <div x-show="open" x-transition>
                        @if($materi->videos->isEmpty() && $materi->youtube->isEmpty())
                        <p class="text-gray-700 text-sm">Tidak ada video untuk materi ini.</p>
                        @else
                            <ul class="mt-4 space-y-4">
                                {{-- Google Drive Videos --}}
                                @foreach ($materi->videos as $video)
                                    <li class="bg-gray-100 p-4 rounded-lg shadow-sm">
                                        <h3 class="font-medium text-sm text-gray-700 mb-1.5">{{ $video->title ?: 'Tidak ada judul video' }}</h3>
                                        @if ($video->link)
                                            <iframe
                                                src="https://drive.google.com/file/d/{{ $video->link }}/preview"
                                                width="100%" height="480"
                                                allow="autoplay"
                                                allowfullscreen
                                                class="rounded-lg shadow-sm">
                                            </iframe>
                                        @else
                                            <p class="text-gray-700 text-sm">Video Google Drive tidak tersedia.</p>
                                        @endif
                                        <p class="text-gray-600 text-sm mt-1.5">{{ $video->description ?: 'Tidak ada deskripsi video G-drive' }}</p>
                                    </li>
                                @endforeach
            
                                {{-- YouTube Videos --}}
                                @foreach ($materi->youtube as $yt)
                                    <li class="bg-gray-100 p-4 rounded-lg shadow-sm">
                                        <h3 class="font-semibold text-gray-700 text-sm mb-1.5">{{ $yt->title ?: 'Tidak ada judul video' }}</h3>
                                        @if ($yt->link)
                                            <iframe
                                                width="100%" height="480"
                                                src="https://www.youtube.com/embed/{{ $yt->link }}"
                                                frameborder="0"
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                allowfullscreen
                                                class="rounded-lg shadow-sm">
                                            </iframe>
                                        @else
                                            <p class="text-gray-700 text-sm">Video YouTube tidak tersedia.</p>
                                        @endif
                                        <p class="text-gray-700 text-sm mt-1.5">{{ $yt->description ?: 'Tidak ada deskripsi video Youtube' }}</p>
                                    </li>
                                @endforeach
                            </ul>
                    @endif                             
                    </div>
                </div>
            </div>
            @endforeach
            @endif
        </div>

        @php
            $catName = strtolower($course->category->name ?? '');
            $isCyber = in_array($catName, ['cyber security', 'siber', 'cybersecurity', 'cyber']);
        @endphp

        <!-- Tugas Akhir atau Kuis -->
        <div class="mt-8">
            <h3 class="text-lg font-semibold text-gray-700 mb-6 border-b-2 border-gray-300 pb-2">
                @if($isCyber)
                    Tugas Akhir
                @else
                    Kuis
                @endif
            </h3>

            @if($isCyber)
                @if(empty($course->finalTask))
                <div class="col-span-full text-center items-center justify-center flex flex-col">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 mb-1 text-gray-600">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5m6 4.125 2.25 2.25m0 0 2.25 2.25M12 13.875l2.25-2.25M12 13.875l-2.25 2.25M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                    </svg>
                    <p class="text-gray-600 text-center text-sm">Belum ada tugas akhir untuk kursus ini.</p>
                </div>
                @else
                    <div x-data="{ open: false }" class="bg-white p-2.5 rounded-lg shadow-sm border border-gray-200">
                        <!-- Judul Tugas Akhir -->
                        <div @click="open = !open" class="flex justify-between items-center cursor-pointer">
                            <span class="text-gray-700 text-sm font-semibold mr-2">
                                01.
                            </span>
                            <span class="flex-1 text-sm font-semibold text-gray-700 capitalize">{{ $course->finalTask->judul }}</span>
                            <svg :class="open ? 'transform rotate-180' : ''" class="w-5 h-5 text-gray-600 transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>

                        <!-- Deskripsi Tugas Akhir -->
                        <div x-show="open" x-transition class="mt-3 text-sm text-gray-700">
                            <p><span class="font-semibold">Deskripsi:</span> {{ $course->finalTask->desc ?: 'Tidak ada deskripsi' }}</p>
                        </div>
                    </div>
                @endif
            @else
                @if($course->quizzes->isEmpty())
                <div class="col-span-full text-center items-center justify-center flex flex-col">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 mb-1 text-gray-600">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5m6 4.125 2.25 2.25m0 0 2.25 2.25M12 13.875l2.25-2.25M12 13.875l-2.25 2.25M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                    </svg>
                    <p class="text-gray-600 text-center text-sm">Belum ada kuis untuk kursus ini.</p>
                </div>
                @else
                    <div class="space-y-4">
                        @foreach($course->quizzes as $quiz)
                            <div x-data="{ open: false }" class="bg-white p-2.5 rounded-lg shadow-sm border border-gray-200">
                                <!-- Judul Kuis -->
                                <div @click="open = !open" class="flex justify-between items-center cursor-pointer">
                                    <!-- Menambahkan nomor urut di sebelah kiri judul -->
                                    <span class="text-gray-700 text-sm font-semibold mr-2">
                                        {{ sprintf('%02d', $loop->iteration) }}.
                                    </span>
                                    <span class="flex-1 text-sm font-semibold text-gray-700 capitalize">{{ $quiz->title }}</span>
                                    <svg :class="open ? 'transform rotate-180' : ''" class="w-5 h-5 text-gray-600 transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>

                                <!-- Detail Kuis -->
                                <div x-show="open" x-transition class="mt-3 text-sm text-gray-700 space-y-2">
                                    <div class="flex flex-wrap">
                                        <span class="w-24 text-sm text-gray-700">Deskripsi</span><span class="mr-1">:</span>
                                        <span class="text-gray-700 text-sm">{{ $quiz->description ?: 'Tidak ada deskripsi' }}</span>
                                    </div>
                                    <div class="flex flex-wrap">
                                        <span class="w-24 text-sm text-gray-700">Durasi</span><span class="mr-1">:</span>
                                        <span class="text-gray-700 text-sm">{{ $quiz->duration }} menit</span>
                                    </div>
                                    <div class="flex flex-wrap">
                                        <span class="w-24 text-sm text-gray-700">Total Soal</span><span class="mr-1">:</span>
                                        <span class="text-gray-700 text-sm">{{ $quiz->questions->count() }} soal</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
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
                            <td class="py-2 px-4 text-gray-600 text-sm border-b border-gray-200">{{ Str::limit($participant->user->name, 30, '...') }}</td>
                            <td class="py-2 px-4 text-gray-600 text-sm border-b border-gray-200">{{ $participant->user->email }}</td>
                            <td class="py-2 px-2 text-center text-sm border-b border-r border-gray-200">
                                @php
                                    $statusClass = '';
                                    $statusLabel = '';
                                    
                                    // Menentukan status dan kelas warna berdasarkan status
                                    if ($participant->status == 'pending') {
                                        $statusClass = 'bg-yellow-200/50 border-yellow-300 text-yellow-500';
                                        $statusLabel = 'Pending';
                                    } elseif ($participant->status == 'success') {
                                        $statusClass = 'bg-green-200/50 border-green-300 text-green-500';
                                        $statusLabel = 'Success';
                                    } elseif ($participant->status == 'paid') {
                                        $statusClass = 'bg-red-200/50 border-red-300 text-red-500';
                                        $statusLabel = 'Paid';
                                    }
                                @endphp
                                <span class="inline-block max-w-[120px] px-2 py-0.5 rounded-xl border-2 text-center 
                                    {{ $statusClass }}">
                                    {{ $statusLabel }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="py-2 text-center text-sm text-gray-600 border-l border-b border-r border-gray-200">Belum ada peserta terdaftar.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                </div>
            </div> 
            <div class="mt-4">
                {{ $participants->links() }}
            </div>
    </div>
@endsection
