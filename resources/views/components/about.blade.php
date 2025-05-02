<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
  <!-- Swiper CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css"/>
  
  <!-- About Section -->
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
                <div class="mb-6">
                    <h3 class="text-xl md:text-2xl text-center font-semibold text-midnight text-opacity-90">
                       Tentang Kami
                    </h3>
                </div>

                <!-- Description -->
                <p class="text-md text-gray-700 text-center">
                    Sibermuda adalah platform pembelajaran digital yang dirancang untuk mempermudah proses belajar di bidang teknologi dan digital. Kami menawarkan berbagai kursus yang dapat mendukung pengembangan keterampilan dan kemampuan digitalmu.
                </p>

                <!-- Accordion -->
                <div class="grid grid-cols-1 gap-4" id="accordion">
                    <!-- Card 1 -->
                    <div class="card h-full flex flex-col bg-white border-2 border-gray-300 rounded-lg transition-all duration-300 ease-in-out" data-aos="fade-up">
                        <button class="flex justify-between items-center w-full px-4 py-2 text-md text-left text-gray-700 font-semibold focus:outline-none"
                            onclick="toggleFeature(this)">
                            <span>Akses Materi Pembelajaran Terlengkap</span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                class="w-5 h-5 transition-transform duration-300 transform rotate-0">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                            </svg>
                        </button>
                        <div class="feature-content max-h-0 overflow-hidden transition-all duration-300 ease-in-out px-4 pb-3  bg-white rounded-b-lg opacity-0">
                            <p class="text-gray-600">
                                Sibermuda.Idn menyediakan akses ke berbagai materi pembelajaran dari berbagai bidang studi yang memungkinkan siswa untuk belajar dengan cara yang lebih terstruktur dan efektif.
                            </p>
                        </div>
                    </div>
                
                    <!-- Card 2 -->
                    <div class="card h-full flex flex-col bg-white border-2 border-gray-300 rounded-lg transition-all duration-300 ease-in-out" data-aos="fade-up">
                        <button class="flex justify-between items-center w-full px-4 py-2 text-md text-left text-gray-700 font-semibold focus:outline-none"
                            onclick="toggleFeature(this)">
                            <span>Pembelajaran Interaktif dan Menyenangkan</span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                class="w-5 h-5 transition-transform duration-300 transform rotate-0">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                            </svg>
                        </button>
                        <div class="feature-content max-h-0 overflow-hidden transition-all duration-300 ease-in-out px-4 pb-3  bg-white rounded-b-lg opacity-0">
                            <p class="text-gray-600">
                                Dengan fitur pembelajaran interaktif, Sibermuda menjadikan proses belajar lebih menyenangkan dan tidak membosankan. Siswa dapat berinteraksi dengan materi melalui tugas akhir yang membuat mereka lebih terlibat dalam proses belajar.
                            </p>
                        </div>
                    </div>
                
                    <!-- Card 3 -->
                    <div class="card h-full flex flex-col bg-white border-2 border-gray-300 rounded-lg transition-all duration-300 ease-in-out" data-aos="fade-up">
                        <button class="flex justify-between items-center w-full px-4 py-2 text-md text-left text-gray-700 font-semibold focus:outline-none"
                            onclick="toggleFeature(this)">
                            <span>Fasilitas untuk Mentor dan Peserta</span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                class="w-5 h-5 transition-transform duration-300 transform rotate-0">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m19.5 8.25-7.5 7.5-7.5-7.5" />
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
                        <button class="flex justify-between items-center w-full px-4 py-2 text-md text-left text-gray-700 font-semibold focus:outline-none"
                            onclick="toggleFeature(this)">
                            <span>Sertifikat Digital Setelah Selesai Kursus</span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                class="w-5 h-5 transition-transform duration-300 transform rotate-0">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                            </svg>
                        </button>
                        <div class="feature-content max-h-0 overflow-hidden transition-all duration-300 ease-in-out px-4 pb-3  bg-white rounded-b-lg opacity-0">
                            <p class="text-gray-600">
                                Setelah menyelesaikan kursus, siswa akan mendapatkan sertifikat digital yang dapat digunakan sebagai bukti kompetensi mereka. Sertifikat ini dapat menjadi nilai tambah untuk karier di dunia digital.
                            </p>
                        </div>
                    </div>
                </div>
                
            </div>
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

<section id="founder" class="py-12 max-w-7xl mx-auto px-4 md:px-8">
    <h2 class="text-xl md:text-2xl text-center font-semibold text-midnight text-opacity-90 mb-8" data-aos="fade-right">Founder</h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6" data-aos="fade-right">
        <!-- Card 1 -->
        <div>
            <div class="bg-white rounded-2xl border border-gray-200 h-[410px] p-4 text-left">
                <div class="mb-2">
                  <h3 class="text-lg font-semibold text-midnight">Rama Ahmed</h3>
                  <p class="text-sm text-gray-500">Chief Executive Officer</p>
                </div>
                <img src="{{ asset('storage/mentor.jpg') }}" alt="Mentor Profile" class="rounded-xl mb-4 w-full h-80 object-cover">
            </div>
        </div>

        <!-- Card 2 -->
        <div>
            <div class="bg-white rounded-2xl border border-gray-200 h-[410px] p-4 text-left">
                <div class="mb-2">
                  <h3 class="text-lg font-semibold text-midnight">Rizky MR</h3>
                  <p class="text-sm text-gray-500">Chief Technology Officer</p>
                </div>
                <img src="{{ asset('storage/mentor.jpg') }}" alt="Mentor Profile" class="rounded-xl mb-4 w-full h-80 object-cover">
            </div>
        </div>

        <!-- Card 3 -->
        <div>
            <div class="bg-white rounded-2xl border border-gray-200 h-[410px] p-4 text-left">
                <div class="mb-2">
                  <h3 class="text-lg font-semibold text-midnight">Delika Pratiwi</h3>
                  <p class="text-sm text-gray-500">Chief Academy Officer</p>
                </div>
                <img src="{{ asset('storage/mentor.jpg') }}" alt="Mentor Profile" class="rounded-xl mb-4 w-full h-80 object-cover">
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

