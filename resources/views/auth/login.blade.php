<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/jpg" href="storage/logo.png">
    <title>Login</title>
    @vite('resources/css/app.css')
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Protest+Guerrilla&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- import sweetalert untuk popup -->
    @vite('resources/js/app.js') <!-- tambah ini untuk menginisialisasi sweetalert yang sudah diimport di app.js dan alert.js di folder js -->
     <!-- Custom Style -->
     <style>
        body {
            font-family: "Poppins", sans-serif !important;
        }
        @layer utilities {
            @keyframes zoom-in {
                0% {
                    transform: scale(0.8);
                    opacity: 0;
                }
                100% {
                    transform: scale(1);
                    opacity: 1;
                }
            }

            .animate-zoom-in {
                animation: zoom-in 0.5s ease-out forwards;
            }
        }
    </style>
        
    {!! htmlScriptTagJsApi() !!}
</head>
<body class="bg-white min-h-screen flex items-center justify-center">
<!-- include elemen loading-screen, untuk animasi saat halaman sedang loading -->
<!-- <x-loading-screen /> -->

<div class="w-full max-w-6xl flex bg-white md:space-x-10 rounded-xl overflow-hidden">
    <!-- Kiri (Logo) -->
    <div class="hidden md:flex md:w-1/2 bg-midnight rounded rounded-2xl items-center justify-center">
        <img src="{{ asset('storage/login2.png') }}" alt="Logo" class="w-70 h-70 transform transition-transform hover:scale-105">
    </div>

    <!-- Kanan (Form) -->
    <div class="w-full md:w-1/2 p-4">
        <div class="flex items-center gap-2 mb-4 text-midnight items-center justify-center text-center">
            <a href="{{ route('landingpage') }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01-.58 4.138l-5.58 3.114-5.58-3.114a12.083 12.083 0 01-.58-4.138L12 14z" />
                </svg>
            </a>
            <h2 class="text-3xl font-semibold">Masuk</h2>
        </div>
        <p class="mb-2 text-gray-600 text-center">Selamat datang di Sibermuda Kursus</p>

        <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Email Field (Dengan efek floating label) -->
            <div class="relative w-full mb-4">
                <input 
                    type="email" 
                    name="email" 
                    id="email" 
                    placeholder=" " 
                    class="peer w-full px-4 pt-5 pb-2 text-sm bg-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-700 focus:border-gray-700 @error('email') border-red-500 @enderror" 
                    value="{{ old('email') }}"
                />
                <label 
                    for="email" 
                    class="absolute left-4 top-2 text-gray-500 text-sm transition-all duration-200 
                    peer-placeholder-shown:top-3.5 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 
                    peer-focus:top-2 peer-focus:text-sm peer-focus:text-gray-700"
                >
                    Email
                </label>
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                </div>

            <!-- Password Field (Dengan efek floating label) -->
            <div class="relative w-full mb-4">
                <input 
                    type="password" 
                    name="password" 
                    id="password" 
                    placeholder=" " 
                    class="peer w-full px-4 pt-5 pb-2 text-sm bg-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-700 focus:border-gray-700 @error('password') border-red-500 @enderror"
                />
                <label 
                    for="password" 
                    class="absolute left-4 top-2 text-gray-500 text-sm transition-all duration-200 
                    peer-placeholder-shown:top-3.5 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 
                    peer-focus:top-2 peer-focus:text-sm peer-focus:text-gray-700"
                >
                    Kata Sandi
                </label>
                <span class="absolute right-3 mt-3.5 transform cursor-pointer text-gray-500"  onclick="toggleVisibility()">
                    <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                        <path d="M10 12.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" />
                            <path fill-rule="evenodd" d="M.664 10.59a1.651 1.651 0 0 1 0-1.186A10.004 10.004 0 0 1 10 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0 1 10 17c-4.257 0-7.893-2.66-9.336-6.41ZM14 10a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z" clip-rule="evenodd" />
                        </svg>
                    </span>
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
            </div>

            <div class="flex justify-end">
                <a href="{{ route('forgot') }}" class="text-sm font-semibold text-midnight hover:underline">Lupa kata sandi?</a>
            </div>

            <div class="flex justify-center">
                {!! htmlFormSnippet() !!}
            </div>
            @error('g-recaptcha-response')
                <p class="text-red-500 text-sm mt-1 text-center">{{ $message }}</p>
            @enderror

            <button type="submit" class="w-full bg-midnight text-white py-3 rounded-lg hover:bg-opacity-90">Masuk</button>
        </form>

        <div class="flex items-center justify-center my-4">
                <div class="border-t border-gray-300 flex-grow mr-4"></div>
                <p class="text-gray-700 text-center">Atau</p>
                <div class="border-t border-gray-300 flex-grow ml-4"></div>
            </div>

            <div class="flex justify-center mt-6">
                <a href="{{ route('login.google') }}" 
                   class="flex w-full items-center justify-center border border-gray-300 rounded-md px-4 py-2 hover:bg-gray-100 transition duration-200">
                    <img width="24" height="24" 
                         src="https://img.icons8.com/color/48/google-logo.png" 
                         alt="google-logo" 
                         class="mr-2" />
                    <span class="text-sm text-gray-700 font-medium">Login dengan Google</span>
                </a>
            </div>

        <p class="text-center text-gray-600 mt-4">
            Kamu belum memiliki akun?
            <a href="{{ route('register') }}" class="text-midnight font-semibold text-center hover:underline">Daftar</a>
        </p>

        @if(session('resent_time'))
                @php
                    $timeDiff = now()->diffInSeconds(session('resent_time'));
                @endphp
            
                @if($timeDiff < 60)
                    <p class="text-gray-500 text-sm">Please wait {{ 60 - $timeDiff }} seconds before sending again.</p>
                @else
                    <form action="{{ route('verification.send') }}" method="post">
                        @csrf
                        <button class="btn">Send Again</button>
                    </form>
                @endif
            @endif
    </div>
</div>
<script>
    //untuk mengatur flash message dari backend
    document.addEventListener('DOMContentLoaded', function () {
        const flashMessage = document.getElementById('flash-message');
            if (flashMessage) {
                setTimeout(() => {
                    flashMessage.remove();
            }, 3000); // Hapus pesan setelah 3 detik
        }
    });
    
    // Pengaturan untuk membuka/menutup input password
    function toggleVisibility() {
    const input = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');

    if (input.type === 'password') { //untuk melihat password
        input.type = 'text';
        eyeIcon.innerHTML = `
            <path fill-rule="evenodd" d="M3.28 2.22a.75.75 0 0 0-1.06 1.06l14.5 14.5a.75.75 0 1 0 1.06-1.06l-1.745-1.745a10.029 10.029 0 0 0 3.3-4.38 1.651 1.651 0 0 0 0-1.185A10.004 10.004 0 0 0 9.999 3a9.956 9.956 0 0 0-4.744 1.194L3.28 2.22ZM7.752 6.69l1.092 1.092a2.5 2.5 0 0 1 3.374 3.373l1.091 1.092a4 4 0 0 0-5.557-5.557Z" clip-rule="evenodd" />
            <path d="m10.748 13.93 2.523 2.523a9.987 9.987 0 0 1-3.27.547c-4.258 0-7.894-2.66-9.337-6.41a1.651 1.651 0 0 1 0-1.186A10.007 10.007 0 0 1 2.839 6.02L6.07 9.252a4 4 0 0 0 4.678 4.678Z" />
        `;
    } else {
        input.type = 'password'; // untuk menyembunyikan password
        eyeIcon.innerHTML = `
            <path d="M10 12.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" />
            <path fill-rule="evenodd" d="M.664 10.59a1.651 1.651 0 0 1 0-1.186A10.004 10.004 0 0 1 10 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0 1 10 17c-4.257 0-7.893-2.66-9.336-6.41ZM14 10a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z" clip-rule="evenodd" />
        `;
    }
    }

    // untuk mengatur button "masuk" saat sedang loading
    const form = document.getElementById('form');
    form.addEventListener('submit', function (e) {
        const buttonSubmit = document.getElementById('btn-submit');
        
        // Ubah teks tombol ke loading state
        buttonSubmit.innerHTML =
            '<svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Loading...';
        
        // Tambahkan atribut disabled
        buttonSubmit.setAttribute('disabled', true);
        
        // Tambahkan kelas untuk menonaktifkan hover dan pointer
        buttonSubmit.classList.add('cursor-not-allowed', 'bg-[#08072a]');
        buttonSubmit.classList.remove('hover:bg-[#08072a]');
    });

    // function untuk menampilkan animasi saat halaman sedang loading (component sudah di include di paling atas layout)
    window.addEventListener('load', () => {
        const loader = document.getElementById('loading-screen');
        if (loader) {
            loader.classList.add('opacity-0', 'transition-opacity', 'duration-500');
            setTimeout(() => loader.remove(), 500); // hilangkan dari DOM
        }
    });

    // Saat DOM sudah siap, tambahkan class animasi zoom-in ke kontainer
    document.addEventListener('DOMContentLoaded', () => {
        const loginContainer = document.getElementById('login-container');
        setTimeout(() => {
            loginContainer.classList.add('animate-zoom-in');
        }, 100); // delay sedikit agar smooth
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
