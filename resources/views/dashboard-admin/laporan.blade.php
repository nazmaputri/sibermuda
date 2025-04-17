@extends('layouts.dashboard-admin')
@section('title', 'Laporan')
@section('content')
<div class="container mx-auto">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow-md p-5 flex items-center border border-gray-200">
            <div class="p-2 bg-yellow-400 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="white" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                </svg>
            </div>
            <div class="ml-4 mt-2">
                <h2 class="text-xl font-semibold text-yellow-400">
                    Rp. {{ number_format($totalAllRevenue, 0, ',', '.') }}
                </h2>
                <p class="text-md font-semibold text-gray-600">
                    Pendapatan Keseluruhan
                </p>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-5 flex items-center border border-gray-200">
            <div class="p-2 bg-yellow-400 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="white" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                </svg>
            </div>
            <div class="ml-4">
                <h2 class="text-xl font-semibold text-yellow-400">Rp.1.000.000</h2>
                <p class="text-md font-semibold text-gray-600">Pendapatan Tahun ini</p>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-5 flex items-center border border-gray-200">
            <div class="p-2 bg-yellow-400 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="white" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                </svg>
            </div>
            <div class="ml-4">
                <h2 class="text-xl font-semibold text-yellow-400">
                    Rp. {{ number_format($totalRevenue, 0, ',', '.') }}
                </h2>
                <p class="text-md font-semibold text-gray-600">Pendapatan Bulan ini</p>
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
        
            <!-- Tombol Submit -->
            <div>
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">
                    Filter
                </button>
            </div>
        </form>  
        
        <form method="GET" action="{{ route('purchases.export') }}" class="mb-4">
            <input type="hidden" name="course_id" value="{{ request('course_id') }}">
            <input type="hidden" name="month" value="{{ request('month') }}">
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">
                Ekspor ke Excel
            </button>
        </form>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm divide-y divide-gray-200">
                <thead class="bg-sky-100 text-gray-700">
                    <tr>
                        <th class="px-4 py-2 border-t text-center">No</th>
                        <th class="px-4 py-2 border-t text-left">Nama User</th>
                        <th class="px-4 py-2 border-t text-left">Judul Kursus</th>
                        <th class="px-4 py-2 border-t text-center">Harga</th>
                        <th class="px-4 py-2 border-t text-center">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @if ($revenues->isEmpty())
                        <tr>
                            <td colspan="5" class="text-center py-2 text-sm text-gray-600 border-b border-l border-r border-gray-200">Data tidak tersedia</td>
                        </tr>
                    @else
                    @foreach ($revenues as $index => $purchase)
                        <tr class="hover:bg-sky-50">
                            <td class="px-4 py-2 text-center">{{ $index + 1 }}</td>
                            <td class="px-4 py-2">{{ $purchase->user->name ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $purchase->course->title ?? '-' }}</td>
                            <td class="px-4 py-2 text-center text-green-600">
                                @if(optional($purchase->payment)->amount)
                                    Rp. {{ number_format(optional($purchase->payment)->amount, 0, ',', '.') }}
                                @else
                                    -
                                @endif
                            </td>                            
                            <td class="px-4 py-2 text-center">{{ $purchase->created_at->format('d M Y') }}</td>
                        </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    
        <!-- Total -->
        <div class="mt-4 text-right text-lg text-gray-700 font-semibold">
            Total Pendapatan: <span class="text-red-500">Rp. {{ number_format($totalRevenue, 0, ',', '.') }}</span>
        </div>
    </div>
</div>

@endsection
