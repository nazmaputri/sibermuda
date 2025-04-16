@extends('layouts.dashboard-admin')
@section('content')

    <!-- Card Informasi -->
    <div class="bg-white rounded-lg border border-gray-200 shadow-md p-5 w-full flex flex-col md:flex-row h-auto items-center">
        <!-- Text Content -->
        <div class="w-full text-center md:text-left mb-4 md:mb-0">
            <h1 class="text-xl font-semibold mb-4 text-gray-700">Selamat datang, {{ Auth::user()->name }}!</h1>
            <p class="mb-6 text-gray-600">
                Semoga hari ini membawa kemudahan dan kelancaran dalam tugas-tugas Anda.
                <br>Mari kita capai hal-hal hebat bersama.
            </p>
        </div>
        <!-- Image Content -->
        <div class="md:w-1/4 flex justify-center md:justify-end">
            <img src="{{ asset('storage/admin.png') }}" alt="Welcome Image" class="w-full h-auto md:w-54"/>
        </div>
    </div>

    <!-- Cards Statistik -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 pt-6">
        <!-- Card Jumlah Mentor -->
        <div class="bg-white rounded-lg shadow-md p-5 flex items-center border border-gray-200 border-l-4 border-l-red-500">
            <div class="p-2 bg-red-500 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 640 512" stroke="currentColor" fill="white">
                    <path d="M160 64c0-35.3 28.7-64 64-64L576 0c35.3 0 64 28.7 64 64l0 288c0 35.3-28.7 64-64 64l-239.2 0c-11.8-25.5-29.9-47.5-52.4-64l99.6 0 0-32c0-17.7 14.3-32 32-32l64 0c17.7 0 32 14.3 32 32l0 32 64 0 0-288L224 64l0 49.1C205.2 102.2 183.3 96 160 96l0-32zm0 64a96 96 0 1 1 0 192 96 96 0 1 1 0-192zM133.3 352l53.3 0C260.3 352 320 411.7 320 485.3c0 14.7-11.9 26.7-26.7 26.7L26.7 512C11.9 512 0 500.1 0 485.3C0 411.7 59.7 352 133.3 352z"/>
                </svg>
            </div>
            <div class="ml-4">
                <h2 class="text-md font-semibold text-gray-700">Jumlah Mentor</h2>
                <p class="text-xl font-semibold text-gray-700">{{ $jumlahMentor }} Mentor</p>
            </div>
        </div>
        <!-- Card Jumlah Peserta -->
        <div class="bg-white rounded-lg shadow-md p-5 flex items-center border border-gray-200 border-l-4 border-l-yellow-500">
            <div class="p-2 bg-yellow-500 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 640 512" stroke="currentColor" fill="white">
                    <path d="M96 0C43 0 0 43 0 96L0 416c0 53 43 96 96 96l448 0c53 0 96-43 96-96l0-320c0-53-43-96-96-96L96 0zM64 96c0-17.7 14.3-32 32-32l448 0c17.7 0 32 14.3 32 32l0 320c0 17.7-14.3 32-32 32L96 448c-17.7 0-32-14.3-32-32L64 96zm159.8 80a48 48 0 1 0 -96 0 48 48 0 1 0 96 0zM96 309.3c0 14.7 11.9 26.7 26.7 26.7l56.1 0c8-34.1 32.8-61.7 65.2-73.6c-7.5-4.1-16.2-6.4-25.3-6.4l-69.3 0C119.9 256 96 279.9 96 309.3zM461.2 336l56.1 0c14.7 0 26.7-11.9 26.7-26.7c0-29.5-23.9-53.3-53.3-53.3l-69.3 0c-9.2 0-17.8 2.3-25.3 6.4c32.4 11.9 57.2 39.5 65.2 73.6zM372 289c-3.9-.7-7.9-1-12-1l-80 0c-4.1 0-8.1 .3-12 1c-26 4.4-47.3 22.7-55.9 47c-2.7 7.5-4.1 15.6-4.1 24c0 13.3 10.7 24 24 24l176 0c13.3 0 24-10.7 24-24c0-8.4-1.4-16.5-4.1-24c-8.6-24.3-29.9-42.6-55.9-47zM512 176a48 48 0 1 0 -96 0 48 48 0 1 0 96 0zM320 256a64 64 0 1 0 0-128 64 64 0 1 0 0 128z"/>
                </svg>
            </div>
            <div class="ml-4">
                <h2 class="text-md font-semibold text-gray-700">Jumlah Peserta</h2>
                <p class="text-xl font-semibold text-gray-700">{{ $jumlahPeserta }} Peserta</p>
            </div>
        </div>
         <!-- Card Jumlah Kursus -->
         <div class="bg-white rounded-lg shadow-md p-5 flex items-center border border-gray-200 border-l-4 border-l-blue-500">
            <div class="p-2 bg-blue-500 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="white" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                </svg>
            </div>
            <div class="ml-4">
                <h2 class="text-md font-semibold text-gray-700">Jumlah Kursus</h2>
                <p class="text-xl font-semibold text-gray-700">{{ $jumlahKursus }} Kursus</p>
            </div>
        </div>
        <!-- Card Jumlah Peserta -->
        <div class="bg-white rounded-lg shadow-md p-5 flex items-center border border-gray-200 border-l-4 border-l-green-500">
            <div class="p-2 bg-green-500 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="white" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0ZM3.75 12h.007v.008H3.75V12Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm-.375 5.25h.007v.008H3.75v-.008Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                </svg>
            </div>
            <div class="ml-4">
                <h2 class="text-md font-semibold text-gray-700">Jumlah Kategori</h2>
                <p class="text-xl font-semibold text-gray-700">{{ $jumlahKategori }} Kategori</p>
            </div>
        </div>
    </div>

    <!-- Grafik Perkembangan Pengguna Bulanan -->
    <div class="bg-white shadow-md border border-gray-200 rounded-lg p-6 mb-6 mt-10">
        <div class="flex flex-col items-center mb-4">
            <div class="flex items-center space-x-4">
                <h2 class="text-xl font-semibold inline-block pb-1 text-gray-700">
                    Laporan Perkembangan Pengguna Bulanan
                </h2>
                <select id="yearFilter" class="p-1 border rounded-md focus:outline-none focus:ring focus:ring-sky-200">
                    @foreach ($years as $availableYear)
                        <option value="{{ $availableYear }}" {{ $availableYear == $year ? 'selected' : '' }}>
                            {{ $availableYear }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="border-b-2 w-full mt-1"></div>
        </div>
        <div style="position: relative; height: 300px; width: 100%;">
            <canvas id="userGrowthChart"></canvas>
        </div>
    </div>

<script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('userGrowthChart').getContext('2d');
        
            // Buat grafik menggunakan Chart.js dengan data dari controller
            const userGrowthChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($monthNames),
                    datasets: [{
                        label: 'Pengguna Baru',
                        data: @json($userGrowthData),
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderWidth: 2,
                        fill: true,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Jumlah Pengguna'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Bulan'
                            }
                        }
                    }
                }
            });
        
            // Update grafik saat tahun dipilih
            document.getElementById('yearFilter').addEventListener('change', function () {
                const selectedYear = this.value;
                window.location.href = `?year=${selectedYear}`;
            });
        });
</script>    
@endsection
