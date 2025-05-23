@extends('layouts.dashboard-admin')
@section('content')
    <!-- Cards Informasi -->
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
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="white" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                </svg>
            </div>
            <div class="ml-4">
                <h2 class="text-md font-semibold text-gray-700">Jumlah Mentor</h2>
                <p class="text-md font-semibold text-red-500">{{ $jumlahMentor }} Mentor</p>
            </div>
        </div>
        <!-- Card Jumlah Peserta -->
        <div class="bg-white rounded-lg shadow-md p-5 flex items-center border border-gray-200 border-l-4 border-l-yellow-500">
            <div class="p-2 bg-yellow-500 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="white" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                </svg>
            </div>
            <div class="ml-4">
                <h2 class="text-md font-semibold text-gray-700">Jumlah Peserta</h2>
                <p class="text-md font-semibold text-yellow-500">{{ $jumlahPeserta }} Peserta</p>
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
                <p class="text-md font-semibold text-blue-500">{{ $jumlahKursus }} Kursus</p>
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
                <p class="text-md font-semibold text-green-500">{{ $jumlahKategori }} Kategori</p>
            </div>
        </div>
    </div>

    <!-- Grafik Perkembangan Pengguna Bulanan -->
    <div class="bg-white shadow-md border border-gray-200  rounded-lg p-6 mb-6 mt-10">
        <div class="flex flex-col items-center mb-4">
            <div class="flex items-center space-x-4">
                <h2 class="md:text-xl text-md font-semibold inline-block pb-1 text-gray-700">
                    Perkembangan Pengguna Bulanan
                </h2>
                <div x-data="{ open: false, selected: '{{ $year }}' }" class="relative w-20">
                    <button @click="open = !open" class="w-full px-2 py-1 leading-tight border rounded-md bg-white flex justify-between items-center focus:outline-none focus:ring-1 focus:ring-sky-200">
                        <span x-text="selected" class="text-gray-700 text-sm"></span>
                        <svg class="w-4 h-4 ml-2 transform transition-transform duration-300 ease-in-out" :class="{ 'rotate-180': open }" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div x-show="open" @click.away="open = false" class="absolute mt-1 w-full bg-white border rounded-md shadow-lg z-10 max-h-24 overflow-y-auto">
                        @foreach ($years as $availableYear)
                            <a 
                                href="?year={{ $availableYear }}"
                                @click="selected = '{{ $availableYear }}'; open = false"
                                class="block px-4 py-2 text-sm text-gray-700 text-center hover:bg-sky-100 {{ $availableYear == $year ? 'bg-sky-50 font-semibold' : '' }}"
                            >
                                {{ $availableYear }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="border-b-2 w-full mt-1"></div>
        </div>
        <!-- Wrapper responsif: selalu punya height! -->
        <div class="relative w-full h-64 sm:h-80 md:h-80 lg:h-80">
          <canvas id="userGrowthChart" class="absolute inset-0 w-full h-full"></canvas>
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