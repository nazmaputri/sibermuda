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
        <div class="flex lg:space-x-12 items-center">

            <!-- Image Section -->
            <!-- <div class="md:w-1/3 order-1 lg:order-1 mb-6 lg:mb-0 flex justify-center" data-aos="fade-left">
                <img src="{{ asset('storage/online-course.png') }}" alt="Gambar" class="md:w-1/2 w-1/3 h-auto">
            </div>             -->

            <!-- Text Content -->
            <div class="md:px-12 space-y-6" data-aos="fade-right">
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
    </div>
</section>

<section id="founder" class="py-12 max-w-6xl mx-auto px-4 md:px-8">
    <h2 class="text-xl md:text-2xl text-center font-semibold text-midnight text-opacity-90 mb-8" data-aos="fade-right">Founder</h2>
    <p class="text-md text-gray-700 text-center mb-3" data-aos="fade-right">Kenali para founder yang berpengalaman di dunia teknologi yang juga memiliki semangat tinggi dalam berbagi ilmu. </p>

    <div class="grid grid-cols-1 gap-6" data-aos="fade-right">
    <!-- Card 1 -->
    <div>
        <div class="bg-white rounded-2xl border border-gray-200 p-4 text-left flex flex-col md:flex-row h-auto">
            <!-- Foto di kiri (atas saat mobile) -->
            <div class="md:w-1/3 w-full md:pr-4 mb-4 md:mb-0">
                <img src="{{ asset('storage/mentor.jpg') }}" alt="Mentor Profile" class="rounded-xl w-full h-64 md:h-full object-cover">
            </div>

            <!-- Teks di kanan -->
            <div class="md:w-2/3 w-full flex flex-col justify-center">
                <h3 class="text-lg md:text-2xl font-semibold text-midnight">Rama Ahmed</h3>
                <p class="text-sm text-gray-500 mb-2">Chief Executive Officer</p>
                <p class="text-gray-600 text-md">
                 Kak Rama Ahmed adalah pakar cyber security dengan karier gemilang yang juga mendirikan Sibermuda, platform edukasi yang telah melatih ribuan talenta lokal melalui pelatihan, sertifikasi, dan program peningkatan kesadaran keamanan digital di Indonesia.
                </p>
                <div class="flex space-x-4 mt-2">
                    <a href="https://www.linkedin.com" target="_blank" class="text-gray-600 hover:text-blue-600 text-xl">
                        <i class="fab fa-linkedin"></i>
                    </a>
                    <a href="https://www.youtube.com" target="_blank" class="text-gray-600 hover:text-red-600 text-xl">
                        <i class="fab fa-youtube"></i>
                    </a>
                    <a href="https://www.instagram.com" target="_blank" class="text-gray-600 hover:text-pink-500 text-xl">
                        <i class="fab fa-instagram"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 2 -->
    <div>
        <div class="bg-white rounded-2xl border border-gray-200 p-4 text-left flex flex-col md:flex-row-reverse h-auto">
            <!-- Foto di kanan (atas saat mobile) -->
            <div class="md:w-1/3 w-full md:pl-4 mb-4 md:mb-0">
                <img src="{{ asset('storage/mentor.jpg') }}" alt="Mentor Profile" class="rounded-xl w-full h-64 md:h-full object-cover">
            </div>

            <!-- Teks di kiri -->
            <div class="md:w-2/3 w-full flex flex-col justify-center">
                <h3 class="text-lg md:text-2xl font-semibold text-midnight">Rizky MR</h3>
                <p class="text-sm text-gray-500 mb-2">Chief Technology Officer</p>
                <p class="text-gray-600 text-md">
                 Kak Rizky MR adalah seorang frontend developer berpengalaman yang juga mengajar sebagai guru frontend. Ia telah sukses mengembangkan berbagai proyek dan membimbing banyak orang dalam menguasai keterampilan desain web.
                </p>
                <div class="flex space-x-4 mt-2">
                    <a href="https://www.linkedin.com" target="_blank" class="text-gray-600 hover:text-blue-600 text-xl">
                        <i class="fab fa-linkedin"></i>
                    </a>
                    <a href="https://www.youtube.com" target="_blank" class="text-gray-600 hover:text-red-600 text-xl">
                        <i class="fab fa-youtube"></i>
                    </a>
                    <a href="https://www.instagram.com" target="_blank" class="text-gray-600 hover:text-pink-500 text-xl">
                        <i class="fab fa-instagram"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 3 -->
    <div>
        <div class="bg-white rounded-2xl border border-gray-200 p-4 text-left flex flex-col md:flex-row h-auto">
            <!-- Foto di kiri (atas saat mobile) -->
            <div class="md:w-1/3 w-full md:pr-4 mb-4 md:mb-0">
                <img src="{{ asset('storage/mentor.jpg') }}" alt="Mentor Profile" class="rounded-xl w-full h-64 md:h-full object-cover">
            </div>

            <!-- Teks di kanan -->
            <div class="md:w-2/3 w-full flex flex-col justify-center">
                <h3 class="text-lg md:text-2xl font-semibold text-midnight">Delika Pratiwi</h3>
                <p class="text-sm text-gray-500 mb-2">Chief Academy Officer</p>
                <p class="text-gray-600 text-md">
                Kak Delika Pratiwi adalah seorang backend developer yang berpengalaman dan juga mengajar sebagai guru backend di sebuah sekolah. Ia mengajarkan konsep-konsep pengembangan backend kepada siswa, membekali mereka dengan keterampilan teknis yang diperlukan untuk berkembang di dunia pemrograman dan teknologi.
                </p>
                <div class="flex space-x-4 mt-2">
                    <a href="https://www.linkedin.com" target="_blank" class="text-gray-600 hover:text-blue-600 text-xl">
                        <i class="fab fa-linkedin"></i>
                    </a>
                    <a href="https://www.youtube.com" target="_blank" class="text-gray-600 hover:text-red-600 text-xl">
                        <i class="fab fa-youtube"></i>
                    </a>
                    <a href="https://www.instagram.com" target="_blank" class="text-gray-600 hover:text-pink-500 text-xl">
                        <i class="fab fa-instagram"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
</section>

<section class="py-12 max-w-7xl mx-auto px-4 md:px-8">
    <h2 class="text-xl md:text-2xl text-center font-semibold text-midnight text-opacity-90 mb-8" data-aos="fade-right">Mentor Kami</h2>

    <div class="swiper mySwiper">
      <div class="swiper-wrapper" data-aos="fade-right">
        <!-- Card 1 -->
        <div class="swiper-slide">
          <div class="bg-white rounded-2xl shadow border border-gray-200 p-4 text-center">
            <img src="{{ asset('storage/mentor.jpg') }}" alt="Mentor Profile" class="rounded-xl mb-4 w-full h-64 object-cover">
            <h3 class="text-lg font-semibold text-midnight">Rama Ahmed</h3>
            <p class="text-sm text-gray-500">Founder & CEO Sibermuda / Penetration Tester / Content Creator</p>
          </div>
        </div>

        <!-- Card 2 -->
        <div class="swiper-slide">
          <div class="bg-white rounded-2xl shadow border border-gray-200 p-4 text-center">
            <img src="{{ asset('storage/mentor.jpg') }}" alt="Mentor Profile" class="rounded-xl mb-4 w-full h-64 object-cover">
            <h3 class="text-lg font-semibold text-midnight">Rama Ahmed</h3>
            <p class="text-sm text-gray-500">Founder & CEO Sibermuda / Penetration Tester / Content Creator</p>
          </div>
        </div>

        <!-- Card 3 -->
        <div class="swiper-slide">
          <div class="bg-white rounded-2xl shadow border border-gray-200 p-4 text-center">
            <img src="{{ asset('storage/mentor.jpg') }}" alt="Mentor Profile" class="rounded-xl mb-4 w-full h-64 object-cover">
            <h3 class="text-lg font-semibold text-midnight">Rama Ahmed</h3>
            <p class="text-sm text-gray-500">Founder & CEO Sibermuda / Penetration Tester / Content Creator</p>
          </div>
        </div>

        <!-- Card 3 -->
        <div class="swiper-slide">
          <div class="bg-white rounded-2xl shadow border border-gray-200 p-4 text-center">
            <img src="{{ asset('storage/mentor.jpg') }}" alt="Mentor Profile" class="rounded-xl mb-4 w-full h-64 object-cover">
            <h3 class="text-lg font-semibold text-midnight">Rama Ahmed</h3>
            <p class="text-sm text-gray-500">Founder & CEO Sibermuda / Penetration Tester / Content Creator</p>
          </div>
        </div>

        <!-- Tambahkan card tambahan jika perlu -->
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
</section>

<section class="py-16 px-4 bg-white">
  <div class="max-w-6xl mx-auto">
    <!-- Judul -->
    <h2 class="text-xl md:text-2xl font-['poppins'] text-center font-semibold text-midnight text-opacity-90 mb-8" data-aos="fade-up">Visi & Misi Kami</h2>

    <!-- Misi -->
    <div class="flex flex-col md:flex-row items-center bg-white border border-gray-200 rounded-2xl shadow mb-8" data-aos="fade-up">
      <div class="md:w-1/3 p-6">
        <div class="w-40 h-40 mx-auto md:mx-0 rounded-full overflow-hidden">
          <img src="{{ asset('storage/visi.jpg') }}" alt="Visi Image" class="object-cover w-full h-full">
        </div>
      </div>
      <div class="md:w-3/3 p-6 text-center md:text-left">
        <h3 class="md:text-2xl text-xl font-semibold text-midnight mb-2">Visi</h3>
        <p class="text-gray-600">Menjadi pionir dalam pengembangan dan pemberdayaan generasi muda di bidang teknologi siber, menciptakan ekosistem inovatif yang mendukung keterampilan, kreativitas, dan pemahaman mendalam tentang dunia digital. Kami berkomitmen untuk memfasilitasi pembelajaran dan kolaborasi, sehingga generasi muda dapat menjadi pemimpin yang tangguh dan beretika dalam menghadapi tantangan teknologi masa depan.</p>
      </div>
    </div>

    <!-- Visi -->
    <div class="flex flex-col md:flex-row-reverse items-center bg-white border border-gray-200 rounded-2xl shadow" data-aos="fade-up">
      <div class="md:w-1/3 p-6">
        <div class="w-40 h-40 mx-auto md:mx-0 rounded-full overflow-hidden">
          <img src="{{ asset('storage/misi.jpg') }}" alt="Misi Image" class="object-cover w-full h-full">
        </div>
      </div>
      <div class="md:w-3/3 p-6 text-center md:text-left">
        <h3 class="md:text-2xl text-xl font-semibold text-midnight mb-2">Misi</h3>
        <p class="text-gray-600">Menyediakan pendidikan teknologi siber yang komprehensif, mendorong inovasi dan kreativitas melalui kolaborasi, membangun kesadaran akan etika digital, menjalin kemitraan strategis, serta memberikan dukungan berkelanjutan bagi generasi muda untuk sukses di dunia teknologi.</p>
      </div>
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