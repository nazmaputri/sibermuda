@extends('layouts.dashboard-admin')
@section('title', 'Data Peserta')
@section('content')
<div class="container mx-auto">
    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <div class="flex flex-col md:flex-row items-center justify-between space-y-4 mb-4">
            <!-- Search Bar -->
            <form action="{{ route('datapeserta-admin') }}" method="GET" class="w-full max-w-xs">
                <label for="search" class="mb-2 text-sm font-medium text-gray-900 sr-only">Cari</label>
                <div class="relative flex items-center">
                    <!-- Input Search -->
                    <input type="search" name="search" id="search" 
                        class="block w-full pl-4 pr-14 py-2.5 text-sm text-gray-700 border-2 border-sky-300 focus:outline-none rounded-full bg-gray-50" 
                        placeholder="Cari Peserta (Nama, Email)" value="{{ request('search') }}" />
                    <!-- Button Search -->
                    <button type="submit" 
                        class="absolute right-1 py-2.5 bg-sky-300 text-white hover:bg-sky-200 focus:ring-4 focus:outline-none focus:ring-blue-300 font-semibold rounded-full text-sm px-3 flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                        </svg>
                    </button>
                </div>
            </form>

            <div class="flex text-center justify-between">
                <!-- button tambah peserta -->
                <form action="{{ route('import.excel') }}" method="POST" enctype="multipart/form-data" class="inline-block ml-4">
                    @csrf
                    <label for="importExcel" class="cursor-pointer text-white px-4 py-2 font-semibold rounded-md bg-sky-300 hover:bg-sky-200 focus:outline-none flex items-center">
                        <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="currentColor">
                            <path d="M128 64c0-35.3 28.7-64 64-64L352 0l0 128c0 17.7 14.3 32 32 32l128 0 0 288c0 35.3-28.7 64-64 64l-256 0c-35.3 0-64-28.7-64-64l0-112 174.1 0-39 39c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0l80-80c9.4-9.4 9.4-24.6 0-33.9l-80-80c-9.4-9.4-24.6-9.4-33.9 0s-9.4 24.6 0 33.9l39 39L128 288l0-224zm0 224l0 48L24 336c-13.3 0-24-10.7-24-24s10.7-24 24-24l104 0zM512 128l-128 0L384 0 512 128z"/>
                        </svg>
                        Import
                    </label>
                    <input type="file" name="file" id="importExcel" accept=".xls,.xlsx" class="hidden" onchange="this.form.submit()">
                </form>                

                <!-- button tambah peserta -->
                <a href="{{ route('tambah-peserta') }}"  class="ml-4 text-white px-4 py-2 font-semibold rounded-md bg-sky-300 hover:bg-sky-200 focus:outline-none flex items-center">
                    <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="currentColor">
                        <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM232 344l0-64-64 0c-13.3 0-24-10.7-24-24s10.7-24 24-24l64 0 0-64c0-13.3 10.7-24 24-24s24 10.7 24 24l0 64 64 0c13.3 0 24 10.7 24 24s-10.7 24-24 24l-64 0 0 64c0 13.3-10.7 24-24 24s-24-10.7-24-24z" />
                    </svg>
                    Tambah
                </a>
            </div>
        </div>

        <!-- Tabel data peserta -->
        <div class="overflow-x-auto">
            <div class="min-w-full w-64">
            <table class="min-w-full border-collapse" id="userTable">
                <thead>
                    <tr class="bg-sky-100 text-gray-700 text-sm">
                        <th class="py-2 border-b border-l border-t border-gray-200">No</th>
                        <th class="py-2 border-b border-t border-gray-200">Nama</th>
                        <th class="py-2 border-b border-t border-gray-200">Email</th>
                        <th class="py-2 border-b border-t border-r border-gray-200">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @php
                    $startNumber = ($users->currentPage() - 1) * $users->perPage() + 1;
                @endphp
                    @foreach ($users as $index => $user)
                        <tr class="bg-white hover:bg-sky-50 user-row" data-role="{{ $user->role }}">
                            <td class="px-4 py-1 text-center text-gray-600 text-sm border-b border-l border-gray-200">{{ $startNumber + $index }}</td>
                            <td class="px-4 py-1 text-gray-600 text-sm border-b border-gray-200">{{ $user->name }}</td>
                            <td class="px-4 py-1 text-gray-600 text-sm border-b border-gray-200">{{ $user->email }}</td>
                            <td class="py-3 px-6 text-center border-b border-r border-gray-200">
                                <div class="flex items-center justify-center space-x-5">
                                    <!-- Tombol Lihat Detail -->
                                    <a href="{{ route('detaildata-peserta', ['id' => $user->id]) }}" class="text-white bg-sky-300 p-1 rounded-md hover:bg-sky-200" title="Lihat">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        </svg>
                                    </a>
                                    <!-- Tombol hapus -->
                                    <button type="button"class="text-white bg-red-400 p-1 rounded-md hover:bg-red-300 delete-button"data-user-id="{{ $user->id }}"title="Hapus">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"viewBox="0 0 24 24" stroke-width="1.5"stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                    </button>
                                </div>
                            </td>                            
                        </tr>
                    @endforeach
                    @if ($users->isEmpty())
                        <tr>
                            <td colspan="4" class="text-center text-gray-500 py-4 text-sm border-b border-l border-r border-gray-200">Belum ada materi untuk kursus ini.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
            </div>
        </div>
        <div class="pagination mt-4">
            {{ $users->links('pagination::tailwind') }}
        </div>
    </div>
</div>

<!-- Modal Konfirmasi -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white p-6 rounded-lg shadow-lg mx-4">
        <div class="flex justify-center mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-16 h-16 text-gray-600">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 5.25h.008v.008H12v-.008Z" />
            </svg>
        </div>
        <p class="text-gray-600 text-center">Apakah Anda yakin ingin menghapus pengguna ini?</p>
        <div class="mt-4 flex justify-center space-x-4">
            <button onclick="closeDeleteModal()" class="px-4 py-2 bg-red-400 hover:bg-red-300 text-white rounded-md">Batal</button>
            <button onclick="confirmDelete()" class="ml-2 px-4 py-2 bg-green-400 hover:bg-green-300 text-white rounded-md">Hapus</button>
        </div>
    </div>
</div>

<!-- Form global untuk delete -->
<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<script>
    // Buka modal dan atur form action sesuai user id
    function openDeleteModal(userId) {
        const form = document.getElementById('deleteForm');

        // Ganti dengan route milikmu jika berbeda
        const routeTemplate = `{{ route('datapeserta-admin.delete', ':id') }}`;
        const route = routeTemplate.replace(':id', userId);

        form.setAttribute('action', route);

        document.getElementById('deleteModal').classList.remove('hidden');
    }

    // Tutup modal
    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }

    // Submit form delete
    function confirmDelete() {
        document.getElementById('deleteForm').submit();
    }

    // Tambahkan event ke tombol-tombol delete
    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.delete-button');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                const userId = this.getAttribute('data-user-id');
                openDeleteModal(userId);
            });
        });
    });
</script>


@endsection
