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
                <p class="text-md font-semibold text-gray-600">
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
        <!-- <div class="bg-white rounded-lg shadow-md px-5 py-2 flex items-center border border-gray-200">
            <div class="mt-2">
                <h2 class="text-xl font-semibold text-gray-600">
                    Rp. {{ number_format($totalRevenue, 0, ',', '.') }}
                </h2>
                <p class="text-md font-semibold text-gray-600">
                    Pendapatan Tahun Ini
                </p>
            </div>
            <div class="flex items-end gap-1 h-24 w-fit cursor-pointer ml-auto">
               
                <div class="w-3 h-6 bg-gradient-to-t from-[#08072a] to-[#1c1b3a] hover:h-10 transition-all duration-300 rounded-t"></div>
                
                
                <div class="w-3 h-10 bg-gradient-to-t from-[#08072a] to-[#2d2b5a] hover:h-14 transition-all duration-300 rounded-t"></div>
                
                
                <div class="w-3 h-16 bg-gradient-to-t from-[#08072a] to-[#3e3b7a] hover:h-20 transition-all duration-300 rounded-t"></div>
            </div>
        </div> -->
        <div class="bg-white rounded-lg shadow-md px-5 py-2 flex items-center border border-gray-200">
            <div class="mt-2">
                <h2 class="text-xl font-semibold text-gray-600">
                    Rp. {{ number_format($totalRevenue, 0, ',', '.') }}
                </h2>
                <p class="text-md font-semibold text-gray-600">
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
        <h3 class="text-lg font-semibold text-gray-700 mb-4">Detail Pembelian Kursus</h3>
    
        <form method="GET" class="mb-4 flex flex-wrap items-center gap-4">
            <!-- Filter Kursus -->
            <div>
                <label for="course_id" class="text-sm text-gray-600 mr-2">Filter Kursus:</label>
                <select name="course_id" id="course_id" class="border rounded px-2 py-1 text-sm">
                    <option value="">Semua Kursus</option>
                    @foreach ($coursesRevenue as $course)
                        <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>
                            {{ $course->title }}
                        </option>
                    @endforeach
                </select>
            </div>
        
            <!-- Filter Bulan -->
            <div>
                <label for="month" class="text-sm text-gray-600 mr-2">Filter Bulan:</label>
                <select name="month" id="month" class="border rounded px-2 py-1 text-sm">
                    <option value="">Semua Bulan</option>
                    @for ($m = 1; $m <= 12; $m++)
                        <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($m)->format('F') }}
                        </option>
                    @endfor
                </select>
            </div>

            <!-- Filter Tahun -->
            <!-- <div>
                <label for="year" class="text-sm text-gray-600 mr-2">Filter Tahun:</label>
                <select name="year" id="year" class="border rounded px-2 py-1 text-sm">
                    <option value="">Semua Tahun</option>
                    @for ($y = 2000; $y <= now()->year; $y++)
                        <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>
                            {{ $y }}
                        </option>
                    @endfor
                </select>
            </div> -->
        
            <!-- Tombol Submit -->
            <div>
                <button type="submit" class="shadow-blue-100 bg-blue-400 hover:bg-blue-300 text-white px-3 py-1 rounded text-sm">
                    Filter
                </button>
            </div>
        </form>  
        
        <form method="GET" action="{{ route('purchases.export') }}" class="mb-4">
            <input type="hidden" name="course_id" value="{{ request('course_id') }}">
            <input type="hidden" name="month" value="{{ request('month') }}">
            <button type="submit" class="bg-green-400 hover:bg-green-300 text-sm text-white px-4 py-2 rounded">
                Ekspor ke Excel
            </button>
        </form>

        <div class="overflow-x-auto">
            <div class="min-w-full w-64">
            <table class="min-w-full text-sm border-separate border-spacing-0">
                <thead class="bg-sky-100 text-gray-700">
                    <tr class="bg-gray-100 text-sm text-600">
                        <th class="px-4 py-2 border-t border-b border-l border-gray-200 text-center rounded-tl-lg">No</th>
                        <th class="px-4 py-2 border-t border-b border-gray-200 text-left">Nama User</th>
                        <th class="px-4 py-2 border-t border-b border-gray-200 text-left">Judul Kursus</th>
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
                                @if(optional($purchase->payment)->amount)
                                    Rp. {{ number_format(optional($purchase->payment)->amount, 0, ',', '.') }}
                                @else
                                    -
                                @endif
                            </td>                            
                            <td class="px-4 py-2 text-center border-b border-gray-200 border-r">{{ $purchase->created_at->format('d M Y') }}</td>
                        </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
            </div>
        </div>
    
        <!-- Total -->
        <div class="mt-4 text-right text-md text-gray-700 font-semibold">
            Total Pendapatan: <span class="text-red-500">Rp. {{ number_format($totalRevenue, 0, ',', '.') }}</span>
        </div>
    </div>
</div>

@endsection