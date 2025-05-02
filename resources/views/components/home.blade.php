<!-- Home Section -->
<section id="home" class="flex items-center h-screen bg-midnigt md:rounded-b-3xl" data-aos="fade-up"> 
  {{-- Gambar background acak --}}
  @for ($i = 0; $i < 15; $i++)
    @php
      // Posisi random dengan jarak aman agar tidak bertumpuk
      $top = rand(5, 85);   // top in percentage
      $left = rand(5, 85);  // left in percentage
      $size = rand(30, 50); // ukuran gambar (dalam px)
      $delayClass = ['animate-fade-slow', 'animate-fade-slower', 'animate-fade-slowest'][rand(0, 2)];
      $style = "top: {$top}%; left: {$left}%; width: {$size}px; height: {$size}px;";
      $zIndex = $i + 1; // memastikan gambar memiliki urutan yang berbeda
    @endphp
    <div class="absolute z-0 bg-no-repeat bg-cover opacity-0 {{ $delayClass }}"
         style="{{ $style }} background-image: url('/storage/bg-wp.png'); z-index: {{ $zIndex }};">
    </div>
  @endfor

  <div class="container mx-auto px-2 md:px-12 py-8 {{ $hasPromo ? 'mt-36 md:mt-32' : 'mt-12' }} rounded-b-3xl relative z-30">
    <div class="flex flex-col items-center gap-6">
      
      <!-- TEKS -->
      <div class="w-full text-center md:text-left flex flex-col justify-center items-center">
        <div class="flex border border-gray-200 rounded-full flex-wrap justify-center gap-1 mb-6">
            <a href="#home2" class="hidden md:inline-flex px-4 py-1.5 text-sm font-semibold text-gray-700 bg-gray-100 rounded-full m-1">
              Kenapa Pilih Kami?
            </a>
            <a href="#category" class="group flex space-x-2 justify-center items-center px-4 py-1.5 text-sm font-semibold text-midnight bg-white rounded-full hover:bg-white/65 transition-all duration-300">
              Lihat Kategori Kursus 
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 transform transition-transform duration-300 group-hover:translate-x-1">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
              </svg>
            </a>
        </div>

        <p class="text-3xl md:text-5xl font-semibold mb-4 pb-1 font-['Roboto'] bg-gradient-to-r from-blue-400 to-blue-900 text-transparent bg-clip-text">Upgrade Skill-mu</p>
        <p class="text-3xl md:text-5xl font-semibold mb-4 font-['Roboto'] text-gray-700">
          Bersama <span class="">Sibermuda.Idn</span>
        </p>
        <p class="text-lg mb-4 text-gray-600">
          Kursus online berkualitas dengan pendekatan praktis dan dukungan mentor yang siap membimbingmu.
        </p>
        <a href="{{ ('login') }}">
          <button class="text-sm px-6 py-2 rounded-md bg-midnight border border-gray-700 hover:bg-midnight text-midnigt mt-2 text-white font-medium shadow-md hover:bg-opacity-90 transition-transform duration-300 ease-in-out transform hover:scale-105">
            Belajar Sekarang
          </button>
        </a>
      </div>

    </div>
  </div>
</section>

<!-- Card Section -->
<div id="home2" class="bg-midnight z-10 pb-6 lg:pb-20 md:pt-6 mx-4 md:mx-20 rounded rounded-2xl" data-aos="fade-up">
    <div class="container mx-auto px-6 md:px-12">
    <p class="text-center font-md text-white text-xl mb-2 md:mb-5 mt-2 pt-4 md:text-3xl" data-aos="fade-up">
    Mengapa <span class="text-white">Sibermuda.Idn</span> Adalah Pilihan Tepat?</p>
    <p class="text-white/65 text-center mb-1" data-aos="fade-up">Bangun karirmu dengan pembelajaran yang tepat, bersama mentor terbaik dan materi berstandar industri.</p>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6" data-aos="fade-up">
            <!-- Card 1 -->
            <div class="bg-midnigt rounded-xl overflow-hidden transform transition-transform hover:scale-105">
              <div class="flex items-center py-4">
                <!-- Icon -->
                <div class="p-3 rounded-full bg-midnigt border border-midnigt mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="white" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                    </svg>
                </div>

                <!-- Teks -->
                <div class="text-left">
                    <h3 class="font-medium text-lg text-white">Mentor Gaul</h3>
                    <p class="text-white/65 text-sm">Dengan adanya pembelajaran yang asik, dapat mempermudah untuk memahami pembelajaran.</p>
                </div>
              </div>
            </div>
            
            <!-- Card 3 -->
            <div class="bg-midnigt rounded-xl overflow-hidden transform transition-transform hover:scale-105">
              <div class="flex items-center py-4">
                <!-- Icon -->
                <div class="p-3 rounded-full bg-midnigt border border-midnigt mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="white" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
                    </svg>
                </div>

                <!-- Teks -->
                <div class="text-left">
                    <h3 class="font-medium text-lg text-white">Perkembangan pemuda</h3>
                    <p class="text-white/65 text-sm">Cukup mengikuti course ini dalam 1 kali, pemuda sudah bisa berkarir dengan handal.</p>
                </div>
              </div>
            </div>

            <!-- Card 4 -->
            <div class="bg-midnigt rounded-xl overflow-hidden transform transition-transform hover:scale-105">
                <div class="flex items-center py-4">
                  <!-- Icon -->
                  <div class="p-3 rounded-full bg-midnigt border border-midnigt mr-4">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                          stroke-width="1.5" stroke="white" class="w-6 h-6">
                          <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16.5 18.75h-9m9 0a3 3 0 0 1 3 3h-15a3 3 0 0 1 3-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 0 1-.982-3.172M9.497 14.25a7.454 7.454 0 0 0 .981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 0 0 7.73 9.728M5.25 4.236V4.5c0 2.108.966 3.99 2.48 5.228M5.25 4.236V2.721C7.456 2.41 9.71 2.25 12 2.25c2.291 0 4.545.16 6.75.47v1.516M7.73 9.728a6.726 6.726 0 0 0 2.748 1.35m8.272-6.842V4.5c0 2.108-.966 3.99-2.48 5.228m2.48-5.492a46.32 46.32 0 0 1 2.916.52 6.003 6.003 0 0 1-5.395 4.972m0 0a6.726 6.726 0 0 1-2.749 1.35m0 0a6.772 6.772 0 0 1-3.044 0" />
                      </svg>                          
                  </div>

                  <!-- Teks -->
                  <div class="text-left">
                      <h3 class="font-medium text-lg text-white">Sertifikat</h3>
                      <p class="text-white/65 text-sm">Dapatkan sertifikat setelah menyelesaikan kursus.</p>
                  </div>
              </div>
            </div>

            <!-- Card 5 -->
            <div class="bg-midnigt rounded-xl overflow-hidden transform transition-transform hover:scale-105">
              <div class="flex items-center py-4">
                <!-- Ikon -->
                <div class="p-3 rounded-full bg-midnigt border border-midnigt mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="white"
                        class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>

                <!-- Teks -->
                <div class="text-left">
                    <h3 class="font-medium text-lg text-white">Materi 24 jam</h3>
                    <p class="text-white/65 text-sm">Akses materi belajar kapan saja, 24 jam penuh.</p>
                </div>
              </div>
            </div>

        </div>
    </div>
</div>
