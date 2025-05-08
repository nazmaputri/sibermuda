@extends('layouts.dashboard-admin')
@section('title', 'Laporan')
@section('content')
<div class="container mx-auto">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow-md px-5 py-2 flex items-center border border-gray-200">
            <div class="mt-2">
                <h2 class="text-xl font-semibold text-gray-600">
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
                <h2 class="text-xl font-semibold text-gray-600">
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

    <!-- Pendapatan Per Kursus -->
    <div class="bg-white shadow-md rounded-lg p-6 border border-gray-200">
        <h3 class="text-lg font-semibold text-gray-700 mb-2">Detail Pembelian Kursus</h3>
    
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
                selected: '{{ request('month') ? \Carbon\Carbon::create()->month((int) request('month'))->format('F') : 'Semua Bulan' }}', 
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
            Total Pendapatan: <span class="text-red-500">Rp. {{ number_format($totalAllRevenue, 0, ',', '.') }}</span>
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
                            <td class="px-4 py-2 border-b border-gray-200 -center text-green-600">
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

@endsection