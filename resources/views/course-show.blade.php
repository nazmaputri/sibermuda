<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/jpg" href="storage/logo.png">
    <title>{{ $course->judul ?? 'Kursus' }}</title>
    @vite('resources/css/app.css')
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Protest+Guerrilla&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- AlphineJs -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- AOS CSS -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
     <!-- Custom Style -->
     <style>
        body {
            font-family: "Poppins", sans-serif !important;
        }
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>
<body>
    @include('components.navbar') 
    
    @if($discount && now()->lt($end_datetime))
        <section id="promo" class="bg-red-600 text-white px-4 py-2 text-center pt-[90px] fixed w-full z-40">
            <div class="max-w-7xl flex flex-col md:flex-row items-center justify-between gap-4 pb-3 mx-2 md:mx-14">
                <!-- Promo text -->
                <div class="text-sm sm:text-base font-medium">
                    Promo Diskon {{ $discount->discount_percentage }}%! <br class="md:hidden" />
                    <span class="font-normal">Berlaku sampai {{ \Carbon\Carbon::parse($discount->end_date)->locale('id')->translatedFormat('d F Y') }}!</span>
                </div>

                <!-- Countdown -->
                <div class="flex items-center gap-2 text-sm sm:text-base font-medium" id="countdown">
                    <span><span id="days">00</span><span class="text-xs font-normal ml-1">Hari</span></span>
                    <span><span id="hours">00</span><span class="text-xs font-normal ml-1">Jam</span></span>
                    <span><span id="minutes">00</span><span class="text-xs font-normal ml-1">Menit</span></span>
                    <span><span id="seconds">00</span><span class="text-xs font-normal ml-1">Detik</span></span>
                </div>

                <!-- Kode Promo -->
                @if($discount->apply_to_all)
                    <div class="flex items-center gap-2">
                        <button class="bg-white text-red-600 font-bold px-3 py-1 rounded hover:bg-gray-100 text-sm">
                            {{ $discount->coupon_code }}
                        </button>
                        <div class="relative inline-block">
                            <button
                                class="bg-sky-500 text-white font-medium px-3 py-1 rounded hover:bg-sky-400 text-sm"
                                onclick="copyToClipboard(this, '{{ $discount->coupon_code }}')">
                                SALIN
                            </button>

                            <div
                                class="absolute left-1/2 translate-x-[-50%] mt-2 px-3 py-1 bg-black text-white text-xs rounded shadow-md opacity-0 pointer-events-none transition-opacity duration-300"
                                id="copy-toast">
                                Disalin!
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </section>

        <!-- JavaScript: Countdown & Hide Section When Done -->
        <script>
            const endDateTime = new Date("{{ $end_datetime->format('Y-m-d H:i:s') }}").getTime();

            const countdownInterval = setInterval(() => {
                const now = new Date().getTime();
                const distance = endDateTime - now;

                if (distance < 0) {
                    clearInterval(countdownInterval);
                    const promoSection = document.getElementById("promo");
                    if (promoSection) {
                        promoSection.style.display = "none"; // Hilangkan section
                    }
                    return;
                }

                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                document.getElementById("days").textContent = String(days).padStart(2, '0');
                document.getElementById("hours").textContent = String(hours).padStart(2, '0');
                document.getElementById("minutes").textContent = String(minutes).padStart(2, '0');
                document.getElementById("seconds").textContent = String(seconds).padStart(2, '0');
            }, 1000);

            function copyToClipboard(button, text) {
                navigator.clipboard.writeText(text).then(() => {
                const toast = button.parentElement.querySelector('#copy-toast');
                toast.classList.remove('opacity-0');
                toast.classList.add('opacity-100');

                setTimeout(() => {
                    toast.classList.remove('opacity-100');
                    toast.classList.add('opacity-0');
                }, 3000);
                });
            }
        </script>
    @endif
    
    <!-- Bagian Materi Kursus -->
    <section id="course" class="py-12 bg-midnight rounded-b-3xl">
        <div class="container mx-auto px-6 lg:px-8 @if($discount && now()->lt($end_datetime))
            md:mt-32 mt-60
        @else
            md:mt-16 mt-10
        @endif">
            <!-- Kontainer Kursus -->
            <div class="flex flex-col lg:flex-row bg-white shadow-lg overflow-hidden border rounded-xl md:mx-4">
                <!-- Detail Kursus -->
                <div class="lg:w-2/3 w-full flex flex-col rounded-xl p-8 text-left">
                    <div>
                        <h2 class="md:text-xl text-md font-semibold text-gray-700 capitalize mb-1 capitalize">{{ $course->title }}</h2>
                        <p class="text-gray-700">{{ $course->description }}</p>
                        <p class="text-gray-600 capitalize">Mentor : {{ $course->mentor->name }}</p>
                        <h3 class="md:text-xl text-md font-semibold text-gray-700 my-2 text-left">Materi</h3>
                        <ul class="divide-y divide-gray-200">
                        @php
                            $maxItems = 10;
                            $totalMateri = $course->materi->count();
                        @endphp

                        @forelse ($course->materi->take($maxItems) as $index => $materi)
                            <li class="flex items-center space-x-4 py-2">
                                <!-- Judul Materi -->
                                <span class="text-sm text-gray-700 capitalize">
                                    {{ $index + 1 }}. {{ $materi->judul }}
                                </span>
                            </li>
                        @empty
                            <li class="py-1 text-sm text-gray-500">
                                belum ada materi untuk kursus ini
                            </li>
                        @endforelse

                        @if ($totalMateri > $maxItems)
                            <li class="py-1 text-sm text-gray-500 italic">
                                dan materi lainnya...
                            </li>
                        @endif
                        </ul>
                        <a href="/">
                            <button class="group bg-blue-400 hover:bg-blue-300 text-white text-sm md:text-md py-2 px-4 rounded-md font-semibold mt-6 flex items-center gap-2 transition-all duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 transform transition-transform duration-300 group-hover:-translate-x-1">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                                </svg>
                                Kembali
                            </button>
                        </a>

                    </div>
                </div>

               <!-- Trailer dan keranjang -->
                <div class="lg:w-1/3 w-full h-full p-6 bg-white border border-gray-300 rounded-lg shadow-md" data-aos="zoom-in">
                    <!-- Cuplikan Video Pembelajaran -->
                    @php
                        $previewMateri = $course->materi->filter(fn($m) => $m->is_preview);
                    @endphp

                    <div>
                        <h3 class="md:text-xl text-md font-semibold text-gray-700 mb-4">Cuplikan Video Pembelajaran</h3>

                        @if($previewMateri->isEmpty())
                            <p class="text-gray-500 text-sm mb-2">Belum ada cuplikan video untuk kursus ini.</p>
                        @else
                            @foreach ($previewMateri as $materi)
                                @php
                                    $driveVid = $materi->videos->first();
                                    // jika video drive tidak ada maka tampilkan video youtube
                                    $ytVid    = $materi->youtube->first();
                                @endphp

                                <div class="mb-6">
                                    @if($driveVid && $driveVid->link)
                                        <iframe
                                            src="https://drive.google.com/file/d/{{ $driveVid->link }}/preview"
                                            width="100%" height="100%"
                                            allow="autoplay"
                                            allowfullscreen
                                            class="rounded-lg shadow-md">
                                        </iframe>
                                    @elseif($ytVid && $ytVid->link)
                                        <iframe
                                            width="100%" height="100%"
                                            src="https://www.youtube.com/embed/{{ $ytVid->link }}"
                                            frameborder="0"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                            allowfullscreen
                                            class="rounded-lg shadow-md">
                                        </iframe>
                                    @else
                                        <p class="text-sm text-gray-500 mb-2">Belum ada cuplikan video untuk kursus ini.</p>
                                    @endif
                                </div>
                            @endforeach
                        @endif
                    </div>
              
                    <!-- Header 3 Teks Sejajar -->
                    <div class="flex space-x-1 items-center mb-4">
                        @if($discount && $discountPercentage > 0 && now()->lt($end_datetime))
                            <span class="font-semibold md:text-2xl text-xl text-red-500">
                                Rp.{{ number_format($discountedPrice, 0, ',', '.') }}
                            </span>
                            <span class="text-sm font-medium text-gray-600 line-through">
                                Rp.{{ number_format($originalPrice, 0, ',', '.') }}
                            </span>
                            <span class="text-xs font-medium text-red-500 p-0.5 bg-red-100 rounded-sm">
                                {{ $discountPercentage }}%!
                            </span>
                        @else
                            <span class="font-semibold md:text-2xl text-xl text-red-500">
                                Rp.{{ number_format($originalPrice, 0, ',', '.') }}
                            </span>
                        @endif
                    </div>
                    <!-- Countdown Diskon -->
                    @if($discount && $end_datetime && now()->lt($end_datetime))
                        @php
                            $remaining = \Carbon\Carbon::now()->diff($end_datetime);
                        @endphp
                        <div class="flex items-center space-x-1 text-red-500 text-sm mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                            </svg>
                            <span>
                                Diskon berlaku <span class="font-semibold">
                                    {{ $remaining->d }} Hari {{ $remaining->h }} Jam {{ $remaining->i }} Menit lagi!
                                </span>
                            </span>
                        </div>
                    @endif

                    <!-- Dua Tombol Vertikal -->
                    <div class="flex flex-col gap-3">
                        <a href="{{ route('beli.kursus', ['slug' => $course->slug]) }}">
                            <button class="w-full bg-blue-400 hover:bg-blue-300 border text-white font-semibold py-2 px-4 rounded-lg flex items-center justify-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" class="w-5 h-5">
                                    <path d="M0 24C0 10.7 10.7 0 24 0L69.5 0c22 0 41.5 12.8 50.6 32l411 0c26.3 0 45.5 25 38.6 50.4l-41 152.3c-8.5 31.4-37 53.3-69.5 53.3l-288.5 0 5.4 28.5c2.2 11.3 12.1 19.5 23.6 19.5L488 336c13.3 0 24 10.7 24 24s-10.7 24-24 24l-288.3 0c-34.6 0-64.3-24.6-70.7-58.5L77.4 54.5c-.7-3.8-4-6.5-7.9-6.5L24 48C10.7 48 0 37.3 0 24zM128 464a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm336-48a48 48 0 1 1 0 96 48 48 0 1 1 0-96z" fill="white"/>
                                </svg>
                                Tambah Ke Keranjang
                            </button>
                        </a>
                        <a href="{{ route('beli.kursus', ['slug' => $course->slug]) }}">
                            <button class="w-full bg-white border border-[#08072a] hover:bg-[#08072a] hover:text-white text-[#08072a] font-semibold py-2 px-4 rounded-lg transition-all duration-300">
                                Beli Sekarang
                            </button>
                        </a>
                    </div>                    
                </div>
            </div>
        </div>        
    </section>

    <!-- Informasi Kursus -->
    <section class="bg-white p-2 md:mx-16">        
        <div class="flex items-center justify-center px-4 mt-2">
            <div class="w-full text-center mt-2 md:mt-8">
                <h2 class="md:text-2xl text-xl font-semibold text-gray-700 mb-2" data-aos="zoom-in">
                    Yuk Beli Kursusnya Sekarang Untuk Akses Materinya!
                </h2>
                <!-- Deskripsi -->
                <p class="text-gray-700 mb-6 px-6 lg:px-20" data-aos="zoom-in">
                    Mari belajar di Sibermuda dan mulai tingkatkan skillmu! Pilih kursus yang kamu butuhkan, 
                    pelajari kapan saja, di mana saja. Nikmati video pembelajaran terstruktur dan modul praktik interaktif yang dirancang oleh para ahli di bidangnya.
                </p>
                {{-- <!-- Button Beli Sekarang -->
                <a href="{{ route('beli.kursus', ['id' => $course->id]) }}">
                    <button class="bg-yellow-300 hover:bg-yellow-200 text-gray-700 font-semibold py-3 px-6 rounded-full text-md shadow-lg shadow-yellow-100 hover:shadow-none" data-aos="zoom-in">
                        Beli Sekarang
                    </button>
                </a> --}}

                <!-- Pop-up Error jika sudah dibeli -->
                @if(session('error'))
                    <div id="popupError" class="fixed top-5 right-5 bg-red-500 text-white px-6 py-4 rounded-lg shadow-lg z-50 animate-bounce">
                        {{ session('error') }}
                    </div>

                    <script>
                        // Hilangkan popup setelah 3 detik
                        setTimeout(function() {
                            const popup = document.getElementById('popupError');
                            if (popup) popup.remove();
                        }, 3000);
                    </script>
                @endif
            </div>
        </div>       
        
        <div class="mt-8 pt-6 px-2 lg:px-2 md:space-y-6 space-y-3">
            <div class="">
                <!-- Judul -->
                <h3 class="text-xl font-semibold text-gray-700 my-4">Yang Akan Didapatkan</h3>
                                
                <!-- Daftar Button -->
                <div class="flex flex-col sm:flex-row sm:space-x-4 space-y-4 sm:space-y-0">
                    <button class="bg-blue-400 hover:bg-blue-300 text-white font-semibold py-2 px-3 rounded-lg text-sm shadow-lg shadow-gray-200 hover:shadow-none flex items-center space-x-2" data-aos="zoom-in-right">
                        <img class="w-6 h-6" style="filter: invert(1);" src="https://img.icons8.com/fluency-systems-regular/50/certificate--v1.png" alt="certificate--v1"/>
                        <span>Sertifikat</span>
                    </button>
                    <button class="bg-blue-400 hover:bg-blue-300 text-white font-semibold py-2 px-3 rounded-lg text-sm shadow-lg shadow-gray-200 hover:shadow-none flex items-center space-x-2" data-aos="zoom-in-right">
                        <img class="w-6 h-6" style="filter: invert(1);" src="https://img.icons8.com/ios-glyphs/30/last-24-hours.png" alt="last-24-hours"/>
                        <span>Akses Materi 24 Jam</span>
                    </button>
                    {{-- <button class="bg-blue-400 hover:bg-blue-300 text-white font-semibold py-2 px-3 rounded-lg text-sm shadow-lg shadow-gray-200 hover:shadow-none flex items-center space-x-2" data-aos="zoom-in-right">
                        <img class="w-6 h-6" style="filter: invert(1);" src="https://img.icons8.com/material-outlined/24/book.png" alt="book"/>
                        <span>Bahan Bacaan</span>
                    </button> --}}
                    <button class="bg-blue-400 hover:bg-blue-300 text-white font-semibold py-2 px-3 rounded-lg text-sm shadow-lg shadow-gray-200 hover:shadow-none flex items-center space-x-2" data-aos="zoom-in-right">
                        <img class="w-6 h-6" style="filter: invert(1);" src="https://img.icons8.com/sf-black/64/cinema-.png" alt="cinema-"/>
                        <span>Video Pembelajaran</span>
                    </button>
                    <button class="bg-blue-400 hover:bg-blue-300 text-white font-semibold py-2 px-3 rounded-lg text-sm shadow-lg shadow-gray-200 hover:shadow-none flex items-center space-x-2" data-aos="zoom-in-right">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 7.5V6.108c0-1.135.845-2.098 1.976-2.192.373-.03.748-.057 1.123-.08M15.75 18H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08M15.75 18.75v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5A3.375 3.375 0 0 0 6.375 7.5H5.25m11.9-3.664A2.251 2.251 0 0 0 15 2.25h-1.5a2.251 2.251 0 0 0-2.15 1.586m5.8 0c.065.21.1.433.1.664v.75h-6V4.5c0-.231.035-.454.1-.664M6.75 7.5H4.875c-.621 0-1.125.504-1.125 1.125v12c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V16.5a9 9 0 0 0-9-9Z" />
                        </svg>
                        <span>Latihan Soal</span>
                    </button>
                </div>                     
            </div> 

            <h3 class="text-xl font-semibold text-gray-700">Rating Kursus</h3>

            @php
                $filteredRatings = $ratings->filter(fn($rating) => $rating->display == 1);
            @endphp

            @if ($filteredRatings->isEmpty())
                <p class="text-gray-500 mt-2 text-sm">Belum ada rating</p>
            @else
                <div class="mt-4">
                    <!-- Swiper Container -->
                    <div class="swiper mySwiper px-8">
                        <div class="swiper-wrapper">
                            @foreach ($filteredRatings as $rating)
                                <div class="swiper-slide min-w-[300px] max-w-[300px] h-[150px] border border-gray-200 rounded-xl p-4 hover:shadow-lg transition-shadow duration-300 ease-in-out" data-aos="zoom-in-up">
                                    <!-- Nama, Foto & Tanggal -->
                                    <div class="flex items-center space-x-2 mb-2">
                                        <img src="{{ $rating->user->photo ? asset('storage/' . $rating->user->photo) : asset('storage/default-profile.jpg') }}" alt="Foto Profil" class="w-6 h-6 rounded-full object-cover">
                                        <div>
                                            <h4 class="text-sm font-semibold text-gray-800">{{ $rating->user->name }}</h4>
                                            <span class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($rating->created_at)->translatedFormat('d F Y') }}</span>
                                        </div>
                                    </div>

                                    <!-- Rating Bintang -->
                                    <div class="flex items-center space-x-1 mb-1">
                                        @for ($i = 0; $i < 5; $i++)
                                            <span class="{{ $i < $rating->stars ? 'text-yellow-500' : 'text-gray-300' }}">&starf;</span>
                                        @endfor
                                    </div>

                                    <!-- Komentar -->
                                    <p class="text-gray-700 text-sm overflow-hidden text-ellipsis line-clamp-3">
                                        {{ $rating->comment }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Navigasi panah manual -->
                    <div class="flex justify-center gap-4 mt-4" data-aos="fade-right">
                        <button class="swiper-button-prev-custom p-2 rounded-full border border-gray-200 bg-white/80 text-midnight hover:bg-gray-100 shadow">
                            <!-- Icon kiri -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>
                        <button class="swiper-button-next-custom p-2 rounded-full border border-gray-200 bg-white/80 text-midnight hover:bg-gray-100 shadow">
                            <!-- Icon kanan -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>
                </div>
            @endif
            </div>
    </section>

@include('components.footer') <!-- Menambahkan Footer -->

<!-- AOS JS -->
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<!-- Swiper CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    // Initialize AOS animation
    AOS.init({
        duration: 1000, 
        once: true,    
    });

    // Inisialisasi Swiper
    document.addEventListener('DOMContentLoaded', function () {
        new Swiper('.mySwiper', {
        slidesPerView: 'auto',
        spaceBetween: 16,
        loop: true,
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
        },
        navigation: {
            nextEl: '.swiper-button-next-custom',
            prevEl: '.swiper-button-prev-custom',
        },
        });
    });
</script>
</body>
</html>
