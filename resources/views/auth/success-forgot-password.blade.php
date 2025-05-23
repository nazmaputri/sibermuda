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
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="bg-white min-h-screen flex items-center justify-center">
    <div class="w-full max-w-6xl bg-white rounded-xl overflow-hidden items-center justify-center" data-aos="zoom-in">
            <!-- <div class="flex items-center justify-center mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="text-midnight size-20 md:size-40">
                    <path fill="currentColor" d="M10.5 14a1.5 1.5 0 0 0 1.5 1.5v-.815c0-.818.604-1.371 1.233-1.54A1.5 1.5 0 0 0 10.5 14m-3.25 5.5h5.055q.258.796.728 1.5H7.25A3.25 3.25 0 0 1 4 17.75v-7.5A3.25 3.25 0 0 1 7.25 7H8V6a4 4 0 1 1 8 0v1h.75A3.25 3.25 0 0 1 20 10.25v2.27a7 7 0 0 1-1.31-1.033a2 2 0 0 0-.19-.163V10.25a1.75 1.75 0 0 0-1.75-1.75h-9.5a1.75 1.75 0 0 0-1.75 1.75v7.5c0 .966.784 1.75 1.75 1.75M12 3.5A2.5 2.5 0 0 0 9.5 6v1h5V6A2.5 2.5 0 0 0 12 3.5m5.99 8.695c.652.65 1.907 1.685 3.449 1.898c.308.042.561.285.561.589v2.838c0 3.816-3.58 5.201-4.353 5.456a.46.46 0 0 1-.293 0C16.58 22.721 13 21.336 13 17.52v-2.838c0-.304.253-.547.561-.59c1.542-.212 2.797-1.247 3.45-1.898a.714.714 0 0 1 .979 0"/>
                </svg>
            </div> -->
            <div class="flex items-center justify-center">
                <img src="{{ asset('storage/forgot-password.png') }}" alt="Logo" class="w-60 h-60 object-cover animate-ping-and-bounce">
            </div>
            <div class="w-full p-4">
                <h1 class="text-3xl font-semibold text-midnight mb-2 text-center">Request Reset Kata Sandi Berhasil!</h1>
                <p class="text-gray-700 text-sm md:text-md text-center">Silahkan cek email kamu untuk melakukan reset password</p>
                <div class="mt-4 flex items-center justify-center space-x-1 group">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 transition-transform duration-200 group-hover:-translate-x-1">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                    </svg>
                    <a href="{{ route('login') }}" class="text-sm text-gray-700 hover:underline">Kembali ke halaman login</a>
                </div>
            </div> 
        </div>
<script>
    AOS.init({
      once: true,
      duration: 800,
    });
</script>
</body>
</html>
