<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/jpg" href="{{ asset('storage/logo.png') }}">
    <title>Verifikasi Sertifikat - Sibermuda: Platform Kursus Online</title>

    <meta property="og:title" content="Verifikasi Sertifikat - Sibermuda: Platform Kursus Online">
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
        .gradient-bg {
            background: linear-gradient(135deg, #0f0f1b 0%, #10132c 100%);
        }
        .certificate-card {
            background: white;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
        }
        .verified-badge {
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }
    </style>
</head>
<body class="bg-gray-50">
    @include('components.navbar')

    <!-- Hero Section -->
    <section class="gradient-bg text-white py-16 md:py-20 px-4">
        <div class="container mx-auto mt-7 md:px-8">
            <div class="text-center max-w-3xl mx-auto" data-aos="fade-up">
                <div class="mb-6">
                    <i class="fas fa-certificate text-6xl opacity-90"></i>
                </div>
                <h1 class="text-4xl md:text-5xl font-bold mb-4">
                    Certificate Verify
                </h1>
                <p class="text-lg md:text-xl opacity-90">
                    Verifikasi keaslian sertifikat digital Sibermuda
                </p>
            </div>
        </div>
    </section>

    <!-- Search Section -->
    <section class="py-12 -mt-20">
        <div class="container mx-auto px-4 md:px-8">
            <div class="max-w-4xl mx-auto">
                <div class="bg-white rounded-2xl shadow-2xl p-8 md:p-12" data-aos="fade-up">
                    <h2 class="text-2xl md:text-3xl font-bold text-[#08072a] mb-2 text-center">
                        Search Certificate by ID
                    </h2>
                    <p class="text-gray-600 text-center mb-8">
                        Masukkan Certificate ID untuk memverifikasi sertifikat
                    </p>

                    <form id="searchForm" class="flex flex-col md:flex-row gap-4">
                        <input
                            type="text"
                            id="certificateId"
                            placeholder="Certificate ID (e.g., CERT-2024-001234)"
                            class="flex-1 px-6 py-4 border-2 border-gray-300 rounded-xl focus:outline-none focus:border-[#0a0d1b] text-lg transition-all duration-300"
                            required
                        >
                        <button
                            type="submit"
                            class="gradient-bg text-white px-8 py-4 rounded-xl font-semibold hover:shadow-xl transition-all duration-300 transform hover:scale-105"
                        >
                            <i class="fas fa-search mr-2"></i>
                            Search
                        </button>
                    </form>

                    <div class="mt-6 text-center text-sm text-gray-500">
                        <i class="fas fa-info-circle mr-1"></i>
                        Certificate ID dapat ditemukan pada sertifikat digital Anda
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Result Section (Initially Hidden) -->
    <section id="resultSection" class="py-8 hidden">
        <div class="container mx-auto px-4 md:px-8">
            <div class="max-w-4xl mx-auto">
                <!-- Valid Certificate -->
                <div id="validResult" class="certificate-card rounded-2xl p-8 md:p-12 hidden" data-aos="zoom-in">
                    <div class="text-center mb-8">
                        <div class="inline-flex items-center justify-center w-20 h-20 bg-green-100 rounded-full mb-4 verified-badge">
                            <i class="fas fa-check-circle text-4xl text-green-600"></i>
                        </div>
                        <h3 class="text-2xl md:text-3xl font-bold text-green-600 mb-2">
                            Certificate Valid!
                        </h3>
                        <p class="text-gray-600">
                            Sertifikat ini terdaftar dan valid di sistem Sibermuda
                        </p>
                    </div>

                    <div class="border-t-2 border-gray-200 pt-8">
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <h4 class="font-semibold text-[#08072a] mb-4 flex items-center">
                                    <i class="fas fa-user-graduate mr-2 text-[#667eea]"></i>
                                    Informasi Penerima
                                </h4>
                                <div class="space-y-3 text-sm">
                                    <div>
                                        <span class="text-gray-500">Nama:</span>
                                        <p id="studentName" class="font-semibold text-gray-800"></p>
                                    </div>
                                    <div>
                                        <span class="text-gray-500">Email:</span>
                                        <p id="studentEmail" class="font-semibold text-gray-800"></p>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <h4 class="font-semibold text-[#08072a] mb-4 flex items-center">
                                    <i class="fas fa-book mr-2 text-[#04050b]"></i>
                                    Informasi Kursus
                                </h4>
                                <div class="space-y-3 text-sm">
                                    <div>
                                        <span class="text-gray-500">Nama Kursus:</span>
                                        <p id="courseName" class="font-semibold text-gray-800"></p>
                                    </div>
                                    <div>
                                        <span class="text-gray-500">Tanggal Selesai:</span>
                                        <p id="completionDate" class="font-semibold text-gray-800"></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 p-4 bg-gray-50 rounded-xl">
                            <div class="flex items-start gap-3">
                                <i class="fas fa-shield-alt text-[#04050b] text-xl mt-1"></i>
                                <div class="flex-1">
                                    <h5 class="font-semibold text-[#08072a] mb-1">Certificate ID</h5>
                                    <p id="certId" class="text-gray-700 font-mono text-sm"></p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 flex flex-wrap gap-3 justify-center">
                            <button onclick="downloadCertificate()" class="bg-[#08072a] text-white px-6 py-3 rounded-lg font-semibold hover:bg-opacity-90 transition-all duration-300">
                                <i class="fas fa-download mr-2"></i>
                                Download Certificate
                            </button>
                            <button onclick="searchAnother()" class="bg-gray-200 text-gray-700 px-6 py-3 rounded-lg font-semibold hover:bg-gray-300 transition-all duration-300">
                                <i class="fas fa-search mr-2"></i>
                                Cari Lagi
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Invalid Certificate -->
                <div id="invalidResult" class="certificate-card rounded-2xl p-8 md:p-12 hidden" data-aos="zoom-in">
                    <div class="text-center">
                        <div class="inline-flex items-center justify-center w-20 h-20 bg-red-100 rounded-full mb-4">
                            <i class="fas fa-times-circle text-4xl text-red-600"></i>
                        </div>
                        <h3 class="text-2xl md:text-3xl font-bold text-red-600 mb-2">
                            Certificate Not Found
                        </h3>
                        <p class="text-gray-600 mb-6">
                            Sertifikat dengan ID tersebut tidak ditemukan di sistem kami
                        </p>

                        <div class="bg-red-50 border border-red-200 rounded-xl p-6 mb-6 text-left">
                            <h4 class="font-semibold text-red-800 mb-3">Kemungkinan Penyebab:</h4>
                            <ul class="space-y-2 text-sm text-red-700">
                                <li class="flex items-start gap-2">
                                    <i class="fas fa-exclamation-circle mt-1"></i>
                                    <span>Certificate ID salah atau tidak valid</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <i class="fas fa-exclamation-circle mt-1"></i>
                                    <span>Sertifikat belum diterbitkan oleh sistem</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <i class="fas fa-exclamation-circle mt-1"></i>
                                    <span>Sertifikat palsu atau tidak resmi dari Sibermuda</span>
                                </li>
                            </ul>
                        </div>

                        <button onclick="searchAnother()" class="gradient-bg text-white px-8 py-3 rounded-lg font-semibold hover:shadow-xl transition-all duration-300">
                            <i class="fas fa-redo mr-2"></i>
                            Coba Lagi
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How to Verify Section -->
    <section class="bg-white py-12">
        <div class="container mx-auto px-4 md:px-8">
            <div class="max-w-4xl mx-auto">
                <h3 class="text-2xl font-bold text-[#08072a] text-center mb-8" data-aos="fade-up">
                    Cara Verifikasi Sertifikat
                </h3>

                <div class="grid md:grid-cols-3 gap-6">
                    <div class="text-center p-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="inline-flex items-center justify-center w-16 h-16 gradient-bg text-white rounded-full mb-4">
                            <span class="text-2xl font-bold">1</span>
                        </div>
                        <h4 class="font-semibold text-[#08072a] mb-2">Temukan Certificate ID</h4>
                        <p class="text-gray-600 text-sm">Cari Certificate ID pada sertifikat digital Anda</p>
                    </div>

                    <div class="text-center p-6" data-aos="fade-up" data-aos-delay="200">
                        <div class="inline-flex items-center justify-center w-16 h-16 gradient-bg text-white rounded-full mb-4">
                            <span class="text-2xl font-bold">2</span>
                        </div>
                        <h4 class="font-semibold text-[#08072a] mb-2">Masukkan ID</h4>
                        <p class="text-gray-600 text-sm">Input Certificate ID pada form pencarian di atas</p>
                    </div>

                    <div class="text-center p-6" data-aos="fade-up" data-aos-delay="300">
                        <div class="inline-flex items-center justify-center w-16 h-16 gradient-bg text-white rounded-full mb-4">
                            <span class="text-2xl font-bold">3</span>
                        </div>
                        <h4 class="font-semibold text-[#08072a] mb-2">Lihat Hasil</h4>
                        <p class="text-gray-600 text-sm">Sistem akan menampilkan detail sertifikat jika valid</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="bg-gray-50 py-12">
        <div class="container mx-auto px-4 md:px-8">
            <div class="max-w-3xl mx-auto">
                <h3 class="text-2xl font-bold text-[#08072a] text-center mb-8" data-aos="fade-up">
                    Pertanyaan Umum
                </h3>

                <div class="space-y-4">
                    <div class="bg-white rounded-xl p-6 border-2 border-gray-200" data-aos="fade-up">
                        <h4 class="font-semibold text-[#08072a] mb-2 flex items-center">
                            <i class="fas fa-question-circle text-[#08072a] mr-2"></i>
                            Apa itu Certificate ID?
                        </h4>
                        <p class="text-gray-600 text-sm">
                            Certificate ID adalah nomor unik yang diberikan pada setiap sertifikat digital yang diterbitkan oleh Sibermuda. ID ini digunakan untuk memverifikasi keaslian sertifikat.
                        </p>
                    </div>

                    <div class="bg-white rounded-xl p-6 border-2 border-gray-200" data-aos="fade-up" data-aos-delay="100">
                        <h4 class="font-semibold text-[#08072a] mb-2 flex items-center">
                            <i class="fas fa-question-circle text-[#08072a] mr-2"></i>
                            Bagaimana jika sertifikat tidak ditemukan?
                        </h4>
                        <p class="text-gray-600 text-sm">
                            Pastikan Certificate ID yang Anda masukkan benar. Jika masih tidak ditemukan, silakan hubungi tim support kami melalui email atau WhatsApp.
                        </p>
                    </div>

                    <div class="bg-white rounded-xl p-6 border-2 border-gray-200" data-aos="fade-up" data-aos-delay="200">
                        <h4 class="font-semibold text-[#08072a] mb-2 flex items-center">
                            <i class="fas fa-question-circle text-[#08072a] mr-2"></i>
                            Berapa lama sertifikat berlaku?
                        </h4>
                        <p class="text-gray-600 text-sm">
                            Sertifikat dari Sibermuda berlaku selamanya dan dapat diverifikasi kapan saja melalui sistem ini.
                        </p>
                    </div>
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

        // Sample certificate data (replace with actual API call)
        const certificates = {
            'CERT-2024-001234': {
                studentName: 'Ahmad Rizki Fauzi',
                studentEmail: 'ahmad.rizki@email.com',
                courseName: 'Full Stack Web Development Bootcamp',
                completionDate: '15 Januari 2024',
                certId: 'CERT-2024-001234'
            },
            'CERT-2024-001235': {
                studentName: 'Siti Nurhaliza',
                studentEmail: 'siti.nur@email.com',
                courseName: 'Cyber Security Bootcamp',
                completionDate: '20 Januari 2024',
                certId: 'CERT-2024-001235'
            },
            'CERT-2024-001236': {
                studentName: 'Budi Santoso',
                studentEmail: 'budi.santoso@email.com',
                courseName: 'Data Science & AI Bootcamp',
                completionDate: '25 Januari 2024',
                certId: 'CERT-2024-001236'
            }
        };

        document.getElementById('searchForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const certId = document.getElementById('certificateId').value.trim().toUpperCase();
            const resultSection = document.getElementById('resultSection');
            const validResult = document.getElementById('validResult');
            const invalidResult = document.getElementById('invalidResult');

            // Hide both results first
            validResult.classList.add('hidden');
            invalidResult.classList.add('hidden');

            // Simulate API call delay
            setTimeout(() => {
                if (certificates[certId]) {
                    // Valid certificate
                    const cert = certificates[certId];
                    document.getElementById('studentName').textContent = cert.studentName;
                    document.getElementById('studentEmail').textContent = cert.studentEmail;
                    document.getElementById('courseName').textContent = cert.courseName;
                    document.getElementById('completionDate').textContent = cert.completionDate;
                    document.getElementById('certId').textContent = cert.certId;

                    validResult.classList.remove('hidden');
                } else {
                    // Invalid certificate
                    invalidResult.classList.remove('hidden');
                }

                // Show result section and scroll to it
                resultSection.classList.remove('hidden');
                resultSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }, 500);
        });

        function searchAnother() {
            document.getElementById('certificateId').value = '';
            document.getElementById('resultSection').classList.add('hidden');
            document.getElementById('certificateId').focus();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function downloadCertificate() {
            // Implement download logic here
            alert('Download certificate feature - will be implemented with actual PDF generation');
        }
    </script>
</body>
</html>
