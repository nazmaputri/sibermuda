@extends('layouts.dashboard-affiliate')
@section('title', 'Laporan Affiliate')
@section('content')
    {{-- Header Section --}}
    <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6 mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Laporan Performa Affiliate</h1>
        <p class="text-gray-600 mt-1">Pantau performa dan komisi affiliate Anda secara detail</p>
    </div>

    {{-- Statistik Utama --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        {{-- Total Komisi --}}
        <div class="bg-white rounded-lg shadow-md p-5 flex items-center border border-gray-200 border-l-4 border-l-green-500">
            <div class="p-2 bg-green-500 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="white" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </div>
            <div class="ml-4">
                <h2 class="text-sm font-medium text-gray-500">Total Komisi</h2>
                <p class="text-xl font-bold text-green-600">Rp {{ number_format($totalKomisi ?? 0, 0, ',', '.') }}</p>
            </div>
        </div>

        {{-- Komisi Bulan Ini --}}
        <div class="bg-white rounded-lg shadow-md p-5 flex items-center border border-gray-200 border-l-4 border-l-blue-500">
            <div class="p-2 bg-blue-500 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="white" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                </svg>
            </div>
            <div class="ml-4">
                <h2 class="text-sm font-medium text-gray-500">Komisi Bulan Ini</h2>
                <p class="text-xl font-bold text-blue-600">Rp {{ number_format($komisiBulanIni ?? 0, 0, ',', '.') }}</p>
            </div>
        </div>

        {{-- Total Klik --}}
        <div class="bg-white rounded-lg shadow-md p-5 flex items-center border border-gray-200 border-l-4 border-l-purple-500">
            <div class="p-2 bg-purple-500 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="white" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.042 21.672 13.684 16.6m0 0-2.51 2.225.569-9.47 5.227 7.917-3.286-.672ZM12 2.25V4.5m5.834.166-1.591 1.591M20.25 10.5H18M7.757 14.743l-1.59 1.59M6 10.5H3.75m4.007-4.243-1.59-1.59" />
                </svg>
            </div>
            <div class="ml-4">
                <h2 class="text-sm font-medium text-gray-500">Total Klik</h2>
                <p class="text-xl font-bold text-purple-600">{{ number_format($totalKlik ?? 0, 0, ',', '.') }}</p>
            </div>
        </div>

        {{-- Conversion Rate --}}
        <div class="bg-white rounded-lg shadow-md p-5 flex items-center border border-gray-200 border-l-4 border-l-yellow-500">
            <div class="p-2 bg-yellow-500 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="white" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
                </svg>
            </div>
            <div class="ml-4">
                <h2 class="text-sm font-medium text-gray-500">Conversion Rate</h2>
                <p class="text-xl font-bold text-yellow-600">{{ number_format($konversiRate ?? 0, 2) }}%</p>
            </div>
        </div>
    </div>

    {{-- Grafik Section --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        {{-- Grafik Komisi Bulanan --}}
        <div class="bg-white shadow-md border border-gray-200 rounded-lg p-6">
            <div class="flex flex-col items-center mb-4">
                <div class="flex items-center space-x-4 w-full justify-center">
                    <h2 class="text-lg font-semibold inline-block pb-1 text-gray-700">
                        Komisi Bulanan
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
            <div class="relative w-full h-64">
                <canvas id="komisiChart" class="absolute inset-0 w-full h-full"></canvas>
            </div>
        </div>

        {{-- Grafik Klik & Konversi --}}
        <div class="bg-white shadow-md border border-gray-200 rounded-lg p-6">
            <div class="flex flex-col items-center mb-4">
                <h2 class="text-lg font-semibold inline-block pb-1 text-gray-700">
                    Klik & Konversi Bulanan
                </h2>
                <div class="border-b-2 w-full mt-1"></div>
            </div>
            <div class="relative w-full h-64">
                <canvas id="klikKonversiChart" class="absolute inset-0 w-full h-full"></canvas>
            </div>
        </div>
    </div>

    {{-- Top Kursus --}}
    <div class="bg-white shadow-md border border-gray-200 rounded-lg p-6 mb-6">
        <div class="flex flex-col items-center mb-4">
            <h2 class="text-lg font-semibold inline-block pb-1 text-gray-700">Top 5 Kursus Terlaris</h2>
            <div class="border-b-2 w-full mt-1"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
            @foreach($kursusTop as $index => $kursus)
            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 border-2 border-blue-200 rounded-lg p-4 text-center">
                <div class="text-3xl font-bold text-blue-600 mb-2">#{{ $index + 1 }}</div>
                <h3 class="font-semibold text-gray-800 text-sm mb-2">{{ $kursus->nama }}</h3>
                <p class="text-xs text-gray-600 mb-1">Terjual: <span class="font-bold">{{ $kursus->total_terjual }}x</span></p>
                <p class="text-xs text-gray-600">Komisi: <span class="font-bold text-green-600">Rp {{ number_format($kursus->total_komisi, 0, ',', '.') }}</span></p>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Riwayat Transaksi --}}
    <div class="bg-white shadow-md border border-gray-200 rounded-lg p-6">
        <div class="flex flex-col items-center mb-4">
            <h2 class="text-lg font-semibold inline-block pb-1 text-gray-700">Riwayat Transaksi</h2>
            <div class="border-b-2 w-full mt-1"></div>
        </div>

        @if(isset($transaksiTerbaru) && count($transaksiTerbaru) > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Invoice</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pembeli</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kursus</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Komisi (%)</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($transaksiTerbaru as $transaksi)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $transaksi->invoice }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $transaksi->created_at->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                {{ $transaksi->pembeli_nama }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                {{ $transaksi->kursus_nama }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                Rp {{ number_format($transaksi->harga, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-green-600">
                                Rp {{ number_format($transaksi->komisi, 0, ',', '.') }} ({{ $transaksi->persentase }}%)
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($transaksi->status == 'paid')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Dibayar
                                    </span>
                                @elseif($transaksi->status == 'pending')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Pending
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Gagal
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <p class="mt-4 text-gray-500 font-medium">Belum ada transaksi</p>
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Grafik Komisi Bulanan
            const ctxKomisi = document.getElementById('komisiChart').getContext('2d');
            const komisiChart = new Chart(ctxKomisi, {
                type: 'line',
                data: {
                    labels: @json($monthNames),
                    datasets: [{
                        label: 'Komisi (Rp)',
                        data: @json($komisiPerBulan),
                        borderColor: 'rgba(34, 197, 94, 1)',
                        backgroundColor: 'rgba(34, 197, 94, 0.1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'Rp ' + value.toLocaleString('id-ID');
                                }
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return 'Komisi: Rp ' + context.parsed.y.toLocaleString('id-ID');
                                }
                            }
                        }
                    }
                }
            });

            // Grafik Klik & Konversi
            const ctxKlikKonversi = document.getElementById('klikKonversiChart').getContext('2d');
            const klikKonversiChart = new Chart(ctxKlikKonversi, {
                type: 'bar',
                data: {
                    labels: @json($monthNames),
                    datasets: [
                        {
                            label: 'Klik',
                            data: @json($klikPerBulan),
                            backgroundColor: 'rgba(59, 130, 246, 0.7)',
                            borderColor: 'rgba(59, 130, 246, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Konversi',
                            data: @json($konversiPerBulan),
                            backgroundColor: 'rgba(168, 85, 247, 0.7)',
                            borderColor: 'rgba(168, 85, 247, 1)',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
@endsection
