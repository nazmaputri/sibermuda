@extends('layouts.dashboard-admin')

@section('content')
<div class="container mx-auto">
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
        <h3 class="text-lg font-semibold text-gray-700 mb-2">Detail Pendapatan per Kursus</h3>
        <div class="overflow-x-auto">
           <div class="min-w-full w-64">
           @if (count($coursesRevenue) > 0)
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-sky-100 text-gray-700">
                        <tr>
                            <th class="px-4 py-2 border-l border-t text-center">No</th>
                            <th class="px-4 py-2 text-left border-t">Judul Kursus</th>
                            <th class="px-4 py-2 text-right border-t">Total Pendapatan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                    @foreach ($paginatedCourses as $course)
                        <tr class="hover:bg-sky-50">
                            <td class="px-4 py-2 text-gray-700 text-sm border-l border-b text-center">
                                {{ $loop->iteration }}
                            </td>
                            <td class="px-4 py-2 text-gray-700 border-b">{{ $course['title'] }}</td>
                            <td class="px-4 py-2 text-right text-red-500 border-r border-b">
                                Rp. {{ number_format(array_sum($course['monthly']), 0, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-gray-500 text-sm">Belum ada pendapatan</p>
            @endif
           </div>
        </div>
        <div class="mt-4">
            {{ $paginatedCourses->links() }}
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
