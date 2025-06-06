@extends('layouts.dashboard-mentor')
@section('title', 'Kursus')

@section('content')
<div class="container mx-auto">
    <!-- Card Wrapper -->
    <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200">
        <!-- container searchbar dan button tambah kursus  -->
        <div class="flex flex-col md:flex-row items-center justify-between">
            <!-- Search Bar -->
            <form action="{{ route('courses.index') }}" method="GET" class="w-full md:max-w-xs">
                <div class="flex items-center border border-gray-300 rounded-lg bg-white">
                    <svg class="w-4 h-4 text-gray-500 ml-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                    <input type="search" name="search" id="default-search" class="block w-full p-2 pl-2 text-sm text-gray-700 border-0 rounded-lg focus:border-sky-400 focus:outline-none" placeholder="Cari Kursus atau Kategori..." required />
                </div>
            </form>

            <!-- button tambah kursus -->
            <div class="text-right p-1 md:text-right md:p-1 mt-4 md:mt-0 flex justify-center md:justify-end">
                <a href="{{ route('courses.create') }}" 
                class="inline-flex shadow-md shadow-blue-100 hover:shadow-none items-center space-x-2 text-white bg-blue-400 hover:bg-blue-300 font-medium py-2 px-4 rounded-md">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="white" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    <span class="text-sm">Tambah Kursus</span>
                </a>
            </div>  
        </div>      

        <!-- Tabel Kursus -->
        <div class="overflow-hidden overflow-x-auto w-full">
            <div class="min-w-full w-64">
            <table class="min-w-full mt-4 border-separate border-spacing-0">
                <thead>
                    <tr class="bg-gray-100 text-gray-600 text-sm">
                        <th class="px-4 py-2 border-b border-l border-t border-gray-200 rounded-tl-lg">No</th>
                        <th class="px-4 py-2 border-b border-t border-gray-200">Judul</th>
                        {{-- <th class="px-4 py-2 border-b border-t border-gray-200">Kategori</th> --}}
                        <th class="px-4 py-2 border-b border-t border-gray-200">Harga</th>
                        <th class="px-4 py-2 border-b border-t border-gray-200">Total Peserta</th>
                        <th class="px-4 py-2 border-b border-t border-r border-gray-200 rounded-tr-lg">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm">
                    @if($courses->isEmpty())
                        <tr>
                            <td colspan="5" class="text-center py-2 text-sm text-gray-600 border-b border-l border-r border-gray-200">Data tidak tersedia</td>
                        </tr>
                    @endif
                    @foreach ($courses as $index => $course)
                    <tr class="bg-white hover:bg-gray-50 text-sm">
                        <!-- Kolom No -->
                        <td class="px-4 py-2 text-center border-b border-l border-gray-200">{{ $index + 1 + ($courses->currentPage() - 1) * $courses->perPage() }}</td>
                        <td class="px-4 py-2 border-b border-gray-200 capitalize">{{ Str::limit($course->title, 40) }}</td>
                        {{-- <td class="px-4 py-2 border-b border-gray-200 capitalize">{{ Str::limit($course->category->name ?? '-', 40) }}</td> --}}
                        <td class="px-4 py-2 text-center border-b border-gray-200">{{ $course->price ? 'Rp. ' . number_format($course->price, 0, ',', '.') : 'Gratis' }}</td>
                        <td class="px-4 py-2 border-b border-gray-200 capitalize text-center">{{ $course->total_peserta }}</td>
                        <td class="py-2 px-4 text-center border-b  border-r border-gray-200">
                            <div class="flex items-center justify-center space-x-3 overflow-x-auto scrollbar-hide">
                                <!-- Tombol Chat -->
                                <a href="{{ $course->chat ? route('chat.mentor', ['slug' => $course->slug]) : '#' }}" class="text-white bg-green-300 p-1 rounded-md hover:bg-green-200 {{ !$course->chat ? 'cursor-not-allowed opacity-50' : '' }}" id="chatButton" {{ !$course->chat ? 'disabled' : '' }} title="{{ !$course->chat ? 'Chat Tidak Aktif' : 'Chat Aktif' }}">
                                     <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" fill="currentColor" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                         <path d="M88.2 309.1c9.8-18.3 6.8-40.8-7.5-55.8C59.4 230.9 48 204 48 176c0-63.5 63.8-128 160-128s160 64.5 160 128s-63.8 128-160 128c-13.1 0-25.8-1.3-37.8-3.6c-10.4-2-21.2-.6-30.7 4.2c-4.1 2.1-8.3 4.1-12.6 6c-16 7.2-32.9 13.5-49.9 18c2.8-4.6 5.4-9.1 7.9-13.6c1.1-1.9 2.2-3.9 3.2-5.9zM208 352c114.9 0 208-78.8 208-176S322.9 0 208 0S0 78.8 0 176c0 41.8 17.2 80.1 45.9 110.3c-.9 1.7-1.9 3.5-2.8 5.1c-10.3 18.4-22.3 36.5-36.6 52.1c-6.6 7-8.3 17.2-4.6 25.9C5.8 378.3 14.4 384 24 384c43 0 86.5-13.3 122.7-29.7c4.8-2.2 9.6-4.5 14.2-6.8c15.1 3 30.9 4.5 47.1 4.5zM432 480c16.2 0 31.9-1.6 47.1-4.5c4.6 2.3 9.4 4.6 14.2 6.8C529.5 498.7 573 512 616 512c9.6 0 18.2-5.7 22-14.5c3.8-8.8 2-19-4.6-25.9c-14.2-15.6-26.2-33.7-36.6-52.1c-.9-1.7-1.9-3.4-2.8-5.1C622.8 384.1 640 345.8 640 304c0-94.4-87.9-171.5-198.2-175.8c4.1 15.2 6.2 31.2 6.2 47.8l0 .6c87.2 6.7 144 67.5 144 127.4c0 28-11.4 54.9-32.7 77.2c-14.3 15-17.3 37.6-7.5 55.8c1.1 2 2.2 4 3.2 5.9c2.5 4.5 5.2 9 7.9 13.6c-17-4.5-33.9-10.7-49.9-18c-4.3-1.9-8.5-3.9-12.6-6c-9.5-4.8-20.3-6.2-30.7-4.2c-12.1 2.4-24.8 3.6-37.8 3.6c-61.7 0-110-26.5-136.8-62.3c-16 5.4-32.8 9.4-50 11.8C279 439.8 350 480 432 480z"/>
                                     </svg>
                                </a>

                                <!-- Tombol Lihat Detail -->
                                <a href="{{ route('courses.show', $course->slug) }}" class="text-white bg-sky-300 p-1 rounded-md hover:bg-sky-200" title="Lihat">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                </a>

                                <!-- Tombol Edit -->
                                <a href="{{ route('courses.edit', $course->slug) }}" class="text-white bg-yellow-300 p-1 rounded-md hover:bg-yellow-200" title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>
                                </a>

                                <!-- Form hapus kursus -->
                                <form action="{{ route('courses.destroy', $course->slug) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn-delete text-white bg-red-400 p-1 rounded-md hover:bg-red-300" title="Hapus">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
        <!-- Tampilkan Pagination -->
        <div class="mt-4">
            {{ $courses->links() }}
        </div>
    </div>
</div>

<script>
    // Mengatur disable button chat jika tidak tersedia
    document.addEventListener('DOMContentLoaded', function() {
        const chatButton = document.getElementById('chatButton');

        if (chatButton && chatButton.disabled) {
            chatButton.addEventListener('click', function(event) {
            event.preventDefault(); // Mencegah aksi klik
        });
        }
    });
</script>
@endsection
