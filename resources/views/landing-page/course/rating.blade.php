<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/jpg" href="{{ asset('storage/logo.png') }}">
    <title>Testimoni - Sibermuda: Platform Kursus Online</title>

    <meta property="og:title" content="Testimoni - Sibermuda: Platform Kursus Online">
    @vite('resources/css/app.css')

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Protest+Guerrilla&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- AOS CSS -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Custom Style -->
    <style>
        body {
            font-family: "Poppins", sans-serif !important;
        }
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .filter-btn {
            background: white;
            border: 2px solid #e5e7eb;
            color: #6b7280;
            transition: all 0.3s ease;
        }
        .filter-btn.active {
            background: #08072a;
            border-color: #08072a;
            color: white;
        }
        .filter-btn:hover:not(.active) {
            border-color: #08072a;
            color: #08072a;
        }
    </style>
</head>
<body class="bg-white">
    @include('components.navbar')

    <!-- Testimoni Section -->
    <section id="testimonials" class="bg-white py-12">
        <div class="container mx-auto px-4">
            <!-- Header -->
            <div class="mb-6 mt-8 md:mt-12">
                <h3 class="text-xl md:text-2xl text-center font-semibold text-midnight text-opacity-90" data-aos="fade-up">
                    Testimoni Sibermuda
                </h3>
                <p class="text-md text-gray-700 text-center mt-2" data-aos="fade-up">
                    Kisah sukses dan pengalaman inspiratif dari para alumni yang telah menyelesaikan program Sibermuda
                </p>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 md:mx-8" data-aos="fade-up">
                <div class="bg-white border-2 border-gray-300 rounded-lg p-6 text-center hover:border-[#08072a] transition-all duration-300">
                    <div class="text-4xl font-bold text-[#08072a] mb-2">{{ $totalTestimonials }}</div>
                    <div class="text-gray-600 text-sm">Total Testimoni</div>
                </div>
                <div class="bg-white border-2 border-gray-300 rounded-lg p-6 text-center hover:border-[#08072a] transition-all duration-300">
                    <div class="flex items-center justify-center gap-2 mb-2">
                        <span class="text-4xl font-bold text-[#08072a]">{{ number_format($averageRating, 1) }}</span>
                        <svg class="w-8 h-8 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    </div>
                    <div class="text-gray-600 text-sm">Rating Rata-rata</div>
                </div>
                <div class="bg-white border-2 border-gray-300 rounded-lg p-6 text-center hover:border-[#08072a] transition-all duration-300">
                    <div class="text-4xl font-bold text-[#08072a] mb-2">98%</div>
                    <div class="text-gray-600 text-sm">Kepuasan Alumni</div>
                </div>
            </div>

            @if ($ratings->isEmpty())
                <div class="flex flex-col justify-center items-center text-gray-500 py-12" data-aos="fade-down">
                    <svg class="w-16 h-16 mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    <h3 class="mt-4 text-xl font-medium text-gray-900">Belum ada testimoni</h3>
                    <p class="mt-2 text-gray-500">Jadilah yang pertama memberikan testimoni!</p>
                </div>
            @else
                <!-- Filter Section -->
                <div class="flex flex-wrap gap-4 items-center justify-between mb-8 md:mx-8" data-aos="fade-up">
                    <div class="flex gap-2 flex-wrap">
                        <button onclick="filterRating('all')" class="filter-btn active px-4 py-2 rounded-lg text-sm font-medium">
                            Semua
                        </button>
                        <button onclick="filterRating(5)" class="filter-btn px-4 py-2 rounded-lg text-sm font-medium">
                            ⭐ 5 Bintang
                        </button>
                        <button onclick="filterRating(4)" class="filter-btn px-4 py-2 rounded-lg text-sm font-medium">
                            ⭐ 4 Bintang
                        </button>
                        <button onclick="filterRating(3)" class="filter-btn px-4 py-2 rounded-lg text-sm font-medium">
                            ⭐ 3 Bintang
                        </button>
                    </div>
                    <div class="text-sm text-gray-600">
                        Menampilkan <span id="visible-count">{{ $ratings->count() }}</span> testimoni
                    </div>
                </div>

                <!-- Featured Testimonial (Testimoni Utama) -->
                @php $featuredTestimonial = $ratings->first(); @endphp
                <div class="mb-12 md:mx-8" data-aos="fade-up">
                    <div class="testimonial-card bg-white border-2 border-gray-300 rounded-2xl overflow-hidden hover:border-[#08072a] transition-all duration-300" data-rating="{{ $featuredTestimonial->rating }}">
                        <div class="grid md:grid-cols-2 gap-0">
                            <!-- Image Section with Featured Badge -->
                            <div class="relative h-64 md:h-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center p-8">
                                <div class="text-center text-white">
                                    <div class="w-32 h-32 mx-auto mb-4 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center border-4 border-white/40">
                                        <span class="text-white font-bold text-5xl">{{ strtoupper(substr($featuredTestimonial->nama, 0, 1)) }}</span>
                                    </div>
                                    <div class="absolute top-4 left-4">
                                        <span class="bg-yellow-400 text-gray-900 px-4 py-1.5 rounded-full text-xs font-semibold uppercase shadow-lg">
                                            ⭐ Testimoni Terbaik
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Content Section -->
                            <div class="p-8 flex flex-col justify-center">
                                <h2 class="text-2xl md:text-3xl font-bold text-[#08072a] mb-2">
                                    {{ $featuredTestimonial->nama }}
                                </h2>

                                <!-- Rating Stars -->
                                <div class="flex items-center gap-1 mb-4">
                                    @for ($i = 0; $i < 5; $i++)
                                        <svg class="w-6 h-6 {{ $i < $featuredTestimonial->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    @endfor
                                </div>

                                <p class="text-gray-700 leading-relaxed mb-6 text-justify">
                                    "{{ $featuredTestimonial->comment }}"
                                </p>

                                <!-- Footer Info -->
                                <div class="pt-4 border-t border-gray-200 flex items-center justify-between text-sm text-gray-500">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                        </svg>
                                        {{ \Carbon\Carbon::parse($featuredTestimonial->created_at)->translatedFormat('d F Y') }}
                                    </span>
                                    <span>📝 {{ str_word_count($featuredTestimonial->comment) }} kata</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Grid Testimoni Lainnya -->
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 md:mx-8">
                    @foreach($ratings->slice(1) as $rating)
                        <div class="testimonial-card bg-white border-2 border-gray-300 rounded-2xl overflow-hidden hover:border-[#08072a] transition-all duration-300 h-full flex flex-col"
                             data-rating="{{ $rating->rating }}"
                             data-aos="fade-up"
                             data-aos-delay="{{ $loop->index * 100 }}">

                            <!-- Header dengan Avatar -->
                            <div class="relative h-40 bg-gradient-to-br from-blue-400 to-purple-500 flex items-center justify-center">
                                <div class="w-20 h-20 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center border-4 border-white/40">
                                    <span class="text-white font-bold text-3xl">{{ strtoupper(substr($rating->nama, 0, 1)) }}</span>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="p-6 flex flex-col flex-grow">
                                <!-- Name -->
                                <h4 class="font-semibold text-gray-800 text-lg mb-1">{{ $rating->nama }}</h4>

                                <!-- Date -->
                                <div class="flex items-center gap-2 text-xs text-gray-500 mb-3">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ \Carbon\Carbon::parse($rating->created_at)->translatedFormat('d M Y') }}
                                </div>

                                <!-- Rating Stars -->
                                <div class="flex items-center gap-1 mb-4">
                                    @for ($i = 0; $i < 5; $i++)
                                        <svg class="w-5 h-5 {{ $i < $rating->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    @endfor
                                </div>

                                <!-- Comment -->
                                <div class="text-gray-700 leading-relaxed mb-4 flex-grow">
                                    <p class="text-sm line-clamp-3">"{{ $rating->comment }}"</p>
                                </div>

                                <!-- Footer -->
                                <div class="pt-4 border-t border-gray-200 mt-auto">
                                    <span class="text-xs text-gray-500">
                                        📝 {{ str_word_count($rating->comment) }} kata
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- CTA Section -->
            <div class="mt-12 bg-gradient-to-r from-blue-500 to-purple-600 rounded-2xl p-8 md:p-12 text-center text-white md:mx-8" data-aos="fade-up">
                <h3 class="text-2xl md:text-3xl font-bold mb-4">Bagikan Pengalaman Anda!</h3>
                <p class="text-md md:text-lg mb-6 max-w-2xl mx-auto opacity-90">
                    Ceritakan pengalaman Anda bersama Sibermuda dan bantu calon peserta lain untuk membuat keputusan yang tepat.
                </p>
                <a href="{{ url('/') }}#ratingform" class="inline-block bg-white text-[#08072a] px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-all duration-300 transform hover:scale-105 shadow-lg">
                    Tulis Testimoni Sekarang
                </a>
            </div>
        </div>
    </section>

    @include('components.footer')

    <!-- AOS JS -->
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        // Initialize AOS animation
        AOS.init({
            duration: 1000,
            once: true,
        });

        // Filter functionality
        function filterRating(rating) {
            const cards = document.querySelectorAll('.testimonial-card');
            const buttons = document.querySelectorAll('.filter-btn');
            const visibleCountSpan = document.getElementById('visible-count');

            buttons.forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');

            let visibleCount = 0;

            cards.forEach(card => {
                if (rating === 'all') {
                    card.style.display = 'block';
                    visibleCount++;
                } else {
                    const cardRating = parseInt(card.getAttribute('data-rating'));
                    if (cardRating === rating) {
                        card.style.display = 'block';
                        visibleCount++;
                    } else {
                        card.style.display = 'none';
                    }
                }
            });

            if (visibleCountSpan) {
                visibleCountSpan.textContent = visibleCount;
            }
        }
    </script>
</body>
</html>
