@extends('layouts.dashboard-peserta')
@section('title', 'Detail Kursus')
@section('content')

<div class="mb-3 flex justify-start">
    <a href="{{ route('kategori-peserta') }}" class=" text-midnight font-semibold p-1 bg-white border border-gray-200 rounded-full transition-transform duration-300 ease-in-out transform hover:scale-105"> <!-- route awalnya : {{ route('categories-detail', ['id' => $category->id]) }} -->
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
    </svg>
    </a>           
</div>

<div class="bg-white p-8 rounded-lg shadow-md border border-gray-200">
    <!-- container detail kursus -->
    <div class="flex flex-col sm:flex-row mb-4 space-y-4 sm:space-y-0 sm:space-x-4">
        <div class="w-full lg:w-1/3">
            <img src="{{ asset('storage/' . $course->image_path) }}" alt="{{ $course->title }}" class="rounded-lg w-full h-auto">
        </div>
        <div class="w-full md:2/3 space-y-1">
            @if(!empty($course->title))
                <h2 class="text-md font-semibold text-gray-700 mb-2 capitalize">{{ $course->title }}</h2>
            @endif
        
            @if(!empty($course->description))
                <p class="text-gray-700 mb-2 text-sm">{{ $course->description }}</p>
            @endif
        
            <div class="space-y-2 text-sm text-gray-600">
                @if(!empty($course->mentor->name))
                    <div class="flex flex-wrap">
                        <span class="w-20">Mentor</span><span class="mr-1">:</span>
                        <span class="capitalize">{{ $course->mentor->name }}</span>
                    </div>
                @endif

                @if(!empty($course->start_date))
                    <div class="flex flex-wrap">
                        <span class="w-20">Tanggal Mulai</span><span class="mr-1">:</span>
                        <span>{{ \Carbon\Carbon::parse($course->start_date)->translatedFormat('d F Y') }}</span>
                    </div>
                @endif

                @if(!empty($course->duration))
                    <div class="flex flex-wrap">
                        <span class="w-20">Masa Aktif</span><span class="mr-1">:</span>
                        <span>{{ $course->duration }}</span>
                    </div>
                @endif
            </div>


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
                :class="open ? 'border-gray-700' : 'border-gray-200'" class="bg-white border border-gray-200 p-3 rounded-lg shadow-sm">
                    <div>
                        <div @click="open = !open" class="flex justify-between items-center cursor-pointer">
                            <span class="text-gray-700 font-semibold mr-2 text-sm">{{ sprintf('%02d', $loop->iteration) }}.</span>
                            <h4 class="text-sm font-medium text-gray-700 flex-1 capitalize">{{ $materi->judul }}</h4>
                            <svg :class="open ? 'transform rotate-180' : ''" class="w-5 h-5 transition-transform duration-300 ease-in-out text-gray-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>

                        <div 
                            x-show="open"
                            x-transition
                            class="mt-2"
                        >
                            <p class="text-gray-700 mb-2 text-sm">{{ $materi->deskripsi }}</p>

                            <ul class="space-y-3">
                                {{-- G-Drive Videos --}}
                                @foreach($materi->videos as $index => $video)
                                    <li class="text-sm text-gray-700">
                                        <div class="flex items-center space-x-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 text-green-500 flex-shrink-0">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                            </svg>
                                            <h4 class=" text-gray-700 flex-1">{{ $video->title }}</h4>
                                            <!-- @if ($video->link)
                                            <iframe 
                                                src="https://drive.google.com/file/d/{{ $video->link }}/preview" 
                                                width="100%" 
                                                height="250" 
                                                allow="autoplay" 
                                                allowfullscreen 
                                                class="rounded-lg shadow-md">
                                            </iframe>
                                            @else
                                            <p class="text-red-500">Video tidak tersedia.</p>
                                            @endif 
                                            <p class="font-medium mt-3 text-gray-700">{{ $video->description }}</p> -->
                                        </div>
                                    </li>
                                @endforeach

                                {{-- YouTube Videos --}}
                                @foreach ($materi->youtube as $index => $youtube)
                                    <li class="text-sm text-gray-700">
                                            <div class="flex items-center space-x-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 text-green-500 flex-shrink-0">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                </svg>
                                                <h3 class=" text-gray-700 flex-1">{{ $youtube->title }}</h3>
                                                <!-- @if ($youtube->link)
                                                    <iframe
                                                        width="100%" height="250"
                                                        src="https://www.youtube.com/embed/{{ $youtube->link }}"
                                                        frameborder="0"
                                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                        allowfullscreen
                                                        class="rounded-lg shadow-md">
                                                    </iframe>
                                                    <p class="text-gray-600 mt-2">{{ $youtube->description ?: 'Tidak ada deskripsi video' }}</p>
                                                @else
                                                    <p class="text-red-500">Video YouTube tidak tersedia.</p>
                                                @endif -->
                                            </div>
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
        <div id="rating-list" class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($rating as $r)
                <div class="bg-white border border-gray-200 p-4 rounded-lg">
                    <div class="flex items-center space-x-4">
                        <img src="{{ $r->user->profile_photo ? asset('storage/' . $r->user->profile_photo) : asset('storage/default-profile.jpg') }}" 
                            alt="User Profile" class="w-6 h-6 rounded-full object-cover">
                        <div>
                            <h4 class="text-sm font-medium text-gray-700">{{ $r->user->name }}</h4>
                            <span class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($r->created_at)->format('d F Y') }}</span>
                        </div>
                    </div>
                    <div class="flex items-center space-x-1 mt-2">
                        @for ($i = 0; $i < 5; $i++)
                            <span class="{{ $i < $r->stars ? 'text-yellow-500' : 'text-gray-300' }}">&starf;</span>
                        @endfor
                    </div>
                    <p class="text-gray-600 text-sm mt-2">{{ $r->comment }}</p>
                </div>
            @endforeach
        </div>

        @if($totalCount > 3)
            <div class="text-center mt-4">
                <button id="load-more-btn"
                    data-offset="3"
                    data-course="{{ $id }}"
                    class="px-4 py-2 text-sm bg-white text-midnight hover:text-white hover:bg-midnight border border-midnight rounded shadow-md transition-transform duration-300 ease-in-out transform hover:scale-105">
                    Tampilkan Lagi
                </button>
            </div>
        @endif
    @endif
    </div>
</div>

<script>
document.getElementById('load-more-btn')?.addEventListener('click', function() {
    const btn = this;
    const offset = parseInt(btn.dataset.offset);
    const courseId = btn.dataset.course;

    fetch("{{ route('rating.loadMore') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ offset: offset, course_id: courseId })
    })
    .then(res => res.json())
    .then(data => {
        if (data.html.trim() !== '') {
            document.getElementById('rating-list').insertAdjacentHTML('beforeend', data.html);
            btn.dataset.offset = offset + 3;

            // Sembunyikan tombol jika sudah semua
            if ((offset + 3) >= {{ $totalCount }}) {
                btn.style.display = 'none';
            }
        } else {
            btn.style.display = 'none';
        }
    })
    .catch(err => console.error(err));
});
</script>
@endsection
