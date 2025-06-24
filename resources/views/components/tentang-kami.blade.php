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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
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

<section id="about" class="bg-white py-12">
    <div class="container mx-auto px-4">
        <div class="flex items-center pb-4">

            <!-- Image Section -->
            <!-- <div class="md:w-1/3 order-1 lg:order-1 mb-6 lg:mb-0 flex justify-center" data-aos="fade-left">
                <img src="{{ asset('storage/online-course.png') }}" alt="Gambar" class="md:w-1/2 w-1/3 h-auto">
            </div>             -->

            <!-- Text Content -->
            <div class="md:px-8 space-y-6" data-aos="fade-right">
                <!-- Title -->
                <div class="mb-6 mt-8 md:mt-12">
                    <h3 class="text-xl md:text-2xl text-center font-semibold text-midnight text-opacity-90">
                       Tentang Kami
                    </h3>
                </div>

                <!-- Description -->
                <p class="text-md text-gray-700 text-center">
                    Sibermuda adalah platform pembelajaran digital yang dirancang untuk mempermudah proses belajar di bidang teknologi dan digital. Kami menawarkan berbagai kursus yang dapat mendukung pengembangan keterampilan dan kemampuan digitalmu.
                </p>
                
            </div>
        </div>

        <!-- Accordion -->
        <div class="grid grid-cols-1 gap-4 md:mx-8" id="accordion">
            <!-- Card 1 -->
            <div class="card h-full flex flex-col bg-white border-2 border-gray-300 rounded-lg transition-all duration-300 ease-in-out" data-aos="fade-up">
                <button class="flex justify-between items-center w-full px-4 py-2 text-md text-left text-gray-700 font-medium focus:outline-none"
                  onclick="toggleFeature(this)">
                  <span>Akses Materi Pembelajaran Terlengkap</span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 transition-transform duration-300 transform rotate-0">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>
                <div class="feature-content max-h-0 overflow-hidden transition-all duration-300 ease-in-out px-4 pb-3  bg-white rounded-b-lg opacity-0">
                  <p class="text-gray-600">
                    Sibermuda.Idn menyediakan akses ke berbagai materi pembelajaran dari berbagai bidang studi yang memungkinkan peserta untuk belajar dengan cara yang lebih terstruktur dan efektif.
                  </p>
               </div>
            </div>
                
            <!-- Card 2 -->
            <div class="card h-full flex flex-col bg-white border-2 border-gray-300 rounded-lg transition-all duration-300 ease-in-out" data-aos="fade-up">
                <button class="flex justify-between items-center w-full px-4 py-2 text-md text-left text-gray-700 font-medium focus:outline-none"
                  onclick="toggleFeature(this)">
                  <span>Pembelajaran Interaktif dan Menyenangkan</span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 transition-transform duration-300 transform rotate-0">
                      <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>
                <div class="feature-content max-h-0 overflow-hidden transition-all duration-300 ease-in-out px-4 pb-3  bg-white rounded-b-lg opacity-0">
                  <p class="text-gray-600">
                      Dengan fitur pembelajaran interaktif, Sibermuda menjadikan proses belajar lebih menyenangkan dan tidak membosankan. peserta dapat berinteraksi dengan materi melalui tugas akhir yang membuat mereka lebih terlibat dalam proses belajar.
                  </p>
                </div>
            </div>
                
            <!-- Card 3 -->
            <div class="card h-full flex flex-col bg-white border-2 border-gray-300 rounded-lg transition-all duration-300 ease-in-out" data-aos="fade-up">
              <button class="flex justify-between items-center w-full px-4 py-2 text-md text-left text-gray-700 font-medium focus:outline-none"
                onclick="toggleFeature(this)">
                <span>Fasilitas untuk Mentor dan Peserta</span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 transition-transform duration-300 transform rotate-0">
                  <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                </svg>
              </button>
              <div class="feature-content max-h-0 overflow-hidden transition-all duration-300 ease-in-out px-4 pb-3  bg-white rounded-b-lg opacity-0">
                <p class="text-gray-600">
                    Sibermuda.Idn tidak hanya menyediakan fasilitas untuk peserta, tetapi juga untuk mentor. Mentor dapat menggunakan platform ini untuk membuat materi baik melalui video youtube maupun google drive
                </p>
              </div>
            </div>
                
            <!-- Card 4 -->
            <div class="card h-full flex flex-col bg-white border-2 border-gray-300 rounded-lg transition-all duration-300 ease-in-out" data-aos="fade-up">
              <button class="flex justify-between items-center w-full px-4 py-2 text-md text-left text-gray-700 font-medium focus:outline-none"
                onclick="toggleFeature(this)">
                  <span>Sertifikat Digital Setelah Selesai Kursus</span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 transition-transform duration-300 transform rotate-0">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                    </svg>
              </button>
              <div class="feature-content max-h-0 overflow-hidden transition-all duration-300 ease-in-out px-4 pb-3  bg-white rounded-b-lg opacity-0">
                <p class="text-gray-600">
                  Setelah menyelesaikan kursus, peserta akan mendapatkan sertifikat digital yang dapat digunakan sebagai bukti kompetensi mereka. Sertifikat ini dapat menjadi nilai tambah untuk karier di dunia digital.
                </p>
              </div>
            </div>
        </div>
    </div>
</section>

<section id="founder" class="py-12 max-w-7xl mx-auto px-4 md:px-10">
    <h2 class="text-xl md:text-2xl text-center font-semibold text-midnight text-opacity-90 mb-6" data-aos="fade-right">Founder</h2>
    <p class="text-md text-gray-700 text-center mb-3 md:mb-5" data-aos="fade-right">Kenali para founder yang berpengalaman di dunia teknologi yang juga memiliki semangat tinggi dalam berbagi ilmu. </p>

    <div class="grid grid-cols-1 gap-6" data-aos="fade-right">
    <!-- Card 1 -->
    <div>
        <div class="bg-white rounded-2xl p-2 text-left flex flex-col md:flex-row h-auto">
            <!-- Foto di kanan (atas saat mobile) -->
            <div class="md:w-1/3 w-full md:pl-4 mb-4 md:mb-0">
                <div class="relative group rounded-xl overflow-hidden w-full h-64 md:h-full">
                    <!-- Gambar -->
                    <img src="{{ asset('storage/default-profile.jpg') }}" alt="Mentor Profile" class="w-full h-full object-cover rounded-xl transition duration-300">

                    <!-- Overlay ketika hover -->
                    <div class="absolute inset-0 bg-black bg-opacity-30 opacity-0 group-hover:opacity-50 transition duration-300 rounded-xl"></div>
                </div>
            </div>

            <!-- Teks di kanan -->
            <div class="md:w-2/3 w-full flex flex-col justify-center md:pl-6">
                <h3 class="text-lg md:text-2xl font-semibold text-midnight">Rama Ahmad Ramdani</h3>
                <p class="text-sm text-gray-500 mb-2">Chief Executive Officer</p>
                <p class="text-gray-600 text-md">
                 Kak Rama Ahmed adalah pakar cyber security dengan karier gemilang yang juga mendirikan Sibermuda, platform edukasi yang telah melatih ribuan talenta lokal melalui pelatihan, sertifikasi, dan program peningkatan kesadaran keamanan digital di Indonesia.
                </p>
                <div class="flex space-x-4 mt-2">
                    <!-- <a href="https://www.linkedin.com" target="_blank" class="text-gray-600 hover:text-blue-600 text-xl">
                        <i class="fab fa-linkedin"></i>
                    </a> -->
                     <a href="https://www.tiktok.com/@ramahmdr?is_from_webapp=1&sender_device=pc" target="_blank" class="text-gray-600 hover:text-gray-800 text-xl">
                        <i class="fab fa-tiktok"></i>
                    </a>
                    <!-- <a href="https://www.youtube.com" target="_blank" class="text-gray-600 hover:text-red-600 text-xl">
                        <i class="fab fa-youtube"></i>
                    </a> -->
                    <a href="https://www.instagram.com/ramahmdrr?igsh=MWNsa2gybmg2ZDlydQ==" target="_blank" class="text-gray-600 hover:text-pink-500 text-xl">
                        <i class="fab fa-instagram"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 2 -->
    <div>
        <div class="bg-white rounded-2xl p-2 text-left flex flex-col md:flex-row-reverse h-auto">
            <!-- Foto di kanan (atas saat mobile) -->
            <div class="md:w-1/3 w-full md:pl-4 mb-4 md:mb-0">
                <div class="relative group rounded-xl overflow-hidden w-full h-64 md:h-full">
                    <!-- Gambar -->
                    <img src="{{ asset('storage/CTO.png') }}" alt="Mentor Profile" class="w-full h-full object-cover rounded-xl transition duration-300">

                    <!-- Overlay ketika hover -->
                    <div class="absolute inset-0 bg-black bg-opacity-30 opacity-0 group-hover:opacity-50 transition duration-300 rounded-xl"></div>
                </div>
            </div>

            <!-- Teks di kiri -->
            <div class="md:w-2/3 w-full flex flex-col justify-center md:pr-6">
                <h3 class="text-lg md:text-2xl font-semibold text-midnight">Rizky MR</h3>
                <p class="text-sm text-gray-500 mb-2">Chief Technology Officer</p>
                <p class="text-gray-600 text-md">
                 Kak Rizky MR adalah seorang frontend developer berpengalaman yang juga mengajar sebagai guru frontend. Ia telah sukses mengembangkan berbagai proyek dan membimbing banyak orang dalam menguasai keterampilan desain web.
                </p>
                <div class="flex space-x-4 mt-2">
                    <!-- <a href="https://www.linkedin.com" target="_blank" class="text-gray-600 hover:text-blue-600 text-xl">
                        <i class="fab fa-linkedin"></i>
                    </a> -->
                    <a href="github.com/learningbydoing08" target="_blank" class="text-gray-600 hover:text-gray-800 text-xl">
                        <i class="fab fa-github"></i>
                    </a>
                    <a href="www.youtube.com/@learningbydoing_official" target="_blank" class="text-gray-600 hover:text-red-600 text-xl">
                        <i class="fab fa-youtube"></i>
                    </a>
                    <a href="https://www.instagram.com/kiwkiwramadan_?igsh=MW9jcXJzbzNtN25oeg==" target="_blank" class="text-gray-600 hover:text-pink-500 text-xl">
                        <i class="fab fa-instagram"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 3 -->
    <div>
        <div class="bg-white rounded-2xl p-2 text-left flex flex-col md:flex-row h-auto">
            <!-- Foto di kiri (atas saat mobile) -->
            <div class="md:w-1/3 w-full md:pl-4 mb-4 md:mb-0">
                <div class="relative group rounded-xl overflow-hidden w-full h-64 md:h-full">
                    <!-- Gambar -->
                    <img src="{{ asset('storage/CAO.png') }}" alt="Mentor Profile" class="w-full h-full object-cover rounded-xl transition duration-300">

                    <!-- Overlay ketika hover -->
                    <div class="absolute inset-0 bg-black bg-opacity-30 opacity-0 group-hover:opacity-50 transition duration-300 rounded-xl"></div>
                </div>
            </div>

            <!-- Teks di kanan -->
            <div class="md:w-2/3 w-full flex flex-col justify-center md:pl-6">
                <h3 class="text-lg md:text-2xl font-semibold text-midnight">Delika Pratiwi</h3>
                <p class="text-sm text-gray-500 mb-2">Chief Academy Officer</p>
                <p class="text-gray-600 text-md">
                Kak Delika Pratiwi adalah seorang backend developer yang berpengalaman dan juga mengajar sebagai guru backend di sebuah sekolah. Ia mengajarkan konsep-konsep pengembangan backend kepada peserta, membekali mereka dengan keterampilan teknis yang diperlukan untuk berkembang di dunia pemrograman dan teknologi.
                </p>
                <div class="flex space-x-4 mt-2">
                    <a href="https://www.linkedin.com/in/delikapratiwi" target="_blank" class="text-gray-600 hover:text-blue-600 text-xl">
                        <i class="fab fa-linkedin"></i>
                    </a>
                    <!-- <a href="https://www.youtube.com" target="_blank" class="text-gray-600 hover:text-red-600 text-xl">
                        <i class="fab fa-youtube"></i>
                    </a> -->
                    <a href="https://www.instagram.com/delikapratiwi?igsh=Z2gyZDNiamNxbWFk" target="_blank" class="text-gray-600 hover:text-pink-500 text-xl">
                        <i class="fab fa-instagram"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
</section>

<section class="py-12 max-w-7xl mx-auto px-4 md:px-8">
  <h2 class="text-xl md:text-2xl text-center font-semibold text-midnight text-opacity-90 mb-8" data-aos="fade-right">
    Mentor Kami
  </h2>

  <div class="swiper mySwiper md:mx-10">
    <div class="swiper-wrapper" data-aos="fade-right">
      @foreach($mentor as $index => $m)
        <div class="swiper-slide">
          <div class="bg-white rounded-2xl shadow-lg border border-gray-200 h-[320px] p-4 text-center relative">
            <!-- Gambar mentor -->
            <img 
              src="{{ asset('storage/' . ($m->photo ?? 'default-profile.jpg')) }}" 
              alt="{{ $m->name }}" 
              class="rounded-xl mb-3 w-full max-h-48 mx-auto object-contain">

            <!-- Sekat bawah gambar -->
            <div class="absolute bottom-0 left-0 right-0 bg-white border-t-2 border-gray-200 py-4 px-4">
              <h3 class="text-md font-semibold text-gray-700">{{ $m->name }}</h3>

              @php
                $courses = $m->courses;
              @endphp

              @if($courses->count() === 1)
                <p class="text-sm text-gray-500 italic mt-1">
                  <strong>Mentor of</strong> {{ $courses->first()->title }}
                </p>
              @elseif($courses->count() > 1)
                <p id="course-title-{{ $index }}" class="text-sm text-gray-500 italic mt-1 min-h-[1.5rem]">
                  <strong>Mentor of </strong><span id="course-text-{{ $index }}"></span>
                  <span class="inline-block w-[1px] h-[1em] bg-gray-500 animate-pulse align-middle ml-0.5"></span>
                </p>

                <script>
                  document.addEventListener('DOMContentLoaded', function () {
                    const courses{{ $index }} = {!! json_encode($courses->pluck('title')) !!};
                    const target{{ $index }} = document.getElementById('course-text-{{ $index }}');
                    let courseIndex{{ $index }} = 0;

                    function typeText{{ $index }}(text, callback) {
                      let i = 0;
                      target{{ $index }}.textContent = '';
                      function typeChar() {
                        if (i < text.length) {
                          target{{ $index }}.textContent += text.charAt(i);
                          i++;
                          setTimeout(typeChar, 80); // kecepatan ketik per huruf
                        } else if (callback) {
                          setTimeout(callback, 2000); // jeda sebelum ganti kursus
                        }
                      }
                      typeChar();
                    }

                    function loopCourses{{ $index }}() {
                      typeText{{ $index }}(courses{{ $index }}[courseIndex{{ $index }}], () => {
                        courseIndex{{ $index }} = (courseIndex{{ $index }} + 1) % courses{{ $index }}.length;
                        loopCourses{{ $index }}();
                      });
                    }

                    setTimeout(loopCourses{{ $index }}, 1000);
                  });
                </script>
              @else
                <p class="text-sm text-gray-400 italic mt-1">belum ada kursus</p>
              @endif
            </div>
          </div>
        </div>
      @endforeach
    </div>

    <!-- Navigasi panah -->
    <div class="flex justify-center gap-4 mt-4" data-aos="fade-right">
      <button class="swiper-button-prev-custom p-2 rounded-full border border-gray-200 bg-white/80 text-midnight hover:bg-gray-100 shadow">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
      </button>
      <button class="swiper-button-next-custom p-2 rounded-full border border-gray-200 bg-white/80 text-midnight hover:bg-gray-100 shadow">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
      </button>
    </div>
  </div>
</section>

@include('components.footer') <!-- Menambahkan Navbar -->

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
<script>
    function toggleFeature(button) {
        const card = button.closest('.card');
        const content = card.querySelector('.feature-content');
        const svg = button.querySelector('svg');
        const isOpen = content.classList.contains('max-h-[200px]');
                
        // Tutup semua card
        document.querySelectorAll('.feature-content').forEach(c => {
            c.classList.remove('max-h-[200px]', 'opacity-100');
            c.classList.add('max-h-0', 'opacity-0');
        });
                
    // Hapus border-sky-400 dari semua card
    document.querySelectorAll('.card').forEach(c => {
        c.classList.remove('border-[#08072a]');
    });
                
    // Jika belum terbuka, buka konten yang diklik
    if (!isOpen) {
        content.classList.remove('max-h-0', 'opacity-0');
        content.classList.add('max-h-[200px]', 'opacity-100'); // Sesuaikan max-height dengan tinggi konten
        card.classList.add('border-[#08072a]');
        svg.classList.add('rotate-180');
    } else {
        svg.classList.remove('rotate-180');
      }
    }

    const swiper = new Swiper(".mySwiper", {
      slidesPerView: 1,
      spaceBetween: 20,
      navigation: {
        nextEl: '.swiper-button-next-custom',
        prevEl: '.swiper-button-prev-custom',
      },
      breakpoints: {
        640: {
          slidesPerView: 1.2,
        },
        768: {
          slidesPerView: 2,
        },
        1024: {
          slidesPerView: 3,
        }
      }
    });
</script>
</body>
</html>