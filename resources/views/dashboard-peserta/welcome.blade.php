@extends('layouts.dashboard-peserta')
@section('title', 'Dashboard')
@section('content')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow-md border border-gray-200 p-5 flex items-center">
            <div class="ml-4">
                <h2 class="text-md font-medium text-gray-700">Hari dan Jam Saat Ini</h2>
                <p id="realtime-clock" class="text-md font-medium text-gray-700">{{ $currentDateTimeFormatted }}</p>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-md border border-gray-200 p-5 flex items-center">
            <div class="ml-4">
                <h2 class="text-md font-medium text-gray-700">Total Kursus Yang Diikuti</h2>
                <p class="text-lg font-medium text-gray-700">{{ $totalKursus }}</p>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-md border border-gray-200 p-5 flex items-center">
            <div class="ml-4">
                <h2 class="text-md font-medium text-gray-700">Total Sertifikat</h2>
                <p class="text-lg font-medium text-gray-700">{{ $totalSertifikat }}</p>
            </div>
        </div>
    </div>

<div class="bg-white rounded-lg shadow-md border border-gray-200 p-6 mt-7">
    <h2 class="text-md font-medium mb-5 text-gray-700 border-b-2 pb-2">Kursus Saya</h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($courses as $course)
            <div class="bg-white rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300 flex flex-col border border-gray-200">
                <!-- Image -->
                <img src="{{ asset('storage/' . $course->image_path) }}" alt="Kursus {{ $course->title }}" class="w-full h-40 object-cover rounded-t-lg">

                <!-- Course Content -->
                <div class="px-4 pt-4 pb-1 flex flex-col flex-grow">
                    <div class="flex justify-between items-center mb-2">
                        <!-- Course Title and Rating -->
                        <div>
                            <h3 class="text-md text-gray-700 font-medium capitalize mb-1">{{ $course->title }}</h3>
                            <div class="flex">
                                <!-- Jumlah Rating -->
                                <span class="text-yellow-500 text-sm font-medium mr-3">{{ number_format($course->average_rating, 1) }}</span>
                                @for ($i = 0; $i < 5; $i++)
                                    @if ($i < floor($course->average_rating)) <!-- Rating Penuh -->
                                        <svg class="w-4 h-4 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927a1 1 0 011.902 0l1.715 4.993 5.274.406a1 1 0 01.593 1.75l-3.898 3.205 1.473 4.74a1 1 0 01-1.516 1.11L10 15.347l-4.692 3.783a1 1 0 01-1.516-1.11l1.473-4.74-3.898-3.205a1 1 0 01.593-1.75l5.274-.406L9.049 2.927z"></path>
                                        </svg>
                                    @elseif ($i < ceil($course->average_rating)) <!-- Rating Setengah -->
                                        <svg class="w-4 h-4" viewBox="0 0 20 20">
                                            <defs>
                                                <linearGradient id="half-star-{{ $i }}">
                                                    <stop offset="50%" stop-color="rgb(234,179,8)" /> <!-- Kuning -->
                                                    <stop offset="50%" stop-color="rgb(209,213,219)" /> <!-- Abu-abu -->
                                                </linearGradient>
                                            </defs>
                                            <path fill="url(#half-star-{{ $i }})" d="M9.049 2.927a1 1 0 011.902 0l1.715 4.993 5.274.406a1 1 0 01.593 1.75l-3.898 3.205 1.473 4.74a1 1 0 01-1.516 1.11L10 15.347l-4.692 3.783a1 1 0 01-1.516-1.11l1.473-4.74-3.898-3.205a1 1 0 01.593-1.75l5.274-.406L9.049 2.927z"></path>
                                        </svg>
                                    @else <!-- Rating Kosong -->
                                        <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927a1 1 0 011.902 0l1.715 4.993 5.274.406a1 1 0 01.593 1.75l-3.898 3.205 1.473 4.74a1 1 0 01-1.516 1.11L10 15.347l-4.692 3.783a1 1 0 01-1.516-1.11l1.473-4.74-3.898-3.205a1 1 0 01.593-1.75l5.274-.406L9.049 2.927z"></path>
                                        </svg>
                                    @endif
                                @endfor
                            </div>
                        </div>
                    </div>
                    <!-- Progress Bar -->
                    <div class="mb-2">
                        <div class="w-full bg-gray-200 rounded-full h-4">
                            <div class="h-4 rounded-full" style="width: {{ $course->progress }}%; background: linear-gradient(to right, #87CEEB, #4682B4);"></div>
                        </div>
                        <p class="text-sm text-gray-500 mt-2 text-right">{{ $course->progress }}% Selesai</p>
                    </div>
                </div>
                <!-- Button -->
                <div class="p-2 mt-auto flex-col sm:flex-row justify-between gap-3">
                    <!-- Button Lanjut Belajar -->
                   <a href="{{ route('study-peserta', ['slug' => $course->slug]) }}" class="flex-1">
                        <button class="bg-white mb-4 text-yellow-500 border border-yellow-300 w-full py-2 rounded-lg font-medium flex items-center justify-center gap-2 hover:text-white hover:bg-yellow-300 transition-colors">
                            Belajar
                        </button>
                    </a>

                    @php
                        $canDownload = $canDownloadCertificates[$course->id] ?? false;
                    @endphp

                    @if ($canDownload)
                        <a href="{{ route('certificate.download', ['courseId' => $course->id]) }}">
                            <button class="w-full py-2 rounded-lg font-medium flex items-center justify-center gap-2 bg-white text-green-500 border border-green-300 hover:bg-green-300 hover:text-white transition-colors">
                                Download Sertifikat
                            </button>
                        </a>
                    @else
                        <div class="relative group w-full">
                            <button
                                class="w-full py-2 rounded-lg font-medium flex items-center justify-center gap-2 bg-white text-gray-500 border border-gray-500 cursor-not-allowed opacity-50"
                                disabled>
                                Sertifikat Tidak Tersedia
                            </button>
                            <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 hidden group-hover:block bg-gray-700 text-white text-xs rounded py-1 px-2 z-10 whitespace-nowrap">
                                Selesaikan kuis
                            </div>
                        </div>
                    @endif

                    {{-- <a href="{{ $canDownloadCertificate ? route('certificate-detail', ['courseId' => $course->id]) : '#' }}"
                        class="flex-1 {{ !$canDownloadCertificate ? 'pointer-events-none' : '' }}">
                         <button class="w-full py-2 rounded-lg font-medium flex items-center justify-center gap-2
                             {{ !$canDownloadCertificate ? 'bg-white text-gray-600 border-gray-600 cursor-not-allowed' : 'bg-white text-green-500 border border-green-300 hover:bg-green-300 hover:text-white transition-colors group' }}">

                             <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" class="w-5 h-5 transition-all
                                 {{ !$canDownloadCertificate ? 'grayscale opacity-50 cursor-not-allowed' : 'group-hover:fill-white fill-green-500' }}">
                                 <path d="M 9.5 7 C 6.47 7 4 9.47 4 12.5 L 4 31.5 C 4 34.53 6.47 37 9.5 37 L 30 37 L 30 35.65 C 28.75 34.11 28 32.14 28 30 C 28 25.03 32.03 21 37 21 C 39.83 21 42.36 22.31 44 24.36 L 44 12.5 C 44 9.47 41.53 7 38.5 7 L 9.5 7 z M 13.5 15 L 34.5 15 C 35.33 15 36 15.67 36 16.5 C 36 17.33 35.33 18 34.5 18 L 13.5 18 C 12.67 18 12 17.33 12 16.5 C 12 15.67 12.67 15 13.5 15 z M 37 23 A 7 7 0 1 0 37 37 A 7 7 0 1 0 37 23 z M 13.5 26 L 22.5 26 C 23.33 26 24 26.67 24 27.5 C 24 28.33 23.33 29 22.5 29 L 13.5 29 C 12.67 29 12 28.33 12 27.5 C 12 26.67 12.67 26 13.5 26 z M 32 37.48 L 32 43.98 C 32 44.79 32.91 45.26 33.57 44.8 L 36.43 42.8 C 36.77 42.56 37.23 42.56 37.57 42.8 L 40.43 44.8 C 41.09 45.26 42 44.79 42 43.98 L 42 37.48 C 40.57 38.44 38.85 39 37 39 C 35.15 39 33.43 38.44 32 37.48 z"></path>
                             </svg>
                             Sertifikat
                         </button>
                     </a> --}}
                </div>
            </div>
        @empty
            <div class="col-span-full text-center items-center justify-center flex flex-col">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 mb-1 text-gray-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5m6 4.125 2.25 2.25m0 0 2.25 2.25M12 13.875l2.25-2.25M12 13.875l-2.25 2.25M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                </svg>
                <p class="text-gray-600 text-center text-sm">Belum ada kursus yang diikuti.</p>
            </div>
        @endforelse
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Ambil waktu dari backend Laravel
        let serverTime = new Date("{{ $currentDateTimeFormatted }}");

        function updateClock() {
            // Tambahkan 1 detik ke waktu server
            serverTime.setSeconds(serverTime.getSeconds() + 1);

            // Format: Senin, 20 April 2025 14:32:45
            const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

            const day = days[serverTime.getDay()];
            const date = serverTime.getDate().toString().padStart(2, '0');
            const month = months[serverTime.getMonth()];
            const year = serverTime.getFullYear();
            const hours = serverTime.getHours().toString().padStart(2, '0');
            const minutes = serverTime.getMinutes().toString().padStart(2, '0');
            const seconds = serverTime.getSeconds().toString().padStart(2, '0');

            const formattedTime = `${day}, ${date} ${month} ${year} ${hours}:${minutes}:${seconds}`;

            document.getElementById('realtime-clock').textContent = formattedTime;
        }

        // Jalankan pertama kali dan update tiap detik
        updateClock();
        setInterval(updateClock, 1000);
    });
</script>

@endsection
