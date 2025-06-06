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

<section class="py-16 px-4 bg-white">
  <div class="max-w-6xl mx-auto mt-7">
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