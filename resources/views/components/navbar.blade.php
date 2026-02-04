<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landingpage</title>
    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body>
<!-- ========== HEADER ========== -->
<header class="flex flex-wrap fixed md:justify-start md:flex-nowrap z-50 w-full py-2 bg-white shadow-md">
  <nav class="relative max-w-7xl w-full flex flex-wrap md:grid md:grid-cols-12 basis-full items-center px-4 md:px-12 mx-auto">
    <div class="md:col-span-3 flex items-center gap-2">
      <!-- Logo -->
       <div class="">
        <img src="{{ asset('storage/login2.png') }}" alt="image description" class="rounded-full bg-white w-10 h-10">
       </div>
      <!-- End Logo -->

      <!-- Teks hanya muncul di layar md ke atas -->
      <span class="text-md font-semibold text-midnight">Sibermuda.Id</span>
    </div>

    <!-- Button Group -->
    <div class="flex items-center gap-x-1 md:gap-x-2 ms-auto py-1 md:order-3 md:col-span-3">
      <!-- Tombol Account hanya muncul di layar menengah keatas -->
        <a href="/register" type="button"
          class="hidden md:inline-flex group py-2 px-4 md:border-1 md:hover:bg-midnight border border-midnight md:border-midnight items-center gap-x-2 text-sm font-medium rounded-xl md:rounded-full focus:outline-none transition ease-in-out duration-300">
            <!-- Teks Daftar -->
            <span class="text-midnight group-hover:text-white transition-colors duration-300">Daftar</span>
        </a>
        <a href="/login" type="button" class="group py-2 px-4 border-white bg-midnight border hover:border-midnight hover:bg-white inline-flex items-center gap-x-2 text-sm font-medium rounded-xl md:rounded-full focus:outline-none transition ease-in-out duration-300">
            <!-- Teks Account hanya tampil di layar medium ke atas -->
            <span class="hidden md:block text-white group-hover:text-midnight hover:border-midnight transition-colors duration-300">Masuk</span>
            <!-- Ikon hanya tampil di layar kecil -->
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-white group-hover:text-midnight block md:hidden w-5 h-5 transition-colors duration-300">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963  0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15  9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
            </svg>
        </a>

      <div class="md:hidden">
        <button type="button" id="menu-toggle" class="size-[38px] flex justify-center items-center text-sm font-semibold rounded-xl text-midnight border border-midnight hover:bg-gray-100 focus:outline-none focus:bg-gray-100">
          <svg class="open-icon shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" x2="21" y1="6" y2="6"/><line x1="3" x2="21" y1="12" y2="12"/><line x1="3" x2="21" y1="18" y2="18"/></svg>
          <svg class="close-icon hidden shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
        </button>
      </div>
    </div>
    <!-- End Button Group -->

    <!-- Menu di layar menengah keatas -->
    <div class="hidden md:block overflow-visible transition-all duration-300 basis-full grow md:w-auto md:basis-auto md:order-2 md:col-span-6 bg-navbar-default md:bg-transparent rounded-lg pl-4 pb-4 pt-2 z-50 mt-2">
      <div class="flex flex-col gap-y-4 gap-x-0 mt-5 md:flex-row md:justify-center md:items-center md:gap-y-0 md:gap-x-7 md:mt-0">
        <div>
          <a href="{{ route('landingpage') }}" class="relative inline-block hover:text-midnight focus:outline-none text-gray-600 transition-all duration-300 hover:-translate-y-0.5 {{ request()->routeIs('landingpage') ? 'font-semibold text-midnight' : '' }}">
            Beranda
          </a>
        </div>
        <div>
          <a href="{{ route('tentang.kami') }}" class="inline-block hover:text-midnight focus:outline-none text-gray-600 transition-all duration-300 hover:-translate-y-0.5 {{ request()->routeIs('tentang.kami') ? 'font-semibold text-midnight' : '' }}">
            Tentang
          </a>
        </div>
        <div>
          <a href="{{ route('category') }}" class="inline-block hover:text-midnight focus:outline-none text-gray-600 transition-all duration-300 hover:-translate-y-0.5 {{ request()->routeIs('category') ? 'font-semibold text-midnight' : '' }}">
            Kategori
          </a>
        </div>
        <div>
          <a href="{{ route('berita') }}" class="inline-block hover:text-midnight focus:outline-none text-gray-600 transition-all duration-300 hover:-translate-y-0.5 {{ request()->routeIs('berita') ? 'font-semibold text-midnight' : '' }}">
            Berita
          </a>
        </div>
        <div>
          <a href="{{ route('bootcamp') }}" class="inline-block hover:text-midnight focus:outline-none text-gray-600 transition-all duration-300 hover:-translate-y-0.5 {{ request()->routeIs('bootcamp') ? 'font-semibold text-midnight' : '' }}">
            Bootcamp
          </a>
        </div>

        <!-- Dropdown Others -->
        <div class="relative group">
          <button class="inline-flex items-center gap-x-2 hover:text-midnight focus:outline-none text-gray-600 transition-all duration-300 hover:-translate-y-0.5 {{ request()->routeIs(['visi.misi', 'testimoni', 'serti-verify']) ? 'font-semibold text-midnight' : '' }}">
            Lainnya
            <svg class="w-4 h-4 transition-transform duration-300 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
          </button>

          <!-- Dropdown Menu -->
          <div class="absolute left-0 mt-2 w-56 bg-white rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform group-hover:translate-y-0 -translate-y-2 z-50 border border-gray-100">
            <div class="py-2">
              <a href="{{ route('visi.misi') }}" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100 hover:text-midnight transition-colors duration-200 {{ request()->routeIs('visi.misi') ? 'bg-gray-100 font-semibold text-midnight' : '' }}">
                <div class="flex items-center gap-3">
                  <span>Visi & Misi</span>
                </div>
              </a>
              <a href="{{ route('testimoni') }}" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100 hover:text-midnight transition-colors duration-200 {{ request()->routeIs('testimoni') ? 'bg-gray-100 font-semibold text-midnight' : '' }}">
                <div class="flex items-center gap-3">
                  <span>Testimoni</span>
                </div>
              </a>
              <a href="{{ route('serti-verify') }}" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100 hover:text-midnight transition-colors duration-200 {{ request()->routeIs('serti-verify') ? 'bg-gray-100 font-semibold text-midnight' : '' }}">
                <div class="flex items-center gap-3">
                  <span>Verifikasi Sertifikat</span>
                </div>
              </a>
               <a href="{{ route('affiliate') }}" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100 hover:text-midnight transition-colors duration-200 {{ request()->routeIs('affiliate') ? 'bg-gray-100 font-semibold text-midnight' : '' }}">
                <div class="flex items-center gap-3">
                  <span>Affiliate</span>
                </div>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </nav>
</header>
<!-- ========== END HEADER ========== -->

<!-- Menu Mobile (Hamburger) -->
<div id="mobile-menu" class="fixed top-16 left-4 right-4 md:hidden overflow-hidden transition-all duration-300 bg-white rounded-lg shadow-lg z-50 hidden max-h-0">
  <div class="flex flex-col gap-y-2 p-4">
    <a href="{{ route('landingpage') }}" class="block px-4 py-2.5 text-gray-700 hover:bg-gray-100 hover:text-midnight rounded-lg transition-colors duration-200 {{ request()->routeIs('landingpage') ? 'bg-gray-100 font-semibold text-midnight' : '' }}">
      Beranda
    </a>
    <a href="{{ route('tentang.kami') }}" class="block px-4 py-2.5 text-gray-700 hover:bg-gray-100 hover:text-midnight rounded-lg transition-colors duration-200 {{ request()->routeIs('tentang.kami') ? 'bg-gray-100 font-semibold text-midnight' : '' }}">
      Tentang
    </a>
    <a href="{{ route('category') }}" class="block px-4 py-2.5 text-gray-700 hover:bg-gray-100 hover:text-midnight rounded-lg transition-colors duration-200 {{ request()->routeIs('category') ? 'bg-gray-100 font-semibold text-midnight' : '' }}">
      Kategori
    </a>
    <a href="{{ route('berita') }}" class="block px-4 py-2.5 text-gray-700 hover:bg-gray-100 hover:text-midnight rounded-lg transition-colors duration-200 {{ request()->routeIs('berita') ? 'bg-gray-100 font-semibold text-midnight' : '' }}">
      Berita
    </a>
    <a href="{{ route('bootcamp') }}" class="block px-4 py-2.5 text-gray-700 hover:bg-gray-100 hover:text-midnight rounded-lg transition-colors duration-200 {{ request()->routeIs('bootcamp') ? 'bg-gray-100 font-semibold text-midnight' : '' }}">
      Bootcamp
    </a>

    <!-- Mobile Dropdown -->
    <div class="border-t border-gray-200 mt-2 pt-2">
      <div class="px-4 py-2 text-xs font-semibold text-gray-500 uppercase">Lainnya</div>
      <a href="{{ route('visi.misi') }}" class="block px-4 py-2.5 text-gray-700 hover:bg-gray-100 hover:text-midnight rounded-lg transition-colors duration-200 {{ request()->routeIs('visi.misi') ? 'bg-gray-100 font-semibold text-midnight' : '' }}">
        <div class="flex items-center gap-3">
          <span>Visi & Misi</span>
        </div>
      </a>
      <a href="{{ route('testimoni') }}" class="block px-4 py-2.5 text-gray-700 hover:bg-gray-100 hover:text-midnight rounded-lg transition-colors duration-200 {{ request()->routeIs('testimoni') ? 'bg-gray-100 font-semibold text-midnight' : '' }}">
        <div class="flex items-center gap-3">
          <span>Testimoni</span>
        </div>
      </a>
      <a href="{{ route('serti-verify') }}" class="block px-4 py-2.5 text-gray-700 hover:bg-gray-100 hover:text-midnight rounded-lg transition-colors duration-200 {{ request()->routeIs('serti-verify') ? 'bg-gray-100 font-semibold text-midnight' : '' }}">
        <div class="flex items-center gap-3">
          <span>Verifikasi Sertifikat</span>
        </div>
      </a>
       <a href="{{ route('affiliate') }}" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100 hover:text-midnight transition-colors duration-200 {{ request()->routeIs('affiliate') ? 'bg-gray-100 font-semibold text-midnight' : '' }}">
            <div class="flex items-center gap-3">
                <span>Affiliate</span>
            </div>
        </a>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const menuToggle = document.getElementById('menu-toggle');
  const mobileMenu = document.getElementById('mobile-menu');
  const openIcon = menuToggle.querySelector('.open-icon');
  const closeIcon = menuToggle.querySelector('.close-icon');

  // Toggle mobile menu
  menuToggle.addEventListener('click', function () {
    if (mobileMenu.classList.contains('hidden')) {
      // Open menu
      mobileMenu.classList.remove('hidden');
      mobileMenu.style.maxHeight = mobileMenu.scrollHeight + 'px';
      openIcon.classList.add('hidden');
      closeIcon.classList.remove('hidden');
    } else {
      // Close menu
      mobileMenu.style.maxHeight = '0px';
      setTimeout(() => {
        mobileMenu.classList.add('hidden');
      }, 300);
      openIcon.classList.remove('hidden');
      closeIcon.classList.add('hidden');
    }
  });

  // Close menu when clicking outside
  document.addEventListener('click', function(event) {
    if (!menuToggle.contains(event.target) && !mobileMenu.contains(event.target)) {
      if (!mobileMenu.classList.contains('hidden')) {
        mobileMenu.style.maxHeight = '0px';
        setTimeout(() => {
          mobileMenu.classList.add('hidden');
        }, 300);
        openIcon.classList.remove('hidden');
        closeIcon.classList.add('hidden');
      }
    }
  });

  // Handle window resize
  window.addEventListener('resize', function () {
    if (window.innerWidth >= 768) {
      mobileMenu.classList.add('hidden');
      mobileMenu.style.maxHeight = '0px';
      openIcon.classList.remove('hidden');
      closeIcon.classList.add('hidden');
    }
  });
});
</script>
</body>
</html>
