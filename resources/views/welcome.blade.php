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
    @if($discount && now()->lt($end_datetime))
        <section id="promo" class="bg-red-600 text-white px-4 py-2 text-center pt-[90px] fixed w-full z-40">
            <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between gap-4 pb-3 mx-14">
                <!-- Promo text -->
                <div class="text-sm sm:text-base font-semibold">
                    Promo Diskon {{ $discount->discount_percentage }}%! <br class="md:hidden" />
                    <span class="font-normal">Berlaku sampai {{ \Carbon\Carbon::parse($discount->end_date)->format('d F Y') }}!</span>
                </div>

                <!-- Countdown -->
                <div class="flex items-center gap-2 text-sm sm:text-base font-bold" id="countdown">
                    <span><span id="days">00</span><span class="text-xs font-normal ml-1">Hari</span></span>
                    <span><span id="hours">00</span><span class="text-xs font-normal ml-1">Jam</span></span>
                    <span><span id="minutes">00</span><span class="text-xs font-normal ml-1">Menit</span></span>
                    <span><span id="seconds">00</span><span class="text-xs font-normal ml-1">Detik</span></span>
                </div>

                <!-- Kode Promo -->
                <div class="flex items-center gap-2">
                    <button class="bg-white text-red-600 font-bold px-3 py-1 rounded hover:bg-gray-100 text-sm">
                        {{ $discount->coupon_code }}
                    </button>
                    <button class="bg-sky-500 text-white font-semibold px-3 py-1 rounded hover:bg-sky-400 text-sm"
                        onclick="copyToClipboard('{{ $discount->coupon_code }}')">
                        SALIN
                    </button>
                </div>
            </div>
        </section>

        <!-- JavaScript: Countdown & Hide Section When Done -->
        <script>
            const endDateTime = new Date("{{ $end_datetime->format('Y-m-d H:i:s') }}").getTime();

            const countdownInterval = setInterval(() => {
                const now = new Date().getTime();
                const distance = endDateTime - now;

                if (distance < 0) {
                    clearInterval(countdownInterval);
                    const promoSection = document.getElementById("promo");
                    if (promoSection) {
                        promoSection.style.display = "none"; // Hilangkan section
                    }
                    return;
                }

                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                document.getElementById("days").textContent = String(days).padStart(2, '0');
                document.getElementById("hours").textContent = String(hours).padStart(2, '0');
                document.getElementById("minutes").textContent = String(minutes).padStart(2, '0');
                document.getElementById("seconds").textContent = String(seconds).padStart(2, '0');
            }, 1000);

            function copyToClipboard(text) {
                navigator.clipboard.writeText(text).then(function () {
                    alert('Kode promo berhasil disalin: ' + text);
                });
            }
        </script>
    @endif
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
