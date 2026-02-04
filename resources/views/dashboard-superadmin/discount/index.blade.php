@extends('layouts.dashboard-superadmin')
@section('title', 'Diskon')
@section('content')
<div class="container mx-auto bg-white rounded-lg p-5 border border-gray-200">
    <!-- Wrapper div dengan background putih dan padding -->
    <div class="">
        <div class="flex flex-col md:flex-row items-center justify-between space-y-4 mb-4">
            <!-- searchbar -->
            <form action="{{ route('diskon-superadmin') }}" method="GET" class="w-full md:max-w-xs">
                <label for="search" class="mb-2 text-sm font-medium text-gray-900 sr-only">Cari</label>
                    <div class="flex items-center border border-gray-300 rounded-lg bg-white">
                        <svg class="w-4 h-4 text-gray-500 ml-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                        </svg>
                        <input type="search" name="search" id="search" 
                            class="block w-full p-2 pl-2 text-sm text-gray-700 border-0 rounded-lg focus:border-sky-400 focus:outline-none" 
                            placeholder="Cari Kode Diskon..." value="{{ request('search') }}" />
                    </div>
            </form>
            
            <!-- button tambah -->
            <div class="inline-flex shadow-md shadow-blue-100 hover:shadow-none items-center space-x-2 text-white bg-blue-400 hover:bg-blue-300 font-semibold py-2 px-4 rounded-md">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="white" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <a href="{{ route('tambah-diskon-superadmin') }}" class="text-sm text-white rounded transition duration-300">Tambah Diskon</a>
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
                        <td colspan="5" class="py-2 px-2 text-center text-gray-600 text-sm border-l border-b border-r">
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
                                    data-id="{{ $discount->id }}"
                                    data-coupon-code="{{ $discount->coupon_code }}"
                                    data-discount-percentage="{{ $discount->discount_percentage }}"
                                    data-start-date="{{ $discount->start_date }}"
                                    data-end-date="{{ $discount->end_date }}"
                                    data-start-time="{{ $discount->start_time }}"
                                    data-end-time="{{ $discount->end_time }}"
                                    data-apply-to-all="{{ $discount->apply_to_all ? 'true' : 'false' }}"
                                    data-courses="{{ json_encode($discount->courses->pluck('title')) }}"
                                    onclick="openDiscountModal(this)">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                                </a>

                                <!-- Tombol Edit -->
                                <a href="{{ route('editdiskon-superadmin', $discount->id) }}" class="text-white bg-yellow-300 p-1 rounded-md  hover:bg-yellow-200" title="Edit">
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
<div id="discountModal" class="fixed inset-0 px-4 flex items-center text-left justify-center bg-black bg-opacity-50 hidden z-[1000]">
    <div id="modal-box" class="bg-white p-4 rounded-xl mx-4 w-full max-w-sm md:max-w-xl mx-auto relative transform scale-90 opacity-0 transition-all duration-300 ease-out">
        <!-- Tombol Close -->
        <button onclick="closeDiscountModal()" class="absolute top-4 right-4 text-gray-600 hover:text-gray-500 text-xl font-medium">
           <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 8.586L15.95 2.636a1 1 0 111.414 1.414L11.414 10l5.95 5.95a1 1 0 01-1.414 1.414L10 11.414l-5.95 5.95a1 1 0 01-1.414-1.414L8.586 10 2.636 4.05a1 1 0 011.414-1.414L10 8.586z" clip-rule="evenodd" />
            </svg>
        </button>
        <!-- Judul -->
        <h3 class="text-xl font-semibold text-center text-gray-700 mb-2">Detail Diskon</h3>
        <div class="w-16 h-1 bg-gray-600 mx-auto mb-4 rounded"></div>
        <!-- Layout detail kursus -->
        <div class="space-y-2 mt-4 text-gray-700 text-sm max-h-[70vh] overflow-y-auto pr-2">
            <div class="flex justify-between space-x-10 py-1 border-b border-gray-200">
                <p class="font-semibold">Kode Diskon : </p>
                <p class="text-gray-700"><span id="modalCouponCode"></span></p>
            </div>
            <div class="flex justify-between space-x-10 py-1 border-b border-gray-200">
                <p class="font-semibold">Terapkan ke semua kursus :</p>
                <p class="text-gray-700"><span id="modalApplyToAll"></span></p>
            </div>
            <div id="modalCoursesContainer" class="mt-2 hidden">
                <p class="font-semibold text-gray-700">Kursus yang mendapat diskon:</p>
                <ul id="modalCoursesList" class="list-disc ml-6 text-gray-700 text-sm mt-1 space-y-1"></ul>
            </div>
            <div class="flex justify-between space-x-10 py-1 border-b border-gray-200">
                <p class="font-semibold">Potongan:</p>
                <p class="text-gray-700"><span id="modalDiscountPercentage"></span>%</p>
            </div>
            <div class="flex justify-between space-x-10 py-1 border-b border-gray-200">
                <p class="font-semibold">Tanggal Mulai:</p>
                <p class="text-gray-700"><span id="modalStartDate"></span></p>
            </div>
            <div class="flex justify-between space-x-10 py-1 border-b border-gray-200">
                <p class="font-semibold">Tanggal Selesai:</p>
                <p class="text-gray-700"><span id="modalEndDate"></span></p>
            </div>
            <div class="flex justify-between space-x-10 py-1 border-b border-gray-200">
                <p class="font-semibold">Jam Mulai:</p>
                <p class="text-gray-700"><span id="modalStartTime"></span></p>
            </div>
            <div class="flex justify-between space-x-10 py-1 border-b border-gray-200">
                <p class="font-semibold">Jam Selesai:</p>
                <p class="text-gray-700"><span id="modalEndTime"></span></p>
            </div>
        </div>
    </div>
</div>

<script>
    function openDiscountModal(element) {
        // Ambil data dari atribut data-*
        const id = element.dataset.id;
        const couponCode = element.dataset.couponCode;
        const discountPercentage = element.dataset.discountPercentage;
        const startDate = element.dataset.startDate;
        const endDate = element.dataset.endDate;
        const startTime = element.dataset.startTime;
        const endTime = element.dataset.endTime;
        const applyToAll = element.dataset.applyToAll === 'true'; // Mengonversi ke boolean
        const courseList = JSON.parse(element.dataset.courses); // Mengubah JSON string menjadi array

        console.log({
            id, couponCode, discountPercentage, startDate, endDate, startTime, endTime, applyToAll, courseList
        });

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
        document.getElementById('modalApplyToAll').textContent = applyToAll ? 'Ya' : 'Tidak';

        const coursesContainer = document.getElementById('modalCoursesContainer');
        const coursesList = document.getElementById('modalCoursesList');
        coursesList.innerHTML = ''; // Clear list first

        if (!applyToAll && Array.isArray(courseList)) {
            coursesContainer.classList.remove('hidden');
            courseList.forEach(course => {
                const li = document.createElement('li');
                li.textContent = course;
                coursesList.appendChild(li);
            });
        } else {
            coursesContainer.classList.add('hidden');
        }

        const modal = document.getElementById('discountModal');
        const modalBox = document.getElementById('modal-box');

        modal.classList.remove('hidden');
        // Trigger animasi buka
        setTimeout(() => {
            modalBox.classList.remove('scale-90', 'opacity-0');
            modalBox.classList.add('scale-100', 'opacity-100');
        }, 10); // delay untuk memastikan transition aktif
    }

    function closeDiscountModal() {
        const modal = document.getElementById('discountModal');
        const modalBox = document.getElementById('modal-box');

        // Animasi tutup
        modalBox.classList.remove('scale-100', 'opacity-100');
        modalBox.classList.add('scale-90', 'opacity-0');

        // Tunggu transisi selesai sebelum menyembunyikan modal
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300); // harus sama dengan duration Tailwind (300ms)
    }
</script>
@endsection
