@extends('layouts.dashboard-affiliate')
@section('title', 'Dashboard')
@section('content')
    {{-- Welcome Section --}}
    <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6 mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Selamat Datang, {{ Auth::user()->name ?? 'Affiliate' }}!</h1>
                <p class="text-gray-600 mt-1">Kelola program afiliasi Anda dan pantau performa dari sini</p>
            </div>
            <div class="hidden md:block">
                <div class="text-right">
                    <p class="text-sm text-gray-500">Hari dan Tanggal</p>
                    <p id="realtime-clock" class="text-lg font-medium text-gray-700">{{ now()->locale('id')->isoFormat('dddd, D MMMM YYYY HH:mm:ss') }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Quick Stats --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        {{-- Total Komisi --}}
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-md p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm">Total Komisi</p>
                    <h2 class="text-3xl font-bold mt-2">Rp {{ number_format($totalKomisi ?? 0, 0, ',', '.') }}</h2>
                </div>
                <div class="bg-white bg-opacity-20 p-3 rounded-full">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Total Referral --}}
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-md p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm">Total Referral Berhasil</p>
                    <h2 class="text-3xl font-bold mt-2">{{ number_format($totalReferral ?? 0, 0, ',', '.') }}</h2>
                </div>
                <div class="bg-white bg-opacity-20 p-3 rounded-full">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Komisi Bulan Ini --}}
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow-md p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm">Komisi Bulan Ini</p>
                    <h2 class="text-3xl font-bold mt-2">Rp {{ number_format($komisiBulanIni ?? 0, 0, ',', '.') }}</h2>
                </div>
                <div class="bg-white bg-opacity-20 p-3 rounded-full">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Link Affiliate Card --}}
    <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6 mb-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
            </svg>
            Link Affiliate Anda
        </h2>

        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border-2 border-blue-200 rounded-lg p-5">
            <div class="grid md:grid-cols-2 gap-4">
                {{-- Kode Referral --}}
                <div>
                    <label class="text-sm font-medium text-gray-700 mb-2 block">Kode Referral:</label>
                    <div class="flex items-center bg-white border-2 border-gray-300 rounded-lg px-4 py-3">
                        <code id="affiliate-code" class="flex-1 text-lg font-mono font-bold text-gray-800">
                            {{ $affiliateCode ?? 'AFFILIATE123' }}
                        </code>
                        <button onclick="copyCode()" class="ml-3 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition flex items-center text-sm">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                            </svg>
                            Salin
                        </button>
                    </div>
                </div>

                {{-- Link Lengkap --}}
                <div>
                    <label class="text-sm font-medium text-gray-700 mb-2 block">Link Lengkap:</label>
                    <div class="flex items-center bg-white border-2 border-gray-300 rounded-lg px-4 py-3">
                        <code id="affiliate-link" class="flex-1 text-sm font-mono text-gray-700 truncate">
                            {{ $affiliateLink ?? url('/register?ref=AFFILIATE123') }}
                        </code>
                        <button onclick="copyLink()" class="ml-3 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition flex items-center text-sm">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                            </svg>
                            Salin
                        </button>
                    </div>
                </div>
            </div>
            <p class="text-sm text-gray-600 mt-4 flex items-start">
                <svg class="w-4 h-4 mr-2 mt-0.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Bagikan link atau kode referral Anda kepada teman dan dapatkan komisi dari setiap pembelian kursus yang mereka lakukan!
            </p>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <a href="{{ route('affiliate.laporan') }}" class="bg-white rounded-lg shadow-md border-2 border-gray-200 hover:border-blue-500 p-6 transition group">
            <div class="flex items-center">
                <div class="bg-blue-100 group-hover:bg-blue-200 p-3 rounded-lg transition">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="font-semibold text-gray-800 group-hover:text-blue-600 transition">Lihat Laporan</h3>
                    <p class="text-sm text-gray-500">Detail performa & komisi</p>
                </div>
            </div>
        </a>

        <a href="{{ route('affiliate.penarikan') }}" class="bg-white rounded-lg shadow-md border-2 border-gray-200 hover:border-green-500 p-6 transition group">
            <div class="flex items-center">
                <div class="bg-green-100 group-hover:bg-green-200 p-3 rounded-lg transition">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="font-semibold text-gray-800 group-hover:text-green-600 transition">Penarikan Dana</h3>
                    <p class="text-sm text-gray-500">Tarik komisi Anda</p>
                </div>
            </div>
        </a>

        <a href="{{ route('affiliate.panduan') }}" class="bg-white rounded-lg shadow-md border-2 border-gray-200 hover:border-purple-500 p-6 transition group">
            <div class="flex items-center">
                <div class="bg-purple-100 group-hover:bg-purple-200 p-3 rounded-lg transition">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="font-semibold text-gray-800 group-hover:text-purple-600 transition">Panduan Affiliate</h3>
                    <p class="text-sm text-gray-500">Tips & cara kerja</p>
                </div>
            </div>
        </a>
    </div>

    {{-- Aktivitas Terbaru --}}
    <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-3">Aktivitas Terbaru</h2>

        @if(isset($aktivitasTerbaru) && count($aktivitasTerbaru) > 0)
            <div class="space-y-4">
                @foreach($aktivitasTerbaru as $aktivitas)
                <div class="flex items-start p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4 flex-1">
                        <p class="text-sm font-medium text-gray-900">{{ $aktivitas->deskripsi }}</p>
                        <p class="text-xs text-gray-500 mt-1">{{ $aktivitas->created_at->diffForHumans() }}</p>
                    </div>
                    <span class="text-sm font-semibold text-green-600">
                        +Rp {{ number_format($aktivitas->komisi ?? 0, 0, ',', '.') }}
                    </span>
                </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                </svg>
                <p class="mt-4 text-gray-500">Belum ada aktivitas</p>
                <p class="text-sm text-gray-400 mt-1">Mulai bagikan link affiliate Anda untuk mendapatkan komisi!</p>
            </div>
        @endif
    </div>

    <script>
        // Realtime Clock
        document.addEventListener('DOMContentLoaded', function () {
            function updateClock() {
                const now = new Date();
                const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

                const day = days[now.getDay()];
                const date = now.getDate().toString().padStart(2, '0');
                const month = months[now.getMonth()];
                const year = now.getFullYear();
                const hours = now.getHours().toString().padStart(2, '0');
                const minutes = now.getMinutes().toString().padStart(2, '0');
                const seconds = now.getSeconds().toString().padStart(2, '0');

                const formattedTime = `${day}, ${date} ${month} ${year} ${hours}:${minutes}:${seconds}`;
                document.getElementById('realtime-clock').textContent = formattedTime;
            }

            updateClock();
            setInterval(updateClock, 1000);
        });

        // Copy Functions
        function copyCode() {
            const code = document.getElementById('affiliate-code').textContent.trim();
            navigator.clipboard.writeText(code).then(() => {
                showNotification('Kode referral berhasil disalin!');
            });
        }

        function copyLink() {
            const link = document.getElementById('affiliate-link').textContent.trim();
            navigator.clipboard.writeText(link).then(() => {
                showNotification('Link affiliate berhasil disalin!');
            });
        }

        function showNotification(message) {
            // Simple notification (you can replace with better toast library)
            const notification = document.createElement('div');
            notification.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
            notification.textContent = message;
            document.body.appendChild(notification);

            setTimeout(() => {
                notification.remove();
            }, 3000);
        }
    </script>
@endsection
