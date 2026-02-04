@extends('layouts.dashboard-admin')
@section('title', 'Berita')
@section('content')
<div class="container mx-auto bg-white rounded-lg p-5 border border-gray-200">
    <!-- Tombol Tambah Berita -->
    <div class="mb-6 p-1 flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0 md:space-x-4">
        <form action="{{ route('admin.news.index') }}" method="GET" class="w-full md:max-w-xs">
                <label for="search" class="mb-2 text-sm font-medium text-gray-900 sr-only">Cari</label>
                    <div class="flex items-center border border-gray-300 rounded-lg bg-white">
                        <svg class="w-4 h-4 text-gray-500 ml-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                        </svg>
                        <input type="search" name="search" id="search"
                            class="block w-full p-2 pl-2 text-sm text-gray-700 border-0 rounded-lg focus:border-sky-400 focus:outline-none"
                            placeholder="Cari Berita..." value="{{ request('search') }}" />
                    </div>
        </form>

        <!-- Tambah Berita -->
        <a id="addNewsButton" href="{{ route('admin.news.create') }}" class="inline-flex shadow-md shadow-blue-100 hover:shadow-none items-center space-x-2 text-white bg-blue-400 hover:bg-blue-300 font-semibold py-2 px-4 rounded-md">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            <span class="text-sm">Tambah Berita</span>
        </a>
    </div>

    <!-- Tabel Berita -->
    <div id="newsTable" class="overflow-hidden overflow-x-auto w-full">
        <div class="min-w-full w-64">
        <table class="min-w-full border-separate border-spacing-0">
            <thead>
                <tr class="bg-gray-100 text-gray-600 text-sm">
                    <th class="py-2 px-2 text-center text-gray-600 border-b border-l border-t border-gray-200 rounded-tl-lg">No</th>
                    <th class="py-2 px-2 text-left text-gray-600 border-b border-t border-gray-200">Judul Berita</th>
                    <th class="py-2 px-2 text-center text-gray-600 border-b border-t border-gray-200">Kategori</th>
                    <th class="py-2 px-2 text-center text-gray-600 border-b border-t border-gray-200">Tanggal Publish</th>
                    <th class="py-2 px-2 text-center text-gray-600 border-b border-t border-gray-200">Penulis</th>
                    <th class="py-2 px-2 text-center text-gray-600 border-b border-t border-gray-200">Views</th>
                    <th class="py-2 px-2 text-center text-gray-600 border-b border-t border-r border-gray-200 rounded-tr-lg">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @php
                $currentPage = request('page', 1);
                $perPage = 10;
                $startNumber = ($currentPage - 1) * $perPage + 1;
            @endphp
                    @forelse($news as $index => $item)
                        <tr class="bg-white hover:bg-gray-50 user-row border-b">
                            <td class="px-2 py-3 text-center text-gray-600 border-b border-l border-gray-200 text-sm">{{ $startNumber + $index }}</td>
                            <td class="py-3 px-2 text-gray-600 text-sm border-b border-gray-200">
                                <div class="flex items-start gap-3">
                                    <img
                                        src="{{ Storage::url($item->image_path) }}"
                                        alt="{{ $item->title }}"
                                        class="w-16 h-12 object-cover rounded"
                                    />
                                    <span class="line-clamp-2">{{ $item->title }}</span>
                                </div>
                            </td>
                            <td class="py-3 px-2 text-center text-gray-600 text-sm border-b border-gray-200">
                                <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-semibold">
                                    {{ $item->category }}
                                </span>
                            </td>
                            <td class="py-3 px-2 text-center text-gray-600 text-sm border-b border-gray-200">
                                {{ $item->published_at->format('d M Y') }}
                            </td>
                            <td class="py-3 px-2 text-center text-gray-600 text-sm border-b border-gray-200">
                                {{ $item->author }}
                            </td>
                            <td class="py-3 px-2 text-center text-gray-600 text-sm border-b border-gray-200">
                                <div class="flex items-center justify-center gap-1">
                                    <svg class="w-4 h-4 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ number_format($item->views) }}
                                </div>
                            </td>
                            <td class="py-3 px-2 text-center border-r border-b border-gray-200">
                                <div class="flex items-center justify-center space-x-2">
                                    <!-- Tombol Lihat Detail -->
                                    <a href="{{ url('admin/news/' . $item->slug) }}" target="_blank" class="text-white bg-sky-300 p-1 rounded-md hover:bg-sky-200" title="Lihat">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        </svg>
                                    </a>
                                    <!-- Tombol Edit -->
                                    <a href="{{ route('admin.news.edit', $item->id) }}" class="text-white bg-yellow-300 p-1 rounded-md hover:bg-yellow-200" title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                        </svg>
                                    </a>
                                    <!-- Tombol Hapus -->
                                    <form action="{{ route('admin.news.destroy', $item->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-delete text-white bg-red-400 p-1 rounded-md hover:bg-red-300" title="Hapus">
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
                        <td colspan="7" class="px-2 py-8 text-center text-sm text-gray-600 border-b border-l border-r border-gray-200">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-16 h-16 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                                </svg>
                                <p class="text-gray-500">Data Berita tidak ditemukan</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
            </tbody>
        </table>
        </div>
    </div>

     <!-- Pagination untuk berita -->
     {{-- <div class="mt-4">
        {{ $news->links() }}
    </div> --}}
</div>

<script>
    // Konfirmasi hapus berita
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function(e) {
            if (!confirm('Apakah Anda yakin ingin menghapus berita ini?')) {
                e.preventDefault();
            }
        });
    });
</script>

<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endsection
