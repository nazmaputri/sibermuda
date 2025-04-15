<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/jpg" href="storage/logo.png">
    <title>Landing Page</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Protest+Guerrilla&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet"><!-- AOS CSS -->
    <script src="https://cdn.tailwindcss.com"></script> <!-- Tailwind CSS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- import sweetalert untuk popup -->
    @vite('resources/js/app.js') <!-- tambah ini untuk menginisialisasi sweetalert yang sudah diimport di app.js dan alert.js di folder js -->
    <!-- Custom Style -->
    <style>
        body {
            font-family: "Nunito", sans-serif !important;
        }
    </style>
</head>
<body class="font-sans">
    @include('components.navbar')
    @include('components.home')
    @include('components.about')
    @include('components.course')
    @include('components.price')
    @include('components.rating')
    @include('components.footer')

    <!-- AOS JS -->
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        // Initialize AOS animation
        AOS.init({
            duration: 1000,   // Durasi animasi dalam milidetik
            once: false,      // Animasi dapat dipicu ulang setiap kali elemen terlihat
            mirror: true,     // Animasi juga dipicu saat menggulir ke atas
        });

        // Reinitialize AOS on window resize (optional, untuk memastikan animasi tetap responsif)
        window.addEventListener('resize', () => {
            AOS.refresh();
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
