<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite('resources/css/app.css')
    <script src="https://cdn.tailwindcss.com"></script> <!-- import tailwind (pake CDN juga soalnya pas di hosting ga muncul style nya) -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script> <!-- import alphine untuk layout responsivenya -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Protest+Guerrilla&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- import sweetalert untuk popup -->
    @vite('resources/js/app.js') <!-- tambah ini untuk menginisialisasi sweetalert yang sudah diimport di app.js dan alert.js di folder js -->
    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>
</head>
<body class="bg-white">

<!-- include elemen loading-screen, untuk animasi saat halaman sedang loading -->
<x-loading-screen />

    <!-- Wrapper -->
    <div class="flex h-screen" x-data="{ sidebarExpanded: true }">

        <!-- Sidebar -->
        <div 
            class="fixed z-50 inset-y-0 left-0 shadow-lg transition-all duration-300 ease-in-out 
            lg:static lg:translate-x-0 flex flex-col justify-between bg-white border-r border-gray-200"
            :class="{
                'translate-x-0': sidebarExpanded,
                '-translate-x-full': !sidebarExpanded,
                'lg:w-64': sidebarExpanded,
                'lg:w-16': !sidebarExpanded
            }"
        >

        <div class="flex items-center justify-center space-x-5 md:justify-center mx-2 mt-6">
            <!-- Logo dan Teks -->
            <div class="flex items-center space-x-2">
            <p 
                class="font-semibold transition-opacity duration-300 text-gray-700" 
                x-show="sidebarExpanded"
                x-transition
                x-cloak
            >
                Sibermuda.Idn
            </p>
            <div class="md:absolute md:right-[-18px] top-6">
                <!-- Tombol toggle untuk membuka tutup sidebar -->
                <button 
                    @click="sidebarExpanded = !sidebarExpanded" 
                    class="p-1 bg-white text-gray-700 rounded-full">
                    
                    <!-- Icon Arrow Left jika sidebar terbuka -->
                    <template x-if="sidebarExpanded">
                        <div class="p-0.5 rounded-full border border-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 font-semibold text-gray-400">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                            </svg>
                        </div>
                    </template>
                    <!-- Icon Arrow Right jika sidebar tertutup -->
                    <template x-if="!sidebarExpanded">
                        <div class="p-0.5 rounded-full border border-gray-400">
                           <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 font-semibold text-gray-400">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                            </svg>
                        </div>
                    </template>
                </button>
            </div>
            </div>
        </div>

            <nav class="flex-grow mt-4">
                <ul class="ml-4 mr-4 mt-5 space-y-2 text-gray-800 py-1">
                    
                <a href="{{ route('welcome-peserta') }}" class="block">
                    <li class="flex items-center px-4 py-2 rounded-md space-x-4 {{ Request::routeIs('welcome-peserta') ? 'bg-midnight' : 'hover:bg-gray-200' }}" :class="sidebarExpanded ? 'px-4' : 'px-1.5'">
                        <!-- Icon SELALU tampil -->
                        <svg class="w-5 h-5 shrink-0 {{ Request::routeIs('welcome-peserta') ? 'text-white' : 'text-gray-700' }}" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                            <path d="M575.8 255.5c0 18-15 32.1-32 32.1l-32 0 .7 160.2c0 2.7-.2 5.4-.5 8.1l0 16.2c0 22.1-17.9 40-40 40l-16 0c-1.1 0-2.2 0-3.3-.1c-1.4 .1-2.8 .1-4.2 .1L416 512l-24 0c-22.1 0-40-17.9-40-40l0-24 0-64c0-17.7-14.3-32-32-32l-64 0c-17.7 0-32 14.3-32 32l0 64 0 24c0 22.1-17.9 40-40 40l-24 0-31.9 0c-1.5 0-3-.1-4.5-.2c-1.2 .1-2.4 .2-3.6 .2l-16 0c-22.1 0-40-17.9-40-40l0-112c0-.9 0-1.9 .1-2.8l0-69.7-32 0c-18 0-32-14-32-32.1c0-9 3-17 10-24L266.4 8c7-7 15-8 22-8s15 2 21 7L564.8 231.5c8 7 12 15 11 24z"/>
                        </svg>

                        <!-- Teks disembunyikan saat sidebar ditutup -->
                        <span 
                            x-show="sidebarExpanded"
                            x-transition
                            x-cloak
                            class="whitespace-nowrap {{ Request::routeIs('welcome-peserta') ? 'text-white' : 'text-gray-700' }}"
                        >
                            Dashboard
                        </span>
                    </li>
                </a>

                <a href="{{ route('kategori-peserta') }}" class="block">
                    <li 
                        class="flex items-center py-2 rounded-md space-x-4 {{ Request::routeIs('kategori-peserta', 'categories-detail', 'kursus-peserta') ? 'bg-midnight' : 'hover:bg-gray-200' }}"
                        :class="sidebarExpanded ? 'px-4' : 'px-1.5'"
                    >
                        <svg class="w-5 h-5 shrink-0 text-gray-700 {{ Request::routeIs('kategori-peserta') ? 'text-white' : 'text-gray-700' }}" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                            <path d="M40 48C26.7 48 16 58.7 16 72l0 48c0 13.3 10.7 24 24 24l48 0c13.3 0 24-10.7 24-24l0-48c0-13.3-10.7-24-24-24L40 48zM192 64c-17.7 0-32 14.3-32 32s14.3 32 32 32l288 0c17.7 0 32-14.3 32-32s-14.3-32-32-32L192 64zm0 160c-17.7 0-32 14.3-32 32s14.3 32 32 32l288 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-288 0zm0 160c-17.7 0-32 14.3-32 32s14.3 32 32 32l288 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-288 0zM16 232l0 48c0 13.3 10.7 24 24 24l48 0c13.3 0 24-10.7 24-24l0-48c0-13.3-10.7-24-24-24l-48 0c-13.3 0-24 10.7-24 24zM40 368c-13.3 0-24 10.7-24 24l0 48c0 13.3 10.7 24 24 24l48 0c13.3 0 24-10.7 24-24l0-48c0-13.3-10.7-24-24-24l-48 0z"/>
                        </svg>
                        <span x-show="sidebarExpanded" x-transition x-cloak class="whitespace-nowrap text-gray-700 {{ Request::routeIs('kategori-peserta') ? 'text-white' : 'text-gray-700' }}">Kategori</span>
                    </li>
                </a>

                <a href="{{ route('daftar-kursus') }}" class="block">
                    <li 
                        class="flex items-center py-2 rounded-md space-x-4 {{ Request::routeIs('daftar-kursus', 'detail-kursus', 'study-peserta', 'chat.student', 'quiz.show', 'quiz.result') ? 'bg-midnight' : 'hover:bg-gray-200' }}"
                        :class="sidebarExpanded ? 'px-4' : 'px-1.5'"
                    >
                        <svg class="w-5 h-5 shrink-0 {{ Request::routeIs('daftar-kursus') ? 'text-white' : 'text-gray-700' }}" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                            <path d="M128 32C92.7 32 64 60.7 64 96l0 256 64 0 0-256 384 0 0 256 64 0 0-256c0-35.3-28.7-64-64-64L128 32zM19.2 384C8.6 384 0 392.6 0 403.2C0 445.6 34.4 480 76.8 480l486.4 0c42.4 0 76.8-34.4 76.8-76.8c0-10.6-8.6-19.2-19.2-19.2L19.2 384z"/>
                        </svg>
                        <span x-show="sidebarExpanded" x-transition x-cloak class="whitespace-nowrap  {{ Request::routeIs('daftar-kursus') ? 'text-white' : 'text-gray-700' }}">Belajar</span>
                    </li>
                </a>

                </ul>
            </nav>

        </div>

        <!-- Overlay (untuk layar kecil) -->
        <div 
            x-show="sidebarExpanded" 
            @click="sidebarExpanded = false"
            x-transition.opacity.duration.300ms
            class="fixed inset-0 bg-black bg-opacity-50 lg:hidden">
        </div>

        <!-- Content didalam navbar -->
        <div class="flex-1 flex flex-col">
            <!-- Navbar -->
            <header class="bg-white p-2 flex items-center justify-start border-b border-gray-200">
                <!-- Tombol Toggle Sidebar -->
            <button 
                @click="sidebarExpanded = !sidebarExpanded" 
                class="lg:hidden p-1 border border-gray-300 text-gray-700 rounded-md">
                <!-- Icon ☰ -->
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                    <path fill-rule="evenodd" d="M3 6.75A.75.75 0 0 1 3.75 6h16.5a.75.75 0 0 1 0 1.5H3.75A.75.75 0 0 1 3 6.75ZM3 12a.75.75 0 0 1 .75-.75h16.5a.75.75 0 0 1 0 1.5H3.75A.75.75 0 0 1 3 12Zm0 5.25a.75.75 0 0 1 .75-.75h16.5a.75.75 0 0 1 0 1.5H3.75a.75.75 0 0 1-.75-.75Z" clip-rule="evenodd" />
                </svg>
            </button>

                <div class="flex items-center ml-auto mr-4 relative"> <!-- container utaman untuk konten didalam navbar -->
                    @php
                    $cartCount = \App\Models\Keranjang::where('user_id', Auth::id())->count();
                @endphp
                
                <a href="{{ route('cart.index') }}" class="relative cursor-pointer mr-6">
                    @if($cartCount > 0)
                        <div class="absolute -top-1 -right-2 bg-red-500 text-gray-700 text-xs text-xs w-4 h-4 flex items-center justify-center rounded-full border-1 border-white">
                            {{ $cartCount }}
                        </div>
                    @endif
                
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" class="w-6 h-6 text-gray-700 hover:text-gray-800">
                        <path d="M0 24C0 10.7 10.7 0 24 0L69.5 0c22 0 41.5 12.8 50.6 32l411 0c26.3 0 45.5 25 38.6 50.4l-41 152.3c-8.5 31.4-37 53.3-69.5 53.3l-288.5 0 5.4 28.5c2.2 11.3 12.1 19.5 23.6 19.5L488 336c13.3 0 24 10.7 24 24s-10.7 24-24 24l-288.3 0c-34.6 0-64.3-24.6-70.7-58.5L77.4 54.5c-.7-3.8-4-6.5-7.9-6.5L24 48C10.7 48 0 37.3 0 24zM128 464a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm336-48a48 48 0 1 1 0 96 48 48 0 1 1 0-96z"/>
                    </svg>
                </a>
                
                <div class="relative">
                <!-- Wrapper yang bisa diklik untuk membuka dropdown -->
                <div id="profile-dropdown-toggle" class="flex items-center space-x-3 cursor-pointer flex items-center">
                    <div>
                        <!-- Pengecekan gambar profil -->
                        @if(Auth::user()->photo)
                            <!-- Tampilkan gambar profil jika ada -->
                            <img src="{{ asset('storage/' . Auth::user()->photo) }}" alt="User Profile" class="rounded-full w-8 h-8 object-cover">
                            @else
                            <!-- Tampilkan gambar default jika tidak ada foto profil -->
                            <img src="{{ asset('storage/default-profile.jpg') }}" alt="Default Profile" class="rounded-full w-8 h-8 object-cover">
                        @endif
                    </div>
                    <!-- Nama dan Role -->
                    @if(Auth::check())
                        <div class="hidden md:block flex flex-col">
                            <p class="text-gray-800 font-semibold mr-2 text-sm">{{ Str::limit(Auth::user()->name, 9, '') }}</p>
                            <p class="text-gray-600 text-sm">{{ Auth::user()->role }}</p>
                        </div>
                    @else
                        <p class="text-gray-800 font-semibold mr-2">Guest</p>
                        <p class="text-gray-600 text-sm">Not logged in</p>
                    @endif
                    <!-- Icon Dropdown -->
                    <button id="dropdown-button-profile" class="text-gray-600 focus:outline-none ml-2 transition-transform duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-gray-600">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                        </svg>
                    </button>
                </div>

                <!-- Dropdown Menu -->
                <div id="dropdown" class="hidden absolute right-0 mt-2 w-48 bg-white border rounded-lg shadow-lg z-10">
                    <ul class="py-1 space-y-1">
                        <li>
                            <a href="{{ route('settings-student') }}" class="group group-hover:text-white block flex items-center p-1 text-sm text-gray-700 hover:bg-midnight rounded-md mx-2">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" 
                                    class="w-4 h-4 ml-1 m-2 fill-current group-hover:text-white">
                                    <path d="M495.9 166.6c3.2 8.7 .5 18.4-6.4 24.6l-43.3 39.4c1.1 8.3 1.7 16.8 1.7 25.4s-.6 17.1-1.7 25.4l43.3 39.4c6.9 6.2 9.6 15.9 6.4 24.6c-4.4 11.9-9.7 23.3-15.8 34.3l-4.7 8.1c-6.6 11-14 21.4-22.1 31.2c-5.9 7.2-15.7 9.6-24.5 6.8l-55.7-17.7c-13.4 10.3-28.2 18.9-44 25.4l-12.5 57.1c-2 9.1-9 16.3-18.2 17.8c-13.8 2.3-28 3.5-42.5 3.5s-28.7-1.2-42.5-3.5c-9.2-1.5-16.2-8.7-18.2-17.8l-12.5-57.1c-15.8-6.5-30.6-15.1-44-25.4L83.1 425.9c-8.8 2.8-18.6 .3-24.5-6.8c-8.1-9.8-15.5-20.2-22.1-31.2l-4.7-8.1c-6.1-11-11.4-22.4-15.8-34.3c-3.2-8.7-.5-18.4 6.4-24.6l43.3-39.4C64.6 273.1 64 264.6 64 256s.6-17.1 1.7-25.4L22.4 191.2c-6.9-6.2-9.6-15.9-6.4-24.6c4.4-11.9 9.7-23.3 15.8-34.3l4.7-8.1c6.6-11 14-21.4 22.1-31.2c5.9-7.2 15.7-9.6 24.5-6.8l55.7 17.7c13.4-10.3 28.2-18.9 44-25.4l12.5-57.1c2-9.1 9-16.3 18.2-17.8C227.3 1.2 241.5 0 256 0s28.7 1.2 42.5 3.5c9.2 1.5 16.2 8.7 18.2 17.8l12.5 57.1c15.8 6.5 30.6 15.1 44 25.4l55.7-17.7c8.8-2.8 18.6-.3 24.5 6.8c8.1 9.8 15.5 20.2 22.1 31.2l4.7 8.1c6.1 11 11.4 22.4 15.8 34.3zM256 336a80 80 0 1 0 0-160 80 80 0 1 0 0 160z"/>
                                </svg>
                                <span class="group-hover:text-white">Profile</span>
                            </a>
                        </li>
                        <li>
                            <a class="group block flex items-center p-1 text-sm text-red-600 hover:bg-red-600 hover:text-gray-700 rounded-md mx-2">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" 
                                    class="w-4 h-4 ml-1 m-2 fill-current group-hover:text-white">
                                    <path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"/>
                                </svg>
                                <form action="{{ route('logout') }}" method="GET" class="w-full">
                                    @csrf
                                    <button type="submit" class="w-full text-left py-1.5 text-sm text-red-600 group-hover:text-white">
                                        Keluar
                                    </button>
                                </form>
                            </a>
                        </li>
                    </ul>                            
                </div>
                </div>
                </div> 
            </header>

            <!-- Konten utama -->
            <main class="flex-1 p-6 overflow-auto">
                @yield('content')
            </main>

            <!-- Footer -->
            <footer class="bg-white text-left text-gray-600 text-sm p-3 shadow-lg"> 
               Copyright © 2025 <span class="text-sky-600">Sibermuda.Idn</span> All Rights Reserved.
            </footer>

        </div>
    </div>

<!-- Script untuk Menangani Dropdown -->
<script>
    const dropdownToggle = document.getElementById('profile-dropdown-toggle');
    const dropdown = document.getElementById('dropdown');
    const dropdownIcon = document.getElementById('dropdown-button-profile');

    document.addEventListener('click', (event) => {
        if (dropdownToggle.contains(event.target)) {
            // Toggle dropdown dan rotasi ikon
            dropdown.classList.toggle('hidden');
            dropdownIcon.classList.toggle('rotate-180');
        } else {
            // Tutup dropdown jika klik di luar, pastikan ikon kembali ke posisi awal
            if (!dropdown.classList.contains('hidden')) {
                dropdown.classList.add('hidden');
                dropdownIcon.classList.remove('rotate-180'); // Pastikan ikon kembali normal saat dropdown tertutup
            }
        }
    });

    // Menutup dropdown jika klik di luar
    window.addEventListener('click', (event) => {
        if (!dropdownButton.contains(event.target) && !dropdown.contains(event.target)) {
            dropdown.classList.add('hidden');
            dropdownIcon.classList.remove('rotate-90');
        }
    });

    // function untuk menampilkan animasi saat halaman sedang loading (component sudah di include di paling atas layout)
    window.addEventListener('load', () => {
        const loader = document.getElementById('loading-screen');
        if (loader) {
            loader.classList.add('opacity-0', 'transition-opacity', 'duration-500');
            setTimeout(() => loader.remove(), 500); // hilangkan dari DOM
        }
    });
</script>   

<!-- tambah ini untuk menangkap popup pesan backend menggunakan sweetalert -->
@if(session('success') || session('error') || session('info') || session('warning'))
    <div id="sweetalert-data"
         data-type="{{ session('success') ? 'success' : (session('error') ? 'error' : (session('info') ? 'info' : 'warning')) }}"
         data-message="{{ session('success') ?? session('error') ?? session('info') ?? session('warning') }}">
    </div>
@endif

</body>
</html>