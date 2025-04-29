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
                    <h3 class="text-xl md:text-3xl font-['Roboto'] text-center font-bold text-[#08072a] text-opacity-90">
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
</script>
</section>
