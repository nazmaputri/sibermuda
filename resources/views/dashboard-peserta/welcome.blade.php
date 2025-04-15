@extends('layouts.dashboard-peserta')
@section('content')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow-md border border-gray-200 p-5 flex items-center">
            <!-- <div class="p-2 bg-red-500 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 640 512" stroke="currentColor" fill="white">
                    <path d="M160 64c0-35.3 28.7-64 64-64L576 0c35.3 0 64 28.7 64 64l0 288c0 35.3-28.7 64-64 64l-239.2 0c-11.8-25.5-29.9-47.5-52.4-64l99.6 0 0-32c0-17.7 14.3-32 32-32l64 0c17.7 0 32 14.3 32 32l0 32 64 0 0-288L224 64l0 49.1C205.2 102.2 183.3 96 160 96l0-32zm0 64a96 96 0 1 1 0 192 96 96 0 1 1 0-192zM133.3 352l53.3 0C260.3 352 320 411.7 320 485.3c0 14.7-11.9 26.7-26.7 26.7L26.7 512C11.9 512 0 500.1 0 485.3C0 411.7 59.7 352 133.3 352z"/>
                </svg>
            </div> -->
            <div class="ml-4">
                <h2 class="text-md font-semibold text-gray-700">Total Kursus Yang Diikuti</h2>
                <p class="text-2xl font-bold text-midnight">0</p>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md border border-gray-200 p-5 flex items-center">
            <!-- <div class="p-2 bg-red-500 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 640 512" stroke="currentColor" fill="white">
                    <path d="M160 64c0-35.3 28.7-64 64-64L576 0c35.3 0 64 28.7 64 64l0 288c0 35.3-28.7 64-64 64l-239.2 0c-11.8-25.5-29.9-47.5-52.4-64l99.6 0 0-32c0-17.7 14.3-32 32-32l64 0c17.7 0 32 14.3 32 32l0 32 64 0 0-288L224 64l0 49.1C205.2 102.2 183.3 96 160 96l0-32zm0 64a96 96 0 1 1 0 192 96 96 0 1 1 0-192zM133.3 352l53.3 0C260.3 352 320 411.7 320 485.3c0 14.7-11.9 26.7-26.7 26.7L26.7 512C11.9 512 0 500.1 0 485.3C0 411.7 59.7 352 133.3 352z"/>
                </svg>
            </div> -->
            <div class="ml-4">
                <h2 class="text-md font-semibold text-gray-700">Total Materi Diselesaikan</h2>
                <p class="text-2xl font-bold text-midnight">0</p>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-md border border-gray-200 p-5 flex items-center">
            <!-- <div class="p-2 bg-red-500 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 640 512" stroke="currentColor" fill="white">
                    <path d="M160 64c0-35.3 28.7-64 64-64L576 0c35.3 0 64 28.7 64 64l0 288c0 35.3-28.7 64-64 64l-239.2 0c-11.8-25.5-29.9-47.5-52.4-64l99.6 0 0-32c0-17.7 14.3-32 32-32l64 0c17.7 0 32 14.3 32 32l0 32 64 0 0-288L224 64l0 49.1C205.2 102.2 183.3 96 160 96l0-32zm0 64a96 96 0 1 1 0 192 96 96 0 1 1 0-192zM133.3 352l53.3 0C260.3 352 320 411.7 320 485.3c0 14.7-11.9 26.7-26.7 26.7L26.7 512C11.9 512 0 500.1 0 485.3C0 411.7 59.7 352 133.3 352z"/>
                </svg>
            </div> -->
            <div class="ml-4">
                <h2 class="text-md font-semibold text-gray-700">Total Sertifikat</h2>
                <p class="text-2xl font-bold text-midnight">0</p>
            </div>
        </div>
    </div>

<div class="bg-white rounded-lg shadow-md border border-gray-200 p-6 mt-7">
    <h2 class="text-md font-semibold mb-5 text-gray-700 border-b-2 pb-2">Kursus Saya</h2>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($courses as $course)
            <div class="bg-white rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300 flex flex-col">
                <!-- Image -->
                <img src="{{ asset('storage/' . $course->image_path) }}" alt="Kursus {{ $course->title }}" class="w-full h-40 object-cover rounded-t-lg">
    
                <!-- Course Content -->
                <div class="px-4 pt-4 pb-1 flex flex-col flex-grow">
                    <div class="flex justify-between items-center mb-2">
                        <!-- Course Title and Rating -->
                        <div>
                            <h3 class="text-md text-gray-700 font-semibold capitalize">{{ $course->title }}</h3>
                            <div class="flex">
                                <!-- Jumlah Rating -->
                                <span class="text-yellow-500 text-sm font-semibold mr-3">{{ number_format($course->average_rating, 1) }}</span>
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
                    <div>
                        <div class="w-full bg-gray-200 rounded-full h-4">
                            <!-- Progress dengan warna gradasi biru -->
                            <div class="h-4 rounded-full" style="width: {{ $course->progress }}%; background: linear-gradient(to right, #87CEEB, #4682B4);"></div>
                        </div>
                        <p class="text-sm text-gray-500 mt-2 text-right">{{ $course->progress }}% completed</p>
                    </div>
                </div>
                <!-- Button -->
                <div class="p-2 mt-auto flex-col sm:flex-row justify-between gap-3">
                    <!-- Button Lanjut Belajar -->
                    <a href="{{ route('study-peserta', ['id' => $course->id]) }}" class="flex-1">
                        <button class="bg-yellow-200/50 mb-4 text-yellow-500 border border-yellow-300 w-full py-2 rounded-lg font-semibold flex items-center justify-center gap-2 hover:text-white hover:bg-yellow-300 transition-colors">
                            Belajar
                        </button>
                    </a>
                
                    <a href="{{ $course->isCompletedForCertificate ? route('certificate-detail', ['courseId' => $course->id]) : '#' }}" 
                        class="flex-1 {{ !$course->isCompletedForCertificate ? 'pointer-events-none' : '' }}">
                         <button class="w-full py-2 rounded-lg font-semibold flex items-center justify-center gap-2 
                             {{ !$course->isCompletedForCertificate ? 'bg-gray-400 text-gray-600 border-gray-600 cursor-not-allowed opacity-50' : 'bg-green-200/50 text-green-500 border border-green-300 hover:bg-green-300 hover:text-white transition-colors group' }}">
                             
                             <!-- SVG Icon with transition effects -->
                             <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 48 48" class="w-5 h-5 transition-all 
                                {{ !$course->isCompletedForCertificate ? 'grayscale opacity-50 cursor-not-allowed' : 'group-hover:fill-white fill-green-500' }}">
                                <path d="M 9.5 7 C 6.47 7 4 9.47 4 12.5 L 4 31.5 C 4 34.53 6.47 37 9.5 37 L 30 37 L 30 35.650391 C 28.75 34.110391 28 32.14 28 30 C 28 25.03 32.03 21 37 21 C 39.83 21 42.36 22.309375 44 24.359375 L 44 12.5 C 44 9.47 41.53 7 38.5 7 L 9.5 7 z M 13.5 15 L 34.5 15 C 35.33 15 36 15.67 36 16.5 C 36 17.33 35.33 18 34.5 18 L 13.5 18 C 12.67 18 12 17.33 12 16.5 C 12 15.67 12.67 15 13.5 15 z M 37 23 A 7 7 0 1 0 37 37 A 7 7 0 1 0 37 23 z M 13.5 26 L 22.5 26 C 23.33 26 24 26.67 24 27.5 C 24 28.33 23.33 29 22.5 29 L 13.5 29 C 12.67 29 12 28.33 12 27.5 C 12 26.67 12.67 26 13.5 26 z M 32 37.480469 L 32 43.980469 C 32 44.790469 32.910312 45.260781 33.570312 44.800781 L 36.429688 42.800781 C 36.769688 42.560781 37.230312 42.560781 37.570312 42.800781 L 40.429688 44.800781 C 41.089687 45.260781 42 44.790469 42 43.980469 L 42 37.480469 C 40.57 38.440469 38.85 39 37 39 C 35.15 39 33.43 38.440469 32 37.480469 z"></path>
                            </svg>
                             Sertifikat
                         </button>
                     </a>                            
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
@endsection
