@extends('layouts.dashboard-peserta')
@section('title', 'Detail Kursus')
@section('content')

<div class="mb-3 flex justify-start">
    <a href="{{ route('kategori-peserta') }}" class=" text-midnight font-semibold p-1 bg-white border border-gray-200 rounded rounded-full transition-transform duration-300 ease-in-out transform hover:scale-105"> <!-- route awalnya : {{ route('categories-detail', ['id' => $category->id]) }} -->
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
    </svg>
    </a>           
</div>

<div class="bg-white p-8 rounded-lg shadow-md border border-gray-200">
    <!-- container detail kursus -->
    <div class="flex flex-col sm:flex-row mb-4 space-y-4 sm:space-y-0 sm:space-x-4">
        <div class="w-full sm:w-1/4 md:w-1/5">
            <img src="{{ asset('storage/' . $course->image_path) }}" alt="{{ $course->title }}" class="rounded-lg w-full h-auto">
        </div>
        <div class="w-full sm:w-2/3 space-y-1">
            @if(!empty($course->title))
                <h2 class="text-md font-semibold text-gray-700 mb-2 capitalize">{{ $course->title }}</h2>
            @endif
        
            @if(!empty($course->description))
                <p class="text-gray-600 mb-2 text-sm">{{ $course->description }}</p>
            @endif
        
            @if(!empty($course->mentor->name))
                <p class="text-gray-600 text-sm capitalize"><span>Mentor :</span> {{ $course->mentor->name }}</p>
            @endif
        
            @if(!empty($course->start_date))
                <p class="text-gray-600 text-sm"><span>Tanggal Mulai :</span>{{ \Carbon\Carbon::parse($course->start_date)->translatedFormat('d F Y') }}</p>
            @endif
        
            @if(!empty($course->duration))
                <p class="text-gray-600 text-sm"><span>Masa aktif :</span> {{ $course->duration }}</p>
            @endif

            @if(!empty($course->price))
                <div class="flex space-x-4">   
                    <p class="text-red-500 inline-flex items-center text-sm rounded-md font-semibold">
                        Rp. {{ number_format($course->price, 0, ',', '.') }}
                    </p>
                    <div class="flex space-x-2 items-center text-center">
                    @if (!$hasPurchased)
                        <!-- Tombol Keranjang -->
                        <form action="{{ route('cart.add', ['id' => $course->id]) }}" method="POST" class="">
                            @csrf
                            <button type="submit" class="flex items-center p-1.5 space-x-2 text-white bg-red-400 rounded-md border hover:bg-red-300">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                                </svg>
                                <span class="text-sm">Keranjang</span>
                            </button>
                        </form>
                    @else
                        <!-- Label Kursus Sudah Dibeli -->
                        <span class="text-sm text-green-700 bg-green-200 rounded-md px-4 cursor-not-allowed">
                            Sudah dibeli
                        </span>
                    @endif
                    </div>
                </div>
            @endif
        </div>        
    </div>
    
    <!-- container materi kursus -->
    <div class="mt-10">
        <h3 class="text-md font-semibold text-gray-700 mb-6 border-b-2 border-gray-300 pb-2">Materi Kursus</h3>
        <div class="space-y-6">
            @if($course->materi->isEmpty())
                <div class="col-span-full text-center items-center justify-center flex flex-col">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 mb-1 text-gray-600">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5m6 4.125 2.25 2.25m0 0 2.25 2.25M12 13.875l2.25-2.25M12 13.875l-2.25 2.25M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                    </svg>
                    <p class="text-gray-600 text-center text-sm">Belum ada materi.</p>
                </div>
            @else
            @foreach($course->materi as $materi)
                <div x-data="{ open: false }" 
                :class="open ? 'border-gray-700' : 'border-gray-200'" class="bg-white border border-gray-200 p-4 rounded-lg shadow-sm">
                    <div>
                        <div @click="open = !open" class="flex justify-between items-center cursor-pointer">
                            <span class="text-gray-700 font-semibold mr-2 text-sm">{{ sprintf('%02d', $loop->iteration) }}.</span>
                            <h4 class="text-sm font-semibold text-gray-700 flex-1 capitalize">{{ $materi->judul }}</h4>
                            <svg :class="open ? 'transform rotate-180' : ''" class="w-5 h-5 transition-transform duration-300 ease-in-out text-gray-600 hover:text-gray-800" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>

                        <div 
                            x-show="open"
                            x-transition
                            class="mt-2"
                        >
                            <p class="text-gray-600 mb-2 text-sm">{{ $materi->deskripsi }}</p>

                            <ul class="space-y-1">
                                @foreach($materi->videos as $index => $video)
                                    <li class="text-sm text-gray-700">
                                        @if($course->is_purchased || ($loop->first && $materi->is_preview))
                                            <button onclick="openModal('modal-{{ $materi->id }}-{{ $index }}')" class="text-blue-600 font-semibold hover:underline">
                                                ▶ {{ $video->judul }}
                                            </button>

                                            <div id="modal-{{ $materi->id }}-{{ $index }}" class="fixed inset-0 hidden z-50 bg-black bg-opacity-75 flex items-center justify-center">
                                                <div class="relative w-full max-w-5xl p-4">
                                                    <video class="w-full h-auto" controls>
                                                        <source src="{{ asset('storage/' . $video->video_url) }}" type="video/mp4">
                                                    </video>
                                                    <button onclick="closeModal('modal-{{ $materi->id }}-{{ $index }}')" class="absolute top-2 right-2 text-white text-xl font-bold">&times;</button>
                                                </div>
                                            </div>
                                        @else
                                            🔒 <span class="text-gray-500">{{ $video->judul }} (Terkunci)</span>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>

                            <script>
                                function openModal(id) {
                                    document.getElementById(id).classList.remove('hidden');
                                    document.getElementById(id).classList.add('flex');
                                }

                                function closeModal(id) {
                                    const modal = document.getElementById(id);
                                    const video = modal.querySelector('video');
                                    video.pause();
                                    video.currentTime = 0;
                                    modal.classList.add('hidden');
                                    modal.classList.remove('flex');
                                }
                            </script>
                        </div>
                    </div>
                </div>
            @endforeach

            @endif
        </div>
    </div>

<!-- Modal Script -->
<script>
    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
        document.getElementById(id).classList.add('flex');
    }

    function closeModal(id) {
        const modal = document.getElementById(id);
        const video = modal.querySelector('video');
        video.pause();
        video.currentTime = 0;
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>

</div>

<!-- Section Ulasan Pengguna -->
<div class="bg-white p-8 rounded-lg shadow-md mt-10 border border-gray-200">
    <h3 class="text-md font-semibold text-gray-700 mb-6 border-b-2 border-gray-300 pb-2">Ulasan Pengguna</h3>
    <!-- card rating -->
    <div class="space-y-6">
    <!-- Jika tidak ada ulasan -->
    @if($rating->isEmpty())
        <div class="col-span-full text-center items-center justify-center flex flex-col">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 mb-1 text-gray-600">
                <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5m6 4.125 2.25 2.25m0 0 2.25 2.25M12 13.875l2.25-2.25M12 13.875l-2.25 2.25M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
            </svg>
            <p class="text-gray-600 text-center text-sm">Belum ada rating.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($rating as $rating)
                <div class="bg-neutral-50 p-4 rounded-lg shadow-md">
                    <div class="flex items-center space-x-4">
                        <img src="{{ $rating->user->profile_photo ? asset('storage/' . $rating->user->profile_photo) : asset('storage/default-profile.jpg') }}" 
                            alt="User Profile" class="w-6 h-6 rounded-full object-cover">
                        <div>
                            <h4 class="text-sm font-semibold text-gray-700">{{ $rating->user->name }}</h4>
                            <span class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($rating->created_at)->format('d F Y') }}</span>
                        </div>
                    </div>
                    <!-- Rating Bintang -->
                    <div class="flex items-center space-x-1">
                        @for ($i = 0; $i < 5; $i++)
                            <span class="{{ $i < $rating->stars ? 'text-yellow-500' : 'text-gray-300' }}">&starf;</span>
                        @endfor
                    </div>
                    <p class="text-gray-600 text-sm">{{ $rating->comment }}</p>
                </div>
            @endforeach
        </div>
    @endif
    </div>

    

</div>
@endsection
