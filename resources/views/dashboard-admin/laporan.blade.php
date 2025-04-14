@extends('layouts.dashboard-admin')

@section('content')
<div class="container mx-auto">
<<<<<<< HEAD
    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <div class="flex flex-col items-center mb-4">
            <div class="flex items-center space-x-4">
                <h2 class="text-xl font-semibold inline-block pb-1 text-gray-700">
                    Laporan Pendapatan
                </h2>
                @php
                    $years = range(2023, 2025);
                    $currentYear = isset($year) ? $year : date('Y');
                @endphp
                <select id="yearFilter" class="p-1 border rounded-md focus:outline-none focus:ring focus:ring-sky-200">
                    @foreach ($years as $availableYear)
                        <option value="{{ $availableYear }}" {{ $availableYear == $currentYear ? 'selected' : '' }}>
                            {{ $availableYear }}
                        </option>
                    @endforeach
                </select>
=======
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow-md p-5 flex items-center">
            <div class="p-2 bg-red-500 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 640 512" stroke="currentColor" fill="white">
                    <path d="M160 64c0-35.3 28.7-64 64-64L576 0c35.3 0 64 28.7 64 64l0 288c0 35.3-28.7 64-64 64l-239.2 0c-11.8-25.5-29.9-47.5-52.4-64l99.6 0 0-32c0-17.7 14.3-32 32-32l64 0c17.7 0 32 14.3 32 32l0 32 64 0 0-288L224 64l0 49.1C205.2 102.2 183.3 96 160 96l0-32zm0 64a96 96 0 1 1 0 192 96 96 0 1 1 0-192zM133.3 352l53.3 0C260.3 352 320 411.7 320 485.3c0 14.7-11.9 26.7-26.7 26.7L26.7 512C11.9 512 0 500.1 0 485.3C0 411.7 59.7 352 133.3 352z"/>
                </svg>
            </div>
            <div class="ml-4">
                <h2 class="text-xl font-semibold text-red-700">Rp.100.000.000</h2>
                <p class="text-md font-semibold text-red-600">Pendapatan Keseluruhan</p>
>>>>>>> 9229acf410835896412f9dd9fb7287a290e7b1f1
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-5 flex items-center">
            <div class="p-2 bg-red-500 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 640 512" stroke="currentColor" fill="white">
                    <path d="M160 64c0-35.3 28.7-64 64-64L576 0c35.3 0 64 28.7 64 64l0 288c0 35.3-28.7 64-64 64l-239.2 0c-11.8-25.5-29.9-47.5-52.4-64l99.6 0 0-32c0-17.7 14.3-32 32-32l64 0c17.7 0 32 14.3 32 32l0 32 64 0 0-288L224 64l0 49.1C205.2 102.2 183.3 96 160 96l0-32zm0 64a96 96 0 1 1 0 192 96 96 0 1 1 0-192zM133.3 352l53.3 0C260.3 352 320 411.7 320 485.3c0 14.7-11.9 26.7-26.7 26.7L26.7 512C11.9 512 0 500.1 0 485.3C0 411.7 59.7 352 133.3 352z"/>
                </svg>
            </div>
            <div class="ml-4">
                <h2 class="text-xl font-semibold text-red-700">Rp.1.000.000</h2>
                <p class="text-md font-semibold text-red-600">Pendapatan Tahun ini</p>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-5 flex items-center">
            <div class="p-2 bg-red-500 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 640 512" stroke="currentColor" fill="white">
                    <path d="M160 64c0-35.3 28.7-64 64-64L576 0c35.3 0 64 28.7 64 64l0 288c0 35.3-28.7 64-64 64l-239.2 0c-11.8-25.5-29.9-47.5-52.4-64l99.6 0 0-32c0-17.7 14.3-32 32-32l64 0c17.7 0 32 14.3 32 32l0 32 64 0 0-288L224 64l0 49.1C205.2 102.2 183.3 96 160 96l0-32zm0 64a96 96 0 1 1 0 192 96 96 0 1 1 0-192zM133.3 352l53.3 0C260.3 352 320 411.7 320 485.3c0 14.7-11.9 26.7-26.7 26.7L26.7 512C11.9 512 0 500.1 0 485.3C0 411.7 59.7 352 133.3 352z"/>
                </svg>
            </div>
            <div class="ml-4">
                <h2 class="text-xl font-semibold text-red-700">Rp.1.000.000</h2>
                <p class="text-md font-semibold text-red-600">Pendapatan Bulan ini</p>
            </div>
        </div>
    </div>

    <!-- Pendapatan Per Kursus -->
    <div class="bg-white shadow-md rounded-lg p-6">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">Detail Pembelian Kursus</h3>
    
        <!-- Filter -->
        <form method="GET" class="mb-4">
            <label for="course_id" class="text-sm text-gray-600 mr-2">Filter Kursus:</label>
            <select name="course_id" id="course_id" onchange="this.form.submit()" class="border rounded px-2 py-1 text-sm">
                <option value="">Semua Kursus</option>
                @foreach ($coursesRevenue as $course)
                    <option value="{{ $course->id }}" {{ $selectedCourseId == $course->id ? 'selected' : '' }}>
                        {{ $course->title }}
                    </option>
                @endforeach
            </select>
        </form>
    
        <!-- Tabel -->
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm divide-y divide-gray-200">
                <thead class="bg-sky-100 text-gray-700">
                    <tr>
                        <th class="px-4 py-2 border-t text-center">No</th>
                        <th class="px-4 py-2 border-t text-left">Nama User</th>
                        <th class="px-4 py-2 border-t text-left">Judul Kursus</th>
                        <th class="px-4 py-2 border-t text-right">Harga</th>
                        <th class="px-4 py-2 border-t text-center">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($revenues as $index => $purchase)
                        <tr class="hover:bg-sky-50">
                            <td class="px-4 py-2 text-center">{{ $index + 1 }}</td>
                            <td class="px-4 py-2">{{ $purchase->user->name ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $purchase->course->title ?? '-' }}</td>
                            <td class="px-4 py-2 text-right text-green-600">
                                Rp. {{ number_format($purchase->price, 0, ',', '.') }}
                            </td>
                            <td class="px-4 py-2 text-center">{{ $purchase->created_at->format('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-4 text-center text-gray-500">Tidak ada data pembelian</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    
        <!-- Total -->
        <div class="mt-4 text-right text-lg text-gray-700 font-semibold">
            Total Pendapatan: <span class="text-red-500">Rp. {{ number_format($totalRevenue, 0, ',', '.') }}</span>
        </div>
    </div>
    
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('revenueChart').getContext('2d');

    const coursesRevenue = @json($coursesRevenue);
    const monthLabels = @json($monthNames);

    // Buat array 12 bulan dan jumlahkan semua pendapatan kursus untuk tiap bulan
    const totalPerMonth = Array(12).fill(0);
    for (const courseId in coursesRevenue) {
        if (coursesRevenue.hasOwnProperty(courseId)) {
            const monthly = coursesRevenue[courseId].monthly;
            for (let i = 1; i <= 12; i++) {
                totalPerMonth[i - 1] += monthly[i] || 0;
            }
        }
    }

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: monthLabels,
            datasets: [{
                label: 'Total Pendapatan Bulanan',
                data: totalPerMonth,
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
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
                        text: 'Pendapatan (Rp)'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Bulan'
                    }
                }
            },
            plugins: {
                legend: {
                    display: true
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Rp ' + context.raw.toLocaleString('id-ID');
                        }
                    }
                }
            }
        }
    });

    document.getElementById('yearFilter').addEventListener('change', function () {
        const selectedYear = this.value;
        window.location.href = `?year=${selectedYear}`;
    });
});
</script>
@endsection
