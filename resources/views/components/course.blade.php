<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/jpg" href="storage/logo.png">
    @vite('resources/css/app.css')
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Protest+Guerrilla&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;700;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- AOS CSS -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css"/>

    <!-- Custom Style -->
    <style>
        body {
            font-family: "Poppins", sans-serif !important;
        }
    </style>
</head>
<body>
@include('components.navbar') <!-- Menambahkan Navbar -->

<!-- Courses Section -->
<section id="category" class="bg-white py-16 md:mx-12">
    <div class="container mx-auto px-6 mt-7">
        <div class="mb-6 text-center">
            <h3 class="text-xl md:text-2xl font-['poppins'] font-semibold text-[#08072a]" data-aos="fade-up">
                Explorasi Kategori Kursus di Sibermuda
            </h3>
            <p class=" text-lg text-gray-700 mt-2" data-aos="fade-up">
                Temukan berbagai kategori menarik dengan kursus berkualitas untuk meningkatkan keterampilan Anda.
            </p>
        </div>
    <div class="space-y-12 px-6 py-10">
        @foreach($category as $index => $categoryItem)
            @php
            $isEven = $index % 2 === 0;
        @endphp
        <div class="flex flex-col md:flex-row {{ $isEven ? '' : 'md:flex-row-reverse' }} items-center bg-white border border-gray-300 rounded-lg shadow-md overflow-hidden" data-aos="fade-up">
            <!-- Gambar -->
            <div class="md:w-1/2 p-6">
                <img src="{{ asset('storage/' . $categoryItem->image_path) }}" alt="{{ $categoryItem->name }}" class="w-full h-auto md:h-72 object-contain md:object-cover rounded-md shadow-sm" />
            </div>
                            
            <!-- Konten -->
            <div class="md:w-1/2 p-6">
                <h4 class="text-2xl font-semibold text-gray-700 mb-2">{{ $categoryItem->name }}</h4>
                <p class="text-gray-600 mb-4 text-sm">{{ $categoryItem->description }}</p>
                <a href="{{ route('category.detail', $categoryItem->slug) }}" class="inline-block bg-[#08072a] text-sm text-white px-6 py-2 rounded-md shadow-md hover:bg-opacity-90 transition-transform duration-300 ease-in-out transform hover:scale-105">
                    Lihat Kursus
                </a>
            </div>
        </div>
        @endforeach
    </div>                          
    </div>
    <style>
        /* Tailwind Custom CSS untuk menyembunyikan scrollbar */
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        /* Animasi hover untuk card */
        .course-card:hover {
            transform: scale(1.05); 
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }
    </style>
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

<!-- Swiper JS untuk slider card mentor -->
<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
</body>
</html>