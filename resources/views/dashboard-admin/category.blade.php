@extends('layouts.dashboard-admin')
@section('title', 'Kategori')
@section('content')
<div class="container mx-auto bg-white rounded-lg p-5 border border-gray-200">
    <!-- Tombol Tambah Kategori -->
    <div class="mb-6 p-1 flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0 md:space-x-4">
        <!-- Tombol untuk menampilkan kursus -->
        <!-- <button id="showCoursesButton" class="bg-sky-300 shadow-md text-white px-2 py-2 rounded-md font-semibold hover:bg-sky-200 flex items-center space-x-2"> -->
            <!-- Gambar Ikon -->
            <!-- <img id="toggleIcon" class="w-5 h-5" style="filter: invert(1);" src="https://img.icons8.com/ios-glyphs/30/fine-print--v1.png" alt="fine-print--v1" /> -->
            <!-- Teks Tombol -->
            <!-- <span id="buttonText">Tampilkan Semua Kursus</span> -->
        <!-- </button> -->
        <form action="{{ route('categories.index') }}" method="GET" class="w-full md:max-w-xs">
                <label for="search" class="mb-2 text-sm font-medium text-gray-900 sr-only">Cari</label>
                    <div class="flex items-center border border-gray-300 rounded-lg bg-white">
                        <svg class="w-4 h-4 text-gray-500 ml-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                        </svg>
                        <input type="search" name="search" id="search" 
                            class="block w-full p-2 pl-2 text-sm text-gray-700 border-0 rounded-lg focus:border-sky-400 focus:outline-none" 
                            placeholder="Cari Kategori..." value="{{ request('search') }}" />
                    </div>
        </form>
    
        <!-- Tambah Kategori -->
        <a id="addCategoryButton" href="{{ route('categories.create') }}" class="inline-flex shadow-md shadow-blue-100 hover:shadow-none items-center space-x-2 text-white bg-blue-400 hover:bg-blue-300 font-semibold py-2 px-4 rounded-md">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            <span class="text-sm">Tambah Kategori</span>
        </a>
    </div>    

    <!-- Tabel Kategori -->
    <div id="categoriesTable" class="overflow-hidden overflow-x-auto w-full">
        <div class="min-w-full w-64">
        <table class="min-w-full border-separate border-spacing-0">
            <thead>
                <tr class="bg-gray-100 text-gray-600 text-sm">
                    <th class="py-2 px-2 text-center text-gray-600 border-b border-l border-t border-gray-200 rounded-tl-lg">No</th>
                    <th class="py-2 px-2 text-center text-gray-600 border-b border-t border-gray-200">Nama Kategori</th>
                    <th class="py-2 px-2 text-center text-gray-600 border-b border-t border-r border-gray-200 rounded-tr-lg">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @php
                $startNumber = ($categories->currentPage() - 1) * $categories->perPage() + 1;
            @endphp
                    @foreach($categories as $index => $category)
                        <tr class="bg-white hover:bg-gray-50 user-row border-b">
                            <td class="px-2 py-3 text-center text-gray-600  border-b border-l border-gray-200 text-sm">{{ $startNumber + $index }}</td>
                            <td class="py-3 px-2 text-gray-600 text-sm border-b border-gray-200">{{ $category->name }}</td>
                            <td class="py-3 px-2 flex items-center justify-center space-x-6 border-r border-b border-gray-200">
                                <!-- Tombol Lihat Detail -->
                                <a href="{{ route('categories.show', $category->id) }}" class="text-white bg-sky-300 p-1 rounded-md hover:bg-sky-200" title="Lihat">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                </a>
                                <!-- Tombol Edit -->
                                <a href="{{ route('categories.edit', $category->id) }}" class="text-white bg-yellow-300 p-1 rounded-md  hover:bg-yellow-200" title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>
                                </a>
                                <!-- Tombol Hapus -->
                                <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete text-white bg-red-400 p-1 mt-1 rounded-md hover:bg-red-300" title="Hapus">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    @if($categories->isEmpty())
                    <tr>
                        <td colspan="3" class="px-2 py-2 text-center text-sm text-gray-600 border-b border-l border-r border-gray-200">Data Kategori tidak ditemukan</td>
                    </tr>
                    @endif
            </tbody>
        </table>
        </div>
        <!-- Pagination untuk kursus -->
        <div class="mt-4">
            {{ $categories->links() }} 
        </div>
    </div>

    <!-- Daftar Kursus (Awalnya disembunyikan) -->
    <div id="coursesList" class="hidden mt-6">
        <!-- Wrapper responsif -->
        <div class="overflow-x-auto w-full">
            <table class="min-w-full border-collapse">
                <thead>
                    <tr class="bg-sky-100 text-gray-700 text-sm">
                        <th class="py-2 px-2 text-center text-gray-700 border-b border-l border-gray-200">No</th>
                        <th class="py-2 px-2 text-center text-gray-700 border-b border-gray-200">Kursus</th>
                        <th class="py-2 px-2 text-center text-gray-700 border-b border-r border-gray-200">Kategori</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($courses as $index => $course)
                    <tr class="bg-white hover:bg-sky-50 user-row border-b">
                        <td class="px-2 py-3 text-center text-gray-600 text-sm border-b border-l border-gray-200">{{ $index + 1 }}</td>
                        <td class="py-3 px-2 text-gray-600 text-sm border-b border-gray-200">{{ $course->title }}</td>
                        <td class="py-3 px-2 text-gray-600 text-sm border-b border-r border-gray-200">{{ $course->category }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination untuk kursus -->
        <div class="mt-4">
            {{ $courses->links() }} 
        </div>
        </div>
</div>

<script>
    const showCoursesButton = document.getElementById('showCoursesButton');
    const coursesList = document.getElementById('coursesList');
    const categoriesTable = document.getElementById('categoriesTable');
    const buttonText = document.getElementById('buttonText');
    const toggleIcon = document.getElementById('toggleIcon');
    const addCategoryButton = document.getElementById('addCategoryButton'); // Tombol Tambah Kategori

    // Menangani perubahan tampilan saat tombol diklik
    showCoursesButton.addEventListener('click', function () {
        if (coursesList.classList.contains('hidden')) {
            // Tampilkan kursus, sembunyikan kategori, sembunyikan tombol Tambah Kategori
            coursesList.classList.remove('hidden');
            categoriesTable.classList.add('hidden');
            addCategoryButton.classList.remove('hidden'); // tetap tampilkan tombol tambah kkategori
            buttonText.innerText = 'Tampilkan Semua Kategori';
            toggleIcon.src = 'https://img.icons8.com/ios-glyphs/30/fine-print--v1.png'; // Ikon untuk kategori
        } else {
            // Tampilkan kategori, sembunyikan kursus, tampilkan tombol Tambah Kategori
            coursesList.classList.add('hidden');
            categoriesTable.classList.remove('hidden');
            addCategoryButton.classList.remove('hidden'); // Tampilkan tombol
            buttonText.innerText = 'Tampilkan Semua Kursus';
            toggleIcon.src = 'https://img.icons8.com/ios-glyphs/30/fine-print--v1.png'; // Ikon untuk kursus
        }
    });

    // Menambahkan event listener untuk menangani perubahan halaman setelah klik pagination
    document.querySelectorAll('.pagination a').forEach(function (link) {
        link.addEventListener('click', function (event) {
            event.preventDefault();
            const url = this.href;

            // Panggil AJAX atau reload konten untuk memuat ulang tabel sesuai dengan halaman yang dipilih
            fetch(url)
                .then(response => response.text())
                .then(data => {
                    // Ganti konten tabel kursus dan kategori berdasarkan data baru
                    document.getElementById('categoriesTable').innerHTML = data.match(/<table[^>]*>([\s\S]*?)<\/table>/)[0];
                    document.getElementById('coursesList').innerHTML = data.match(/<table[^>]*>([\s\S]*?)<\/table>/)[1];

                    // Menangani visibilitas setelah memuat konten baru
                    handlePagination();
                })
                .catch(error => console.error('Error:', error));
        });
    });

    // Fungsi untuk menangani visibilitas elemen
    function handlePagination() {
        if (coursesList.classList.contains('hidden')) {
            // Sembunyikan kursus, tampilkan kategori
            coursesList.classList.add('hidden');
            categoriesTable.classList.remove('hidden');
            addCategoryButton.classList.remove('hidden'); // Tampilkan tombol
        } else {
            // Tampilkan kursus, sembunyikan kategori
            coursesList.classList.remove('hidden');
            categoriesTable.classList.add('hidden');
            addCategoryButton.classList.add('hidden'); // Sembunyikan tombol
        }
    }
</script>
@endsection
