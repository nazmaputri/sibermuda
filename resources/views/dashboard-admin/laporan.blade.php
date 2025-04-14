@extends('layouts.dashboard-admin')

@section('content')
<div class="container mx-auto">
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
            </div>
            <div class="border-b-2 w-full mt-1"></div>
        </div>

        <!-- Grafik -->
        <div style="position: relative; height: 300px; width: 100%;">
            <canvas id="revenueChart"></canvas>
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
