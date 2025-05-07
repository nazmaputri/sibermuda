<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 Not Found</title>
    <link rel="icon" type="image/jpg" href="storage/logo.png">
    @vite('resources/css/app.css')
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- AOS Animation CSS -->
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
    
    <!-- Lottie Player -->
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="bg-white min-h-screen flex items-center justify-center">
    <div class="w-full max-w-6xl bg-white rounded-xl overflow-hidden items-center justify-center" data-aos="zoom-in">
        <!-- Lottie Animation -->
        <div class="mx-auto md:w-[300px] md:h-[300px] w-[600] h-[600]" data-aos="zoom-in" data-aos-duration="1000">
            <iframe 
                src="https://lottie.host/embed/b48b1d42-c904-4410-b5d4-b36678f75c95/LpJW7LJ7FG.lottie" 
                class="w-full h-full border-0"
                allowfullscreen>
            </iframe>
        </div>

        <div class="w-full p-4">
            <h1 class="md:text-3xl text-xl font-semibold text-midnight mb-2 text-center">Halaman Tidak Ditemukan</h1>
            <div class="mt-4 flex items-center justify-center">
                <button class="flex items-center justify-center space-x-1 p-2 bg-midnight rounded-md group">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="white" class="size-4 transition-transform duration-200 group-hover:-translate-x-1">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                    </svg>
                    <a href="{{ url('/') }}" class="text-sm text-white hover:underline pr-1">Kembali ke beranda</a>
                </button>
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
