<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/jpg" href="storage/logo.png">
    <title>Register Mentor</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite('resources/css/app.css')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Protest+Guerrilla&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
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
</head>
<body class="bg-white min-h-screen flex items-center justify-center">
<!-- include elemen loading-screen, untuk animasi saat halaman sedang loading -->
<x-loading-screen />

<div class="w-full max-w-6xl flex bg-white md:space-x-10 rounded-xl overflow-hidden">
    
        <!-- Kiri (Logo) -->
        <div class="hidden md:flex md:w-1/2 md:my-10 bg-midnight rounded rounded-2xl items-center justify-center">
            <img src="{{ asset('storage/login2.png') }}" alt="Logo" class="w-70 h-70 transform transition-transform hover:scale-105">
        </div>

         <!-- Form Login di sebelah kanan -->
         <div id="register-container" class="w-full md:w-1/2 p-4">
            
         <div class="flex flex-col items-center justify-center space-y-2">
                <div class="flex items-center gap-2 mb-4 text-midnight items-center justify-center text-center">
                    <a href="{{ route('landingpage') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01-.58 4.138l-5.58 3.114-5.58-3.114a12.083 12.083 0 01-.58-4.138L12 14z" />
                        </svg>
                    </a>
                    <h2 class="text-3xl font-semibold">Daftar Mentor</h2>
                </div>
                <h4 class="text-center text-gray-700">
                    Ayo menjadi mentor bersama Sibermuda.Idn!
                </h4>
            </div> 

            <!-- Notifikasi Sukses -->
            @if (session('success'))
                <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif
            
            <!-- Form -->
            <form action="{{ route('register') }}" method="POST" class="space-y-4" id="form">
                @csrf
        
                    <div class="relative w-full mb-4">
                        <input 
                            type="text" 
                            name="name" 
                            id="name" 
                            value="{{ old('name') }}" 
                            placeholder=" " 
                            class="peer w-full px-4 pt-5 pb-2 text-sm bg-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-700 focus:border-gray-700 @error('name') border-red-500 @enderror"
                        />
                        <label 
                            for="name" 
                            class="absolute left-4 top-2 text-gray-500 text-sm transition-all duration-200 
                            peer-placeholder-shown:top-3.5 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 
                            peer-focus:top-2 peer-focus:text-sm peer-focus:text-gray-700"
                        >
                            Nama Lengkap
                        </label>

                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
    
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
                        <span class="absolute right-3 mt-3.5 transform cursor-pointer text-gray-500" id="togglePassword">
                            <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                                <path d="M10 12.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" />
                                <path fill-rule="evenodd" d="M.664 10.59a1.651 1.651 0 0 1 0-1.186A10.004 10.004 0 0 1 10 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0 1 10 17c-4.257 0-7.893-2.66-9.336-6.41ZM14 10a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z" clip-rule="evenodd" />
                            </svg>
                        </span>
                        @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                
                    <!-- Confirm Password Field (Dengan efek floating label) -->
                    <div class="relative w-full mb-4">
                        <input 
                            type="password" 
                            name="password_confirmation" 
                            id="password_confirmation" 
                            placeholder=" " 
                            class="peer w-full px-4 pt-5 pb-2 text-sm bg-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-700 focus:border-gray-700 @error('password_confirmation') border-red-500 @enderror"
                        />
                        <label 
                            for="password_confirmation" 
                            class="absolute left-4 top-2 text-gray-500 text-sm transition-all duration-200 
                            peer-placeholder-shown:top-3.5 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 
                            peer-focus:top-2 peer-focus:text-sm peer-focus:text-gray-700"
                        >
                            Konfirmasi Kata Sandi
                        </label>
                        <span class="absolute mt-3.5 right-1 transform -translate-x-1/2 cursor-pointer text-gray-500" id="toggleConfirmPassword">
                            <svg id="eyeConfirmIcon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                                <path d="M10 12.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" />
                                <path fill-rule="evenodd" d="M.664 10.59a1.651 1.651 0 0 1 0-1.186A10.004 10.004 0 0 1 10 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0 1 10 17c-4.257 0-7.893-2.66-9.336-6.41ZM14 10a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z" clip-rule="evenodd" />
                            </svg>
                        </span>
                        @error('password_confirmation')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                
                    <!-- Phone Number Field (Dengan efek floating label) -->
                    <div class="relative w-full mb-4">
                        <input 
                            type="text" 
                            name="phone_number" 
                            id="phone_number" 
                            placeholder=" " 
                            class="peer w-full px-4 pt-5 pb-2 text-sm bg-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-700 focus:border-gray-700 @error('phone_number') border-red-500 @enderror"
                            value="{{ old('phone_number') }}"
                        />
                        <label 
                            for="phone_number" 
                            class="absolute left-4 top-2 text-gray-500 text-sm transition-all duration-200 
                            peer-placeholder-shown:top-3.5 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 
                            peer-focus:top-2 peer-focus:text-sm peer-focus:text-gray-700"
                        >
                            Nomor Telepon
                        </label>
                        @error('phone_number')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                
                    <!-- Deskripsi Pengalaman (Dengan efek floating label) -->
                    <div class="relative w-full mb-4">
                        <textarea 
                            name="experience" 
                            id="experience" 
                            rows="5" 
                            placeholder=" " 
                            class="peer text-sm w-full px-4 pt-5 pb-2 bg-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-700 focus:border-gray-700 @error('experience') border-red-500 @enderror"
                        >{{ old('experience') }}</textarea>
                        <label 
                            for="experience" 
                            class="absolute left-4 top-2 text-gray-500 text-sm transition-all duration-200 
                            peer-placeholder-shown:top-3.5 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 
                            peer-focus:top-2 peer-focus:text-sm peer-focus:text-gray-700"
                        >
                            Deskripsi Pengalaman
                        </label>
                        @error('experience')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                     <!-- Hidden Role Field -->
                    <input type="hidden" name="role" value="mentor">
             
             <div class="justify-center items-center space-y-4 mt-5">
                 <!-- Submit Button -->
                 <div class="flex justify-center">
                     <button type="submit" id="btn-submit"
                         class="inline-flex justify-center items-center w-full px-4 py-2 bg-[#08072a] text-white font-semibold rounded-md hover:bg-opacity-90 focus:outline-none">
                         Daftar
                     </button>
                 </div>
             
                 <!-- Login Link -->
                 <h4 class="text-center text-gray-700">
                     Sudah punya akun?
                     <a href="/login" class="text-midnight font-semibold hover:underline">Login</a>
                 </h4>
             <!-- </div> -->
            </div>
            </form>
        </div>
</div>

<script>
    // Pengaturan Icon PAssword
    const togglePassword = document.getElementById('togglePassword');
    const passwordField = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');

    const eyeOpen = `<path d="M10 12.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" />
                    <path fill-rule="evenodd" d="M.664 10.59a1.651 1.651 0 0 1 0-1.186A10.004 10.004 0 0 1 10 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0 1 10 17c-4.257 0-7.893-2.66-9.336-6.41ZM14 10a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z" clip-rule="evenodd" />`;
    const eyeClosed = `<path fill-rule="evenodd" d="M3.28 2.22a.75.75 0 0 0-1.06 1.06l14.5 14.5a.75.75 0 1 0 1.06-1.06l-1.745-1.745a10.029 10.029 0 0 0 3.3-4.38 1.651 1.651 0 0 0 0-1.185A10.004 10.004 0 0 0 9.999 3a9.956 9.956 0 0 0-4.744 1.194L3.28 2.22ZM7.752 6.69l1.092 1.092a2.5 2.5 0 0 1 3.374 3.373l1.091 1.092a4 4 0 0 0-5.557-5.557Z" clip-rule="evenodd" />
                    <path d="m10.748 13.93 2.523 2.523a9.987 9.987 0 0 1-3.27.547c-4.258 0-7.894-2.66-9.337-6.41a1.651 1.651 0 0 1 0-1.186A10.007 10.007 0 0 1 2.839 6.02L6.07 9.252a4 4 0 0 0 4.678 4.678Z" />`;

    togglePassword.addEventListener('click', function() {
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            eyeIcon.innerHTML = eyeClosed;
        } else {
            passwordField.type = 'password';
            eyeIcon.innerHTML = eyeOpen;
        }
    });

    // Pengaturan Icon Konfirmasi Password
    const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
    const confirmPasswordField = document.getElementById('password_confirmation');
    const eyeConfirmIcon = document.getElementById('eyeConfirmIcon');

    const eyeOpenConfirm = `<path d="M10 12.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" />
                    <path fill-rule="evenodd" d="M.664 10.59a1.651 1.651 0 0 1 0-1.186A10.004 10.004 0 0 1 10 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0 1 10 17c-4.257 0-7.893-2.66-9.336-6.41ZM14 10a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z" clip-rule="evenodd" />`;

    const eyeClosedConfirm = `<path fill-rule="evenodd" d="M3.28 2.22a.75.75 0 0 0-1.06 1.06l14.5 14.5a.75.75 0 1 0 1.06-1.06l-1.745-1.745a10.029 10.029 0 0 0 3.3-4.38 1.651 1.651 0 0 0 0-1.185A10.004 10.004 0 0 0 9.999 3a9.956 9.956 0 0 0-4.744 1.194L3.28 2.22ZM7.752 6.69l1.092 1.092a2.5 2.5 0 0 1 3.374 3.373l1.091 1.092a4 4 0 0 0-5.557-5.557Z" clip-rule="evenodd" />
                    <path d="m10.748 13.93 2.523 2.523a9.987 9.987 0 0 1-3.27.547c-4.258 0-7.894-2.66-9.337-6.41a1.651 1.651 0 0 1 0-1.186A10.007 10.007 0 0 1 2.839 6.02L6.07 9.252a4 4 0 0 0 4.678 4.678Z" />`;

    toggleConfirmPassword.addEventListener('click', function() {
        if (confirmPasswordField.type === 'password') {
            confirmPasswordField.type = 'text';
            eyeConfirmIcon.innerHTML = eyeClosedConfirm;
        } else {
            confirmPasswordField.type = 'password';
            eyeConfirmIcon.innerHTML = eyeOpenConfirm;
        }
    });

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
        const loginContainer = document.getElementById('register-container');
        setTimeout(() => {
            loginContainer.classList.add('animate-zoom-in');
        }, 100); // delay sedikit agar smooth
    });
</script>
</body>
</html>
