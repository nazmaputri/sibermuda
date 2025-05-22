<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landingpage</title>
    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400&display=swap" rel="stylesheet">
    <style>
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
      <span class="text-md font-semibold text-midnight">Sibermuda.Idn</span>
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
        <button type="button" id="menu-toggle" class="hs-collapse-toggle size-[38px] flex justify-center items-center text-sm font-semibold rounded-xl text-midnight border border-midnight text-orange hover:bg-gray-100 focus:outline-none focus:bg-gray-100" id="hs-navbar-hcail-collapse" aria-expanded="false" aria-controls="hs-navbar-hcail" aria-label="Toggle navigation" data-hs-collapse="#hs-navbar-hcail">
          <svg class="hs-collapse-open:hidden shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" x2="21" y1="6" y2="6"/><line x1="3" x2="21" y1="12" y2="12"/><line x1="3" x2="21" y1="18" y2="18"/></svg>
          <svg class="hs-collapse-open:block hidden shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
        </button>
      </div>
    </div>
    <!-- End Button Group -->

    <!-- Menu di layar menengah keatas -->
    <div id="" class="hidden md:block overflow-hidden transition-all duration-300 basis-full grow md:w-auto md:basis-auto md:order-2 md:col-span-6 bg-navbar-default md:bg-transparent rounded-lg pl-4 pb-4 pt-2 z-50 mt-2" aria-labelledby="hs-navbar-hcail-collapse">
      <div class="flex flex-col gap-y-4 gap-x-0 mt-5 md:flex-row md:justify-center md:items-center md:gap-y-0 md:gap-x-7 md:mt-0">
        <div>
          <a href="{{ route('landingpage') }}" class="relative inline-block hover:text-midnight focus:outline-none text-gray-600 transition-all duration-300 hover:-translate-y-0.5 {{ request()->routeIs('landingpage') ? 'font-semibold border-midnight' : '' }}" href="#" aria-current="page">
            Beranda
          </a>
        </div>
        <div>
          <a href="{{ route('tentang.kami') }}"class="inline-block hover:text-midnight focus:outline-none text-gray-600 transition-all duration-300 hover:-translate-y-0.5 {{ request()->routeIs('tentang.kami') ? 'font-semibold border-midnight' : '' }}">
            Tentang
          </a>
        </div>
        <div>
          <a href="{{ route('visi.misi') }}"class="inline-block hover:text-midnight focus:outline-none text-gray-600 transition-all duration-300 hover:-translate-y-0.5 {{ request()->routeIs('visi.misi') ? 'font-semibold border-midnight' : '' }}">
            Visi
          </a>
        </div>
        <div>
          <a href="{{ route('category') }}" class="inline-block hover:text-midnight focus:outline-none text-gray-600 transition-all duration-300 hover:-translate-y-0.5 {{ request()->routeIs('category') ? 'font-semibold border-midnight' : '' }}">
            Kategori
          </a>
        </div>
      </div>
    </div>
    <!-- End Collapse -->
  </nav>
</header>
<!-- ========== END HEADER ========== -->

<!-- Menu di layar menengah kebawah -->
<div id="hs-navbar-hcail"  class="hs-collapse fixed top-16 left-4 right-4 overflow-x-hidden my-4 z-50 md:hidden hidden overflow-hidden transition-all duration-300 bg-white border border-gray-300 shadow-sm rounded-lg pl-4 pr-4 pb-4 pt-2" aria-labelledby="hs-navbar-hcail-collapse">
  <div class="flex flex-col gap-y-4 gap-x-0 mt-2 md:flex-row md:justify-center md:items-center md:gap-y-0 md:gap-x-7 md:mt-0">
    <div>
      <a href="{{ route('landingpage') }}" class="relative inline-block hover:text-midnight focus:outline-none text-gray-600 transition-all duration-300 hover:-translate-y-0.5 {{ request()->routeIs('landingpage') ? 'font-semibold border-midnight' : '' }}" href="#" aria-current="page">
        Beranda
      </a>
    </div>
    <div>
      <a href="{{ route('tentang.kami') }}"class="inline-block hover:text-midnight focus:outline-none text-gray-600 transition-all duration-300 hover:-translate-y-0.5 {{ request()->routeIs('tentang.kami') ? 'font-semibold border-midnight' : '' }}">
        Tentang
      </a>
    </div>
    <div>
      <a href="{{ route('visi.misi') }}"class="inline-block hover:text-midnight focus:outline-none text-gray-600 transition-all duration-300 hover:-translate-y-0.5 {{ request()->routeIs('visi.misi') ? 'font-semibold border-midnight' : '' }}">
        Visi
      </a>
    </div>
    <div>
      <a href="{{ route('category') }}" class="inline-block hover:text-midnight focus:outline-none text-gray-600 transition-all duration-300 hover:-translate-y-0.5 {{ request()->routeIs('category') ? 'font-semibold border-midnight' : '' }}">
        Kategori
      </a>
    </div>
  </div>
</div>
</body>
</html>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const menuToggle = document.getElementById('menu-toggle');
  const menu = document.getElementById('hs-navbar-hcail');
  const openIcon = menuToggle.querySelector('.hs-collapse-open\\:hidden');
  const closeIcon = menuToggle.querySelector('.hs-collapse-open\\:block');
  const sections = ['home', 'about', 'category', 'price', 'rating'];
  const links = sections.map(section => document.getElementById('link-' + section));

  menuToggle.addEventListener('click', function () {
    if (window.innerWidth < 768) {
      if (menu.classList.contains('hidden')) {
        menu.classList.remove('hidden');
        menu.style.maxHeight = menu.scrollHeight + 'px';
        menu.classList.add('bg-white', 'text-midnight');
      } else {
        menu.style.maxHeight = '0px';
        setTimeout(() => {
          menu.classList.add('hidden');
        }, 300);
      }
      openIcon.classList.toggle('hidden');
      closeIcon.classList.toggle('hidden');
    }
  });

  window.addEventListener('resize', function () {
    if (window.innerWidth >= 768) {
      menu.style.maxHeight = 'none';
      menu.classList.remove('hidden');
      menu.classList.remove('bg-white', 'text-midnight');
      openIcon.classList.remove('hidden');
      closeIcon.classList.add('block');
    }
  });
  function setActiveLink() {
    let scrollPos = window.scrollY + 100; // 100px offset for better accuracy
    sections.forEach((section, index) => {
      let sectionElement = document.querySelector('#' + section);
      if (sectionElement) {
        let sectionTop = sectionElement.offsetTop;
        let sectionHeight = sectionElement.offsetHeight;
        if (scrollPos >= sectionTop && scrollPos < sectionTop + sectionHeight) {
          links.forEach(link => link.classList.remove('border-midnight', 'font-semibold'));
          links[index].classList.add('border-midnight', 'font-semibold');
        }
      }
    });
  }

  // Event listener for scroll to detect active section
  window.addEventListener('scroll', setActiveLink);

  // Event listener for click
  links.forEach(link => {
    link.addEventListener('click', function () {
      links.forEach(l => l.classList.remove('border-midnight'));
      this.classList.add('border-midnight');
    });
  });
});
</script>