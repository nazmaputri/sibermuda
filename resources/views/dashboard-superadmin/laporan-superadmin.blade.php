@extends('layouts.dashboard-superadmin')
@section('title', 'Laporan')
@section('content')
<div class="container mx-auto">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow-md px-5 py-2 flex items-center border border-gray-200">
            <div class="mt-2">
                <h2 class="text-md font-semibold text-gray-600">
                    Rp. {{ number_format($totalAllRevenue, 0, ',', '.') }}
                </h2>
                <p class="text-md text-gray-600">
                    Pendapatan Keseluruhan
                </p>
            </div>
            <div class="flex items-end gap-1 h-24 w-fit cursor-pointer ml-auto">
                <!-- Batang 1 -->
                <div class="w-3 h-6 bg-gradient-to-t from-[#08072a] to-[#1c1b3a] hover:h-10 transition-all duration-300 rounded-t"></div>
                
                <!-- Batang 2 -->
                <div class="w-3 h-10 bg-gradient-to-t from-[#08072a] to-[#2d2b5a] hover:h-14 transition-all duration-300 rounded-t"></div>
                
                <!-- Batang 3 -->
                <div class="w-3 h-16 bg-gradient-to-t from-[#08072a] to-[#3e3b7a] hover:h-20 transition-all duration-300 rounded-t"></div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-md px-5 py-2 flex items-center border border-gray-200">
            <div class="mt-2">
                <h2 class="text-md font-semibold text-gray-600">
                    Rp. {{ number_format($totalRevenue, 0, ',', '.') }}
                </h2>
                <p class="text-md text-gray-600">
                    Pendapatan Bulan Ini
                </p>
            </div>
            <div class="flex items-end gap-1 h-24 w-fit cursor-pointer ml-auto">
                <!-- Batang 1 -->
                <div class="w-3 h-6 bg-gradient-to-t from-[#08072a] to-[#1c1b3a] hover:h-10 transition-all duration-300 rounded-t"></div>
                
                <!-- Batang 2 -->
                <div class="w-3 h-10 bg-gradient-to-t from-[#08072a] to-[#2d2b5a] hover:h-14 transition-all duration-300 rounded-t"></div>
                
                <!-- Batang 3 -->
                <div class="w-3 h-16 bg-gradient-to-t from-[#08072a] to-[#3e3b7a] hover:h-20 transition-all duration-300 rounded-t"></div>
            </div>
        </div>          
    </div>

    <!-- Canvas Grafik Pendapatan -->
    <div class="bg-white p-6 shadow-md my-6 border border-gray-200 rounded-lg">
        <div class="flex flex-row items-center justify-center gap-4 mb-6">
            <h2 class="text-md text-gray-700 font-semibold">
                Statistik Pendapatan
            </h2>
            <form method="GET" action="{{ route('laporan-superadmin') }}">
                <div x-data="{ open: false, selected: '{{ $selectedYear }}' }" class="relative w-20">
                    <!-- Tombol tampilan dropdown -->
                    <button type="button" @click="open = !open"
                        class="w-full px-2 py-1 leading-tight border rounded-md bg-white flex justify-between items-center focus:outline-none focus:ring-1 focus:ring-sky-200">
                        <span x-text="selected" class="text-gray-700 text-sm"></span>
                        <svg class="w-4 h-4 ml-2 transform transition-transform duration-300 ease-in-out"
                            :class="{ 'rotate-180': open }" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <!-- Opsi tahun -->
                    <div x-show="open" @click.away="open = false"
                        class="absolute mt-1 w-full bg-white border rounded-md shadow-lg z-10 max-h-24 overflow-y-auto">
                        @for ($year = now()->year; $year >= 2025; $year--)
                            <button type="submit"
                                name="year"
                                value="{{ $year }}"
                                @click="selected = '{{ $year }}'; open = false"
                                class="block w-full px-4 py-2 text-sm text-gray-700 text-center hover:bg-sky-100 {{ $selectedYear == $year ? 'bg-sky-50 font-semibold' : '' }}">
                                {{ $year }}
                            </button>
                        @endfor
                    </div>
                </div>
            </form>
        </div>
        <div class="w-full overflow-x-auto h-[300px]">
            <canvas id="monthlyRevenueChart" class="max-w-full h-full"></canvas>
        </div>
    </div>

    <!-- Pendapatan Per Kursus -->
    <div class="bg-white shadow-md rounded-lg p-6 border border-gray-200">
        <h3 class="text-md font-semibold text-gray-700 mb-2">Detail Pembelian Kursus</h3>
    
        <!-- Form Filter dan Export Menjadi Satu -->
        <form method="GET" class="mb-4 flex flex-wrap items-end gap-4">

        <!-- Filter Kursus -->
        <div x-data="{ open: false, selected: '{{ request('course_id') ? $coursesRevenue->firstWhere('id', request('course_id'))->title : 'Semua Kursus' }}', selectedId: '{{ request('course_id') ?? '' }}' }" class="relative w-64">
            <label for="course_id" class="text-sm text-gray-600 mr-2">Filter Kursus:</label>
            <div @click="open = !open" class="border rounded px-4 py-2 text-sm bg-white cursor-pointer text-gray-700 flex justify-between items-center h-[38px]">
                <span class="truncate max-w-[200px] overflow-hidden whitespace-nowrap" x-text="selected"></span>
                <svg class="w-4 h-4 ml-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </div>
            <div x-show="open" @click.away="open = false"
                class="absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded shadow max-h-48 overflow-y-auto text-sm scrollbar-hide text-gray-700"
                style="display: none;">
                <div @click="selected = 'Semua Kursus'; selectedId = ''; open = false"
                    class="cursor-pointer px-4 py-2 hover:bg-gray-100"
                    :class="{ 'bg-gray-100': selectedId === '' }">
                    Semua Kursus
                </div>
                @foreach ($coursesRevenue as $course)
                    <div @click="selected = '{{ $course->title }}'; selectedId = '{{ $course->id }}'; open = false"
                        class="cursor-pointer px-4 py-2 hover:bg-gray-100"
                        :class="{ 'bg-gray-100': selectedId == '{{ $course->id }}' }">
                        {{ $course->title }}
                    </div>
                @endforeach
            </div>
            <input type="hidden" name="course_id" :value="selectedId">
        </div>

        <!-- Filter Bulan -->
        <div x-data="{ 
                open: false, 
                selected: '{{ request('month') ? \Carbon\Carbon::create()->month((int) request('month'))->translatedFormat('F') : 'Semua Bulan' }}', 
                selectedMonth: '{{ request('month') ?? '' }}' 
            }" class="relative w-64">
            <label for="month" class="text-sm text-gray-600 mr-2">Filter Bulan:</label>
            <div @click="open = !open" class="border rounded px-4 py-2 text-sm bg-white cursor-pointer text-gray-700 flex justify-between items-center">
                <span x-text="selected"></span>
                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </div>
            <div x-show="open" @click.away="open = false"
                class="absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded shadow max-h-48 overflow-y-auto text-sm scrollbar-hide text-gray-700"
                style="display: none;">
                <div @click="selected = 'Semua Bulan'; selectedMonth = ''; open = false"
                    class="cursor-pointer px-4 py-2 hover:bg-gray-100"
                    :class="{ 'bg-gray-100': selectedMonth === '' }">
                    Semua Bulan
                </div>
                @for ($m = 1; $m <= 12; $m++)
                    @php $monthName = \Carbon\Carbon::create()->month($m)->translatedFormat('F');@endphp
                    <div @click="selected = '{{ $monthName }}'; selectedMonth = '{{ $m }}'; open = false"
                        class="cursor-pointer px-4 py-2 hover:bg-gray-100"
                        :class="{ 'bg-gray-100': selectedMonth == '{{ $m }}' }">
                        {{ $monthName }}
                    </div>
                @endfor
            </div>
            <input type="hidden" name="month" :value="selectedMonth">
        </div>

        <!-- Tombol Filter -->
        <button type="submit" class="bg-blue-400 hover:bg-blue-300 text-white px-4 py-2 rounded text-sm">
            Filter
        </button>

        <!-- Tombol Export -->
        <button type="submit" formaction="{{ route('purchases.export') }}" class="bg-green-400 hover:bg-green-300 text-white px-4 py-2 rounded text-sm">
            Ekspor ke Excel
        </button>
        </form>

        <!-- Total -->
        <div class="my-3 text-right text-md text-gray-700 font-semibold">
            @if($selectedCourseId || $selectedMonth)
                Total Pendapatan :
                <span class="text-red-500">Rp. {{ number_format($totalFilteredRevenue, 0, ',', '.') }}</span>
            @else
                Total Pendapatan :
                <span class="text-red-500">Rp. {{ number_format($totalAllRevenue, 0, ',', '.') }}</span>
            @endif
        </div>

        <div class="overflow-x-auto">
            <div class="min-w-full w-64">
            <table class="min-w-full text-sm border-separate border-spacing-0">
                <thead class="bg-sky-100 text-gray-700">
                    <tr class="bg-gray-100 text-sm text-600">
                        <th class="px-4 py-2 border-t border-b border-l border-gray-200 text-center rounded-tl-lg">No</th>
                        <th class="px-4 py-2 border-t border-b border-gray-200 text-center">Nama Peserta</th>
                        <th class="px-4 py-2 border-t border-b border-gray-200 text-center">Judul Kursus</th>
                        <th class="px-4 py-2 border-t border-b border-gray-200 text-center">Harga</th>
                        <th class="px-4 py-2 border-t border-b border-r border-gray-200 text-center rounded-tr-lg">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @if ($revenues->isEmpty())
                        <tr>
                            <td colspan="5" class="text-center py-2 text-sm text-gray-600 border-b border-l border-r border-gray-200">Data tidak tersedia</td>
                        </tr>
                    @else
                    @foreach ($revenues as $index => $purchase)
                        <tr class="hover:bg-gray-50 text-gray-600 text-sm">
                            <td class="px-4 py-2 text-center border-l border-b border-gray-200">{{ $index + 1 }}</td>
                            <td class="px-4 py-2 border-b border-gray-200">{{ $purchase->user->name ?? '-' }}</td>
                            <td class="px-4 py-2 border-b border-gray-200">{{ $purchase->course->title ?? '-' }}</td>
                            <td class="px-4 py-2 border-b border-gray-200">
                                Rp. {{ number_format(optional($purchase)->harga_course, 0, ',', '.') }}
                            </td>                            
                            <td class="px-4 py-2 text-center border-b border-gray-200 border-r">{{ $purchase->created_at->translatedFormat('d F Y') }}</td>
                        </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
            </div>
        </div>
    
        <div class="pagination mt-4">
            {{ $revenues->links('pagination::tailwind') }}
        </div>
    </div>
</div>

@php
    $months = [
        1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr',
        5 => 'Mei', 6 => 'Jun', 7 => 'Jul', 8 => 'Agu',
        9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'
    ];
    $dataPoints = [];
    foreach ($months as $i => $month) {
        $dataPoints[] = $monthlyRevenue[$i] ?? 0;
    }
@endphp

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('monthlyRevenueChart').getContext('2d');
    const monthlyRevenueChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode(array_values($months)) !!},
            datasets: [{
                label: 'Pendapatan Bulanan (Rp)',
                data: {!! json_encode($dataPoints) !!},
                borderColor: '#3b82f6',
                backgroundColor: 'rgba(59, 130, 246, 0.2)',
                borderWidth: 2, // ⬅️ Ini yang membuat garis lebih tipis
                fill: 'origin', // hanya sampai baseline
                tension: 0.4,
                fill: true,
                pointRadius: 5,
                pointBackgroundColor: '#3b82f6',
                pointBorderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false, // ⛔ WAJIB: agar tinggi div diikuti (tinggi grafik mengikuti kontainer nya agar tidak terlalu tinggi)
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
                            let value = context.parsed.y;
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                }
            }
        }
    });
</script>

@endsection