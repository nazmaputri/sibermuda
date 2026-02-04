@php
    // Data dummy untuk berita
    $news = collect([
        (object)[
            'id' => 1,
            'slug' => 'sibermuda-luncurkan-kursus-ai-terbaru',
            'title' => 'Sibermuda Luncurkan Kursus Artificial Intelligence Terbaru untuk Pemula',
            'content' => 'Sibermuda dengan bangga mengumumkan peluncuran kursus Artificial Intelligence terbaru yang dirancang khusus untuk pemula. Kursus ini mencakup pembelajaran mendalam tentang Machine Learning, Deep Learning, dan implementasi AI dalam kehidupan sehari-hari. Dengan mentor berpengalaman dan materi yang mudah dipahami, peserta akan dibimbing dari dasar hingga mahir.',
            'image_path' => 'https://images.unsplash.com/photo-1677442136019-21780ecad995?w=800&h=600&fit=crop',
            'category' => 'Kursus Baru',
            'published_at' => now()->subDays(1),
            'author' => 'Admin Sibermuda',
            'views' => 1250
        ],
        (object)[
            'id' => 2,
            'slug' => 'tips-belajar-programming-efektif',
            'title' => '5 Tips Belajar Programming Secara Efektif untuk Pemula',
            'content' => 'Belajar programming memang membutuhkan dedikasi dan strategi yang tepat. Berikut adalah 5 tips yang telah terbukti efektif: 1) Konsisten berlatih setiap hari, 2) Mulai dari project kecil, 3) Bergabung dengan komunitas, 4) Jangan takut membuat error, 5) Selalu dokumentasikan pembelajaran Anda.',
            'image_path' => 'https://images.unsplash.com/photo-1516116216624-53e697fedbea?w=600&h=400&fit=crop',
            'category' => 'Tips & Trik',
            'published_at' => now()->subDays(3),
            'author' => 'Budi Santoso',
            'views' => 2100
        ],
        (object)[
            'id' => 3,
            'slug' => 'alumni-sibermuda-diterima-di-google',
            'title' => 'Prestasi Membanggakan! Alumni Sibermuda Diterima Bekerja di Google',
            'content' => 'Kabar gembira datang dari alumni Sibermuda, Andi Wijaya, yang berhasil diterima sebagai Software Engineer di Google Indonesia. Andi merupakan lulusan kursus Full Stack Web Development yang telah mengikuti program intensif selama 6 bulan.',
            'image_path' => 'https://images.unsplash.com/photo-1498050108023-c5249f4df085?w=600&h=400&fit=crop',
            'category' => 'Prestasi',
            'published_at' => now()->subDays(5),
            'author' => 'Tim Redaksi',
            'views' => 3500
        ],
        (object)[
            'id' => 4,
            'slug' => 'webinar-gratis-digital-marketing',
            'title' => 'Webinar Gratis: Strategi Digital Marketing di Era Modern',
            'content' => 'Sibermuda mengadakan webinar gratis dengan tema "Strategi Digital Marketing di Era Modern" pada tanggal 25 Januari 2026. Webinar ini akan menghadirkan praktisi digital marketing terkemuka yang akan membagikan pengalaman dan strategi sukses mereka.',
            'image_path' => 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=600&h=400&fit=crop',
            'category' => 'Event',
            'published_at' => now()->subDays(7),
            'author' => 'Event Team',
            'views' => 890
        ],
        (object)[
            'id' => 5,
            'slug' => 'update-platform-sibermuda-2026',
            'title' => 'Update Platform Sibermuda 2026: Fitur Baru yang Lebih Interaktif',
            'content' => 'Platform Sibermuda telah melakukan update besar-besaran dengan menambahkan berbagai fitur baru yang lebih interaktif. Fitur-fitur tersebut meliputi live coding session, forum diskusi real-time, AI assistant untuk membantu pembelajaran.',
            'image_path' => 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=600&h=400&fit=crop',
            'category' => 'Pengumuman',
            'published_at' => now()->subDays(10),
            'author' => 'Tech Team',
            'views' => 1680
        ],
        (object)[
            'id' => 6,
            'slug' => 'kolaborasi-dengan-startup-ternama',
            'title' => 'Sibermuda Berkolaborasi dengan 10 Startup Ternama untuk Program Magang',
            'content' => 'Dalam upaya memfasilitasi peserta mendapatkan pengalaman kerja nyata, Sibermuda telah menjalin kerjasama dengan 10 startup ternama di Indonesia. Program magang ini akan memberikan kesempatan kepada peserta terbaik.',
            'image_path' => 'https://images.unsplash.com/photo-1531482615713-2afd69097998?w=600&h=400&fit=crop',
            'category' => 'Kerjasama',
            'published_at' => now()->subDays(12),
            'author' => 'Partnership Team',
            'views' => 2240
        ],
        (object)[
            'id' => 7,
            'slug' => 'tips-membangun-portofolio-developer',
            'title' => 'Cara Membangun Portofolio Developer yang Menarik Perhatian Recruiter',
            'content' => 'Portofolio yang baik adalah kunci untuk mendapatkan pekerjaan impian sebagai developer. Artikel ini membahas langkah-langkah praktis untuk membangun portofolio yang profesional dan menarik.',
            'image_path' => 'https://images.unsplash.com/photo-1504384308090-c894fdcc538d?w=600&h=400&fit=crop',
            'category' => 'Tips & Trik',
            'published_at' => now()->subDays(14),
            'author' => 'Career Coach',
            'views' => 1920
        ],
        (object)[
            'id' => 8,
            'slug' => 'promo-ramadan-diskon-50-persen',
            'title' => 'Promo Spesial Ramadan: Diskon hingga 50% untuk Semua Kursus!',
            'content' => 'Menyambut bulan suci Ramadan, Sibermuda memberikan promo spesial dengan diskon hingga 50% untuk semua kursus. Promo ini berlaku mulai 1 Februari hingga 28 Februari 2026.',
            'image_path' => 'https://images.unsplash.com/photo-1557804506-669a67965ba0?w=600&h=400&fit=crop',
            'category' => 'Promo',
            'published_at' => now()->subDays(16),
            'author' => 'Marketing Team',
            'views' => 4120
        ]
    ]);

    // Data statistik
    $totalMentor = 45;
    $totalStudent = 12500;
    $totalCourses = 78;
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/jpg" href="storage/logo.png">
    <title>Berita - Sibermuda: Platform Kursus Online</title>

    <meta property="og:title" content="Berita - Sibermuda: Platform Kursus Online">
    @vite('resources/css/app.css')
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Protest+Guerrilla&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- AOS CSS -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Custom Style -->
    <style>
        body {
            font-family: "Poppins", sans-serif !important;
        }
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</head>
<body>
@include('components.navbar')

<!-- News Section -->
<section id="news" class="bg-gray-50 py-16 md:mx-12">
    <div class="container mx-auto px-6 mt-7">
        <div class="mb-6 text-center">
            <h3 class="text-xl md:text-2xl font-['poppins'] font-semibold text-[#08072a]" data-aos="fade-up">
                Berita Terbaru Sibermuda
            </h3>
            <p class=" text-lg text-gray-700 mt-2" data-aos="fade-up">
               Update terkini seputar teknologi, kursus, dan pencapaian Sibermuda
            </p>
        </div>
        @if($news->isEmpty())
            <div class="flex flex-col justify-center items-center text-gray-500 py-12" data-aos="fade-down">
                <svg class="w-16 h-16 mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                </svg>
                <p class="text-lg">Belum ada berita tersedia.</p>
            </div>
        @else
            <!-- Featured News (Berita Utama) -->
            <div class="mb-12" data-aos="fade-up">
                @php $featuredNews = $news->first(); @endphp
                <a href="{{ url('/news/' . $featuredNews->slug) }}" class="block group">
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300">
                        <div class="grid md:grid-cols-2 gap-0">
                            <div class="relative h-64 md:h-full overflow-hidden">
                                <img src="{{ $featuredNews->image_path }}"
                                     alt="{{ $featuredNews->title }}"
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                <div class="absolute top-4 left-4">
                                    <span class="bg-red-600 text-white px-4 py-1.5 rounded-full text-xs font-semibold uppercase">
                                        Berita Utama
                                    </span>
                                </div>
                            </div>
                            <div class="p-8 flex flex-col justify-center">
                                <div class="flex items-center gap-4 mb-4 text-sm text-gray-600">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                        </svg>
                                        {{ $featuredNews->published_at->format('d M Y') }}
                                    </span>
                                    @if($featuredNews->category)
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"></path>
                                        </svg>
                                        {{ $featuredNews->category }}
                                    </span>
                                    @endif
                                </div>
                                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-4 group-hover:text-[#08072a] transition-colors">
                                    {{ $featuredNews->title }}
                                </h2>
                                <p class="text-gray-600 mb-6 line-clamp-3">
                                    {{ Str::limit(strip_tags($featuredNews->content), 180) }}
                                </p>
                                <div class="flex items-center text-[#08072a] font-semibold group-hover:gap-3 transition-all">
                                    Baca Selengkapnya
                                    <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Grid Berita Lainnya -->
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($news->slice(1) as $item)
                    <div class="bg-white rounded-lg shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden group" data-aos="zoom-in" data-aos-delay="{{ $loop->index * 100 }}">
                        <a href="{{ url('/news/' . $item->slug) }}" class="block">
                            <div class="relative h-48 overflow-hidden">
                                <img src="{{ $item->image_path }}"
                                     alt="{{ $item->title }}"
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                @if($item->category)
                                <div class="absolute top-3 left-3">
                                    <span class="bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-semibold text-gray-800">
                                        {{ $item->category }}
                                    </span>
                                </div>
                                @endif
                            </div>

                            <div class="p-6">
                                <div class="flex items-center gap-2 text-xs text-gray-500 mb-3">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $item->published_at->format('d M Y') }}
                                </div>

                                <h3 class="text-lg font-bold text-gray-900 mb-3 line-clamp-2 group-hover:text-[#08072a] transition-colors">
                                    {{ $item->title }}
                                </h3>

                                <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                                    {{ Str::limit(strip_tags($item->content), 120) }}
                                </p>

                                <div class="flex items-center text-[#08072a] text-sm font-semibold group-hover:gap-2 transition-all">
                                    Baca Selengkapnya
                                    <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            <!-- Load More Button -->
            @if($news->count() > 7)
            <div class="mt-12 text-center" data-aos="fade-up">
                <button class="inline-block bg-[#08072a] text-white px-8 py-3 rounded-lg font-semibold hover:bg-opacity-90 transition-all duration-300 transform hover:scale-105">
                    Lihat Semua Berita
                </button>
            </div>
            @endif
        @endif
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
</script>

</body>
</html>
