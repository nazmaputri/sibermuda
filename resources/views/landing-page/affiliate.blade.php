<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/jpg" href="{{ asset('storage/logo.png') }}">
    <title>Program Affiliate - Sibermuda: Platform Kursus Online</title>

    <meta property="og:title" content="Program Affiliate - Sibermuda: Platform Kursus Online">
    @vite('resources/css/app.css')

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- AOS CSS -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Custom Style -->
    <style>
        body {
            font-family: "Poppins", sans-serif !important;
        }
        .gradient-blue {
            background: linear-gradient(135deg, #667eea 0%, #26338c 100%);
        }
        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #26338c 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
</head>
<body class="bg-gray-50">
    @include('components.navbar')

    <!-- Hero Section -->
    <section class="relative bg-white pt-28 pb-16 overflow-hidden">
        <div class="container mx-auto px-4 md:px-8">
            <div class="grid md:grid-cols-2 gap-8 items-center">
                <!-- Left Content -->
                <div class="order-2 md:order-1" data-aos="fade-right">
                    <h1 class="text-4xl md:text-4xl font-bold mb-4">
                        <span class="gradient-text">Program Afiliasi<br>SIBERMUDA</span>
                    </h1>
                    <p class="text-xl font-semibold text-gray-800 mb-4">
                        Mulai hasilkan uang dari rumah!
                    </p>
                    <p class="text-gray-600 mb-2">
                        Gabung Program Afiliasi SIBERMUDA sekarang dan nikmati <span class="font-bold text-blue-600">komisi 20%</span>
                    </p>
                    <p class="text-gray-600 mb-6">
                        dari setiap transaksi. <span class="font-bold text-[#08072a]">GRATIS tanpa modal!</span>
                    </p>
                    <a href="#daftar" class="gradient-blue inline-flex items-center gap-2 text-white px-8 py-4 rounded-xl font-semibold hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                        <i class="fas fa-gift"></i>
                        Gabung Afiliasi Sekarang
                    </a>
                </div>

                <!-- Right Image -->
                <div class="order-1 md:order-2 relative" data-aos="fade-left">
                    <div class="relative">
                        <!-- Background Shapes -->
                        <div class="absolute -top-10 -right-10 w-64 h-64 bg-gradient-to-br from-blue-400 to-pink-400 rounded-3xl opacity-20 animate-pulse"></div>
                        <div class="absolute -bottom-10 -left-10 w-48 h-48 bg-gradient-to-br from-cyan-400 to-blue-400 rounded-3xl opacity-20 animate-pulse" style="animation-delay: 1s"></div>

                        <!-- Person Image Placeholder -->
                        <div class="relative z-10 bg-gradient-to-br from-blue-100 to-pink-100 rounded-3xl p-8 text-center">
                            <div class="mb-4">
                                <i class="fas fa-user-tie text-9xl text-gray-400"></i>
                            </div>

                            <!-- Floating Cards -->
                            <div class="absolute -top-8 -left-4 bg-white rounded-xl shadow-lg p-4 animate-bounce" style="animation-duration: 2s;">
                                <div class="text-sm font-semibold text-blue-600">Komisi 20%</div>
                                <div class="text-2xl font-bold text-[#08072a]">+5%</div>
                            </div>

                            <div class="absolute top-1/4 -right-6 bg-white rounded-xl shadow-lg p-3">
                                <div class="flex items-center gap-2">
                                    <img src="https://ui-avatars.com/api/?name=Putri+Maharani&background=667eea&color=fff" alt="User" class="w-8 h-8 rounded-full">
                                    <div class="text-left">
                                        <div class="text-xs font-semibold text-gray-800">Putri Maharani</div>
                                        <div class="text-xs text-gray-500">Masukkan kode referral</div>
                                    </div>
                                </div>
                            </div>

                            <div class="absolute bottom-8 -left-6 bg-white rounded-xl shadow-lg p-3">
                                <div class="flex items-center gap-2">
                                    <img src="https://ui-avatars.com/api/?name=Budi+Santoso&background=764ba2&color=fff" alt="User" class="w-8 h-8 rounded-full">
                                    <div class="text-left">
                                        <div class="text-xs font-semibold text-gray-800">Budi Santoso</div>
                                        <div class="text-xs text-green-600 font-semibold">Your balance</div>
                                        <div class="text-sm font-bold text-[#08072a]">Rp 3.497.500</div>
                                    </div>
                                    <button class="gradient-blue text-white px-3 py-1 rounded-lg text-xs font-semibold">Tarik Saldo</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Benefits Section -->
    <section class="bg-gray-50 py-16">
        <div class="container mx-auto px-4 md:px-8">
            <div class="text-center mb-12" data-aos="fade-up">
                <h2 class="text-3xl md:text-4xl font-bold text-[#08072a] mb-4">
                    Keuntungan Bergabung
                </h2>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    Raih penghasilan tambahan dengan menjadi affiliate partner Sibermuda
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 border-2 border-transparent hover:border-blue-500" data-aos="fade-up">
                    <div class="w-16 h-16 gradient-blue rounded-xl flex items-center justify-center mb-4">
                        <i class="fas fa-percent text-3xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold text-[#08072a] mb-3">Komisi Besar 25%</h3>
                    <p class="text-gray-600">
                        Dapatkan komisi 25% dari setiap transaksi yang berhasil melalui link referral Anda. Semakin banyak referral, semakin besar penghasilan!
                    </p>
                </div>

                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 border-2 border-transparent hover:border-blue-500" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-16 h-16 gradient-blue rounded-xl flex items-center justify-center mb-4">
                        <i class="fas fa-gift text-3xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold text-[#08072a] mb-3">Gratis Tanpa Modal</h3>
                    <p class="text-gray-600">
                        Tidak perlu modal apapun untuk bergabung. Daftar sekarang dan mulai hasilkan uang dari rumah dengan mudah!
                    </p>
                </div>

                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 border-2 border-transparent hover:border-blue-500" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-16 h-16 gradient-blue rounded-xl flex items-center justify-center mb-4">
                        <i class="fas fa-wallet text-3xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold text-[#08072a] mb-3">Pencairan Mudah</h3>
                    <p class="text-gray-600">
                        Tarik komisi Anda kapan saja melalui transfer bank atau e-wallet. Proses cepat dan aman, tanpa minimum withdrawal yang memberatkan.
                    </p>
                </div>

                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 border-2 border-transparent hover:border-blue-500" data-aos="fade-up">
                    <div class="w-16 h-16 gradient-blue rounded-xl flex items-center justify-center mb-4">
                        <i class="fas fa-chart-line text-3xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold text-[#08072a] mb-3">Dashboard Analytics</h3>
                    <p class="text-gray-600">
                        Monitor performa affiliate Anda secara real-time dengan dashboard yang lengkap dan mudah dipahami.
                    </p>
                </div>

                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 border-2 border-transparent hover:border-blue-500" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-16 h-16 gradient-blue rounded-xl flex items-center justify-center mb-4">
                        <i class="fas fa-headset text-3xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold text-[#08072a] mb-3">Support 24/7</h3>
                    <p class="text-gray-600">
                        Tim support kami siap membantu Anda kapan saja untuk memaksimalkan penghasilan dari program affiliate.
                    </p>
                </div>

                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 border-2 border-transparent hover:border-blue-500" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-16 h-16 gradient-blue rounded-xl flex items-center justify-center mb-4">
                        <i class="fas fa-rocket text-3xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold text-[#08072a] mb-3">Marketing Materials</h3>
                    <p class="text-gray-600">
                        Dapatkan akses ke berbagai materi marketing seperti banner, template sosmed, dan konten promosi yang menarik.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="bg-white py-16">
        <div class="container mx-auto px-4 md:px-8">
            <div class="text-center mb-12" data-aos="fade-up">
                <h2 class="text-3xl md:text-4xl font-bold text-[#08072a] mb-4">
                    Cara Kerja Program Affiliate
                </h2>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    Mudah dan sederhana, mulai hasilkan uang dalam 3 langkah
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                <div class="relative" data-aos="fade-up">
                    <div class="bg-white shadow-lg rounded-2xl p-8 text-center">
                        <div class="w-16 h-16 gradient-blue rounded-full flex items-center justify-center text-white text-2xl font-bold mx-auto mb-4">
                            1
                        </div>
                        <h3 class="text-xl font-bold text-[#08072a] mb-3">Daftar Gratis</h3>
                        <p class="text-gray-600">
                            Isi formulir pendaftaran dan verifikasi akun Anda. Proses mudah dan cepat, hanya butuh 2 menit!
                        </p>
                    </div>
                    <div class="hidden md:block absolute top-1/2 -right-8 transform -translate-y-1/2">
                        <i class="fas fa-arrow-right text-4xl text-blue-300"></i>
                    </div>
                </div>

                <div class="relative" data-aos="fade-up" data-aos-delay="100">
                    <div class="bg-white shadow-lg rounded-2xl p-8 text-center">
                        <div class="w-16 h-16 gradient-blue rounded-full flex items-center justify-center text-white text-2xl font-bold mx-auto mb-4">
                            2
                        </div>
                        <h3 class="text-xl font-bold text-[#08072a] mb-3">Bagikan Link</h3>
                        <p class="text-gray-600">
                            Dapatkan link referral unik dan bagikan ke teman, keluarga, atau sosial media Anda.
                        </p>
                    </div>
                    <div class="hidden md:block absolute top-1/2 -right-8 transform -translate-y-1/2">
                        <i class="fas fa-arrow-right text-4xl text-blue-300"></i>
                    </div>
                </div>

                <div class="relative" data-aos="fade-up" data-aos-delay="200">
                    <div class="bg-white shadow-lg rounded-2xl p-8 text-center">
                        <div class="w-16 h-16 gradient-blue rounded-full flex items-center justify-center text-white text-2xl font-bold mx-auto mb-4">
                            3
                        </div>
                        <h3 class="text-xl font-bold text-[#08072a] mb-3">Dapatkan Komisi</h3>
                        <p class="text-gray-600">
                            Raih komisi 25% setiap ada yang membeli melalui link Anda. Komisi langsung masuk ke saldo!
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Registration Form Section -->
    <section id="daftar" class="bg-gray-50 py-16">
        <div class="container mx-auto px-4 md:px-8">
            <div class="max-w-2xl mx-auto">
                <!-- Alert Notice -->
                <div class="bg-red-600 text-white rounded-xl p-4 mb-8 flex items-start gap-3" data-aos="fade-up">
                    <i class="fas fa-exclamation-triangle text-2xl mt-1"></i>
                    <div>
                        <p class="font-semibold">Perhatian!</p>
                        <p class="text-sm">Kamu harus membeli produk <a href="#" class="underline font-semibold">Daftar Affiliate</a> untuk menjadi affiliate setelah mengirimkan formulir</p>
                    </div>
                </div>

                <!-- Form Card -->
                <div class="bg-white rounded-2xl shadow-xl p-8 md:p-12" data-aos="fade-up">
                    <h2 class="text-2xl md:text-3xl font-bold text-[#08072a] mb-8 text-center">
                        Formulir Pendaftaran Program Affiliate
                    </h2>

                    <form action="{{ route('affiliate.register') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Full Name -->
                        <div>
                            <label for="full_name" class="block text-sm font-semibold text-gray-700 mb-2">
                                Nama Lengkap <span class="text-red-600">*</span>
                            </label>
                            <input
                                type="text"
                                id="full_name"
                                name="full_name"
                                required
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:outline-none focus:border-blue-500 transition-colors duration-300"
                                placeholder="Masukkan nama lengkap Anda"
                            >
                        </div>

                        <!-- Username -->
                        <div>
                            <label for="username" class="block text-sm font-semibold text-gray-700 mb-2">
                                Username <span class="text-red-600">*</span>
                            </label>
                            <input
                                type="text"
                                id="username"
                                name="username"
                                required
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:outline-none focus:border-blue-500 transition-colors duration-300 bg-gray-50"
                                placeholder="nazmaaputrii@gmail.com"
                                value="nazmaaputrii@gmail.com"
                            >
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                Email <span class="text-red-600">*</span>
                            </label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                required
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:outline-none focus:border-blue-500 transition-colors duration-300"
                                placeholder="contoh@email.com"
                            >
                        </div>

                        <!-- WhatsApp Number -->
                        <div>
                            <label for="whatsapp" class="block text-sm font-semibold text-gray-700 mb-2">
                                No. Whatsapp <span class="text-red-600">*</span>
                            </label>
                            <input
                                type="tel"
                                id="whatsapp"
                                name="whatsapp"
                                required
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:outline-none focus:border-blue-500 transition-colors duration-300"
                                placeholder="08xxxxxxxxxx"
                            >
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                                Password <span class="text-red-600">*</span>
                            </label>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                required
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:outline-none focus:border-blue-500 transition-colors duration-300 bg-gray-50"
                                placeholder="••••••••••••"
                            >
                        </div>

                        <!-- Terms & Conditions -->
                        <div class="flex items-start gap-3">
                            <input
                                type="checkbox"
                                id="terms"
                                name="terms"
                                required
                                class="mt-1 w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                            >
                            <label for="terms" class="text-sm text-gray-700">
                                <span class="text-red-600">*</span> Saya Menyetujui
                                <a href="#" class="text-blue-600 hover:underline font-semibold">Terms of Service</a>
                            </label>
                        </div>

                        <!-- Submit Button -->
                        <button
                            type="submit"
                            class="w-full gradient-blue text-white py-4 rounded-xl font-semibold text-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105"
                        >
                            Register
                        </button>

                        <!-- Login Link -->
                        <p class="text-center text-sm text-gray-600">
                            Sudah punya akun affiliate?
                            <a href="{{ route('affiliate.login') }}" class="text-blue-600 hover:underline font-semibold">Login di sini</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="bg-white py-16">
        <div class="container mx-auto px-4 md:px-8">
            <div class="text-center mb-12" data-aos="fade-up">
                <h2 class="text-3xl md:text-4xl font-bold text-[#08072a] mb-4">
                    Pertanyaan yang Sering Diajukan
                </h2>
            </div>

            <div class="max-w-3xl mx-auto space-y-4">
                <div class="bg-gray-50 rounded-xl p-6 border-2 border-gray-200 hover:border-blue-500 transition-colors duration-300" data-aos="fade-up">
                    <h3 class="font-semibold text-[#08072a] mb-2 flex items-center gap-2">
                        <i class="fas fa-question-circle text-blue-600"></i>
                        Apakah ada biaya untuk bergabung?
                    </h3>
                    <p class="text-gray-600 text-sm ml-7">
                        Tidak ada biaya sama sekali. Program affiliate Sibermuda 100% gratis dan tanpa modal.
                    </p>
                </div>

                <div class="bg-gray-50 rounded-xl p-6 border-2 border-gray-200 hover:border-blue-500 transition-colors duration-300" data-aos="fade-up">
                    <h3 class="font-semibold text-[#08072a] mb-2 flex items-center gap-2">
                        <i class="fas fa-question-circle text-blue-600"></i>
                        Kapan saya bisa menarik komisi?
                    </h3>
                    <p class="text-gray-600 text-sm ml-7">
                        Anda bisa menarik komisi kapan saja setelah mencapai minimum withdrawal sebesar Rp 100.000.
                    </p>
                </div>

                <div class="bg-gray-50 rounded-xl p-6 border-2 border-gray-200 hover:border-blue-500 transition-colors duration-300" data-aos="fade-up">
                    <h3 class="font-semibold text-[#08072a] mb-2 flex items-center gap-2">
                        <i class="fas fa-question-circle text-blue-600"></i>
                        Bagaimana cara mendapatkan link referral?
                    </h3>
                    <p class="text-gray-600 text-sm ml-7">
                        Setelah mendaftar dan akun Anda diverifikasi, Anda akan mendapatkan link referral unik di dashboard affiliate Anda.
                    </p>
                </div>

                <div class="bg-gray-50 rounded-xl p-6 border-2 border-gray-200 hover:border-blue-500 transition-colors duration-300" data-aos="fade-up">
                    <h3 class="font-semibold text-[#08072a] mb-2 flex items-center gap-2">
                        <i class="fas fa-question-circle text-blue-600"></i>
                        Apakah komisi berlaku selamanya?
                    </h3>
                    <p class="text-gray-600 text-sm ml-7">
                        Ya, Anda akan terus mendapatkan komisi dari setiap pembelian yang dilakukan melalui link referral Anda tanpa batas waktu.
                    </p>
                </div>
            </div>
        </div>
    </section>

    @include('components.footer')

    <!-- AOS JS -->
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 1000,
            once: true,
        });
    </script>
</body>
</html>
