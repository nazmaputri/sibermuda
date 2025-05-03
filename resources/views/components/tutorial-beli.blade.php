<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/jpg" href="storage/logo.png">
    @vite('resources/css/app.css')
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Protest+Guerrilla&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">

    <!-- AOS CSS -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Custom Style -->
    <style>
        body {
            font-family: "Poppins", sans-serif !important;
        }
    </style>
</head>
<body>
@include('components.navbar') <!-- Menambahkan Navbar -->
  <!-- Feature Section Title and Cards -->
<section class="max-w-6xl mx-auto px-6 py-12">
  <!-- Judul dan Subjudul -->
  <div class="text-center mb-10 mt-8 md:mt-12" data-aos="fade-up">
    <h2 class="font-bold text-midnight mb-2 text-xl md:text-2xl">Tingkatkan Skillmu di Era Digital</h2>
    <p class="text-gray-600 text-base">Gabung bersama ribuan pelajar lain, raih sertifikat, dan buka peluang karier baru dengan kursus online Sibermuda.</p>
    <div class="h-1 bg-midnight w-1/5 rounded-2xl mx-auto mt-2"></div> <!-- garis setengah lebar -->
  </div>

  <!-- Feature Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6" data-aos="fade-up">
  <div class="bg-white rounded-2xl shadow-md p-6 text-center border-t-4 border-blue-400">
    <div class="text-blue-400 text-3xl font-bold mb-2">01</div>
    <h3 class="font-semibold md:text-lg text-md mb-1 text-midnight">Daftar & Login</h3>
    <p class="text-sm text-gray-600">Buat akun terlebih dahulu lalu masuk ke platform untuk mulai belajar.</p>
  </div>
  <div class="bg-white rounded-2xl shadow-md p-6 text-center border-t-4 border-blue-400">
    <div class="text-blue-400 text-3xl font-bold mb-2">02</div>
    <h3 class="font-semibold md:text-lg text-md mb-1 text-midnight">Pilih Kursus</h3>
    <p class="text-sm text-gray-600">Pilih kursus yang kamu minati dan tambahkan ke keranjang.</p>
  </div>
  <div class="bg-white rounded-2xl shadow-md p-6 text-center border-t-4 border-blue-400">
    <div class="text-blue-400 text-3xl font-bold mb-2">03</div>
    <h3 class="font-semibold md:text-lg text-md mb-1 text-midnight">Beli & Konfirmasi</h3>
    <p class="text-sm text-gray-600">Lakukan pembayaran dan tunggu konfirmasi dari admin.</p>
  </div>
  <div class="bg-white rounded-2xl shadow-md p-6 text-center border-t-4 border-blue-400">
    <div class="text-blue-400 text-3xl font-bold mb-2">04</div>
    <h3 class="font-semibold md:text-lg text-md mb-1 text-midnight">Belajar & Sertifikat</h3>
    <p class="text-sm text-gray-600">Setelah dikonfirmasi, kamu bisa mulai belajar dan selesaikan tugas akhir sebelum mengunduh sertifikat.</p>
  </div>
</div>

</section>

@include('components.footer') <!-- Menambahkan Navbar -->

<!-- AOS JS -->
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        // Initialize AOS animation
        AOS.init({
            duration: 1000, 
            once: true,    
        });
    </script>
</body>