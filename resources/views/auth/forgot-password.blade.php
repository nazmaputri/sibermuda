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
            <div class="hidden md:flex md:w-1/2 bg-midnight rounded rounded-3xl items-center justify-center">
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
                <h2 class="text-3xl font-semibold text-center text-midnight mb-2">Lupa Kata Sandi</h2>
            </div>
            <p class="text-center text-gray-600 mb-5 text-sm">Silahkan masukkan alamat email Anda dan kami akan mengirimkan tautan untuk mengatur ulang kata sandi Anda.</p>

            <form action="" method="POST" class="space-y-4">
                @csrf
                <div class="relative">
                    <input 
                        type="email" 
                        name="email" 
                        id="email" 
                        placeholder=" "
                        class="peer w-full px-4 pt-5 pb-2 text-sm bg-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-midnight @error('email') border-red-500 @enderror"
                        value="{{ old('email') }}"
                    />
                    <label for="email" class="absolute left-4 top-2 text-gray-500 text-sm transition-all duration-200 
                        peer-placeholder-shown:top-3.5 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 
                        peer-focus:top-2 peer-focus:text-sm peer-focus:text-gray-700">
                        Email
                    </label>
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="w-full bg-midnight text-white py-3 rounded-lg hover:bg-opacity-90">Kirim Link Reset</button>
            </form>
            <div class="mt-4 flex items-center justify-center space-x-1 group">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 transition-transform duration-200 group-hover:-translate-x-1">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
                <a href="{{ route('login') }}" class="text-sm text-gray-700 hover:underline">Kembali ke halaman login</a>
            </div>
            </div> 
        </div>
</body>
</html>
