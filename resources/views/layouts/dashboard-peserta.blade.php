<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite('resources/css/app.css')
    @section('title', 'Dashboard')
    <link rel="icon" type="image/png" href="{{ asset('storage/logo.png') }}?v=2>

    <title>Sibermuda : Platform Kursus Online</title> 

    <meta property="og:title" content="Sibermuda: Platform Kursus Online">
    <meta property="og:description" content="Bangun karirmu dengan pembelajaran yang tepat, bersama mentor terbaik dan materi berstandar industri.">
    <meta property="og:image" content="https://sibermuda.id/storage/logo.png"> <meta property="og:url" content="https://sibermuda.id">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="id_ID">
    <script src="https://cdn.tailwindcss.com"></script> <!-- import tailwind (pake CDN juga soalnya pas di hosting ga muncul style nya) -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script> <!-- import alphine untuk layout responsivenya -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Protest+Guerrilla&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- import sweetalert untuk popup -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
    @vite('resources/js/app.js') <!-- tambah ini untuk menginisialisasi sweetalert yang sudah diimport di app.js dan alert.js di folder js -->
    <style>
        body {
            font-family: 'Poppins', sans-serif !important;
        }
    </style>
    <!-- meta, title, css utama, dll -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    @stack('styles') <!-- wajib -->
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
                Sibermuda
                <span class="flex items-center gap-2 mt-1">
                    <span class="flex-1 h-px bg-gray-400"></span>
                    <span class="text-sm">Kursus</span>
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
                <ul class="ml-4 mr-4 mt-5 space-y-2 text-gray-800 py-1">
                    
                <a href="{{ route('welcome-peserta') }}" class="block group">
                    <li class="flex items-center px-4 py-2 rounded-md space-x-4 transition-all duration-300 ease-in-out 
                            {{ Request::routeIs('welcome-peserta') ? 'bg-midnight' : 'hover:bg-gray-200' }}" 
                        :class="sidebarExpanded ? 'px-4' : 'px-1.5'">

                        <!-- Icon dengan efek geser ke kanan saat hover -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" 
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" 
                            class="w-5 h-5 transform transition-all duration-300 ease-in-out group-hover:translate-x-1
                                    {{ Request::routeIs('welcome-peserta') ? 'text-white' : 'text-gray-700' }}">
                            <path stroke-linecap="round" stroke-linejoin="round" 
                                d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                        </svg>

                        <!-- Teks juga ikut geser ke kanan saat hover -->
                        <span 
                            x-show="sidebarExpanded"
                            x-transition
                            x-cloak
                            class="whitespace-nowrap transform transition-all duration-300 ease-in-out group-hover:translate-x-1
                                {{ Request::routeIs('welcome-peserta') ? 'text-white' : 'text-gray-700' }}">
                            Dashboard
                        </span>
                    </li>
                </a>

                <a href="{{ route('kategori-peserta') }}" class="block group">
                    <li 
                        class="flex items-center py-2 rounded-md space-x-4 transition-all duration-300 ease-in-out
                            {{ Request::routeIs('kategori-peserta', 'categories-detail', 'kursus-peserta') ? 'bg-midnight' : 'hover:bg-gray-200' }}"
                        :class="sidebarExpanded ? 'px-4' : 'px-1.5'"
                    >
                        <!-- Icon geser ke kanan saat hover -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                            class="w-5 h-5 shrink-0 transform transition-all duration-300 ease-in-out group-hover:translate-x-1
                                    {{ Request::routeIs('kategori-peserta', 'categories-detail', 'kursus-peserta') ? 'text-white' : 'text-gray-700' }}">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                        </svg>

                        <!-- Teks geser ke kanan saat hover -->
                        <span 
                            x-show="sidebarExpanded"
                            x-transition
                            x-cloak
                            class="whitespace-nowrap transform transition-all duration-300 ease-in-out group-hover:translate-x-1
                                {{ Request::routeIs('kategori-peserta', 'categories-detail', 'kursus-peserta') ? 'text-white' : 'text-gray-700' }}">
                            Kursus
                        </span>
                    </li>
                </a>

                <a href="{{ route('daftar-kursus') }}" class="block group">
                    <li 
                        class="flex items-center py-2 rounded-md space-x-4 transition-all duration-300 ease-in-out 
                            {{ Request::routeIs('daftar-kursus', 'detail-kursus', 'study-peserta', 'chat.student', 'quiz.show', 'quiz.result') ? 'bg-midnight' : 'hover:bg-gray-200' }}"
                        :class="sidebarExpanded ? 'px-4' : 'px-1.5'"
                    >
                        <!-- Icon dengan animasi hover ke kanan -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" 
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" 
                            class="w-5 h-5 transform transition-all duration-300 ease-in-out group-hover:translate-x-1 
                                    {{ Request::routeIs('daftar-kursus', 'study-peserta', 'detail-kursus', 'quiz.show', 'quiz.result', 'chat.student') ? 'text-white' : 'text-gray-700' }}">
                            <path stroke-linecap="round" stroke-linejoin="round" 
                                d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
                        </svg>

                        <!-- Teks dengan animasi hover ke kanan -->
                        <span x-show="sidebarExpanded" x-transition x-cloak 
                            class="whitespace-nowrap transform transition-all duration-300 ease-in-out group-hover:translate-x-1 
                                    {{ Request::routeIs('daftar-kursus', 'study-peserta', 'detail-kursus', 'quiz.show', 'quiz.result', 'chat.student') ? 'text-white' : 'text-gray-700' }}">
                            Belajar
                        </span>
                    </li>
                </a>
                
                </ul>
            </nav>
            
            <div class="m-4">
                <a href="#" id="waLink" target="_blank" class="block group">
                    <li 
                        class="flex items-center py-2 rounded-md space-x-4 text-green-700 bg-green-200 transition-all duration-300 ease-in-out " 
                        :class="sidebarExpanded ? 'px-4' : 'px-1.5'"
                    >
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-700 transform transition-all duration-300 ease-in-out group-hover:translate-x-1"  height="100" viewBox="0 0 50 50" fill="currentColor">
                        <path d="M 25 2 C 12.309534 2 2 12.309534 2 25 C 2 29.079097 3.1186875 32.88588 4.984375 36.208984 L 2.0371094 46.730469 A 1.0001 1.0001 0 0 0 3.2402344 47.970703 L 14.210938 45.251953 C 17.434629 46.972929 21.092591 48 25 48 C 37.690466 48 48 37.690466 48 25 C 48 12.309534 37.690466 2 25 2 z M 25 4 C 36.609534 4 46 13.390466 46 25 C 46 36.609534 36.609534 46 25 46 C 21.278025 46 17.792121 45.029635 14.761719 43.333984 A 1.0001 1.0001 0 0 0 14.033203 43.236328 L 4.4257812 45.617188 L 7.0019531 36.425781 A 1.0001 1.0001 0 0 0 6.9023438 35.646484 C 5.0606869 32.523592 4 28.890107 4 25 C 4 13.390466 13.390466 4 25 4 z M 16.642578 13 C 16.001539 13 15.086045 13.23849 14.333984 14.048828 C 13.882268 14.535548 12 16.369511 12 19.59375 C 12 22.955271 14.331391 25.855848 14.613281 26.228516 L 14.615234 26.228516 L 14.615234 26.230469 C 14.588494 26.195329 14.973031 26.752191 15.486328 27.419922 C 15.999626 28.087653 16.717405 28.96464 17.619141 29.914062 C 19.422612 31.812909 21.958282 34.007419 25.105469 35.349609 C 26.554789 35.966779 27.698179 36.339417 28.564453 36.611328 C 30.169845 37.115426 31.632073 37.038799 32.730469 36.876953 C 33.55263 36.755876 34.456878 36.361114 35.351562 35.794922 C 36.246248 35.22873 37.12309 34.524722 37.509766 33.455078 C 37.786772 32.688244 37.927591 31.979598 37.978516 31.396484 C 38.003976 31.104927 38.007211 30.847602 37.988281 30.609375 C 37.969311 30.371148 37.989581 30.188664 37.767578 29.824219 C 37.302009 29.059804 36.774753 29.039853 36.224609 28.767578 C 35.918939 28.616297 35.048661 28.191329 34.175781 27.775391 C 33.303883 27.35992 32.54892 26.991953 32.083984 26.826172 C 31.790239 26.720488 31.431556 26.568352 30.914062 26.626953 C 30.396569 26.685553 29.88546 27.058933 29.587891 27.5 C 29.305837 27.918069 28.170387 29.258349 27.824219 29.652344 C 27.819619 29.649544 27.849659 29.663383 27.712891 29.595703 C 27.284761 29.383815 26.761157 29.203652 25.986328 28.794922 C 25.2115 28.386192 24.242255 27.782635 23.181641 26.847656 L 23.181641 26.845703 C 21.603029 25.455949 20.497272 23.711106 20.148438 23.125 C 20.171937 23.09704 20.145643 23.130901 20.195312 23.082031 L 20.197266 23.080078 C 20.553781 22.728924 20.869739 22.309521 21.136719 22.001953 C 21.515257 21.565866 21.68231 21.181437 21.863281 20.822266 C 22.223954 20.10644 22.02313 19.318742 21.814453 18.904297 L 21.814453 18.902344 C 21.828863 18.931014 21.701572 18.650157 21.564453 18.326172 C 21.426943 18.001263 21.251663 17.580039 21.064453 17.130859 C 20.690033 16.232501 20.272027 15.224912 20.023438 14.634766 L 20.023438 14.632812 C 19.730591 13.937684 19.334395 13.436908 18.816406 13.195312 C 18.298417 12.953717 17.840778 13.022402 17.822266 13.021484 L 17.820312 13.021484 C 17.450668 13.004432 17.045038 13 16.642578 13 z M 16.642578 15 C 17.028118 15 17.408214 15.004701 17.726562 15.019531 C 18.054056 15.035851 18.033687 15.037192 17.970703 15.007812 C 17.906713 14.977972 17.993533 14.968282 18.179688 15.410156 C 18.423098 15.98801 18.84317 16.999249 19.21875 17.900391 C 19.40654 18.350961 19.582292 18.773816 19.722656 19.105469 C 19.863021 19.437122 19.939077 19.622295 20.027344 19.798828 L 20.027344 19.800781 L 20.029297 19.802734 C 20.115837 19.973483 20.108185 19.864164 20.078125 19.923828 C 19.867096 20.342656 19.838461 20.445493 19.625 20.691406 C 19.29998 21.065838 18.968453 21.483404 18.792969 21.65625 C 18.639439 21.80707 18.36242 22.042032 18.189453 22.501953 C 18.016221 22.962578 18.097073 23.59457 18.375 24.066406 C 18.745032 24.6946 19.964406 26.679307 21.859375 28.347656 C 23.05276 29.399678 24.164563 30.095933 25.052734 30.564453 C 25.940906 31.032973 26.664301 31.306607 26.826172 31.386719 C 27.210549 31.576953 27.630655 31.72467 28.119141 31.666016 C 28.607627 31.607366 29.02878 31.310979 29.296875 31.007812 L 29.298828 31.005859 C 29.655629 30.601347 30.715848 29.390728 31.224609 28.644531 C 31.246169 28.652131 31.239109 28.646231 31.408203 28.707031 L 31.408203 28.708984 L 31.410156 28.708984 C 31.487356 28.736474 32.454286 29.169267 33.316406 29.580078 C 34.178526 29.990889 35.053561 30.417875 35.337891 30.558594 C 35.748225 30.761674 35.942113 30.893881 35.992188 30.894531 C 35.995572 30.982516 35.998992 31.07786 35.986328 31.222656 C 35.951258 31.624292 35.8439 32.180225 35.628906 32.775391 C 35.523582 33.066746 34.975018 33.667661 34.283203 34.105469 C 33.591388 34.543277 32.749338 34.852514 32.4375 34.898438 C 31.499896 35.036591 30.386672 35.087027 29.164062 34.703125 C 28.316336 34.437036 27.259305 34.092596 25.890625 33.509766 C 23.114812 32.325956 20.755591 30.311513 19.070312 28.537109 C 18.227674 27.649908 17.552562 26.824019 17.072266 26.199219 C 16.592866 25.575584 16.383528 25.251054 16.208984 25.021484 L 16.207031 25.019531 C 15.897202 24.609805 14 21.970851 14 19.59375 C 14 17.077989 15.168497 16.091436 15.800781 15.410156 C 16.132721 15.052495 16.495617 15 16.642578 15 z">
                        </path>
                    </svg>
                        <span x-show="sidebarExpanded" x-transition x-cloak class="whitespace-nowrap transform transition-all duration-300 ease-in-out group-hover:translate-x-1">Whatsapp</span>
                    </li>
                </a>
            </div>

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
                class="lg:hidden p-0.5 border border-gray-300 text-gray-700 rounded-md">
                <!-- Icon ☰ -->
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                    <path fill-rule="evenodd" d="M3 6.75A.75.75 0 0 1 3.75 6h16.5a.75.75 0 0 1 0 1.5H3.75A.75.75 0 0 1 3 6.75ZM3 12a.75.75 0 0 1 .75-.75h16.5a.75.75 0 0 1 0 1.5H3.75A.75.75 0 0 1 3 12Zm0 5.25a.75.75 0 0 1 .75-.75h16.5a.75.75 0 0 1 0 1.5H3.75a.75.75 0 0 1-.75-.75Z" clip-rule="evenodd" />
                </svg>
            </button>
            
            <p class="text-sm md:text-lg md:pl-4 font-semibold pl-1 text-gray-700">@yield('title')</p>

                <div class="flex items-center ml-auto mr-4 relative"> <!-- container utaman untuk konten didalam navbar -->
                    @php
                        $cartCount = \App\Models\Keranjang::where('user_id', Auth::id())->count();
                    @endphp
                
                <a href="{{ route('cart.index') }}" class="relative cursor-pointer mr-4">
                    @if($cartCount > 0)
                        <div class="absolute -top-1 -right-2 bg-red-500 text-white text-xs w-4 h-4 flex items-center justify-center rounded-full border-1 border-white">
                            {{ $cartCount }}
                        </div>
                    @endif
                
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                    </svg>
                </a>

                <!-- Notifikasi -->
                <div class="relative flex items-center cursor-pointer mr-4" id="notification-container">
                    <button id="notification-button" class="bg-white relative">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 
                                9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 
                                3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 
                                0m5.714 0a3 3 0 1 1-5.714 0"/>
                        </svg>

                        <!-- Badge notifikasi -->
                        <span id="notification-badge"
                            class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center hidden">
                            <span id="notification-count">0</span>
                        </span>
                    </button>

                    <!-- Dropdown notifikasi -->
                    <div id="notification-dropdown" class="absolute z-10 right-0 top-8 bg-white shadow-lg rounded-md border border-gray-200 w-60 md:mt-1 md:w-96 hidden"> 
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
                        const list = document.getElementById('notification-list');
                        const badge = document.getElementById('notification-badge');
                        const count = document.getElementById('notification-count');
                        const emptyMessage = document.getElementById('notification-empty');

                        // Fungsi untuk render notifikasi yang belum dibaca
                        function renderNotifications(data) {
                            const seenIds = JSON.parse(localStorage.getItem('read_notifications') || '[]');
                            // Filter notifikasi yang belum dibaca
                            const unread = data.filter(item => !seenIds.includes(item.id));

                            if (unread.length > 0) {
                                badge.classList.remove('hidden');
                                count.textContent = unread.length;
                                emptyMessage.classList.add('hidden');
                                list.innerHTML = unread.map(item => `
                                    <div class="p-2 text-sm border-b hover:bg-gray-100 cursor-pointer" data-id="${item.id}">
                                        <div class="font-medium text-gray-700">Pembelian Dikonfirmasi</div>
                                        <div class="text-gray-600 text-xs">Kursus: ${item.course_title}</div>
                                        <div class="text-gray-400 text-xs">${new Date(item.updated_at).toLocaleString()}</div>
                                    </div>
                                `).join('');
                            } else {
                                badge.classList.add('hidden');
                                count.textContent = '0';
                                emptyMessage.classList.remove('hidden');
                                list.innerHTML = '';
                            }
                        }

                        // Fungsi fetch dan render notifikasi
                        function loadNotifications() {
                            fetch('/notifikasi/pembelian')
                                .then(res => res.json())
                                .then(data => {
                                    renderNotifications(data);
                                })
                                .catch(() => {
                                    // Jika gagal fetch, anggap tidak ada notifikasi
                                    badge.classList.add('hidden');
                                    count.textContent = '0';
                                    emptyMessage.classList.remove('hidden');
                                    list.innerHTML = '';
                                });
                        }

                        loadNotifications();

                        // Toggle dropdown dan tandai semua notifikasi sebagai sudah dibaca
                        button.addEventListener('click', (event) => {
                            event.stopPropagation();

                            dropdown.classList.toggle('hidden');

                            if (!dropdown.classList.contains('hidden')) {
                                // Tandai semua notifikasi sebagai sudah dibaca saat dropdown dibuka
                                fetch('/notifikasi/pembelian')
                                    .then(res => res.json())
                                    .then(data => {
                                        const ids = data.map(item => item.id);
                                        localStorage.setItem('read_notifications', JSON.stringify(ids));
                                        badge.classList.add('hidden');
                                        count.textContent = '0';
                                        // Setelah tandai semua dibaca, reload tampilan agar hilang notifikasi
                                        loadNotifications();
                                    });
                            }
                        });

                        // Tutup dropdown saat klik di luar area
                        document.addEventListener('click', (event) => {
                            if (!dropdown.classList.contains('hidden') &&
                                !dropdown.contains(event.target) &&
                                !button.contains(event.target)) {
                                dropdown.classList.add('hidden');
                            }
                        });

                        // Optional: jika ingin klik notifikasi langsung dianggap dibaca (hapus satu per satu)
                        list.addEventListener('click', (event) => {
                            const notifDiv = event.target.closest('div[data-id]');
                            if (!notifDiv) return;

                            const id = parseInt(notifDiv.getAttribute('data-id'));
                            let readIds = JSON.parse(localStorage.getItem('read_notifications') || '[]');

                            if (!readIds.includes(id)) {
                                readIds.push(id);
                                localStorage.setItem('read_notifications', JSON.stringify(readIds));
                            }

                            notifDiv.remove();

                            // Update badge dan count setelah hapus satu notifikasi
                            const remainingNotifs = list.querySelectorAll('div[data-id]');
                            if (remainingNotifs.length === 0) {
                                badge.classList.add('hidden');
                                count.textContent = '0';
                                emptyMessage.classList.remove('hidden');
                            } else {
                                badge.classList.remove('hidden');
                                count.textContent = remainingNotifs.length;
                                emptyMessage.classList.add('hidden');
                            }
                        });
                    });
                </script>
                
                <div class="relative">
                <!-- Wrapper yang bisa diklik untuk membuka dropdown -->
                <div id="profile-dropdown-toggle" class="flex items-center space-x-3 cursor-pointer flex items-center">
                    <div>
                        <!-- Pengecekan gambar profil -->
                        @if(Auth::user()->photo)
                            <!-- Tampilkan gambar profil jika ada -->
                            <img src="{{ route('user.avatar', $user->id) }}" alt="User Profile" class="rounded-full w-8 h-8 object-cover">
                            @else
                            <!-- Tampilkan gambar default jika tidak ada foto profil -->
                            <img src="{{ asset('storage/default-profile.jpg') }}" alt="Default Profile" class="rounded-full w-8 h-8 object-cover">
                        @endif
                    </div>
                    <!-- Nama dan Role -->
                    @if(Auth::check())
                        <div class="hidden md:block flex flex-col">
                            <p class="text-gray-800 font-semibold mr-2 text-sm">{{ Str::limit(Auth::user()->name, 9) }}</p>
                            <p class="text-gray-600 text-xs">Peserta</p>
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
                                <span class="group-hover:text-white">Profil</span>
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

    // Mengambil nomor telepon admin langsung dari Blade
    var nomorAdmin = @json(DB::table('users')->where('role', 'admin')->value('phone_number'));

    // Memastikan nomor admin ditemukan, jika ada update link WhatsApp
    if (nomorAdmin) {
        document.getElementById('waLink').setAttribute('href', 'https://wa.me/' + nomorAdmin);
    } else {
            Swal.fire({
            icon: 'error',
            title: 'Oops!',
            text: 'Nomor admin tidak ditemukan!',
        });
    }
</script>   

<!-- tambah ini untuk menangkap popup pesan backend menggunakan sweetalert -->
@if((session('success') || session('error') || session('info') || session('warning')) && !session('disable_swal')) <!-- tambahkan disable_swal agar popup ketika mengirim chat berhasil, popup tidak muncul (di controller chat liat dah) -->
    <div id="sweetalert-data"
         data-type="{{ session('success') ? 'success' : (session('error') ? 'error' : (session('info') ? 'info' : 'warning')) }}"
         data-message="{{ session('success') ?? session('error') ?? session('info') ?? session('warning') }}">
    </div>
@endif

 <!-- script utama seperti alpine, jquery -->
 <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

 @stack('scripts') <!-- wajib -->

</body>
</html>
