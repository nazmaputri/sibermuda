@php
    // Data bootcamp
    $bootcamps = collect([
        (object)[
            'id' => 1,
            'title' => 'Full Stack Web Development Bootcamp',
            'slug' => 'fullstack-web-development',
            'description' => 'Kuasai pengembangan web dari frontend hingga backend. Pelajari HTML, CSS, JavaScript, React, Node.js, dan database dalam 12 minggu intensif.',
            'duration' => '12 Minggu',
            'level' => 'Pemula - Menengah',
            'schedule' => 'Senin - Jumat, 19.00 - 21.00 WIB',
            'price' => 'Rp 5.000.000',
            'discount_price' => 'Rp 3.500.000',
            'image' => 'https://images.unsplash.com/photo-1498050108023-c5249f4df085?w=600&h=400&fit=crop',
            'features' => [
                'Live Class dengan Mentor Expert',
                'Project-Based Learning',
                'Sertifikat Digital',
                'Career Mentoring',
                'Akses Lifetime ke Materi',
                'Community Support'
            ],
            'syllabus' => [
                'HTML & CSS Fundamentals',
                'JavaScript ES6+',
                'React.js & State Management',
                'Node.js & Express.js',
                'Database & API Development',
                'Deployment & DevOps'
            ]
        ],
        (object)[
            'id' => 2,
            'title' => 'Cyber Security Bootcamp',
            'slug' => 'cyber-security',
            'description' => 'Jadilah ahli keamanan siber profesional. Pelajari ethical hacking, penetration testing, network security, dan security best practices.',
            'duration' => '10 Minggu',
            'level' => 'Menengah - Lanjutan',
            'schedule' => 'Sabtu - Minggu, 09.00 - 15.00 WIB',
            'price' => 'Rp 6.500.000',
            'discount_price' => 'Rp 4.500.000',
            'image' => 'https://images.unsplash.com/photo-1550751827-4bd374c3f58b?w=600&h=400&fit=crop',
            'features' => [
                'Hands-on Lab Environment',
                'Real-world Security Scenarios',
                'Industry-recognized Certificate',
                'Mentoring from Security Experts',
                'Career Placement Support',
                'Networking Opportunities'
            ],
            'syllabus' => [
                'Network Security Fundamentals',
                'Ethical Hacking & Penetration Testing',
                'Web Application Security',
                'Malware Analysis',
                'Incident Response',
                'Security Compliance & Audit'
            ]
        ],
        (object)[
            'id' => 3,
            'title' => 'Data Science & AI Bootcamp',
            'slug' => 'data-science-ai',
            'description' => 'Masuki dunia Data Science dan Artificial Intelligence. Pelajari Python, Machine Learning, Deep Learning, dan implementasi AI untuk bisnis.',
            'duration' => '14 Minggu',
            'level' => 'Pemula - Menengah',
            'schedule' => 'Selasa & Kamis, 19.00 - 22.00 WIB',
            'price' => 'Rp 7.000.000',
            'discount_price' => 'Rp 5.000.000',
            'image' => 'https://images.unsplash.com/photo-1555949963-aa79dcee981c?w=600&h=400&fit=crop',
            'features' => [
                'Python Programming Mastery',
                'Real Data Projects',
                'AI Model Development',
                'Industry Mentors',
                'Portfolio Building',
                'Job Guarantee Program'
            ],
            'syllabus' => [
                'Python for Data Science',
                'Data Analysis & Visualization',
                'Machine Learning Algorithms',
                'Deep Learning & Neural Networks',
                'Natural Language Processing',
                'AI Project Deployment'
            ]
        ],
        (object)[
            'id' => 4,
            'title' => 'Mobile App Development Bootcamp',
            'slug' => 'mobile-app-development',
            'description' => 'Bangun aplikasi mobile profesional untuk iOS dan Android. Pelajari Flutter, React Native, dan best practices dalam mobile development.',
            'duration' => '10 Minggu',
            'level' => 'Pemula - Menengah',
            'schedule' => 'Senin, Rabu, Jumat, 19.00 - 21.00 WIB',
            'price' => 'Rp 5.500.000',
            'discount_price' => 'Rp 4.000.000',
            'image' => 'https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?w=600&h=400&fit=crop',
            'features' => [
                'Cross-platform Development',
                'UI/UX Best Practices',
                'App Store Deployment',
                'Experienced Mobile Developers',
                'Real App Projects',
                'Freelance Opportunities'
            ],
            'syllabus' => [
                'Mobile Development Basics',
                'Flutter & Dart Programming',
                'State Management',
                'API Integration',
                'Firebase & Backend',
                'App Publishing'
            ]
        ]
    ]);
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/jpg" href="{{ asset('storage/logo.png') }}">
    <title>Bootcamp - Sibermuda: Platform Kursus Online</title>

    <meta property="og:title" content="Bootcamp - Sibermuda: Platform Kursus Online">
    @vite('resources/css/app.css')

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
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
<body class="bg-white">
    @include('components.navbar')

    <section class="bg-midnight text-white py-16 w-full overflow-hidden">
    <div class="container mx-auto px-6 mt-10">
        <div class="text-center max-w-4xl mx-auto" data-aos="fade-up">
            <h1 class="text-xl md:text-2xl font-['poppins'] text-center font-semibold mb-6">
                Informasi Bootcamp Sibermuda
            </h1>
            <p class="text-md text-center mb-8 opacity-90">
                Tingkatkan skill teknologi Anda dalam waktu singkat dengan program bootcamp kami. Dibimbing langsung oleh praktisi industri berpengalaman.
            </p>
            <div class="flex flex-wrap gap-4 justify-center">
                <div class="bg-white/10 backdrop-blur-sm rounded-lg px-6 py-4">
                    <div class="text-3xl font-bold">500+</div>
                    <div class="text-sm opacity-80">Alumni Sukses</div>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-lg px-6 py-4">
                    <div class="text-3xl font-bold">95%</div>
                    <div class="text-sm opacity-80">Tingkat Kelulusan</div>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-lg px-6 py-4">
                    <div class="text-3xl font-bold">85%</div>
                    <div class="text-sm opacity-80">Dapat Kerja</div>
                </div>
            </div>
        </div>
    </div>
</section>

    <!-- Bootcamp List Section -->
    <section id="bootcamps" class="bg-white py-12">
        <div class="container mx-auto px-4 md:px-8">
            <div class="mb-8">
                <h3 class="text-xl md:text-2xl text-center font-semibold text-midnight text-opacity-90" data-aos="fade-up">
                    Program Bootcamp Kami
                </h3>
                <p class="text-md text-gray-700 text-center mt-2" data-aos="fade-up">
                    Pilih program bootcamp yang sesuai dengan tujuan karir Anda
                </p>
            </div>

            <div class="grid md:grid-cols-2 gap-8 md:mx-8">
                @foreach($bootcamps as $index => $bootcamp)
                    <div class="bg-white border-2 border-gray-300 rounded-2xl overflow-hidden hover:border-[#08072a] transition-all duration-300 flex flex-col" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                        <!-- Image -->
                        <div class="relative h-48 overflow-hidden">
                            <img src="{{ $bootcamp->image }}" alt="{{ $bootcamp->title }}" class="w-full h-full object-cover">
                            @if($bootcamp->discount_price)
                                <div class="absolute top-4 right-4 bg-red-600 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                    Diskon!
                                </div>
                            @endif
                            <div class="absolute bottom-4 left-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-semibold text-[#08072a]">
                                {{ $bootcamp->level }}
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-6 flex flex-col flex-grow">
                            <h3 class="text-xl font-bold text-[#08072a] mb-3">
                                {{ $bootcamp->title }}
                            </h3>

                            <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                                {{ $bootcamp->description }}
                            </p>

                            <!-- Info Grid -->
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div class="flex items-center gap-2 text-sm text-gray-600">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span>{{ $bootcamp->duration }}</span>
                                </div>
                                <div class="flex items-center gap-2 text-sm text-gray-600">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="line-clamp-1">{{ $bootcamp->schedule }}</span>
                                </div>
                            </div>

                            <!-- Price -->
                            <div class="mb-4">
                                @if($bootcamp->discount_price)
                                    <div class="flex items-center gap-2">
                                        <span class="text-2xl font-bold text-[#08072a]">{{ $bootcamp->discount_price }}</span>
                                        <span class="text-sm text-gray-400 line-through">{{ $bootcamp->price }}</span>
                                    </div>
                                @else
                                    <span class="text-2xl font-bold text-[#08072a]">{{ $bootcamp->price }}</span>
                                @endif
                            </div>

                            <!-- Features -->
                            <div class="mb-4 flex-grow">
                                <p class="text-sm font-semibold text-gray-700 mb-2">Yang Akan Anda Dapatkan:</p>
                                <ul class="space-y-1">
                                    @foreach(array_slice($bootcamp->features, 0, 3) as $feature)
                                        <li class="flex items-start gap-2 text-sm text-gray-600">
                                            <svg class="w-4 h-4 text-green-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                            </svg>
                                            <span>{{ $feature }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            <!-- CTA Buttons -->
                            <div class="flex gap-2 mt-auto">
                                <button onclick="openBootcampModal({{ $bootcamp->id }})" class="flex-1 bg-[#08072a] text-white px-4 py-2.5 rounded-lg font-semibold hover:bg-opacity-90 transition-all duration-300 text-sm">
                                    Lihat Detail
                                </button>
                                <a href="https://wa.me/6281234567890?text=Halo,%20saya%20tertarik%20dengan%20bootcamp%20{{ urlencode($bootcamp->title) }}" target="_blank" class="flex-1 bg-green-600 text-white px-4 py-2.5 rounded-lg font-semibold hover:bg-green-700 transition-all duration-300 text-sm text-center flex items-center justify-center gap-2">
                                    <i class="fab fa-whatsapp"></i>
                                    Daftar
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Why Choose Us Section -->
    <section class="bg-gray-50 py-12">
        <div class="container mx-auto px-4 md:px-8">
            <div class="mb-8">
                <h3 class="text-xl md:text-2xl text-center font-semibold text-midnight text-opacity-90" data-aos="fade-up">
                    Mengapa Memilih Bootcamp Sibermuda?
                </h3>
            </div>

            <div class="grid md:grid-cols-3 gap-6 md:mx-8">
                <div class="bg-white border-2 border-gray-300 rounded-2xl p-6 hover:border-[#08072a] transition-all duration-300" data-aos="fade-up">
                    <div class="w-12 h-12 bg-[#08072a] rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <h4 class="text-lg font-semibold text-[#08072a] mb-2">Kurikulum Terstruktur</h4>
                    <p class="text-gray-600 text-sm">Materi pembelajaran yang disusun sistematis dari dasar hingga advanced, disesuaikan dengan kebutuhan industri.</p>
                </div>

                <div class="bg-white border-2 border-gray-300 rounded-2xl p-6 hover:border-[#08072a] transition-all duration-300" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-12 h-12 bg-[#08072a] rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h4 class="text-lg font-semibold text-[#08072a] mb-2">Mentor Berpengalaman</h4>
                    <p class="text-gray-600 text-sm">Dibimbing oleh praktisi yang sudah bekerja di perusahaan teknologi ternama dengan pengalaman 5+ tahun.</p>
                </div>

                <div class="bg-white border-2 border-gray-300 rounded-2xl p-6 hover:border-[#08072a] transition-all duration-300" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-12 h-12 bg-[#08072a] rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h4 class="text-lg font-semibold text-[#08072a] mb-2">Career Support</h4>
                    <p class="text-gray-600 text-sm">Mendapat bimbingan karir, review CV, persiapan interview, hingga koneksi ke perusahaan partner kami.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal Detail Bootcamp -->
    <div id="bootcampModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl max-w-3xl w-full max-h-[90vh] overflow-y-auto">
            <div class="sticky top-0 bg-white border-b border-gray-200 p-6 flex justify-between items-center">
                <h3 id="modalTitle" class="text-xl font-bold text-[#08072a]"></h3>
                <button onclick="closeBootcampModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <div class="p-6">
                <img id="modalImage" src="" alt="" class="w-full h-64 object-cover rounded-lg mb-6">

                <div class="mb-6">
                    <h4 class="font-semibold text-[#08072a] mb-2">Deskripsi Program</h4>
                    <p id="modalDescription" class="text-gray-600"></p>
                </div>

                <div class="grid md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <h4 class="font-semibold text-[#08072a] mb-3">Informasi Program</h4>
                        <div class="space-y-2 text-sm">
                            <div class="flex items-center gap-2 text-gray-600">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                </svg>
                                <span><strong>Durasi:</strong> <span id="modalDuration"></span></span>
                            </div>
                            <div class="flex items-center gap-2 text-gray-600">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path>
                                </svg>
                                <span><strong>Level:</strong> <span id="modalLevel"></span></span>
                            </div>
                            <div class="flex items-start gap-2 text-gray-600">
                                <svg class="w-4 h-4 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                </svg>
                                <span><strong>Jadwal:</strong> <span id="modalSchedule"></span></span>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h4 class="font-semibold text-[#08072a] mb-3">Investasi</h4>
                        <div id="modalPrice" class="mb-2"></div>
                    </div>
                </div>

                <div class="mb-6">
                    <h4 class="font-semibold text-[#08072a] mb-3">Fitur Program</h4>
                    <ul id="modalFeatures" class="grid md:grid-cols-2 gap-2"></ul>
                </div>

                <div class="mb-6">
                    <h4 class="font-semibold text-[#08072a] mb-3">Silabus Pembelajaran</h4>
                    <ul id="modalSyllabus" class="space-y-2"></ul>
                </div>

                <div class="flex gap-3">
                    <a id="modalWhatsapp" href="#" target="_blank" class="flex-1 bg-green-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-700 transition-all duration-300 text-center flex items-center justify-center gap-2">
                        <i class="fab fa-whatsapp text-xl"></i>
                        Daftar via WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>

    @include('components.footer')

    <!-- AOS JS -->
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 1000,
            once: true,
        });

        const bootcamps = @json($bootcamps);

        function openBootcampModal(id) {
            const bootcamp = bootcamps.find(b => b.id === id);
            if (!bootcamp) return;

            document.getElementById('modalTitle').textContent = bootcamp.title;
            document.getElementById('modalImage').src = bootcamp.image;
            document.getElementById('modalDescription').textContent = bootcamp.description;
            document.getElementById('modalDuration').textContent = bootcamp.duration;
            document.getElementById('modalLevel').textContent = bootcamp.level;
            document.getElementById('modalSchedule').textContent = bootcamp.schedule;

            // Price
            const priceHtml = bootcamp.discount_price
                ? `<div class="flex items-center gap-2">
                     <span class="text-3xl font-bold text-[#08072a]">${bootcamp.discount_price}</span>
                     <span class="text-lg text-gray-400 line-through">${bootcamp.price}</span>
                   </div>
                   <span class="text-sm text-red-600 font-semibold">Hemat ${calculateDiscount(bootcamp.price, bootcamp.discount_price)}</span>`
                : `<span class="text-3xl font-bold text-[#08072a]">${bootcamp.price}</span>`;
            document.getElementById('modalPrice').innerHTML = priceHtml;

            // Features
            const featuresHtml = bootcamp.features.map(feature =>
                `<li class="flex items-start gap-2 text-sm text-gray-600">
                    <svg class="w-4 h-4 text-green-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span>${feature}</span>
                </li>`
            ).join('');
            document.getElementById('modalFeatures').innerHTML = featuresHtml;

            // Syllabus
            const syllabusHtml = bootcamp.syllabus.map((item, index) =>
                `<li class="flex items-start gap-3 text-sm text-gray-600">
                    <span class="flex-shrink-0 w-6 h-6 bg-[#08072a] text-white rounded-full flex items-center justify-center text-xs font-semibold">${index + 1}</span>
                    <span class="mt-0.5">${item}</span>
                </li>`
            ).join('');
            document.getElementById('modalSyllabus').innerHTML = syllabusHtml;

            // WhatsApp Link
            const waMessage = `Halo, saya tertarik dengan bootcamp ${bootcamp.title}. Mohon informasi lebih lanjut.`;
            document.getElementById('modalWhatsapp').href = `https://wa.me/6281234567890?text=${encodeURIComponent(waMessage)}`;

            document.getElementById('bootcampModal').classList.remove('hidden');
            document.getElementById('bootcampModal').classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeBootcampModal() {
            document.getElementById('bootcampModal').classList.add('hidden');
            document.getElementById('bootcampModal').classList.remove('flex');
            document.body.style.overflow = 'auto';
        }

        function calculateDiscount(original, discounted) {
            const orig = parseInt(original.replace(/\D/g, ''));
            const disc = parseInt(discounted.replace(/\D/g, ''));
            const saved = orig - disc;
            return 'Rp ' + saved.toLocaleString('id-ID');
        }

        // Close modal when clicking outside
        document.getElementById('bootcampModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeBootcampModal();
            }
        });
    </script>
</body>
</html>
