<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password</title>
    <link rel="icon" type="image/jpg" href="storage/logo.png">
    @vite('resources/css/app.css')
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="bg-white min-h-screen flex items-center justify-center">
    <div class="w-full max-w-6xl flex bg-white md:space-x-10 rounded-xl overflow-hidden items-center justify-center">
            <!-- Kiri (Logo) -->
            <div class="hidden md:flex md:w-1/2 bg-midnight rounded rounded-2xl items-center justify-center">
                <img src="{{ asset('storage/login2.png') }}" alt="Logo" class="w-70 h-70 transform transition-transform hover:scale-105">
            </div>
            <!-- <div class="flex items-center justify-center mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="text-midnight size-20">
                    <path fill="currentColor" d="M10.5 14a1.5 1.5 0 0 0 1.5 1.5v-.815c0-.818.604-1.371 1.233-1.54A1.5 1.5 0 0 0 10.5 14m-3.25 5.5h5.055q.258.796.728 1.5H7.25A3.25 3.25 0 0 1 4 17.75v-7.5A3.25 3.25 0 0 1 7.25 7H8V6a4 4 0 1 1 8 0v1h.75A3.25 3.25 0 0 1 20 10.25v2.27a7 7 0 0 1-1.31-1.033a2 2 0 0 0-.19-.163V10.25a1.75 1.75 0 0 0-1.75-1.75h-9.5a1.75 1.75 0 0 0-1.75 1.75v7.5c0 .966.784 1.75 1.75 1.75M12 3.5A2.5 2.5 0 0 0 9.5 6v1h5V6A2.5 2.5 0 0 0 12 3.5m5.99 8.695c.652.65 1.907 1.685 3.449 1.898c.308.042.561.285.561.589v2.838c0 3.816-3.58 5.201-4.353 5.456a.46.46 0 0 1-.293 0C16.58 22.721 13 21.336 13 17.52v-2.838c0-.304.253-.547.561-.59c1.542-.212 2.797-1.247 3.45-1.898a.714.714 0 0 1 .979 0"/>
                </svg>
            </div> -->

            <div class="w-full md:w-1/2 p-4">
            <div class="flex items-center gap-2 mb-4 text-midnight items-center justify-center text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01-.58 4.138l-5.58 3.114-5.58-3.114a12.083 12.083 0 01-.58-4.138L12 14z" />
                </svg>
                <h2 class="text-3xl font-semibold text-center text-midnight mb-2">Reset Password</h2>
            </div>
            <p class="text-center text-gray-600 mb-5 text-sm">Silahkan masukkan password baru untuk melakukan reset password</p>

            <form action="" method="POST" class="space-y-4">
                @csrf
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

                        <!-- Toggle password visibility -->
                        <span class="absolute top-1/2 -translate-y-1/2 right-3 cursor-pointer text-gray-500" id="togglePassword">
                            <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                                <path d="M10 12.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" />
                                <path fill-rule="evenodd" d="M.664 10.59a1.651 1.651 0 0 1 0-1.186A10.004 10.004 0 0 1 10 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0 1 10 17c-4.257 0-7.893-2.66-9.336-6.41ZM14 10a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z" clip-rule="evenodd" />
                            </svg>
                        </span>

                        @error('password')
                            <p class="text-red-500 text-sm mt-1" id="password-error">{{ $message }}</p>
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

                        <!-- Toggle confirm password visibility -->
                        <span class="absolute top-1/2 -translate-y-1/2 right-3 cursor-pointer text-gray-500" id="toggleConfirmPassword">
                            <svg id="eyeConfirmIcon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                                <path d="M10 12.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" />
                                <path fill-rule="evenodd" d="M.664 10.59a1.651 1.651 0 0 1 0-1.186A10.004 10.004 0 0 1 10 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0 1 10 17c-4.257 0-7.893-2.66-9.336-6.41ZM14 10a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z" clip-rule="evenodd" />
                            </svg>
                        </span>

                        @error('password_confirmation')
                            <p class="text-red-500 text-sm mt-1" id="password_confirmation-error">{{ $message }}</p>
                        @enderror
                    </div>

                <button type="submit" class="w-full bg-midnight text-white py-3 rounded-lg hover:bg-opacity-90">Reset Password</button>
            </form>
            </div> 
        </div>

<script>
    // Fungsi untuk menghapus class error dan menyembunyikan pesan error validasi (form line 149 to 168)
    document.addEventListener('DOMContentLoaded', function () {
    const inputs = document.querySelectorAll('input');
        inputs.forEach(input => {
            input.addEventListener('input', function () {
                removeErrorStyles(input.id);
            });
        });
    });

    function removeErrorStyles(inputId) {
        const input = document.getElementById(inputId);
        if (input) {
            input.classList.remove('border-red-500', 'focus:ring-red-500', 'text-red-500');
            const errorMessage = document.getElementById(inputId + '-error');
            if (errorMessage) {
                errorMessage.style.display = 'none';
            }
        }
    }

    // Pengaturan Icon Password
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

    // function untuk menampilkan animasi saat halaman sedang loading (component sudah di include di paling atas layout)
    window.addEventListener('load', () => {
        const loader = document.getElementById('loading-screen');
        if (loader) {
            loader.classList.add('opacity-0', 'transition-opacity', 'duration-500');
            setTimeout(() => loader.remove(), 500); // hilangkan dari DOM
        }
    });
</script>
</body>
</html>
