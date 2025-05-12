@extends('layouts.dashboard-mentor')
@section('title', 'Detail Kuis')
@section('content')

<div class="mb-3 flex justify-start">
    <a href="{{ route('courses.show', ['course' => $course->id]) }}" class="text-midnight font-semibold p-1 bg-white border border-gray-200 rounded-full transition-transform duration-300 ease-in-out transform hover:scale-105">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
        </svg>
    </a>
</div>

<div class="container mx-auto">
    <!-- Card Wrapper untuk Kuis -->
    <div class="bg-white p-6 rounded-lg shadow-lg border border-gray-200">
        <!-- Judul Kuis -->
        <h1 class="text-lg text-gray-700 text-center font-semibold mb-3 border-b-2 pb-2 capitalize">{{ $quiz->title }}</h1>

        <!-- Deskripsi Kuis -->
        <p class="text-gray-700 mb-2 text-sm">
            {{ $quiz->description ?? 'Tidak ada deskripsi untuk kuis ini.' }}
        </p>

        <!-- Durasi Kuis -->
        <p class="text-gray-600 mb-4 text-sm">
            <strong>Durasi :</strong> {{ $quiz->duration }} Menit
        </p>

        <!-- Daftar Soal -->
        @if($quiz->questions->isNotEmpty())
        <div class="grid grid-cols-1 md:grid-cols-1 gap-4">
            @foreach($quiz->questions as $index => $question)
            <div 
                x-data="{ open: false }" 
                :class="open ? 'border-midnight' : 'border-gray-200'" 
                class="bg-white border rounded-lg p-2.5 flex flex-col self-start transition-all duration-300"
            >
                <!-- Header Soal -->
                <div @click="open = !open" class="flex items-center justify-between cursor-pointer">
                     <div class="flex items-start flex-1">
                        <span class="text-sm text-gray-700 font-medium mr-2">{{ $index + 1 }}.</span>
                        <p class="text-sm font-medium text-gray-700 capitalize break-words">{{ $question->question }}</p>
                    </div>
                    <!-- Icon Dropdown -->
                    <svg :class="{ 'rotate-180': open }" class="w-5 h-5 text-gray-400 transition-transform duration-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>

                <!-- Dropdown Content -->
                <div x-show="open" x-collapse class="mt-4 overflow-hidden">
                    <p class="text-sm font-medium text-gray-500 mb-2">Jawaban:</p>
                    <ul class="list-none space-y-2">
                        @foreach($question->answers as $answer)
                        <li class="p-2 border border-gray-200 rounded-md text-sm {{ $answer->is_correct ? 'bg-green-50 text-green-600 font-medium' : 'bg-gray-50 text-gray-600' }}">
                            {{ $answer->answer }}
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <p class="text-gray-500">Belum ada soal yang ditambahkan untuk kuis ini.</p>
        @endif

        <!-- Tombol Kembali -->
        <!-- <div class="mt-6 justify-end flex">
            @if(isset($materiId))
                {{-- Jika sedang membuat kuis biasa --}}
                <a href="{{ route('materi.show', ['courseId' => $course->id, 'materiId' => $materi->id]) }}"
                class="bg-sky-400 hover:bg-sky-300 text-white font-medium py-2 px-4 rounded-lg">
                    Kembali
                </a>
            @else
                {{-- Jika sedang membuat tugas akhir --}}
                <a href="{{ route('courses.show', ['course' => $course->id]) }}"
                class="bg-sky-400 hover:bg-sky-300 text-white font-semibold py-2 px-4 rounded-lg">
                    Kembali
                </a>
            @endif
        </div> -->
    </div>
</div>
@endsection
