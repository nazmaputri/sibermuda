@extends('layouts.dashboard-superadmin')
@section('title', 'Tambah Diskon')
@section('content')
<div class="container mx-auto bg-white rounded-lg p-5 border border-gray-200">
    <!-- Wrapper div dengan background putih, padding, dan shadow -->
    <div class="">
        <h2 class="text-lg font-semibold text-gray-700 text-center w-full border-b-2 border-gray-300 pb-2">Tambah Diskon</h2>

        <!-- Formulir Diskon -->
        <form action="{{ route('discount.store') }}" method="POST" class="mt-4 grid grid-col-1 md:grid-cols-2 space-x-3">
            @csrf

            <!-- Kode Kupon -->
            <div class="mb-4">
                <label class="block text-gray-700 pb-2 font-medium">Kode Diskon</label>
                <input type="text" name="coupon_code" class="border p-2 w-full text-sm text-gray-700 rounded focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400 @error('coupon_code') border-red-500 @enderror" placeholder="Masukkan kode kupon">
                @error('coupon_code')
                    <p class="text-red-500 text-sm mt-1" id="coupon_code-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Persen Diskon -->
            <div class="mb-4">
                <label class="block text-gray-700 pb-2 font-medium">Persen Diskon (%)</label>
                <input type="number" name="discount_percentage" min="1" max="100" class="border p-2 w-full text-sm text-gray-700 rounded focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400 @error('discount_percentage') border-red-500 @enderror" placeholder="Masukkan persentase diskon">
                @error('discount_percentage')
                    <p class="text-red-500 text-sm mt-1" id="discount_percentage-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tanggal Mulai -->
            <div class="mb-4">
                <label class="block text-gray-700 pb-2 font-medium">Tanggal Mulai</label>
                <input type="date" name="start_date" class="border p-2 w-full text-sm text-gray-700 rounded focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400 @error('start_date') border-red-500 @enderror" min="{{ \Carbon\Carbon::today()->toDateString() }}">
                @error('start_date')
                    <p class="text-red-500 text-sm mt-1" id="start_date-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tanggal Berakhir -->
            <div class="mb-4">
                <label class="block text-gray-700 pb-2 font-medium">Tanggal Berakhir</label>
                <input type="date" name="end_date" class="border p-2 w-full text-sm text-gray-700 rounded focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400 @error('end_date') border-red-500 @enderror" min="{{ \Carbon\Carbon::today()->toDateString() }}">
                @error('end_date')
                    <p class="text-red-500 text-sm mt-1" id="end_date-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Jam Mulai -->
            <div class="mb-4">
                <label class="block text-gray-700 pb-2 font-medium">Jam Mulai</label>
                <input type="time" name="start_time" class="border p-2 w-full text-sm text-gray-700 rounded focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400 @error('start_time') border-red-500 @enderror">
                @error('start_time')
                    <p class="text-red-500 text-sm mt-1" id="start_time-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Jam Berakhir -->
            <div class="mb-4">
                <label class="block text-gray-700 pb-2 font-medium">Jam Berakhir</label>
                <input type="time" name="end_time" class="border p-2 w-full text-sm text-gray-700 rounded focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400 @error('end_time') border-red-500 @enderror">
                @error('end_time')
                    <p class="text-red-500 text-sm mt-1" id="end_time-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Dropdown Pilih Kursus -->
            <div id="courseSelection" x-data="{ open: false, selectedCourseIds: [], selectedCourseTitles: [], searchTerm: '', applyToAll: false}">
                <input type="hidden" name="apply_to_all" :value="applyToAll ? 1 : 0">

                <label class="block text-gray-700 pb-2 font-medium">Pilih Kursus</label>

                <div class="relative w-full max-w-full">
                <!-- Tombol untuk membuka dropdown -->
                <button @click="open = !open" type="button"
                    class="border px-4 py-2 text-gray-700 w-full rounded bg-white flex justify-between items-center focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400 overflow-hidden">
                    <div class="flex-1 w-full max-w-full overflow-x-auto max-h-10 scrollbar-hide">
                        <span class="block text-left text-sm">
                            <template x-if="applyToAll">
                                <span class="font-medium text-gray-700">Terapkan ke semua kursus</span>
                            </template>
                            <template x-if="!applyToAll && selectedCourseTitles.length > 0">
                                <span x-text="selectedCourseTitles.join(', ')"></span>
                            </template>
                            <template x-if="!applyToAll && selectedCourseTitles.length === 0">
                                <span>Pilih Kursus</span>
                            </template>
                        </span>
                    </div>
                    <!-- Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 ml-1 shrink-0" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>

                <!-- Dropdown menu -->
                <div x-show="open" @click.away="open = false"
                        class="mt-1 w-full bg-white border rounded-lg shadow-lg"> <!-- disini tambah class absolute aja kalau mau agar dropdownnya responsive-->
                    <div class="p-2">
                        <input type="text" placeholder="Cari kursus..." x-model="searchTerm"
                                class="w-full text-sm text-gray-700 px-4 py-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400">
                    </div>

                    <ul class="max-h-48 overflow-y-auto text-sm text-gray-700">

                        <!-- Opsi Terapkan ke Semua Kursus -->
                        <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer border border-dashed">
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" x-model="applyToAll"
                                        class="text-midnight focus:ring-gray-400 rounded">
                                <span class="font-medium text-gray-700">Terapkan ke semua kursus</span>
                            </label>
                        </li>

                        <!-- Daftar Kursus -->
                        @foreach($courses as $course)
                            @php
                                $hasActiveDiscount = $course->discounts->where('start_date', '<=', \Carbon\Carbon::now())
                                                        ->where('end_date', '>=', \Carbon\Carbon::now())->count() > 0;
                            @endphp
                            <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer" x-show="'{{ Str::lower($course->title) }}'.includes(searchTerm.toLowerCase())">
                                <label class="flex items-center">
                                    <input type="checkbox"
                                        :disabled="applyToAll || {{ $hasActiveDiscount ? 'true' : 'false' }}"
                                        @change="
                                            if ($event.target.checked) {
                                                selectedCourseIds.push({{ $course->id }});
                                                selectedCourseTitles.push('{{ $course->title }}');
                                            } else {
                                                selectedCourseIds = selectedCourseIds.filter(id => id !== {{ $course->id }});
                                                selectedCourseTitles = selectedCourseTitles.filter(title => title !== '{{ $course->title }}');
                                            }
                                        "
                                        class="mr-2 text-gray-700">
                                    <span>{{ $course->title }}</span>
                                    @if($hasActiveDiscount)
                                        <span class="text-xs text-red-500 ml-2">Diskon Aktif</span>
                                    @endif
                                </label>

                                <!-- Hidden input untuk submit id kursus -->
                                <template x-if="selectedCourseIds.includes({{ $course->id }})">
                                    <input type="hidden" name="courses[]" value="{{ $course->id }}">
                                </template>
                            </li>
                        @endforeach
                    </ul>
                </div>
                </div>
                <p class="text-sm text-gray-500 mt-1">* Pilih beberapa kursus atau terapkan ke semua.</p>
            </div>

            <!-- Tombol -->
            <div class="col-span-1 md:col-span-2 mt-6 flex justify-end space-x-2">
                <a href="{{ route('diskon-superadmin') }}" class="bg-red-400 hover:bg-red-300 text-white font-medium py-2 px-4 rounded-md">
                    Batal
                </a>
                <button type="submit" class="bg-sky-400 hover:bg-sky-300 text-white font-medium py-2 px-4 rounded-md">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('discountForm', () => ({
            applyToAll: false,
        }));
    });

    document.getElementById('applyToAll').addEventListener('change', function () {
        document.getElementById('courseSelection').style.display = this.checked ? 'none' : 'block';
    });

    // Fungsi untuk menghapus class error dan menyembunyikan pesan error validasi
    document.addEventListener('DOMContentLoaded', function () {
    const inputs = document.querySelectorAll('input');
        inputs.forEach(input => {
            input.addEventListener('input', function () {
                removeErrorStyles(input.id);
            });
        });
    });

    function removeErrorStyles(inputId) {
        const input = document.getElementById(inputId);
        if (input) {
            input.classList.remove('border-red-500', 'focus:ring-red-500', 'text-red-500');
            const errorMessage = document.getElementById(inputId + '-error');
            if (errorMessage) {
                errorMessage.style.display = 'none';
            }
        }
    }
</script>
@endsection
