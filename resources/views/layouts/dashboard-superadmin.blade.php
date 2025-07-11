<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Super Admin</title>
    <link rel="icon" type="image/jpg" href="storage/logo.png">
    @vite('resources/css/app.css')
    @section('title', 'Dashboard')
    <script src="https://cdn.tailwindcss.com"></script> <!-- import tailwind (pake CDN juga soalnya pas di hosting ga muncul style nya) -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script> <!-- import alphine untuk layout responsivenya -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Protest+Guerrilla&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- import sweetalert untuk popup -->
    @vite('resources/js/app.js') <!-- tambah ini untuk menginisialisasi sweetalert yang sudah diimport di app.js dan alert.js di folder js -->
    @vite('resources/js/delete-confirm.js') <!-- tambah ini agar bisa menggunakan popup konfirmasi penghapusan data menggunakan sweetalert yang ada di folder js>delete-confirm.js -->
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
            }"
        >
        <div class="flex items-center justify-center space-x-5 md:justify-center mx-2 mt-6">
            <!-- Logo dan Teks -->
            <div class="flex items-center space-x-2">
            <p 
                class="font-semibold transition-opacity duration-300 text-gray-700 md:text-lg" 
                x-show="sidebarExpanded"
                x-transition
                x-cloak
            >
                Super Admin
                <span class="flex items-center gap-2 mt-1">
                    <span class="flex-1 h-px bg-gray-400"></span>
                    <span class="text-sm">Sibermuda</span>
                    <span class="flex-1 h-px bg-gray-400"></span>
                </span>
            </p>
            <div :class="{
                'md:absolute md:right-[-16px] top-10': sidebarExpanded,
                'top-14': !sidebarExpanded
            }">
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
                <ul class="ml-4 mr-4 space-y-2 mt-2 text-gray-800">
                    
                <a href="{{ route('welcome-superadmin') }}" class="block group">
                    <li class="flex items-center px-4 py-2 rounded-md space-x-4 transition-all duration-300 ease-in-out 
                            {{ Request::routeIs('welcome-superadmin') ? 'bg-midnight' : 'hover:bg-gray-200' }}"
                        :class="sidebarExpanded ? 'px-4' : 'px-1.5'">

                        <!-- Icon dengan efek geser ke kanan saat hover -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" 
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" 
                            class="w-5 h-5 transform transition-all duration-300 ease-in-out group-hover:translate-x-1
                                    {{ Request::routeIs('welcome-superadmin') ? 'text-white' : 'text-gray-700' }}">
                            <path stroke-linecap="round" stroke-linejoin="round" 
                                d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                        </svg>

                        <!-- Teks juga ikut geser ke kanan saat hover -->
                        <span 
                            x-show="sidebarExpanded"
                            x-transition
                            x-cloak
                            class="whitespace-nowrap transform transition-all duration-300 ease-in-out group-hover:translate-x-1
                                {{ Request::routeIs('welcome-superadmin') ? 'text-white' : 'text-gray-700' }}">
                            Dashboard
                        </span>
                    </li>
                </a>

                <li class="relative">
                    <div class="flex items-center rounded-xl transition-all duration-300 ease-in-out"
                        :class="sidebarExpanded ? 'px-2 space-x-4' : 'justify-center px-1.5'">
                        <button onclick="toggleDropdown()"
                                class="flex items-center w-full p-2 rounded-sm group transition-all duration-300 ease-in-out"
                                :class="sidebarExpanded ? 'justify-start' : 'justify-center'">
                            
                            <!-- Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 shrink-0 transform transition-all duration-300 ease-in-out group-hover:translate-x-1">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                            </svg>

                            <!-- Teks Data User -->
                            <span x-show="sidebarExpanded" x-transition x-cloak
                                class="ml-4 pr-14 whitespace-nowrap transform transition-all duration-300 ease-in-out group-hover:translate-x-1">
                                Data User
                            </span>

                           <!-- Panah dropdown -->
                            <svg x-show="sidebarExpanded" x-transition x-cloak  id="dropdown-arrow" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="ml-auto w-4 h-4 transition-transform duration-200 {{ Request::routeIs('datamentor-admin', 'datapeserta-admin', 'detaildata-mentor-superadmin', 'detaildata-peserta-superadmin') ? 'rotate-180' : '' }}">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                            </svg>
                        </button>
                    </div>

                    <!-- Submenu -->
                    <ul id="dropdown-menu"
                        x-show="sidebarExpanded"
                        x-transition
                        x-cloak
                        class="bg-white rounded-md shadow-lg ml-4 space-y-1 mt-2 p-2 transition-all duration-300 ease-in-out
                            {{ Request::routeIs('dataadmin-superadmin', 'datamentor-superadmin', 'datapeserta-superadmin', 'detaildataadmin-superadmin', 'detaildata-mentor-superadmin', 'detaildata-peserta-superadmin') ? '' : 'hidden' }}">

                        <!-- Data Admin -->
                        <li class="rounded-md {{ Request::routeIs('dataadmin-superadmin', 'detaildataadmin-superadmin') ? 'bg-midnight' : 'hover:bg-gray-200' }}">
                            <a href="{{ route('dataadmin-superadmin') }}" class="flex items-center gap-2 p-2 rounded-sm group
                                {{ Request::routeIs('dataadmin-superadmin', 'detaildataadmin-superadmin') ? 'text-white' : 'text-gray-700' }}">
                                
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor"
                                    class="w-5 h-5 transform transition-all duration-300 ease-in-out group-hover:translate-x-1
                                    {{ Request::routeIs('dataadmin-superadmin', 'detaildataadmin-superadmin') ? 'text-white' : 'text-gray-700' }}">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                                </svg>

                                <span class="transform transition-all duration-300 ease-in-out group-hover:translate-x-1">
                                    Data Admin
                                </span>
                            </a>
                        </li>

                        <!-- Data Mentor -->
                        <li class="rounded-md {{ Request::routeIs('datamentor-superadmin', 'detaildata-mentor-superadmin') ? 'bg-midnight' : 'hover:bg-gray-200' }}">
                            <a href="{{ route('datamentor-superadmin') }}" class="flex items-center gap-2 p-2 rounded-sm group
                                {{ Request::routeIs('datamentor-superadmin', 'detaildata-mentor-superadmin') ? 'text-white' : 'text-gray-700' }}">
                                
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor"
                                    class="w-5 h-5 transform transition-all duration-300 ease-in-out group-hover:translate-x-1
                                    {{ Request::routeIs('datamentor-superadmin', 'detaildata-mentor-superadmin') ? 'text-white' : 'text-gray-700' }}">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                                </svg>

                                <span class="transform transition-all duration-300 ease-in-out group-hover:translate-x-1">
                                    Data Mentor
                                </span>
                            </a>
                        </li>

                        <!-- Data Peserta -->
                        <li class="rounded-md {{ Request::routeIs('datapeserta-superadmin', 'detaildata-peserta-superadmin') ? 'bg-midnight' : 'hover:bg-gray-200' }}">
                            <a href="{{ route('datapeserta-superadmin') }}" class="flex items-center gap-2 p-2 rounded-sm group
                                {{ Request::routeIs('datapeserta-superadmin', 'detaildata-peserta-superadmin') ? 'text-white' : 'text-gray-700' }}">
                                
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor"
                                    class="w-5 h-5 transform transition-all duration-300 ease-in-out group-hover:translate-x-1
                                    {{ Request::routeIs('datapeserta-superadmin', 'detaildata-peserta-superadmin') ? 'text-white' : 'text-gray-700' }}">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                                </svg>

                                <span class="transform transition-all duration-300 ease-in-out group-hover:translate-x-1">
                                    Data Peserta
                                </span>
                            </a>
                        </li>
                    </ul>
                </li>

                <a href="{{ route('kategori-superadmin') }}" class="block group">
                    <li 
                        class="flex items-center py-2 rounded-md space-x-4 transition-all duration-300 ease-in-out
                        {{ Request::routeIs('kategori-superadmin', 'tambahkategori-superadmin', 'detailkategori-superadmin', 'editkategori-superadmin', 'detail-kursus-superadmin') ? 'bg-midnight' : 'hover:bg-gray-200' }}"
                        :class="sidebarExpanded ? 'px-4' : 'px-1.5'"
                    >

                        <!-- Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                            class="w-5 h-5 shrink-0 transform transition-all duration-300 ease-in-out group-hover:translate-x-1
                                {{ Request::routeIs('kategori-superadmin', 'tambahkategori-superadmin', 'detailkategori-superadmin', 'editkategori-superadmin', 'detail-kursus-superadmin') ? 'text-white' : 'text-gray-700' }}">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0ZM3.75 12h.007v.008H3.75V12Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm-.375 5.25h.007v.008H3.75v-.008Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                        </svg>

                        <!-- Teks -->
                        <span 
                            x-show="sidebarExpanded"
                            x-transition
                            x-cloak
                            class="whitespace-nowrap transform transition-all duration-300 ease-in-out group-hover:translate-x-1
                            {{ Request::routeIs('kategori-superadmin', 'tambahkategori-superadmin', 'detailkategori-superadmin', 'editkategori-superadmin', 'detail-kursus-superadmin') ? 'text-white' : 'text-gray-700' }}">
                            Kategori
                        </span>
                    </li>
                </a>

                <a href="{{ route('diskon-superadmin') }}" class="block group">
                    <li 
                        class="flex items-center py-2 rounded-md space-x-4 transition-all duration-300 ease-in-out
                        {{ Request::routeIs('diskon-superadmin', 'tambah-diskon-superadmin', 'editdiskon-superadmin') ? 'bg-midnight' : 'hover:bg-gray-200' }}"
                        :class="sidebarExpanded ? 'px-4' : 'px-1.5'"
                    >

                        <!-- Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor"
                            class="w-5 h-5 shrink-0 transform transition-all duration-300 ease-in-out group-hover:translate-x-1
                                {{ Request::routeIs('diskon-superadmin', 'tambah-diskon-superadmin', 'editdiskon-superadmin') ? 'text-white' : 'text-gray-700' }}">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m8.99 14.993 6-6m6 3.001c0 1.268-.63 2.39-1.593 3.069a3.746 3.746 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043 3.745 3.745 0 0 1-3.068 1.593c-1.268 0-2.39-.63-3.068-1.593a3.745 3.745 0 0 1-3.296-1.043 3.746 3.746 0 0 1-1.043-3.297 3.746 3.746 0 0 1-1.593-3.068c0-1.268.63-2.39 1.593-3.068a3.746 3.746 0 0 1 1.043-3.297 3.745 3.745 0 0 1 3.296-1.042 3.745 3.745 0 0 1 3.068-1.594c1.268 0 2.39.63 3.068 1.593a3.745 3.745 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.297 3.746 3.746 0 0 1 1.593 3.068ZM9.74 9.743h.008v.007H9.74v-.007Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm4.125 4.5h.008v.008h-.008v-.008Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                        </svg>

                        <!-- Teks -->
                        <span 
                            x-show="sidebarExpanded"
                            x-transition
                            x-cloak
                            class="whitespace-nowrap transform transition-all duration-300 ease-in-out group-hover:translate-x-1
                            {{ Request::routeIs('diskon-superadmin', 'tambah-diskon-superadmin', 'editdiskon-superadmin') ? 'text-white' : 'text-gray-700' }}">
                            Diskon
                        </span>
                    </li>
                </a>

                <a href="{{ route('rating-superadmin') }}" class="block group">
                    <li 
                        class="flex items-center py-2 rounded-md space-x-4 transition-all duration-300 ease-in-out
                        {{ Request::routeIs('rating-superadmin') ? 'bg-midnight' : 'hover:bg-gray-200' }}"
                        :class="sidebarExpanded ? 'px-4' : 'px-1.5'"
                    >
                        <!-- Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor"
                            class="w-5 h-5 shrink-0 transform transition-all duration-300 ease-in-out group-hover:translate-x-1
                                {{ Request::routeIs('rating-superadmin') ? 'text-white' : 'text-gray-700' }}">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                        </svg>

                        <!-- Teks -->
                        <span 
                            x-show="sidebarExpanded"
                            x-transition
                            x-cloak
                            class="whitespace-nowrap transform transition-all duration-300 ease-in-out group-hover:translate-x-1
                            {{ Request::routeIs('rating-superadmin') ? 'text-white' : 'text-gray-700' }}">
                            Penilaian
                        </span>
                    </li>
                </a>

                <a href="{{ route('laporan-superadmin') }}" class="block group">
                    <li 
                        class="flex items-center py-2 rounded-md space-x-4 transition-all duration-300 ease-in-out
                            {{ Request::routeIs('laporan-superadmin') ? 'bg-midnight' : 'hover:bg-gray-200' }}"
                        :class="sidebarExpanded ? 'px-4' : 'px-1.5'"
                    >
                        <!-- Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor"
                            class="w-5 h-5 shrink-0 transform transition-all duration-300 ease-in-out group-hover:translate-x-1
                                {{ Request::routeIs('laporan-superadmin') ? 'text-white' : 'text-gray-700' }}">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.75 3v11.25A2.25 2.25 0 0 0 6 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0 1 18 16.5h-2.25m-7.5 0h7.5m-7.5 0-1 3m8.5-3 1 3m0 0 .5 1.5m-.5-1.5h-9.5m0 0-.5 1.5M9 11.25v1.5M12 9v3.75m3-6v6" />
                        </svg>

                        <!-- Teks -->
                        <span 
                            x-show="sidebarExpanded"
                            x-transition
                            x-cloak
                            class="whitespace-nowrap transform transition-all duration-300 ease-in-out group-hover:translate-x-1
                                {{ Request::routeIs('laporan-superadmin') ? 'text-white' : 'text-gray-700' }}">
                            Laporan
                        </span>
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
        <div class="flex-1 flex flex-col bg-zinc-50">
            <!-- Navbar -->
            <header class="bg-white shadow-md p-2 mx-6 mt-3 mb-2 border border-gray-200 rounded rounded-md flex items-center justify-start">
            <!-- button ☰ membuka sidebar -->
            <button 
                @click="sidebarExpanded = !sidebarExpanded" 
                class="lg:hidden p-0.5 border border-gray-300 text-gray-700 rounded-md">
                <!-- Icon ☰ -->
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                    <path fill-rule="evenodd" d="M3 6.75A.75.75 0 0 1 3.75 6h16.5a.75.75 0 0 1 0 1.5H3.75A.75.75 0 0 1 3 6.75ZM3 12a.75.75 0 0 1 .75-.75h16.5a.75.75 0 0 1 0 1.5H3.75A.75.75 0 0 1 3 12Zm0 5.25a.75.75 0 0 1 .75-.75h16.5a.75.75 0 0 1 0 1.5H3.75a.75.75 0 0 1-.75-.75Z" clip-rule="evenodd" />
                </svg>
            </button>

            <h5 class="text-sm md:text-md md:pl-4 font-semibold pl-2 text-gray-700">@yield('title')</h5>

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
                    document.addEventListener('DOMContentLoaded', function () {
                        const button = document.getElementById('notification-button');
                        const dropdown = document.getElementById('notification-dropdown');
                        const badge = document.getElementById('notification-badge');
                        const countSpan = document.getElementById('notification-count');
                        const notificationList = document.getElementById('notification-list');
                        const markAsReadBtn = document.getElementById('mark-as-read');
                        const emptyMessage = document.getElementById('notification-empty');
                    
                        // Toggle dropdown & ambil notifikasi saat dibuka
                        button.addEventListener('click', function (event) {
                            event.stopPropagation(); // Cegah klik pada tombol memicu penutupan
                            dropdown.classList.toggle('hidden');
                            if (!dropdown.classList.contains('hidden')) {
                                fetchNotifications();
                            }
                        });

                        // Tutup dropdown jika klik di luar dropdown
                        document.addEventListener('click', function (event) {
                            // Jika dropdown sedang terbuka dan klik terjadi di luar tombol dan dropdown
                            if (!dropdown.classList.contains('hidden') &&
                                !dropdown.contains(event.target) &&
                                !button.contains(event.target)) {
                                dropdown.classList.add('hidden');
                            }
                        });
                    
                        // Fungsi ambil notifikasi dari route
                        function fetchNotifications() {
                            const url = "{{ route('superadmin.notifications') }}";
                            console.log("Fetching notifications from:", url);

                            fetch(url)
                                .then(response => response.json())
                                .then(data => {
                                    console.log("Data notifikasi:", data);
                                    notificationList.innerHTML = '';
                                    let unreadCount = data.notifications.length;

                                    if (unreadCount > 0) {
                                        badge.classList.remove('hidden');
                                        countSpan.textContent = unreadCount;

                                        // Tampilkan notifikasi, sembunyikan pesan kosong
                                        emptyMessage.classList.add('hidden');

                                        data.notifications.forEach(notif => {
                                            const div = document.createElement('div');
                                            div.classList.add('p-2', 'border-b', 'text-sm', 'text-gray-700', 'hover:bg-gray-100');

                                            const link = document.createElement('a');
                                            link.href = notif.url;
                                            link.innerHTML = notif.message;
                                            link.classList.add('block', 'w-full');

                                            div.appendChild(link);
                                            notificationList.appendChild(div);
                                        });

                                    } else {
                                        badge.classList.add('hidden');
                                        // Tampilkan pesan kosong jika tidak ada notifikasi
                                        emptyMessage.classList.remove('hidden');
                                    }
                                })
                                .catch(error => {
                                    console.error("Gagal mengambil notifikasi:", error);
                                });
                        }
                    
                        // Opsional: Muat awal saat halaman dimuat 
                        fetchNotifications();
                    });
                </script>
                <!-- Wrapper yang bisa diklik untuk membuka dropdown -->
                @if(Auth::check())
                    <div id="profile-dropdown-toggle" class="flex items-center space-x-3 cursor-pointer">
                        <div>
                            @if(Auth::user()->photo)
                                <img src="{{ asset('storage/' . Auth::user()->photo) }}" alt="User Profile" class="rounded-full w-8 h-8 object-cover">
                            @else
                                <img src="{{ asset('storage/default-profile.jpg') }}" alt="Default Profile" class="rounded-full w-8 h-8 object-cover">
                            @endif
                        </div>
                        <div class="hidden md:block flex flex-col">
                            <p class="text-gray-700 font-semibold mr-2 text-sm">{{ Str::limit(Auth::user()->name, 9) }}</p>
                            <p class="text-gray-600 text-sm">{{ Auth::user()->role }}</p>
                        </div>
                        <button id="dropdown-button-profile" class="text-gray-600 focus:outline-none ml-2 transition-transform duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-gray-600">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                            </svg>
                        </button>
                    </div>
                @else
                    <div id="profile-dropdown-toggle" class="flex items-center space-x-3">
                        <img src="{{ asset('storage/default-profile.jpg') }}" alt="Default Profile" class="rounded-full w-8 h-8 object-cover">
                        <div class="hidden md:block flex flex-col">
                            <p class="text-gray-700 font-semibold mr-2 text-sm">Guest</p>
                            <p class="text-gray-600 text-sm">Not logged in</p>
                        </div>
                    </div>
                @endif

                <!-- Dropdown Menu -->
                <div id="dropdown" class="hidden absolute right-6 mt-10 md:mt-12 w-48 bg-white border rounded-lg shadow-lg z-10">
                    <ul class="py-1 space-y-1">
                        <li>
                            <a href="{{ route('settings.superadmin') }}" class="group group-hover:text-white block flex items-center p-1 text-sm text-gray-700 hover:bg-midnight rounded-md mx-2">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" 
                                    class="w-4 h-4 ml-1 m-2 fill-current group-hover:text-white">
                                    <path d="M495.9 166.6c3.2 8.7 .5 18.4-6.4 24.6l-43.3 39.4c1.1 8.3 1.7 16.8 1.7 25.4s-.6 17.1-1.7 25.4l43.3 39.4c6.9 6.2 9.6 15.9 6.4 24.6c-4.4 11.9-9.7 23.3-15.8 34.3l-4.7 8.1c-6.6 11-14 21.4-22.1 31.2c-5.9 7.2-15.7 9.6-24.5 6.8l-55.7-17.7c-13.4 10.3-28.2 18.9-44 25.4l-12.5 57.1c-2 9.1-9 16.3-18.2 17.8c-13.8 2.3-28 3.5-42.5 3.5s-28.7-1.2-42.5-3.5c-9.2-1.5-16.2-8.7-18.2-17.8l-12.5-57.1c-15.8-6.5-30.6-15.1-44-25.4L83.1 425.9c-8.8 2.8-18.6 .3-24.5-6.8c-8.1-9.8-15.5-20.2-22.1-31.2l-4.7-8.1c-6.1-11-11.4-22.4-15.8-34.3c-3.2-8.7-.5-18.4 6.4-24.6l43.3-39.4C64.6 273.1 64 264.6 64 256s.6-17.1 1.7-25.4L22.4 191.2c-6.9-6.2-9.6-15.9-6.4-24.6c4.4-11.9 9.7-23.3 15.8-34.3l4.7-8.1c6.6-11 14-21.4 22.1-31.2c5.9-7.2 15.7-9.6 24.5-6.8l55.7 17.7c13.4-10.3 28.2-18.9 44-25.4l12.5-57.1c2-9.1 9-16.3 18.2-17.8C227.3 1.2 241.5 0 256 0s28.7 1.2 42.5 3.5c9.2 1.5 16.2 8.7 18.2 17.8l12.5 57.1c15.8 6.5 30.6 15.1 44 25.4l55.7-17.7c8.8-2.8 18.6-.3 24.5 6.8c8.1 9.8 15.5 20.2 22.1 31.2l4.7 8.1c6.1 11 11.4 22.4 15.8 34.3zM256 336a80 80 0 1 0 0-160 80 80 0 1 0 0 160z"/>
                                </svg>
                                <span class="group-hover:text-white">Profil</span>
                            </a>
                        </li>
                        <li class="mx-2">
                            <form action="{{ route('logout') }}" method="GET" class="group block w-full">
                                @csrf
                                <button type="submit" class="flex items-center w-full p-1 text-sm text-red-600 hover:bg-red-600 hover:text-white rounded-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" 
                                        class="w-4 h-4 ml-1 m-2 fill-current group-hover:text-white">
                                        <path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"/>
                                    </svg>
                                    <span class="text-left">Keluar</span>
                                </button>
                            </form>
                        </li>
                    </ul>                            
                </div>
                </div>
            </header>

            <!-- Konten utama -->
            <main class="flex-1 p-6 overflow-auto bg-zinc-50"> 
                @yield('content')
            </main>

            <!-- Footer -->
            <!-- <footer class="bg-white text-left text-gray-600 text-sm p-3 shadow-lg border-t border-gray-200"> 
               Copyright © 2025 <span class="text-midnight">Sibermuda.Id</span> All Rights Reserved. Powered by PPLG SMKN 1 Ciomas
            </footer> -->

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

    function toggleDropdown() {
        const dropdownMenu = document.getElementById('dropdown-menu');
        const dropdownArrow = document.getElementById('dropdown-arrow');
                            
        if (!dropdownMenu.classList.contains('hidden')) {
            dropdownMenu.classList.add('hidden');
            dropdownArrow.classList.remove('rotate-180');
        } else {
            dropdownMenu.classList.remove('hidden');
            dropdownArrow.classList.add('rotate-180');
        }
    }

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
