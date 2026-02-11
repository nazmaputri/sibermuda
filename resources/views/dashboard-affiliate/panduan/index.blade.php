@extends('layouts.dashboard-affiliate')
@section('title', 'Panduan Affiliate')
@section('content')
    {{-- Header Section --}}
    <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6 mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Panduan Affiliate</h1>
        <p class="text-gray-600 mt-1">Pelajari cara menjadi affiliate sukses dan maksimalkan penghasilan Anda</p>
    </div>

    {{-- Quick Stats --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-md p-6 text-white">
            <div class="flex items-center">
                <div class="bg-white bg-opacity-20 p-3 rounded-full">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-blue-100 text-sm">Komisi Per Penjualan</p>
                    <h2 class="text-3xl font-bold mt-1">10%</h2>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-md p-6 text-white">
            <div class="flex items-center">
                <div class="bg-white bg-opacity-20 p-3 rounded-full">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-green-100 text-sm">Cookie Duration</p>
                    <h2 class="text-3xl font-bold mt-1">30 Hari</h2>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow-md p-6 text-white">
            <div class="flex items-center">
                <div class="bg-white bg-opacity-20 p-3 rounded-full">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-purple-100 text-sm">Minimal Penarikan</p>
                    <h2 class="text-2xl font-bold mt-1">Rp 100K</h2>
                </div>
            </div>
        </div>
    </div>

    {{-- Cara Kerja --}}
    <div class="bg-white shadow-md border border-gray-200 rounded-lg p-6 mb-6">
        <div class="flex flex-col items-center mb-4">
            <h2 class="text-lg font-semibold inline-block pb-1 text-gray-700">Cara Kerja Program Affiliate</h2>
            <div class="border-b-2 w-full mt-1"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="text-center">
                <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl font-bold text-blue-600">1</span>
                </div>
                <h3 class="font-semibold text-gray-800 mb-2">Daftar & Dapatkan Link</h3>
                <p class="text-sm text-gray-600">Daftar sebagai affiliate dan dapatkan link referral unik Anda</p>
            </div>

            <div class="text-center">
                <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl font-bold text-green-600">2</span>
                </div>
                <h3 class="font-semibold text-gray-800 mb-2">Bagikan Link</h3>
                <p class="text-sm text-gray-600">Promosikan link Anda di media sosial, blog, atau ke teman-teman</p>
            </div>

            <div class="text-center">
                <div class="bg-yellow-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl font-bold text-yellow-600">3</span>
                </div>
                <h3 class="font-semibold text-gray-800 mb-2">Referral Membeli</h3>
                <p class="text-sm text-gray-600">Ketika seseorang membeli kursus melalui link Anda</p>
            </div>

            <div class="text-center">
                <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl font-bold text-purple-600">4</span>
                </div>
                <h3 class="font-semibold text-gray-800 mb-2">Dapatkan Komisi</h3>
                <p class="text-sm text-gray-600">Anda mendapat komisi 10% dari setiap pembelian</p>
            </div>
        </div>
    </div>

    {{-- Tips Sukses --}}
    <div class="bg-white shadow-md border border-gray-200 rounded-lg p-6 mb-6">
        <div class="flex flex-col items-center mb-4">
            <h2 class="text-lg font-semibold inline-block pb-1 text-gray-700">Tips Sukses Menjadi Affiliate</h2>
            <div class="border-b-2 w-full mt-1"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="border-l-4 border-blue-500 pl-4 py-2">
                <h3 class="font-semibold text-gray-800 mb-2 flex items-center">
                    <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Pilih Target Audience yang Tepat
                </h3>
                <p class="text-sm text-gray-600">Fokus pada audience yang memang membutuhkan kursus online. Pastikan mereka tertarik dengan topik pembelajaran yang Anda promosikan.</p>
            </div>

            <div class="border-l-4 border-green-500 pl-4 py-2">
                <h3 class="font-semibold text-gray-800 mb-2 flex items-center">
                    <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Buat Konten Berkualitas
                </h3>
                <p class="text-sm text-gray-600">Review kursus secara jujur, buat tutorial atau tips yang relate dengan kursus. Konten edukatif lebih efektif daripada hard selling.</p>
            </div>

            <div class="border-l-4 border-yellow-500 pl-4 py-2">
                <h3 class="font-semibold text-gray-800 mb-2 flex items-center">
                    <svg class="w-5 h-5 text-yellow-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Manfaatkan Multiple Channels
                </h3>
                <p class="text-sm text-gray-600">Jangan hanya promosi di satu platform. Gunakan Instagram, Facebook, YouTube, Blog, Email, WhatsApp, dan channel lainnya.</p>
            </div>

            <div class="border-l-4 border-purple-500 pl-4 py-2">
                <h3 class="font-semibold text-gray-800 mb-2 flex items-center">
                    <svg class="w-5 h-5 text-purple-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Gunakan Call-to-Action yang Jelas
                </h3>
                <p class="text-sm text-gray-600">Berikan instruksi yang jelas kepada audience untuk mengklik link Anda. Contoh: "Daftar sekarang", "Klaim diskonnya", dll.</p>
            </div>

            <div class="border-l-4 border-red-500 pl-4 py-2">
                <h3 class="font-semibold text-gray-800 mb-2 flex items-center">
                    <svg class="w-5 h-5 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Bangun Trust dengan Audience
                </h3>
                <p class="text-sm text-gray-600">Jangan hanya jualan, bangun hubungan. Berikan value terlebih dahulu, jawab pertanyaan, dan jadilah resource yang helpful.</p>
            </div>

            <div class="border-l-4 border-pink-500 pl-4 py-2">
                <h3 class="font-semibold text-gray-800 mb-2 flex items-center">
                    <svg class="w-5 h-5 text-pink-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Track & Optimize
                </h3>
                <p class="text-sm text-gray-600">Pantau performa link Anda di dashboard. Lihat mana channel yang paling efektif dan fokus ke sana.</p>
            </div>
        </div>
    </div>

    {{-- FAQ --}}
    <div class="bg-white shadow-md border border-gray-200 rounded-lg p-6">
        <div class="flex flex-col items-center mb-4">
            <h2 class="text-lg font-semibold inline-block pb-1 text-gray-700">Frequently Asked Questions</h2>
            <div class="border-b-2 w-full mt-1"></div>
        </div>

        <div class="space-y-4" x-data="{ activeIndex: null }">
            {{-- FAQ 1 --}}
            <div class="border border-gray-200 rounded-lg">
                <button @click="activeIndex = activeIndex === 1 ? null : 1"
                        class="w-full flex justify-between items-center p-4 text-left hover:bg-gray-50 transition">
                    <span class="font-semibold text-gray-800">Berapa komisi yang saya dapatkan?</span>
                    <svg class="w-5 h-5 text-gray-500 transform transition-transform"
                         :class="{ 'rotate-180': activeIndex === 1 }"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="activeIndex === 1"
                     x-transition
                     class="px-4 pb-4 text-sm text-gray-600">
                    Anda mendapatkan komisi 10% dari setiap pembelian kursus yang dilakukan melalui link referral Anda. Misalnya, jika seseorang membeli kursus seharga Rp 1.000.000, Anda akan mendapat komisi Rp 100.000.
                </div>
            </div>

            {{-- FAQ 2 --}}
            <div class="border border-gray-200 rounded-lg">
                <button @click="activeIndex = activeIndex === 2 ? null : 2"
                        class="w-full flex justify-between items-center p-4 text-left hover:bg-gray-50 transition">
                    <span class="font-semibold text-gray-800">Kapan saya bisa menarik komisi?</span>
                    <svg class="w-5 h-5 text-gray-500 transform transition-transform"
                         :class="{ 'rotate-180': activeIndex === 2 }"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="activeIndex === 2"
                     x-transition
                     class="px-4 pb-4 text-sm text-gray-600">
                    Anda bisa menarik komisi kapan saja asalkan saldo Anda sudah mencapai minimal penarikan yaitu Rp 100.000. Proses penarikan biasanya diproses dalam 3-7 hari kerja.
                </div>
            </div>

            {{-- FAQ 3 --}}
            <div class="border border-gray-200 rounded-lg">
                <button @click="activeIndex = activeIndex === 3 ? null : 3"
                        class="w-full flex justify-between items-center p-4 text-left hover:bg-gray-50 transition">
                    <span class="font-semibold text-gray-800">Apa itu cookie duration 30 hari?</span>
                    <svg class="w-5 h-5 text-gray-500 transform transition-transform"
                         :class="{ 'rotate-180': activeIndex === 3 }"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="activeIndex === 3"
                     x-transition
                     class="px-4 pb-4 text-sm text-gray-600">
                    Cookie duration adalah periode waktu dimana referral Anda masih "tercatat" di sistem. Jadi jika seseorang klik link Anda hari ini tapi baru membeli 20 hari kemudian, Anda tetap mendapat komisi karena masih dalam periode 30 hari.
                </div>
            </div>

            {{-- FAQ 4 --}}
            <div class="border border-gray-200 rounded-lg">
                <button @click="activeIndex = activeIndex === 4 ? null : 4"
                        class="w-full flex justify-between items-center p-4 text-left hover:bg-gray-50 transition">
                    <span class="font-semibold text-gray-800">Apakah ada batasan jumlah referral?</span>
                    <svg class="w-5 h-5 text-gray-500 transform transition-transform"
                         :class="{ 'rotate-180': activeIndex === 4 }"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="activeIndex === 4"
                     x-transition
                     class="px-4 pb-4 text-sm text-gray-600">
                    Tidak ada batasan! Anda bisa mereferensikan sebanyak mungkin orang. Semakin banyak referral, semakin besar potensi komisi Anda.
                </div>
            </div>

            {{-- FAQ 5 --}}
            <div class="border border-gray-200 rounded-lg">
                <button @click="activeIndex = activeIndex === 5 ? null : 5"
                        class="w-full flex justify-between items-center p-4 text-left hover:bg-gray-50 transition">
                    <span class="font-semibold text-gray-800">Bagaimana cara melacak performa saya?</span>
                    <svg class="w-5 h-5 text-gray-500 transform transition-transform"
                         :class="{ 'rotate-180': activeIndex === 5 }"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="activeIndex === 5"
                     x-transition
                     class="px-4 pb-4 text-sm text-gray-600">
                    Dashboard affiliate menyediakan berbagai data seperti total klik, konversi, komisi, dan grafik performa. Anda bisa melihat semua ini di menu "Laporan".
                </div>
            </div>
        </div>
    </div>

    {{-- Contact Support --}}
    <div class="bg-gradient-to-r from-blue-500 to-indigo-600 rounded-lg shadow-md p-8 text-center text-white">
        <h2 class="text-2xl font-bold mb-2">Masih Ada Pertanyaan?</h2>
        <p class="mb-6 opacity-90">Tim support kami siap membantu Anda!</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="mailto:support@example.com" class="bg-white text-blue-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition inline-flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                </svg>
                Email Support
            </a>
            <a href="https://wa.me/6281234567890" target="_blank" class="bg-green-500 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-600 transition inline-flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="w-5 h-5 mr-2">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                </svg>
                WhatsApp
            </a>
        </div>
    </div>
@endsection
