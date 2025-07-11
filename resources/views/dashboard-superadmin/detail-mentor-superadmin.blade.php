@extends('layouts.dashboard-superadmin')
@section('title', 'Detail Mentor')
@section('content')

<!-- Tombol Kembali -->
<div class="flex justify-start mb-2">
    <a href="{{ route('datamentor-superadmin') }}" class="text-midnight font-semibold p-1 bg-white border border-gray-200 rounded-full transition-transform duration-300 ease-in-out transform hover:scale-105 inline-flex items-center">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
        </svg>
    </a>
</div>

<div class="container mx-auto">
    <!-- Card Detail Mentor -->
    <div class="bg-white shadow-lg rounded-lg p-6 mb-6 border border-gray-200">

        <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
            <!-- Kolom Kiri: Foto Profil & Role -->
            <div class="flex flex-col items-center space-y-1">
                <!-- Foto Profil -->
                <div class="w-20 h-20 rounded-full overflow-hidden flex justify-center items-center bg-gray-100">
                    <img src="{{ $user->photo ? asset('storage/' . $user->photo) : asset('storage/default-profile.jpg') }}" alt="" class="object-cover w-full h-full">
                </div>                
                
                <!-- Nama -->
                <div class="p-1">
                    <p class="font-semibold text-gray-700 text-sm">{{ Str::limit($user->name, 35, '...') }}</p>
                </div>

                <!-- Role -->
                <div class="w-full text-center">
                    <p class="text-gray-700">{{ ucfirst($user->role) }}</p>
                </div>
            </div>

            <!-- Kolom Tengah: Informasi Mentor -->
            <div class="col-span-1 md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-1">
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

    <!-- Card Kursus -->
    <div class="bg-white shadow-lg rounded-lg p-6 mb-6 border border-gray-200">
        <div class="text-left mb-4 border-b-2 border-gray-300 pb-2">
            <h2 class="text-lg font-semibold text-gray-700">Kursus</h2>
        </div>
        <div class="overflow-x-auto">
            <div class="min-w-full w-64">
                <table class="min-w-full text-sm border-separate border-spacing-0">
                    <thead>
                        <tr class="bg-gray-100 text-gray-600 text-sm">
                            <th class="px-2 py-2 text-center border-b border-l border-gray-200 border-t rounded-tl-lg">No</th>
                            <th class="px-4 py-2 text-center border-b border-gray-200 border-t">Judul</th>
                            <th class="px-4 py-2 text-center border-b border-gray-200 border-t">Harga</th>
                            <th class="px-4 py-2 text-center border-b border-gray-200 border-t">Tanggal dibuat</th>
                            <th class="px-4 py-2 text-center border-b border-gray-200 border-t border-r rounded-tr-lg">Rating</th>
                            <!-- <th class="px-4 py-2 text-center border-b border-r border-gray-200 border-t rounded-tr-lg">Aksi</th> -->
                        </tr>
                    </thead>
                
                    <tbody class="text-gray-600 text-sm">
                        @forelse ($courses as $index => $course) 
                            <tr class="bg-white hover:bg-gray-50 border-b text-sm">
                                <td class="px-2 py-2 text-center border-b border-l border-gray-200">{{ $courses->firstItem() + $index }}</td>
                                <td class="px-4 py-2 border-b border-gray-200">{{ Str::limit($course->title, 40) }}</td>
                                <td class="px-4 py-2 border-b border-gray-200 text-center">Rp {{ number_format($course->price, 0, ',', '.') }}</td> 
                                <td class="px-4 py-2 border-b border-gray-200 text-center">{{\Carbon\Carbon::parse( $course->created_at)->translatedFormat('d F Y') }}</td>
                                <td class="px-4 py-2 border-b border-gray-200 text-center border-r">
                                    @if (!empty($course->average_rating) && is_numeric($course->average_rating))
                                        <span class="text-yellow-500">★</span> {{ $course->average_rating }}/5
                                    @else
                                        Belum ada rating
                                    @endif
                                </td> 
                                <!-- Tombol Lihat Detail -->
                                <!-- <td class="py-3 px-6 text-center border-b border-r border-gray-200">
                                    <div class="flex items-center justify-center space-x-8">
                                       
                                        <a href="{{ route('detailkursus', [$course->id]) }}" class="text-white bg-sky-300 p-1 rounded-md hover:bg-sky-200" title="Lihat">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                            </svg>
                                        </a>
                                    </div>
                                </td> -->
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-gray-500 py-2 border-b border-l border-r border-gray-200">Belum ada kursus yang diajarkan oleh mentor ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Tampilkan Pagination -->
        <div class="mt-4">
            {{ $courses->links('pagination::tailwind') }}
        </div>
    </div>
@endsection
