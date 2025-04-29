@extends('layouts.dashboard-mentor')
@section('title', 'Detail Jawaban')
@section('content')

<div class="mb-3 flex justify-start">
    <a href="{{ route('finaltask.detail', ['course' => $course->id, 'id' => $finalTask->id]) }}" class="text-midnight font-semibold p-1 bg-white border border-gray-200 rounded-full transition-transform duration-300 ease-in-out transform hover:scale-105">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
        </svg>
    </a>
</div>

<div class="container mx-auto">
    <!-- Final Task Detail -->
    <div class="bg-white rounded-lg shadow p-6 mb-6 border border-gray-200">
        <h1 class="text-lg text-center font-semibold text-gray-700 mb-4 border-b-2">Detail Jawaban Tugas Akhir</h1>
        <div class="space-y-2 text-sm text-gray-700">
        <div class="space-y-2 text-sm text-gray-700">
            <div class="flex flex-wrap">
                <span class="font-semibold w-16 min-w-[0]">Nama</span><span class="mr-1">:</span>
                <span class="">{{ $submission->user->name }}</span>
            </div>
            <div class="flex flex-wrap">
                <span class="font-semibold w-16 min-w-[0]">Judul</span><span class="mr-1">:</span>
                <span class="">{{ $submission->title }}</span>
            </div>
            <div class="flex flex-wrap">
                <span class="font-semibold w-16 min-w-[0]">Deskripsi</span><span class="mr-1">:</span>
                <span class="">{{ $submission->description }}</span>
            </div>
        </div>

        <div class="my-2">
            <div class="flex flex-wrap">
                <span class="font-semibold w-16 min-w-[0]">Foto</span><span class="mr-1">:</span>
            </div>
            
            @if ($submission->photo && count($submission->photo))
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-2">
                    @foreach ($submission->photo as $photoPath)
                        <div>
                            <img src="{{ asset('storage/' . $photoPath) }}" alt="Foto Submission" class="w-full rounded shadow">
                        </div>
                    @endforeach
                </div>
            @else
                <p>Tidak ada foto.</p>
            @endif
        </div>
    </div>
</div>

@endsection