<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>404 Not Found</title>
    @vite('resources/css/app.css')
    
    <!-- AOS Animation CSS -->
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
    
    <!-- Lottie Player -->
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
</head>
<body class="bg-white text-[#08072a] flex items-center justify-center min-h-screen px-6">
    <div class="text-center" data-aos="zoom-in" data-aos-duration="800">
        <p class="md:text-md text-sm text-gray-600 mb-6">Ups! Sepertinya kamu nyasar. Halaman ini tidak tersedia.</p>

        <!-- Lottie Animation -->
        <div class="mx-auto md:w-[400px] md:h-[400px] w-[500] h-[500] mb-3" data-aos="zoom-in" data-aos-duration="1000">
            <iframe 
                src="https://lottie.host/embed/b48b1d42-c904-4410-b5d4-b36678f75c95/LpJW7LJ7FG.lottie" 
                class="w-full h-full border-0"
                allowfullscreen>
            </iframe>
        </div>

        <h1 class="md:text-xl text-md font-medium mb-4" data-aos="zoom-in" data-aos-delay="200">404 - Halaman Tidak Ditemukan</h1>

        <a href="{{ url('/') }}"
           class="inline-block px-3 py-2 bg-[#08072a] text-white rounded-lg shadow hover:bg-opacity-90 transition-transform duration-300 ease-in-out transform hover:scale-105">
            Kembali ke Beranda
        </a>
    </div>

    <!-- AOS Script -->
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>
</html>
