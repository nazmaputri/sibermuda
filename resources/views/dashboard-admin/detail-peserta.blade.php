@extends('layouts.dashboard-admin')
@section('title', 'Detail Peserta')
@section('content')

<!-- Tombol Kembali -->
<div class="flex justify-start mb-2">
    <a href="{{ route('datapeserta-admin') }}" class="text-midnight font-semibold p-1 bg-white border border-gray-200 rounded-full transition-transform duration-300 ease-in-out transform hover:scale-105 inline-flex items-center">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
        </svg>
    </a>
</div>

<div class="container mx-auto">
    <!-- Card Detail User -->
    <div class="bg-white shadow-lg rounded-lg border border-gray-200 p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Kolom Kiri: Foto Profil, Nama, Role -->
            <div class="flex flex-col items-center space-y-3">
                <!-- Foto Profil -->
                <div class="w-20 h-20 rounded-full overflow-hidden flex justify-center items-center bg-gray-100">
                    <img src="{{ $user->photo ? asset('storage/' . $user->photo) :  asset('storage/default-profile.jpg') }}" alt="Foto Profil" class="object-cover w-full h-full">
                </div>

                <!-- Nama -->
                <p class="text-lg text-gray-700 font-semibold text-center md:text-left">{{ Str::limit($user->name, 35, '...') }}</p>

                <!-- Role -->
                <p class="text-gray-700 text-sm text-center md:text-left">{{ ucfirst($user->role) }}</p>
            </div>

            <!-- Kolom Kanan: Informasi Lainnya -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 w-full">
                <!-- Email -->
                <div>
                    <h4 class="font-semibold text-gray-700 text-sm">Email:</h4>
                    <p class="text-sm text-gray-700">{{ $user->email }}</p>
                </div>

                <!-- No Telepon -->
                <div>
                    <h4 class="font-semibold text-gray-700 text-sm">No Telepon:</h4>
                    <p class="text-sm text-gray-700">{{ $user->phone_number ?? '-' }}</p>
                </div>

                <!-- Status -->
                <div>
                    <h4 class="font-semibold text-gray-700 text-sm">Status:</h4>
                    <p class="text-sm text-gray-700">{{ ucfirst($user->status) ?? '-' }}</p>
                </div>

                <!-- Tanggal Registrasi -->
                <div>
                    <h4 class="font-semibold text-gray-700 text-sm">Tanggal Registrasi:</h4>
                    <p class="text-sm text-gray-700">{{ $user->created_at->translatedFormat('d F Y') }}</p>
                </div>

                <!-- Email Verified At -->
                <div class="md:col-span-2">
                    <h4 class="font-semibold text-gray-700 text-sm">Email Terverifikasi:</h4>
                    <p class="text-sm text-gray-700">{{ $user->email_verified_at ? $user->email_verified_at->translatedFormat('d F Y H:i:s') : 'Belum Terverifikasi' }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white shadow-lg rounded-lg border border-gray-200 p-6 mb-6">
        <div class="text-left mb-4 border-b-2 border-gray-300 pb-2">
            <h2 class="text-lg font-semibold text-gray-700">Kursus Yang Diikuti</h2>
        </div>
        <div class="overflow-x-auto">
            <div class="min-w-full w-64">
                <table class="min-w-full text-sm border-separate border-spacing-0">
                    <thead>
                        <tr class="bg-gray-100 text-gray-600 text-sm">
                            <th class="px-2 py-2 text-center border-b border-t border-l border-gray-200 rounded-tl-lg">No</th>
                            <th class="px-4 py-2 text-center border-b border-t border-gray-200">Judul</th>
                            <th class="px-4 py-2 text-center border-b border-t border-gray-200">Kategori</th>
                            <th class="px-4 py-2 text-center border-b border-t border-r border-gray-200  rounded-tr-lg">Status Pembayaran</th>
                            <!-- <th class="px-4 py-2 text-center border-b border-t border-r border-gray-200 rounded-tr-lg">Aksi</th> -->
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm">
                        @forelse($purchasedCourses as $index => $purchase)
                            <tr class="bg-white hover:bg-gray-50 border-b text-sm">
                                <td class="px-2 py-2 text-center border-b border-l border-gray-200">{{ $index + 1 }}</td>
                                <td class="px-4 py-2 border-b border-gray-200 capitalize">{{ Str::limit($purchase->course->title ?? '-', 70) }}</td>
                                <td class="px-4 py-2 border-b border-gray-200 capitalize">{{ Str::limit($purchase->course->category->name ?? '-', 40) }}</td>
                                <td class="py-3 px-6 text-center border-b border-r border-gray-200">
                                    @php
                                        $status = $purchase->payment->transaction_status ?? '-';
                                    @endphp
                                
                                    @if ($status === 'pending')
                                        <button 
                                            onclick="confirmUpdate('{{ route('admin.update-status', $purchase->payment->id) }}')" 
                                            class="bg-yellow-200/50 border border-2 border-yellow-300 text-yellow-600 px-2 py-0.5 rounded-xl hover:bg-yellow-300">
                                            {{ $status }}
                                        </button>
                                    @elseif ($status === 'settlement' || $status === 'paid' || $status === 'success')
                                        <span class="bg-green-200/50 border border-2 border-green-300 text-green-500 px-2 py-0.5 rounded-xl">
                                            {{ $status }}
                                        </span>
                                    @else
                                        <span class="bg-gray-200/50 border border-2 border-gray-300 text-gray-600 px-2 py-0.5 rounded-xl">
                                            {{ $status }}
                                        </span>
                                    @endif
                                </td>
                                <!-- <td class="px-4 py-2 border-b border-gray-200 border-r capitalize text-center">
                                    <div class="flex justify-center items-center">
                                        <button class="flex items-center justify-center gap-1 bg-green-400 text-white p-1 rounded-md hover:bg-green-300 transition" title="Setujui">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                            </svg>
                                        </button>
                                    </div>
                                </td> -->
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-2 px-2 text-gray-400 border-l border-b border-r">Belum ada kursus yang dibeli</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="pagination mt-4">
            {{ $purchasedCourses->links('pagination::tailwind') }}
        </div> 
    </div>
</div>

<form id="statusUpdateForm" method="POST" style="display: none;">
    @csrf
    @method('PUT')
</form>

<script>
     function confirmUpdate(route) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: 'Anda akan mengubah status pembayaran.',
            icon: 'warning',
            customClass: {
                popup: 'text-sm',
                confirmButton: 'bg-green-400 hover:bg-green-300 text-white rounded-md px-4 py-2 mx-2',
                cancelButton: 'bg-red-400 hover:bg-red-300 text-white rounded-md px-4 py-2 mx-2'
            },
            buttonsStyling: false,
            showCancelButton: true,
            confirmButtonText: 'Ya, ubah status!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById('statusUpdateForm');
                form.action = route;
                form.submit();
            }
        });
    }
</script>
@endsection