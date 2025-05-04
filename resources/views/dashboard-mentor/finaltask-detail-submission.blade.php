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
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/alpinejs" defer></script>
    @endpush
    
    <div class="bg-white rounded-lg shadow-md p-6 mb-8 border border-gray-200">
    <h1 class="text-lg font-semibold text-gray-700 mb-4 border-b-2 text-center">Detail Jawaban Tugas Akhir</h1>
    
        <div class="space-y-3 text-sm md:text-base text-gray-700">
            <div class="flex flex-wrap items-start text-sm">
                <span class="font-medium w-24">Nama</span><span class="mr-2">:</span>
                <span>{{ $submission->user->name }}</span>
            </div>
            <div class="flex flex-wrap items-start text-sm">
                <span class="font-medium w-24">Judul</span><span class="mr-2">:</span>
                <span>{{ $submission->title }}</span>
            </div>
            <div class="flex flex-wrap items-start text-sm">
                <span class="font-medium w-24">Deskripsi</span><span class="mr-2">:</span>
                <span>{{ $submission->description }}</span>
            </div>
        </div>
    
        <div class="mt-3">
            <div class="flex flex-wrap items-start mb-2">
                <span class="font-medium w-24 text-gray-700 text-sm">Foto</span><span class="mr-2">:</span>
            </div>
    
            @if ($submission->photo && count($submission->photo))
                <div class="space-y-2">
                    @foreach ($submission->photo as $index => $photoPath)
                        <div x-data="{ open: false }">
                            <button 
                                @click="open = true"
                                class="text-blue-500 hover:underline text-sm"
                            >
                                📎 Lihat Foto {{ $index + 1 }}
                            </button>
    
                            <!-- Modal -->
                            <div 
                                x-show="open" 
                                x-transition 
                                class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 px-4"
                                @click="open = false"
                            >
                                <div 
                                    class="bg-white rounded-lg p-4 w-full max-w-3xl mx-auto max-h-[90vh] overflow-auto"
                                    @click.stop
                                >
                                    <img 
                                        src="{{ asset('storage/' . $photoPath) }}" 
                                        alt="Foto Submission" 
                                        class="w-full h-auto rounded shadow"
                                    >
                                    <button 
                                        @click="open = false" 
                                        class="mt-4 w-full py-2 bg-red-500 text-white rounded hover:bg-red-400"
                                    >
                                        Tutup
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500">Tidak ada foto.</p>
            @endif
        </div>
    </div>
    
</div>

@endsection