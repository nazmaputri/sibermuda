<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    @section('title', 'Dashboard Mentor')
    <script src="https://cdn.tailwindcss.com"></script> <!-- import tailwind (pake CDN juga soalnya pas di hosting ga muncul style nya) -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script> <!-- import alphine untuk layout responsivenya -->
    <script src="//unpkg.com/alpinejs" defer></script> <!-- Tambahkan Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Protest+Guerrilla&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- import sweetalert untuk popup -->
    @vite('resources/js/delete-confirm.js') <!-- tambah ini agar bisa menggunakan popup konfirmasi penghapusan data menggunakan sweetalert yang ada di folder js>delete-confirm.js -->
    @vite('resources/js/app.js') <!-- tambah ini untuk menginisialisasi sweetalert yang sudah diimport di app.js dan alert.js di folder js -->
    <style>
        body {
            font-family: 'Poppins', sans-serif !important;
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
            }">

            <div class="flex items-center justify-center space-x-5 md:justify-center mx-2 mt-6">
            <!-- Logo dan Teks -->
            <div class="flex items-center space-x-2">
            <p 
                class="font-semibold transition-opacity duration-300 text-gray-700" 
                x-show="sidebarExpanded"
                x-transition
                x-cloak
            >
                Sibermuda
                <span class="flex items-center gap-2 mt-1">
                    <span class="flex-1 h-px bg-gray-400"></span>
                    <span class="text-sm">Kursus</span>
                    <span class="flex-1 h-px bg-gray-400"></span>
                </span>
            </p>
            <div class="md:absolute md:right-[-16px] top-10">
                <!-- Tombol toggle untuk membuka tutup sidebar -->
                <button 
                    @click="sidebarExpanded = !sidebarExpanded" 
                    class="p-0.5 bg-white text-gray-700 rounded-full">
                    
                    <!-- Icon Arrow Left jika sidebar terbuka -->
                    <template x-if="sidebarExpanded">
                        <div class="p-0.5 rounded-full border border-gray-300">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 font-semibold text-gray-500">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                            </svg>
                        </div>
                    </template>
                    <!-- Icon Arrow Right jika sidebar tertutup -->
                    <template x-if="!sidebarExpanded">
                        <div class="p-0.5 rounded-full border border-gray-400">
                           <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 font-semibold text-gray-500">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                            </svg>
                        </div>
                    </template>
                </button>
            </div>
            </div>
        </div>

            <nav class="flex-grow mt-4">
                <ul class="ml-4 mr-4 space-y-2 mt-2 text-gray-800 py-1">

                <a href="{{ route('welcome-mentor') }}" class="block group">
                    <li class="flex items-center px-4 py-2 rounded-md space-x-4 transition-all duration-300 ease-in-out 
                            {{ Request::routeIs('welcome-mentor') ? 'bg-midnight' : 'hover:bg-gray-200' }}" 
                        :class="sidebarExpanded ? 'px-4' : 'px-1.5'">

                        <!-- Icon dengan efek geser ke kanan saat hover -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" 
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" 
                            class="w-5 h-5 transform transition-all duration-300 ease-in-out group-hover:translate-x-1
                                    {{ Request::routeIs('welcome-mentor') ? 'text-white' : 'text-gray-700' }}">
                            <path stroke-linecap="round" stroke-linejoin="round" 
                                d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                        </svg>

                        <!-- Teks juga ikut geser ke kanan saat hover -->
                        <span 
                            x-show="sidebarExpanded"
                            x-transition
                            x-cloak
                            class="whitespace-nowrap transform transition-all duration-300 ease-in-out group-hover:translate-x-1
                                {{ Request::routeIs('welcome-mentor') ? 'text-white' : 'text-gray-700' }}">
                            Dashboard
                        </span>
                    </li>
                </a>

                <a href="{{ route('courses.index') }}" class="block group">
                    <li class="flex items-center px-4 py-2 rounded-md space-x-4 transition-all duration-300 ease-in-out 
                            {{ Request::routeIs('courses.index', 'courses.show', 'courses.edit', 'courses.create', 'materi.show', 'materi.create', 'materi.edit', 'quiz.show', 'quiz.create', 'quiz.edit', 'chat-mentor', 'final-task.create', 'final-detail', 'final-edit') ? 'bg-midnight' : 'hover:bg-gray-200' }}" 
                        :class="sidebarExpanded ? 'px-4' : 'px-1.5'">

                        <!-- Icon dengan efek geser ke kanan saat hover -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" 
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" 
                            class="w-5 h-5 transform transition-all duration-300 ease-in-out group-hover:translate-x-1
                                {{ Request::routeIs('courses.index', 'courses.show', 'courses.edit', 'courses.create', 'materi.show', 'materi.create', 'materi.edit', 'quiz.show', 'quiz.create', 'quiz.edit', 'chat-mentor', 'final-task.create', 'final-detail', 'final-edit') ? 'text-white' : 'text-gray-700' }}">
                            <path stroke-linecap="round" stroke-linejoin="round" 
                                d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                        </svg>

                        <!-- Teks juga ikut geser ke kanan saat hover -->
                        <span 
                            x-show="sidebarExpanded"
                            x-transition
                            x-cloak
                            class="whitespace-nowrap transform transition-all duration-300 ease-in-out group-hover:translate-x-1
                                {{ Request::routeIs('courses.index', 'courses.show', 'courses.edit', 'courses.create', 'materi.show', 'materi.create', 'materi.edit', 'quiz.show', 'quiz.create', 'quiz.edit', 'chat-mentor', 'final-task.create', 'final-detail', 'final-edit') ? 'text-white' : 'text-gray-700' }}">
                            Kursus
                        </span>
                    </li>
                </a>

                <!-- <a href="{{ route ('rating-kursus') }}" class="block"class="block">
                    <li class="flex items-center px-4 py-2 rounded-xl space-x-4 {{ Request::routeIs('rating-kursus', 'rating-detail') ? 'bg-primary-sidebar' : 'hover:bg-primary-sidebar-hover' }}" :class="sidebarExpanded ? 'px-4' : 'px-1.5'">
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                            <path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"/>
                        </svg>
                        <span 
                            x-show="sidebarExpanded"
                            x-transition
                            x-cloak
                            class="whitespace-nowrap text-white">Penilaian</span>
                    </li>
                </a> -->

                <!-- <a href="{{ route ('laporan-mentor') }}" class="block"class="block">
                    <li class="flex items-center px-4 py-2 rounded-xl space-x-4 {{ Request::routeIs('laporan-mentor') ? 'bg-primary-sidebar' : 'hover:bg-primary-sidebar-hover' }}" :class="sidebarExpanded ? 'px-4' : 'px-1.5'">
                        <svg class="w-5 h-5"  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                            <path d="M32 32c17.7 0 32 14.3 32 32l0 336c0 8.8 7.2 16 16 16l400 0c17.7 0 32 14.3 32 32s-14.3 32-32 32L80 480c-44.2 0-80-35.8-80-80L0 64C0 46.3 14.3 32 32 32zM160 224c17.7 0 32 14.3 32 32l0 64c0 17.7-14.3 32-32 32s-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32zm128-64l0 160c0 17.7-14.3 32-32 32s-32-14.3-32-32l0-160c0-17.7 14.3-32 32-32s32 14.3 32 32zm64 32c17.7 0 32 14.3 32 32l0 96c0 17.7-14.3 32-32 32s-32-14.3-32-32l0-96c0-17.7 14.3-32 32-32zM480 96l0 224c0 17.7-14.3 32-32 32s-32-14.3-32-32l0-224c0-17.7 14.3-32 32-32s32 14.3 32 32z"/>
                        </svg>
                        <span 
                            x-show="sidebarExpanded"
                            x-transition
                            x-cloak
                            class="whitespace-nowrap text-white">Laporan</span>
                    </li>
                </a> -->

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
            <header class="bg-white shadow p-2 flex items-center justify-start">
                <!-- button ☰ membuka sidebar -->
                <button 
                    @click="sidebarExpanded = !sidebarExpanded" 
                    class="lg:hidden p-0.5 border border-gray-300 text-gray-700 rounded-md">
                    <!-- Icon ☰ -->
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                        <path fill-rule="evenodd" d="M3 6.75A.75.75 0 0 1 3.75 6h16.5a.75.75 0 0 1 0 1.5H3.75A.75.75 0 0 1 3 6.75ZM3 12a.75.75 0 0 1 .75-.75h16.5a.75.75 0 0 1 0 1.5H3.75A.75.75 0 0 1 3 12Zm0 5.25a.75.75 0 0 1 .75-.75h16.5a.75.75 0 0 1 0 1.5H3.75a.75.75 0 0 1-.75-.75Z" clip-rule="evenodd" />
                    </svg>
                </button>

                <h5 class="text-sm md:text-lg md:pl-4 font-semibold pl-1 text-gray-700">@yield('title')</h5>

                <div class="ml-auto flex mr-4 space-x-4">
                <!-- Notifikasi -->
                <div class="relative flex items-center cursor-pointer" id="notification-container">
                    <button id="notification-button" class="relative">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-500">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0"/>
                        </svg>

                        <!-- Badge notifikasi -->
                        <span id="notification-badge"
                            class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-medium rounded-full w-4 h-4 flex items-center justify-center hidden">
                            <span id="notification-count">0</span>
                        </span>
                    </button>

                    <!-- Dropdown notifikasi -->
                    <div id="notification-dropdown"
                        class="absolute right-0 top-10 md:top-12 bg-white shadow-lg border border-gray-200 rounded-md w-60 md:w-96 hidden z-30">
                        <p id="notification-empty" class="text-center pt-2.5 text-sm text-gray-500 hidden">
                            Tidak ada notifikasi
                        </p>
                        <div id="notification-list" class="max-h-64 overflow-y-auto scrollbar-hide p-2">
                            <!-- Notifikasi akan dimuat di sini -->
                        </div>
                    </div>
                </div>
                <script>
                    document.addEventListener('DOMContentLoaded', () => {
                        const badge = document.getElementById('notification-badge');
                        const count = document.getElementById('notification-count');
                        const list = document.getElementById('notification-list');
                        const emptyText = document.getElementById('notification-empty');
                        const dropdown = document.getElementById('notification-dropdown');
                        const button = document.getElementById('notification-button');

                        function renderNotifications(data) {
                            list.innerHTML = ''; // Bersihkan notifikasi lama

                            if (!data || data.length === 0) {
                                // Tidak ada notifikasi
                                badge.classList.add('hidden');
                                count.textContent = '0';
                                emptyText.classList.remove('hidden');
                            } else {
                                // Ada notifikasi
                                badge.classList.remove('hidden');
                                count.textContent = data.length;
                                emptyText.classList.add('hidden');

                                data.forEach(item => {
                                    const div = document.createElement('div');
                                    div.className = 'p-2 text-sm text-gray-700 border-b border-gray-100 hover:bg-gray-100 rounded cursor-pointer';
                                    div.innerHTML = item.message;

                                    div.addEventListener('click', () => {
                                        window.location.href = item.url;
                                    });

                                    list.appendChild(div);
                                });
                            }
                        }

                        fetch('/notifications/final-task-user')
                            .then(response => response.json())
                            .then(data => {
                                // Pastikan data adalah array, kalau server mengirim objek, sesuaikan di sini
                                // Contoh: data.notifications atau data.items bisa disesuaikan
                                const notifications = Array.isArray(data) ? data : (data.notifications || []);
                                renderNotifications(notifications);
                            })
                            .catch(() => {
                                // Kalau error fetch, juga tampilkan "Belum ada notifikasi"
                                renderNotifications([]);
                            });

                        button.addEventListener('click', () => {
                            dropdown.classList.toggle('hidden');
                        });
                    });
                </script>
                <!-- Wrapper yang bisa diklik untuk membuka dropdown -->
                <div id="profile-dropdown-toggle" class="flex items-center space-x-3 cursor-pointer">
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
                            <p class="text-gray-800 font-semibold mr-2 text-sm">{{ Str::limit(Auth::user()->name, 9) }}</p>
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
                <div id="dropdown" class="hidden absolute right-6 mt-10 md:mt-12 w-48 bg-white border rounded-lg shadow-lg z-10">
                    <ul class="py-1 space-y-1">
                        <li>
                            <a href="{{ route('settings.mentor') }}" class="group group-hover:text-white block flex items-center p-1 text-sm text-gray-700 hover:bg-midnight rounded-md mx-2">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" 
                                    class="w-4 h-4 ml-1 m-2 fill-current group-hover:text-white">
                                    <path d="M495.9 166.6c3.2 8.7 .5 18.4-6.4 24.6l-43.3 39.4c1.1 8.3 1.7 16.8 1.7 25.4s-.6 17.1-1.7 25.4l43.3 39.4c6.9 6.2 9.6 15.9 6.4 24.6c-4.4 11.9-9.7 23.3-15.8 34.3l-4.7 8.1c-6.6 11-14 21.4-22.1 31.2c-5.9 7.2-15.7 9.6-24.5 6.8l-55.7-17.7c-13.4 10.3-28.2 18.9-44 25.4l-12.5 57.1c-2 9.1-9 16.3-18.2 17.8c-13.8 2.3-28 3.5-42.5 3.5s-28.7-1.2-42.5-3.5c-9.2-1.5-16.2-8.7-18.2-17.8l-12.5-57.1c-15.8-6.5-30.6-15.1-44-25.4L83.1 425.9c-8.8 2.8-18.6 .3-24.5-6.8c-8.1-9.8-15.5-20.2-22.1-31.2l-4.7-8.1c-6.1-11-11.4-22.4-15.8-34.3c-3.2-8.7-.5-18.4 6.4-24.6l43.3-39.4C64.6 273.1 64 264.6 64 256s.6-17.1 1.7-25.4L22.4 191.2c-6.9-6.2-9.6-15.9-6.4-24.6c4.4-11.9 9.7-23.3 15.8-34.3l4.7-8.1c6.6-11 14-21.4 22.1-31.2c5.9-7.2 15.7-9.6 24.5-6.8l55.7 17.7c13.4-10.3 28.2-18.9 44-25.4l12.5-57.1c2-9.1 9-16.3 18.2-17.8C227.3 1.2 241.5 0 256 0s28.7 1.2 42.5 3.5c9.2 1.5 16.2 8.7 18.2 17.8l12.5 57.1c15.8 6.5 30.6 15.1 44 25.4l55.7-17.7c8.8-2.8 18.6-.3 24.5 6.8c8.1 9.8 15.5 20.2 22.1 31.2l4.7 8.1c6.1 11 11.4 22.4 15.8 34.3zM256 336a80 80 0 1 0 0-160 80 80 0 1 0 0 160z"/>
                                </svg>
                                <span class="group-hover:text-white">Profil</span>
                            </a>
                        </li>
                        <li>
                            <a class="group block flex items-center p-1 text-sm text-red-600 hover:bg-red-600 hover:text-white rounded-md mx-2">
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
            </header>

            <!-- Konten utama -->
            <main class="flex-1 p-6 overflow-auto">
                @yield('content')
            </main>

            <!-- Footer -->
            <footer class="bg-white text-left text-gray-600 text-sm p-3 shadow-lg border-t border-gray-200"> 
               Copyright © 2025 <span class="text-midnight">Sibermuda.Id</span> All Rights Reserved. Powered by PPLG SMKN 1 Ciomas
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
@if((session('success') || session('error') || session('info') || session('warning')) && !session('disable_swal')) <!-- tambahkan disable_swal agar popup ketika mengirim chat berhasil, popup tidak muncul (di controller chat liat dah) -->
    <div id="sweetalert-data"
         data-type="{{ session('success') ? 'success' : (session('error') ? 'error' : (session('info') ? 'info' : 'warning')) }}"
         data-message="{{ session('success') ?? session('error') ?? session('info') ?? session('warning') }}">
    </div>
@endif

</body>
</html>