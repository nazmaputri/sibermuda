@extends('layouts.dashboard-admin')
@section('title', 'Diskon')
@section('content')
<div class="container mx-auto bg-white rounded-lg p-5 border border-gray-200">
    <!-- Wrapper div dengan background putih dan padding -->
    <div class="">
        <div class="flex flex-col md:flex-row items-center justify-between space-y-4 mb-4">
            <!-- searchbar -->
            <form action="{{ route('discount') }}" method="GET" class="w-full md:max-w-xs">
                <label for="search" class="mb-2 text-sm font-medium text-gray-900 sr-only">Cari</label>
                    <div class="flex items-center border border-gray-300 rounded-lg bg-white">
                        <svg class="w-4 h-4 text-gray-500 ml-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                        </svg>
                        <input type="search" name="search" id="search" 
                            class="block w-full p-2 pl-2 text-sm text-gray-700 border-0 rounded-lg focus:border-sky-400 focus:outline-none" 
                            placeholder="Cari Kode Kupon..." value="{{ request('search') }}" />
                    </div>
            </form>
            
            <!-- button tambah -->
            <div class="inline-flex shadow-md shadow-blue-100 hover:shadow-none items-center space-x-2 text-white bg-blue-400 hover:bg-blue-300 font-semibold py-2 px-4 rounded-md">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="white" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <a href="{{ route('discount-tambah') }}" class="text-sm text-white rounded transition duration-300">Tambah Diskon</a>
            </div>
        </div>

        <!-- Tabel dengan responsivitas -->
        <div class="overflow-x-auto mt-6">
            <div class="min-w-full w-64">
            <table class="min-w-full border-separate border-spacing-0">
                <thead>
                    <tr class="bg-gray-100 text-gray-600 text-sm">
                    <th class="py-2 px-2 text-center text-gray-700 border-b border-l border-t border-gray-200 rounded-tl-lg">No</th>
                        <th class="py-2 px-2 text-center text-gray-700 border-b border-t border-gray-200">Kode Kupon</th>
                        <th class="py-2 px-2 text-center text-gray-700 border-b border-t border-gray-200">Diskon (%)</th>
                        <th class="py-2 px-2 text-center text-gray-700 border-b border-t border-gray-200">Tanggal</th>
                        <th class="py-2 px-2 text-center text-gray-700 border-b border-t border-r border-gray-200 rounded-tr-lg">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @if($discounts->isEmpty())
                    <tr>
                        <td colspan="5" class="py-2 px-2 text-center text-gray-700 text-sm border-l border-b border-r">
                            Tidak ada data diskon yang tersedia
                        </td>
                    </tr>
                @else
                    @foreach($discounts as $discount)
                        <tr class="hover:bg-gray-50">
                        <td class="py-3 px-2 text-center text-gray-600 text-sm border-b border-l border-gray-200">{{ $loop->iteration }}</td>
                            <td class="py-3 px-2 text-center text-gray-600 text-sm border-b border-gray-200">{{ $discount->coupon_code }}</td>
                            <td class="py-3 px-2 text-center text-gray-600 text-sm border-b border-gray-200">{{ $discount->discount_percentage }}%</td>
                            <td class="py-3 px-2 text-center text-gray-600 text-sm border-b border-gray-200">{{ \Carbon\Carbon::parse($discount->start_date)->translatedFormat('d F Y') }} - {{ \Carbon\Carbon::parse($discount->end_date)->translatedFormat('d F Y') }}</td>
                            <td class="py-3 px-2 text-center border-b border-r border-gray-200">
                                <div class="flex items-center justify-center space-x-6">
                                <!-- Tombol Lihat Detail -->
                                <a href="#" class="text-white bg-sky-300 p-1 rounded-md hover:bg-sky-200" title="Lihat"
                                    onclick="openDiscountModal(
                                    '{{ $discount->id }}',
                                    '{{ $discount->coupon_code }}',
                                    '{{ $discount->discount_percentage }}',
                                    '{{ $discount->start_date }}',
                                    '{{ $discount->end_date }}',
                                    '{{ $discount->start_time }}',
                                    '{{ $discount->end_time }}',
                                    {{ $discount->apply_to_all ? 'true' : 'false' }}
                                )">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                                </a>

                                <!-- Tombol Edit -->
                                <a href="{{ route('discount.edit', $discount->id) }}" class="text-white bg-yellow-300 p-1 rounded-md  hover:bg-yellow-200" title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>
                                </a>
                                <!-- Tombol Hapus -->
                                <form action="{{ route('discount.destroy', $discount->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete text-white bg-red-400 p-1 mt-1 rounded-md hover:bg-red-300" title="Hapus">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                    </button>
                                </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
            </div>
        </div>
        <div class="pagination mt-4">
            {{ $discounts->links('pagination::tailwind') }}
        </div>
    </div>
</div>

<!-- Modal Detail Discount -->
<div id="discountModal" class="fixed inset-0 flex items-center text-left justify-center bg-black bg-opacity-50 hidden z-[1000]">
    <div class="bg-white p-4 rounded-md mx-4 w-full md:w-[700px]">
    <div class="flex items-center justify-between w-full mb-4">
        <h2 class="text-gray-700 font-semibold w-full text-center text-lg">Detail Diskon</h2>
        <button class="text-gray-700 px-2 py-0.5 rounded-md" onclick="closeDiscountModal()">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 font-semibold">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
        <p class="text-gray-700 font-semibold">Kode Diskon : <span id="modalCouponCode"></span></p>
        <p class="text-gray-700 font-semibold">Terapkan pada semua kursus : <span id="modalApplyToAll"></span></p>
        <!-- Tabel dengan border bottom dashed -->
        <div class="overflow-x-auto">
            <table class="w-full border-collapse mt-4">
                <thead class="bg-gray-100">
                    <tr class="border-b border-dashed border-gray-400">
                        <th class="px-4 py-2 text-center text-sm text-gray-700">Potongan</th>
                        <th class="px-4 py-2 text-center text-sm text-gray-700">Tanggal Mulai</th>
                        <th class="px-4 py-2 text-center text-sm text-gray-700">Tanggal Selesai</th>
                        <th class="px-4 py-2 text-center text-sm text-gray-700">Jam Mulai</th>
                        <th class="px-4 py-2 text-center text-sm text-gray-700">Jam Selesai</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b border-dashed border-gray-300">
                        <td class="px-4 py-2 text-sm text-gray-700 text-center"><span id="modalDiscountPercentage"></span>%</td>
                        <td class="px-4 py-2 text-sm text-gray-700 text-center"><span id="modalStartDate"></span></td>
                        <td class="px-4 py-2 text-sm text-gray-700 text-center"><span id="modalEndDate"></span></td>
                        <td class="px-4 py-2 text-sm text-gray-700 text-center"><span id="modalStartTime"></span></td>
                        <td class="px-4 py-2 text-sm text-gray-700 text-center"><span id="modalEndTime"></span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    // untuk menampilkan detail diskon 
    function openDiscountModal(id, couponCode, discountPercentage, startDate, endDate, startTime, endTime, applyToAll) {
        // Isi data ke modal
        document.getElementById('modalCouponCode').textContent = couponCode;
        document.getElementById('modalDiscountPercentage').textContent = discountPercentage;
        document.getElementById('modalStartDate').textContent = new Date(startDate).toLocaleDateString('id-ID', {
            day: '2-digit',
            month: 'long',
            year: 'numeric'
        });
        document.getElementById('modalEndDate').textContent = new Date(endDate).toLocaleDateString('id-ID', {
            day: '2-digit',
            month: 'long',
            year: 'numeric'
        });
        document.getElementById('modalStartTime').textContent = startTime;
        document.getElementById('modalEndTime').textContent = endTime;
        document.getElementById('modalApplyToAll').textContent = applyToAll ? 'Yes' : 'No';
            // Tampilkan modal
            document.getElementById('discountModal').classList.remove('hidden');
        }

    function closeDiscountModal() {
        document.getElementById('discountModal').classList.add('hidden');
    }
</script>
@endsection
