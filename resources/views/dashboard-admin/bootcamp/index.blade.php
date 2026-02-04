@extends('layouts.dashboard-admin')
@section('title', 'Bootcamp')
@section('content')
<div class="container mx-auto bg-white rounded-lg p-5 border border-gray-200">
    <!-- Alert Success -->
    @if(session('success'))
    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
        {{ session('success') }}
    </div>
    @endif

    <!-- Header Section -->
    <div class="mb-6 p-1 flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0 md:space-x-4">
        <!-- Search Form -->
        <form action="{{ route('admin.bootcamp.index') }}" method="GET" class="w-full md:max-w-xs">
            <label for="search" class="mb-2 text-sm font-medium text-gray-900 sr-only">Cari</label>
            <div class="flex items-center border border-gray-300 rounded-lg bg-white">
                <svg class="w-4 h-4 text-gray-500 ml-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                </svg>
                <input type="search" name="search" id="search"
                    class="block w-full p-2 pl-2 text-sm text-gray-700 border-0 rounded-lg focus:border-sky-400 focus:outline-none"
                    placeholder="Cari Bootcamp..." value="{{ request('search') }}" />
            </div>
        </form>

        <!-- Tambah Bootcamp Button -->
        <a href="{{ route('admin.bootcamp.create') }}" class="inline-flex shadow-md shadow-blue-100 hover:shadow-none items-center space-x-2 text-white bg-blue-400 hover:bg-blue-300 font-semibold py-2 px-4 rounded-md">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            <span class="text-sm">Tambah Bootcamp</span>
        </a>
    </div>

    <!-- Table Bootcamp -->
    <div class="overflow-hidden overflow-x-auto w-full">
        <div class="min-w-full">
            <table class="min-w-full border-separate border-spacing-0">
                <thead>
                    <tr class="bg-gray-100 text-gray-600 text-sm">
                        <th class="py-2 px-2 text-center border-b border-l border-t border-gray-200 rounded-tl-lg">No</th>
                        <th class="py-2 px-2 text-center border-b border-t border-gray-200">Gambar</th>
                        <th class="py-2 px-2 text-left border-b border-t border-gray-200">Judul Bootcamp</th>
                        <th class="py-2 px-2 text-center border-b border-t border-gray-200">Durasi</th>
                        <th class="py-2 px-2 text-center border-b border-t border-gray-200">Level</th>
                        <th class="py-2 px-2 text-center border-b border-t border-gray-200">Harga</th>
                        <th class="py-2 px-2 text-center border-b border-t border-gray-200">Status</th>
                        <th class="py-2 px-2 text-center border-b border-t border-r border-gray-200 rounded-tr-lg">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $startNumber = ($bootcamps->currentPage() - 1) * $bootcamps->perPage() + 1;
                    @endphp
                    @forelse($bootcamps as $index => $bootcamp)
                    <tr class="bg-white hover:bg-gray-50 border-b">
                        <td class="px-2 py-3 text-center text-gray-600 border-b border-l border-gray-200 text-sm">
                            {{ $startNumber + $index }}
                        </td>
                        <td class="px-2 py-3 text-center border-b border-gray-200">
                            @if($bootcamp->image)
                                <img src="{{ asset('storage/' . $bootcamp->image) }}" alt="{{ $bootcamp->title }}" class="w-16 h-16 object-cover rounded-md mx-auto">
                            @else
                                <div class="w-16 h-16 bg-gray-200 rounded-md mx-auto flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-gray-400">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                    </svg>
                                </div>
                            @endif
                        </td>
                        <td class="py-3 px-2 text-gray-600 text-sm border-b border-gray-200">
                            {{ Str::limit($bootcamp->title, 50, '...') }}
                        </td>
                        <td class="py-3 px-2 text-center text-gray-600 text-sm border-b border-gray-200">
                            {{ $bootcamp->duration }}
                        </td>
                        <td class="py-3 px-2 text-center text-gray-600 text-sm border-b border-gray-200">
                            <span class="px-2 py-1 text-xs rounded-full bg-purple-100 text-purple-600">
                                {{ $bootcamp->level }}
                            </span>
                        </td>
                        <td class="py-3 px-2 text-center text-gray-600 text-sm border-b border-gray-200">
                            <div class="flex flex-col items-center">
                                @if($bootcamp->discount_price)
                                    <span class="line-through text-gray-400 text-xs">{{ $bootcamp->price }}</span>
                                    <span class="text-green-600 font-semibold">{{ $bootcamp->discount_price }}</span>
                                @else
                                    <span class="font-semibold">{{ $bootcamp->price }}</span>
                                @endif
                            </div>
                        </td>
                        <td class="py-3 px-2 text-center border-b border-gray-200">
                            @if($bootcamp->is_active)
                                <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-600">Aktif</span>
                            @else
                                <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-600">Nonaktif</span>
                            @endif
                        </td>
                        <td class="py-3 px-2 text-center border-r border-b border-gray-200">
                            <div class="flex items-center justify-center space-x-2">
                                <!-- Tombol Lihat Detail -->
                                <a href="{{ route('admin.bootcamp.show', $bootcamp->id) }}" class="text-white bg-sky-300 p-1 rounded-md hover:bg-sky-200" title="Lihat">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                </a>
                                <!-- Tombol Edit -->
                                <a href="{{ route('admin.bootcamp.edit', $bootcamp->id) }}" class="text-white bg-yellow-300 p-1 rounded-md hover:bg-yellow-200" title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>
                                </a>
                                <!-- Tombol Hapus -->
                                <form action="{{ route('admin.bootcamp.destroy', $bootcamp->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus bootcamp ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-white bg-red-400 p-1 rounded-md hover:bg-red-300" title="Hapus">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-2 py-4 text-center text-sm text-gray-600 border-b border-l border-r border-gray-200">
                            Data Bootcamp tidak ditemukan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $bootcamps->links() }}
    </div>
</div>
@endsection
