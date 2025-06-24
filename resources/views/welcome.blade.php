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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet"><!-- AOS CSS -->
    <script src="https://cdn.tailwindcss.com"></script> <!-- Tailwind CSS CDN -->
    <!-- Swiper JS -->
  <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
  <!-- Swiper CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- import sweetalert untuk popup -->
    @vite('resources/js/app.js') <!-- tambah ini untuk menginisialisasi sweetalert yang sudah diimport di app.js dan alert.js di folder js -->
    @vite('resources/css/app.css')
    <!-- Custom Style -->
    <style>
        body {
            font-family: "Poppins", sans-serif !important;
        }
    </style>
</head>
<body class="font-sans">
    @include('components.navbar')
    
    @if($discount && now()->lt($end_datetime))
        <section id="promo" class="bg-red-600 text-white px-4 py-2 text-center pt-[90px] fixed w-full z-40">
            <div class="max-w-7xl flex flex-col md:flex-row items-center justify-between gap-4 pb-3 mx-2 md:mx-14">
                <!-- Promo text -->
                <div class="text-sm sm:text-base font-medium">
                    Promo Diskon {{ $discount->discount_percentage }}%! <br class="md:hidden" />
                    <span class="font-normal">Berlaku sampai {{ \Carbon\Carbon::parse($discount->end_date)->locale('id')->translatedFormat('d F Y') }}!</span>
                </div>

                <!-- Countdown -->
                <div class="flex items-center gap-2 text-sm sm:text-base font-medium" id="countdown">
                    <span><span id="days">00</span><span class="text-xs font-normal ml-1">Hari</span></span>
                    <span><span id="hours">00</span><span class="text-xs font-normal ml-1">Jam</span></span>
                    <span><span id="minutes">00</span><span class="text-xs font-normal ml-1">Menit</span></span>
                    <span><span id="seconds">00</span><span class="text-xs font-normal ml-1">Detik</span></span>
                </div>

                <!-- Kode Promo -->
                <div class="flex items-center gap-2">
                    <button class="bg-white text-red-600 font-semibold px-3 py-1 rounded hover:bg-gray-100 text-sm">
                        {{ $discount->coupon_code }}
                    </button>
                    <div class="relative inline-block">
                        <button
                            class="bg-sky-500 text-white font-medium px-3 py-1 rounded hover:bg-sky-400 text-sm"
                            onclick="copyToClipboard(this, '{{ $discount->coupon_code }}')">
                            SALIN
                        </button>

                        <div
                            class="absolute left-1/2 translate-x-[-50%] mt-2 px-3 py-1 bg-black text-white text-xs rounded shadow-md opacity-0 pointer-events-none transition-opacity duration-300"
                            id="copy-toast">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- JavaScript: Countdown & Hide Section When Done -->
        <!-- <script>
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
                    Swal.fire({
                        icon: 'success',
                        title: 'Disalin!',
                        text: 'Kode promo berhasil disalin: ' + text,
                        showConfirmButton: false,
                        timer: 2000
                    });
                }).catch(function (error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Gagal menyalin kode promo.',
                    });
                });
            }
        </script> -->
    @endif

    <!-- kode untuk menjalankan script jika end_time diskon nya ada dan tidak akan dijalankan bila end_time nya null/tidak ada promo -->
    @if ($end_datetime)
    <script>
        const endDateTime = new Date("{{ $end_datetime->format('Y-m-d H:i:s') }}").getTime();

        const countdownInterval = setInterval(() => {
            const now = new Date().getTime();
            const distance = endDateTime - now;

            if (distance < 0) {
                clearInterval(countdownInterval);
                const promoSection = document.getElementById("promo");
                if (promoSection) {
                    promoSection.style.display = "none";
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
    </script>
    @endif

    @include('components.home', ['hasPromo' => $discount && now()->lt($end_datetime)])
    @include('components.about')
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

    //function copy kode diskon
    function copyToClipboard(button, text) {
        if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(text).then(() => {
                showToast(button, "Disalin!");
            }).catch(() => {
                fallbackCopy(text, button);
            });
        } else {
            fallbackCopy(text, button);
        }
    }

    //function untuk menangani ketika gagal mengcopy karena tidak diizinkan di pengaturan hosting
    function fallbackCopy(text, button) {
        const textarea = document.createElement("textarea");
        textarea.value = text;
        textarea.style.position = "fixed";
        textarea.style.opacity = 0;
        textarea.style.left = "-9999px";
        document.body.appendChild(textarea);
        textarea.focus();
        textarea.select();
        try {
            const successful = document.execCommand("copy");
            if (successful) {
                showToast(button, "Disalin!");
            } else {
                throw new Error("Copy command failed");
            }
        } catch (err) {
            showToast(button, "Gagal!");
        }
        document.body.removeChild(textarea);
    }

    //function ntuk menangani toast saat copy kode diskon
    function showToast(button, message) {
        const toast = button.parentElement.querySelector('#copy-toast');
        if (toast) {
            toast.textContent = message;
            toast.classList.remove('opacity-0');
            toast.classList.add('opacity-100');

            setTimeout(() => {
                toast.classList.remove('opacity-100');
                toast.classList.add('opacity-0');
            }, 3000);
        }
    }
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
