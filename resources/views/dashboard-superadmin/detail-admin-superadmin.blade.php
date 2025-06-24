@extends('layouts.dashboard-superadmin')
@section('title', 'Detail Admin')
@section('content')

<!-- Tombol Kembali -->
<div class="flex justify-start mb-2">
    <a href="{{ route('dataadmin-superadmin') }}" class="text-midnight font-semibold p-1 bg-white border border-gray-200 rounded-full transition-transform duration-300 ease-in-out transform hover:scale-105 inline-flex items-center">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
        </svg>
    </a>
</div>

<div class="container mx-auto">
    <!-- Card Detail Mentor -->
    <div class="bg-white shadow-lg rounded-lg p-6 mb-6 border border-gray-200">

        <div class="grid grid-cols-1 md:grid-cols-4 gap-2">
            <!-- Kolom Kiri: Foto Profil & Role -->
            <div class="flex flex-col items-center space-y-1">
                <!-- Foto Profil -->
                <div class="w-64 h-64 overflow-hidden flex justify-center items-center bg-gray-100">
                    <img src="{{ $user->photo ? asset('storage/' . $user->photo) : asset('storage/default-profile.jpg') }}" alt="" class="object-cover w-full h-full">
                </div>                
            </div>

            <!-- Kolom Tengah: Informasi Mentor -->
            <div class="col-span-1 md:col-span-3 grid grid-cols-1 md:grid-cols-3 gap-1">
                <!-- Nama -->
                <div class="p-2">
                    <h4 class="font-semibold text-gray-700 text-sm">Username:</h4>
                    <p class="text-sm text-gray-700">{{ $user->name }}</p>
                </div>

                <!-- Password -->
                <div class="p-2">
                    <h4 class="font-semibold text-gray-700 text-sm">Password:</h4>
                    <p class="text-sm text-gray-700"></p>
                </div>

                <!-- Role -->
                <div class="p-2">
                    <h4 class="font-semibold text-gray-700 text-sm">Role:</h4>
                    <p class="text-sm text-gray-700">{{ ucfirst($user->role) }}</p>
                </div>

                <div class="p-2">
                    <h4 class="font-semibold text-gray-700 text-sm">Email:</h4>
                    <p class="text-sm text-gray-700">{{ $user->email }}</p>
                </div>

                <div class="p-2">
                    <h4 class="font-semibold text-gray-700 text-sm">No Telepon:</h4>
                    <p class="text-sm text-gray-700">{{ $user->phone_number ?? '-' }}</p>
                </div>

                <div class="p-2">
                    <h4 class="font-semibold text-gray-700 text-sm">Pengalaman:</h4>
                    <p class="text-sm text-gray-700">{{ $user->experience ?? '-' }}</p>
                </div>

                <div class="p-2">
                    <h4 class="font-semibold text-gray-700 text-sm">Status:</h4>
                    <p class="text-sm text-gray-700">{{ ucfirst($user->status) ?? '-' }}</p>
                </div>

                <div class="p-2">
                    <h4 class="font-semibold text-gray-700 text-sm">Tanggal Registrasi:</h4>
                    <p class="text-sm text-gray-700">{{\Carbon\Carbon::parse($user->created_at)->translatedFormat('d F Y') }}</p>
                </div>
                
                <div class="p-2">
                    <h4 class="font-semibold text-gray-700 text-sm">Email Terverifikasi:</h4>
                    <p class="text-sm text-gray-700">
                        {{ $user->email_verified_at ? \Carbon\Carbon::parse($user->email_verified_at)->translatedFormat('d F Y H:i:s') : 'Belum Terverifikasi' }}
                    </p>
                </div>                
            </div>
        </div>
    </div>
@endsection
