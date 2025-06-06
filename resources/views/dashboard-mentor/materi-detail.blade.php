@extends('layouts.dashboard-mentor')
@section('title', 'Detail Materi')
@section('content')

<div class="mb-3 flex justify-start">
    <a href="{{ route('courses.show', $course->slug) }}" class="text-midnight font-semibold p-1 bg-white border border-gray-200 rounded-full transition-transform duration-300 ease-in-out transform hover:scale-105">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
        </svg>
    </a>
</div>

<div class="container mx-auto">
<!-- Card Wrapper -->
<div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">

    <!-- Judul Halaman -->
    <h1 class="text-lg text-center text-gray-700 font-semibold mb-4 border-b-2 pb-2 capitalize">Detail Materi : {{ $materi->judul }}</h1>

    <!-- Nama Kursus -->
    <p class="mt-2 text-gray-700 text-sm"><span class="font-medium">Kursus :</span> {{ $materi->course->title ?? 'Kursus tidak tersedia' }}</p>

    <!-- Detail Materi -->
    <p class="text-gray-700 text-sm">{{ $materi->deskripsi ?? 'Tidak ada deskripsi' }}</p>

    <!-- Video Section -->
    <div class="mt-2">

        @if($materi->videos->isEmpty() && $materi->youtube->isEmpty())
            <p class="text-gray-700 text-sm font-medium">Tidak ada video untuk materi ini.</p>
        @else
            <div class="space-y-4 text-sm">
                {{-- Google Drive Videos --}}
                @if ($materi->videos->isNotEmpty())
                    <div>
                        <h2 class="text-sm font-medium text-gray-700 mb-2">Video G-Drive</h2>
                        <div class="grid grid-cols-1 gap-4">
                            @foreach ($materi->videos as $video)
                                <div x-data="{ open: false }" 
                                :class="open ? 'border-midnight' : 'border-gray-200'" 
                                class="bg-white border rounded-lg p-2.5 flex flex-col self-start transition-colors duration-300">
                                    <div @click="open = !open" class="flex items-center justify-between cursor-pointer">
                                    <div class="flex items-center space-x-2">
                                        <span class="text-gray-700 font-medium">{{ $loop->iteration }}.</span>
                                        <h3 class="text-sm font-medium text-gray-700">{{ $video->title ?: 'Tidak ada judul video' }}</h3>
                                    </div>
                                        <svg :class="{ 'rotate-180': open }" class="w-5 h-5 text-gray-400 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>
                                    <div x-show="open" x-collapse class="mt-4 overflow-hidden">
                                        @if ($video->link)
                                            <iframe
                                                src="https://drive.google.com/file/d/{{ $video->link }}/preview"
                                                width="100%" height="480"
                                                allow="autoplay"
                                                allowfullscreen
                                                class="rounded-lg shadow-md">
                                            </iframe>
                                        @else
                                            <p class="text-red-500 text-sm">Video Google Drive tidak tersedia.</p>
                                        @endif
                                        <p class="text-gray-700 mt-2 text-sm">{{ $video->description ?: 'Tidak ada deskripsi video' }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- YouTube Videos --}}
                @if ($materi->youtube->isNotEmpty())
                    <div>
                        <h2 class="text-sm font-medium text-gray-700 mb-2">Video YouTube</h2>
                        <div class="grid grid-cols-1 gap-4">
                            @foreach ($materi->youtube as $yt)
                                <div x-data="{ open: false }" 
                                :class="open ? 'border-midnight' : 'border-gray-200'" 
                                class="bg-white border rounded-lg p-2.5 flex flex-col self-start transition-colors duration-300" >
                                    <div @click="open = !open" class="flex items-center justify-between cursor-pointer">
                                    <div class="flex items-center space-x-2">
                                        <span class="text-gray-700 font-medium">{{ $loop->iteration }}.</span>
                                        <h3 class="text-sm font-medium text-gray-700">{{ $yt->title ?: 'Tidak ada judul video' }}</h3>
                                    </div>
                                        <svg :class="{ 'rotate-180': open }" class="w-5 h-5 text-gray-400 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>
                                    <div x-show="open" x-collapse class="mt-4 overflow-hidden">
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
                                            <p class="text-red-500 text-sm">Video YouTube tidak tersedia.</p>
                                        @endif
                                        <p class="text-gray-700 mt-2 text-sm">{{ $yt->description ?: 'Tidak ada deskripsi video' }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        @endif
    </div>
</div>
</div>

<!-- Modal Popup -->
<div id="deleteModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center hidden z-[1000]">
    <div class="bg-white p-5 rounded-lg shadow-lg w-96 mx-4">
        <h2 class="text-lg text-gray-700 text-center font-semibold mb-2">Konfirmasi Hapus</h2>
        <p class="text-gray-600 text-center mb-4">Apakah Anda yakin ingin menghapus kuis ini?</p>
        <div class="flex justify-center space-x-2">
            <button onclick="closeDeleteModal()" class="px-4 py-2 bg-sky-400 text-white hover:bg-sky-300 rounded-md">Batal</button>
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-400 hover:bg-red-300  text-white rounded-md">Hapus</button>
            </form>
        </div>
    </div>
</div>

<script>
    //untuk membuka/menutup popup konfirmasi penghapusa data
    function openDeleteModal(url) {
        document.getElementById('deleteForm').action = url;
        document.getElementById('deleteModal').classList.remove('hidden');
    }
    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }
</script>

@endsection
