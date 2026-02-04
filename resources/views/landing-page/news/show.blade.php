@php
    // Simulasi pengambilan berita berdasarkan slug (dalam production, ini akan dari database)
    $allNews = collect([
        (object)[
            'id' => 1,
            'slug' => 'sibermuda-luncurkan-kursus-ai-terbaru',
            'title' => 'Sibermuda Luncurkan Kursus Artificial Intelligence Terbaru untuk Pemula',
            'content' => '<p>Sibermuda dengan bangga mengumumkan peluncuran kursus Artificial Intelligence (AI) terbaru yang dirancang khusus untuk pemula. Kursus ini hadir sebagai respons terhadap tingginya permintaan akan pembelajaran AI yang mudah dipahami dan praktis.</p>

<h3 class="text-2xl font-bold mt-6 mb-4">Apa yang Akan Dipelajari?</h3>
<p>Kursus ini mencakup berbagai topik penting dalam AI, termasuk:</p>
<ul class="list-disc ml-6 my-4 space-y-2">
    <li>Fundamental Machine Learning dan konsep dasarnya</li>
    <li>Deep Learning dan Neural Networks untuk pemrosesan data kompleks</li>
    <li>Natural Language Processing (NLP) untuk memahami bahasa manusia</li>
    <li>Computer Vision untuk analisis gambar dan video</li>
    <li>Implementasi AI dalam proyek nyata yang dapat diterapkan di industri</li>
</ul>

<h3 class="text-2xl font-bold mt-6 mb-4">Kenapa Memilih Kursus Ini?</h3>
<p>Dengan mentor berpengalaman yang telah bekerja di perusahaan teknologi terkemuka seperti Google, Microsoft, dan startup unicorn Indonesia, peserta akan dibimbing dari dasar hingga mahir. Materi disusun secara sistematis dengan pendekatan hands-on learning yang memastikan peserta tidak hanya memahami teori tetapi juga mampu mengimplementasikan AI dalam proyek nyata.</p>

<h3 class="text-2xl font-bold mt-6 mb-4">Fasilitas yang Didapatkan</h3>
<ul class="list-disc ml-6 my-4 space-y-2">
    <li>Video pembelajaran berkualitas HD dengan subtitle bahasa Indonesia</li>
    <li>E-book dan resource lengkap yang dapat diunduh</li>
    <li>Live session dengan mentor setiap minggu untuk tanya jawab</li>
    <li>Akses ke komunitas eksklusif Sibermuda AI Community</li>
    <li>Sertifikat profesional setelah menyelesaikan kursus</li>
    <li>Career support dan job placement assistance</li>
    <li>Akses seumur hidup ke materi kursus dan update terbaru</li>
</ul>

<p class="mt-6">Kursus ini telah dibuka untuk pendaftaran dan mendapat sambutan luar biasa dari komunitas tech Indonesia. Dalam minggu pertama saja, sudah lebih dari 500 peserta mendaftar. Jangan lewatkan kesempatan untuk menjadi bagian dari revolusi AI dan tingkatkan karir Anda di bidang teknologi masa depan!</p>',
            'image_path' => 'https://images.unsplash.com/photo-1677442136019-21780ecad995?w=1200&h=600&fit=crop',
            'category' => 'Kursus Baru',
            'published_at' => now()->subDays(1),
            'author' => 'Admin Sibermuda',
            'views' => 1250,
            'tags' => ['AI', 'Machine Learning', 'Kursus Baru', 'Technology', 'Programming']
        ],
        (object)[
            'id' => 2,
            'slug' => 'tips-belajar-programming-efektif',
            'title' => '5 Tips Belajar Programming Secara Efektif untuk Pemula',
            'content' => '<p>Belajar programming memang membutuhkan dedikasi dan strategi yang tepat. Berikut adalah 5 tips yang telah terbukti efektif...</p>',
            'image_path' => 'https://images.unsplash.com/photo-1516116216624-53e697fedbea?w=1200&h=600&fit=crop',
            'category' => 'Tips & Trik',
            'published_at' => now()->subDays(3),
            'author' => 'Budi Santoso',
            'views' => 2100,
            'tags' => ['Programming', 'Tips', 'Belajar', 'Pemula']
        ],
        (object)[
            'id' => 3,
            'slug' => 'alumni-sibermuda-diterima-di-google',
            'title' => 'Prestasi Membanggakan! Alumni Sibermuda Diterima Bekerja di Google',
            'content' => '<p>Kabar gembira datang dari alumni Sibermuda...</p>',
            'image_path' => 'https://images.unsplash.com/photo-1498050108023-c5249f4df085?w=1200&h=600&fit=crop',
            'category' => 'Prestasi',
            'published_at' => now()->subDays(5),
            'author' => 'Tim Redaksi',
            'views' => 3500,
            'tags' => ['Alumni', 'Success Story', 'Google', 'Career']
        ],
    ]);

    // Cari berita berdasarkan slug dari URL (simulasi)
    $slug = request()->segment(2) ?? 'sibermuda-luncurkan-kursus-ai-terbaru';
    $newsItem = $allNews->firstWhere('slug', $slug) ?? $allNews->first();

    // Berita terkait (exclude berita yang sedang dibaca)
    $relatedNews = $allNews->where('id', '!=', $newsItem->id)->take(2);
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/jpg" href="{{ asset('storage/logo.png') }}">
    <title>{{ $newsItem->title }} - Sibermuda: Platform Kursus Online</title>

    <meta property="og:title" content="{{ $newsItem->title }} - Sibermuda: Platform Kursus Online">
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
        .prose h3 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-top: 2rem;
            margin-bottom: 1rem;
            color: #08072a;
        }
        .prose p {
            margin-bottom: 1.5rem;
            line-height: 1.8;
            color: #374151;
        }
        .prose ul {
            list-style-type: disc;
            margin-left: 2rem;
            margin-bottom: 1.5rem;
        }
        .prose ul li {
            margin-bottom: 0.5rem;
            line-height: 1.8;
        }
    </style>
</head>
<body>
@include('components.navbar')

<!-- Breadcrumb -->
<div class="bg-white border-b">
    <div class="container mx-auto px-4 md:px-12 py-4">
        <nav class="flex items-center space-x-2 text-sm text-gray-600">
            <a href="/" class="hover:text-[#08072a] transition-colors">Beranda</a>
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
            </svg>
            <a href="{{ url('/news') }}" class="hover:text-[#08072a] transition-colors">Berita</a>
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
            </svg>
            <span class="text-gray-400">{{ Str::limit($newsItem->title, 50) }}</span>
        </nav>
    </div>
</div>

<!-- Article Header -->
<article class="bg-white py-12">
    <div class="container mx-auto px-4 md:px-12 max-w-4xl">
        <!-- Category Badge -->
        <div class="mb-6" data-aos="fade-down">
            <span class="bg-[#08072a] text-white px-4 py-1.5 rounded-full text-sm font-semibold">
                {{ $newsItem->category }}
            </span>
        </div>

        <!-- Title -->
        <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 mb-6 leading-tight" data-aos="fade-down" data-aos-delay="100">
            {{ $newsItem->title }}
        </h1>

        <!-- Meta Information -->
        <div class="flex flex-wrap items-center gap-6 text-gray-600 mb-8 pb-8 border-b" data-aos="fade-down" data-aos-delay="200">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                </svg>
                <span>{{ $newsItem->author }}</span>
            </div>
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                </svg>
                <span>{{ $newsItem->published_at->format('d F Y') }}</span>
            </div>
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                </svg>
                <span>{{ number_format($newsItem->views) }} views</span>
            </div>
        </div>

        <!-- Featured Image -->
        <div class="mb-10" data-aos="zoom-in">
            <img src="{{ $newsItem->image_path }}"
                 alt="{{ $newsItem->title }}"
                 class="w-full h-auto rounded-lg shadow-lg">
        </div>

        <!-- Article Content -->
        <div class="prose max-w-none text-gray-700" data-aos="fade-up">
            {!! $newsItem->content !!}
        </div>

        <!-- Tags -->
        @if(isset($newsItem->tags) && count($newsItem->tags) > 0)
        <div class="mt-12 pt-8 border-t" data-aos="fade-up">
            <h4 class="text-sm font-semibold text-gray-700 mb-3">Tags:</h4>
            <div class="flex flex-wrap gap-2">
                @foreach($newsItem->tags as $tag)
                <span class="bg-gray-100 text-gray-700 px-4 py-2 rounded-full text-sm hover:bg-gray-200 transition-colors cursor-pointer">
                    #{{ $tag }}
                </span>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Share Buttons -->
        <div class="mt-8 pt-8 border-t" data-aos="fade-up">
            <h4 class="text-sm font-semibold text-gray-700 mb-4">Bagikan artikel ini:</h4>
            <div class="flex flex-wrap gap-3">
                <button onclick="shareToFacebook()" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-2">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                    </svg>
                    Facebook
                </button>
                <button onclick="shareToTwitter()" class="bg-sky-500 text-white px-6 py-2 rounded-lg hover:bg-sky-600 transition-colors flex items-center gap-2">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                    </svg>
                    Twitter
                </button>
                <button onclick="shareToWhatsApp()" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition-colors flex items-center gap-2">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                    </svg>
                    WhatsApp
                </button>
            </div>
        </div>
    </div>
</article>

<!-- Related News -->
@if(isset($relatedNews) && $relatedNews->count() > 0)
<section class="bg-gray-50 py-16">
    <div class="container mx-auto px-4 md:px-12 max-w-6xl">
        <h3 class="text-2xl md:text-3xl font-bold text-gray-900 mb-8" data-aos="fade-down">
            Berita Terkait
        </h3>
        <div class="grid md:grid-cols-2 gap-8">
            @foreach($relatedNews as $related)
                <div class="bg-white rounded-lg shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden group" data-aos="fade-up">
                    <a href="{{ url('/news/' . $related->slug) }}" class="block">
                        <div class="relative h-48 overflow-hidden">
                            <img src="{{ $related->image_path }}"
                                 alt="{{ $related->title }}"
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        </div>
                        <div class="p-6">
                            <div class="flex items-center gap-2 text-xs text-gray-500 mb-3">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $related->published_at->format('d M Y') }}
                            </div>
                            <h4 class="text-lg font-bold text-gray-900 mb-3 group-hover:text-[#08072a] transition-colors">
                                {{ $related->title }}
                            </h4>
                            <div class="flex items-center text-[#08072a] text-sm font-semibold group-hover:gap-2 transition-all">
                                Baca Artikel
                                <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@include('components.footer')

<!-- AOS JS -->
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
    // Initialize AOS animation
    AOS.init({
        duration: 1000,
        once: true,
    });

    // Share functions
    function shareToFacebook() {
        const url = encodeURIComponent(window.location.href);
        window.open(`https://www.facebook.com/sharer/sharer.php?u=${url}`, '_blank', 'width=600,height=400');
    }

    function shareToTwitter() {
        const url = encodeURIComponent(window.location.href);
        const text = encodeURIComponent('{{ $newsItem->title }}');
        window.open(`https://twitter.com/intent/tweet?url=${url}&text=${text}`, '_blank', 'width=600,height=400');
    }

    function shareToWhatsApp() {
        const url = encodeURIComponent(window.location.href);
        const text = encodeURIComponent('{{ $newsItem->title }}');
        window.open(`https://wa.me/?text=${text}%20${url}`, '_blank');
    }
</script>

</body>
</html>
