<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/jpg" href="storage/logo.png">
    <title>{{ $course->judul ?? 'Kursus' }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Protest+Guerrilla&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">

    <!-- AOS CSS -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Custom Style -->
    <style>
        body {
            font-family: "Poppins", sans-serif !important;
        }
    </style>
</head>
<body class="font-sans dark:text-white/50">
    @include('components.navbar') <!-- Menambahkan Navbar -->

    <!-- Bagian Materi Kursus -->
    <section id="course" class="py-12 bg-white p-6">
        <div class="mb-4 mt-8 md:mt-10">
            <h3 class="text-xl md:text-3xl font-['Roboto'] font-bold text-center text-[#08072a]" data-aos="fade-up">
                Daftar Kursus Yang Tersedia
            </h3>
        </div>

        <!-- Description -->
        <p class="text-lg text-md text-gray-700 text-center mb-6" data-aos="fade-up">
            Kategori : {{ $category->name }}
        </p>
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4" data-aos="zoom-in-down">
                @forelse ($category->courses as $course)
                <!-- container card kursus -->
                <div class="w-72">
                    <a href="{{ route('kursus.detail', $course->slug) }}" class="block bg-white rounded-lg shadow-md hover:shadow-lg transition-transform transform hover:scale-105 h-full">
                        <div class="overflow-hidden h-full flex flex-col">
                            <div class="w-full">
                                <img src="{{ asset('storage/' . $course->image_path) }}" alt="{{ $course->title }}" class="w-full h-36 object-cover">
                            </div>
                            <div class="p-3 flex flex-col flex-grow">
                                <h1 class="text-base font-semibold text-gray-800 mb-1">{{ $course->title }}</h1>
                                <p class="text-sm text-gray-600 mb-1.5 capitalize">
                                    Mentor: {{ $course->mentor ? $course->mentor->name : 'Mentor tidak ditemukan' }}
                                </p>
                                <div class="flex items-center mb-1.5">
                                    <div class="flex">
                                        @for ($i = 0; $i < 5; $i++)
                                            @if ($i < floor($course->average_rating))
                                                <svg class="w-4 h-4 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927a1 1 0 011.902 0l1.715 4.993 5.274.406a1 1 0 01.593 1.75l-3.898 3.205 1.473 4.74a1 1 0 01-1.516 1.11L10 15.347l-4.692 3.783a1 1 0 01-1.516-1.11l1.473-4.74-3.898-3.205a1 1 0 01.593-1.75l5.274-.406L9.049 2.927z"></path>
                                                </svg>
                                            @elseif ($i < ceil($course->average_rating))
                                                <svg class="w-4 h-4" viewBox="0 0 20 20">
                                                    <defs>
                                                        <linearGradient id="half-star-{{ $i }}">
                                                            <stop offset="50%" stop-color="rgb(234,179,8)" />
                                                            <stop offset="50%" stop-color="rgb(209,213,219)" />
                                                        </linearGradient>
                                                    </defs>
                                                    <path fill="url(#half-star-{{ $i }})" d="M9.049 2.927a1 1 0 011.902 0l1.715 4.993 5.274.406a1 1 0 01.593 1.75l-3.898 3.205 1.473 4.74a1 1 0 01-1.516 1.11L10 15.347l-4.692 3.783a1 1 0 01-1.516-1.11l1.473-4.74-3.898-3.205a1 1 0 01.593-1.75l5.274-.406L9.049 2.927z"></path>
                                                </svg>
                                            @else
                                                <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927a1 1 0 011.902 0l1.715 4.993 5.274.406a1 1 0 01.593 1.75l-3.898 3.205 1.473 4.74a1 1 0 01-1.516 1.11L10 15.347l-4.692 3.783a1 1 0 01-1.516-1.11l1.473-4.74-3.898-3.205a1 1 0 01.593-1.75l5.274-.406L9.049 2.927z"></path>
                                                </svg>
                                            @endif
                                        @endfor
                                        <span class="text-yellow-500 text-xs ml-2">{{ number_format($course->average_rating, 1) }} / 5</span>
                                    </div>
                                </div>
                                    @if($course->discounted_price)
                                        @php
                                            $discountPercentage = 100 - (($course->discounted_price / $course->price) * 100);
                                        @endphp
                                        <p class="text-red-500 inline-flex text-sm rounded-xl font-semibold space-x-3">
                                            Rp. {{ number_format($course->discounted_price, 0, ',', '.') }}
                                            <span class="line-through text-gray-400 text-sm ml-2">
                                                Rp. {{ number_format($course->price, 0, ',', '.') }}
                                            </span>
                                            <span class="text-xs ml-2 font-medium text-red-500 p-0.5 bg-red-100 rounded-sm">
                                            - {{ $discountPercentage }}%!
                                            </span>
                                        </p>
                                    @else
                                        <p class="text-gray-700 inline-flex text-sm rounded-xl font-semibold space-x-3">
                                            Rp. {{ number_format($course->price, 0, ',', '.') }}
                                        </p>
                                    @endif 
                            </div>
                        </div>
                    </a>
                </div>
                @empty
                    <p class="col-span-full text-center text-gray-500">
                        Belum ada kursus dalam kategori ini.
                    </p>
                @endforelse
            </div>
        </div>
        
    </section>

    @include('components.footer') <!-- Menambahkan Footer -->

    <!-- AOS JS -->
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        // Initialize AOS animation
        AOS.init({
            duration: 1000, 
            once: true,    
        });
    </script>
</body>
</html>
