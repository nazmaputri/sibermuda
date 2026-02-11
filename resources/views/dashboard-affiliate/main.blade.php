@extends('layouts.dashboard-affiliate')
@section('title', 'Dashboard')
@section('content')
    {{-- Welcome Section --}}
    <div class="bg-white rounded-lg border border-gray-200 shadow-md p-5 w-full flex flex-col md:flex-row h-auto items-center mb-6">
        <!-- Text Content -->
        <div class="w-full text-center md:text-left mb-4 md:mb-0">
            <h1 class="text-xl font-semibold mb-4 text-gray-700">Selamat datang, {{ Auth::user()->name }}!</h1>
            <p class="mb-6 text-gray-600">
                Kelola program afiliasi Anda dan pantau performa dari sini.
                <br>Mari raih komisi lebih banyak dengan berbagi link referral Anda!
            </p>
        </div>
        <!-- Clock Content -->
        <div class="md:w-1/4 flex justify-center md:justify-end">
            <div class="text-center md:text-right">
                <p class="text-sm font-medium text-gray-500">Hari dan Tanggal</p>
                <p id="realtime-clock" class="text-md font-medium text-gray-700">{{ now()->locale('id')->isoFormat('dddd, D MMMM YYYY HH:mm:ss') }}</p>
            </div>
        </div>
    </div>

    {{-- Cards Statistik --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        {{-- Card Total Komisi --}}
        <div class="bg-white rounded-lg shadow-md p-5 flex items-center border border-gray-200 border-l-4 border-l-green-500">
            <div class="p-2 bg-green-500 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="white" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </div>
            <div class="ml-4">
                <h2 class="text-md font-semibold text-gray-700">Total Komisi</h2>
                <p class="text-md font-semibold text-green-500">Rp {{ number_format($totalKomisi ?? 0, 0, ',', '.') }}</p>
            </div>
        </div>

        {{-- Card Total Referral --}}
        <div class="bg-white rounded-lg shadow-md p-5 flex items-center border border-gray-200 border-l-4 border-l-blue-500">
            <div class="p-2 bg-blue-500 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="white" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                </svg>
            </div>
            <div class="ml-4">
                <h2 class="text-md font-semibold text-gray-700">Total Referral</h2>
                <p class="text-md font-semibold text-blue-500">{{ number_format($totalReferral ?? 0, 0, ',', '.') }} Orang</p>
            </div>
        </div>

        {{-- Card Komisi Bulan Ini --}}
        <div class="bg-white rounded-lg shadow-md p-5 flex items-center border border-gray-200 border-l-4 border-l-purple-500">
            <div class="p-2 bg-purple-500 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="white" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                </svg>
            </div>
            <div class="ml-4">
                <h2 class="text-md font-semibold text-gray-700">Komisi Bulan Ini</h2>
                <p class="text-md font-semibold text-purple-500">Rp {{ number_format($komisiBulanIni ?? 0, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>

    {{-- Link Affiliate Card --}}
    <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6 mb-6">
        <div class="flex flex-col items-center mb-4">
            <h2 class="text-xl font-semibold inline-block pb-1 text-gray-700 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                </svg>
                Link Affiliate Anda
            </h2>
            <div class="border-b-2 w-full mt-1"></div>
        </div>

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
                <svg class="w-4 h-4 mr-2 mt-0.5 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Bagikan link atau kode referral Anda kepada teman dan dapatkan komisi dari setiap pembelian kursus yang mereka lakukan!
            </p>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        {{-- Lihat Laporan --}}
        {{-- <a href="{{ route('affiliate.laporan') }}" class="bg-white rounded-lg shadow-md border border-gray-200 hover:shadow-lg p-5 transition group"> --}}
        <a href="#" class="bg-white rounded-lg shadow-md border border-gray-200 hover:shadow-lg p-5 transition group">
            <div class="flex items-center">
                <div class="p-2 bg-blue-100 group-hover:bg-blue-200 rounded-full transition">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-blue-600">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-md font-semibold text-gray-700 group-hover:text-blue-600 transition">Lihat Laporan</h3>
                    <p class="text-sm text-gray-500">Detail performa & komisi</p>
                </div>
            </div>
        </a>

        {{-- Penarikan Dana --}}
        {{-- <a href="{{ route('affiliate.penarikan') }}" class="bg-white rounded-lg shadow-md border border-gray-200 hover:shadow-lg p-5 transition group"> --}}
        <a href="#" class="bg-white rounded-lg shadow-md border border-gray-200 hover:shadow-lg p-5 transition group">
            <div class="flex items-center">
                <div class="p-2 bg-green-100 group-hover:bg-green-200 rounded-full transition">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-green-600">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-md font-semibold text-gray-700 group-hover:text-green-600 transition">Penarikan Dana</h3>
                    <p class="text-sm text-gray-500">Tarik komisi Anda</p>
                </div>
            </div>
        </a>

        {{-- Panduan Affiliate --}}
        {{-- <a href="{{ route('affiliate.panduan') }}" class="bg-white rounded-lg shadow-md border border-gray-200 hover:shadow-lg p-5 transition group"> --}}
        <a href="#" class="bg-white rounded-lg shadow-md border border-gray-200 hover:shadow-lg p-5 transition group">
            <div class="flex items-center">
                <div class="p-2 bg-purple-100 group-hover:bg-purple-200 rounded-full transition">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-purple-600">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-md font-semibold text-gray-700 group-hover:text-purple-600 transition">Panduan Affiliate</h3>
                    <p class="text-sm text-gray-500">Tips & cara kerja</p>
                </div>
            </div>
        </a>
    </div>

    {{-- Aktivitas Terbaru --}}
    <div class="bg-white shadow-md border border-gray-200 rounded-lg p-6">
        <div class="flex flex-col items-center mb-4">
            <h2 class="text-xl font-semibold inline-block pb-1 text-gray-700">Aktivitas Terbaru</h2>
            <div class="border-b-2 w-full mt-1"></div>
        </div>

        @if(isset($aktivitasTerbaru) && count($aktivitasTerbaru) > 0)
            <div class="space-y-3">
                @foreach($aktivitasTerbaru as $aktivitas)
                <div class="flex items-start p-4 bg-gray-50 border border-gray-200 rounded-lg hover:bg-gray-100 transition">
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
                <p class="mt-4 text-gray-500 font-medium">Belum ada aktivitas</p>
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
