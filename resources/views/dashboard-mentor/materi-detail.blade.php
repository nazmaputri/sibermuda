@extends('layouts.dashboard-mentor')
@section('title', 'Materi Detail')
@section('content')
<div class="container mx-auto">

  <!-- Card Wrapper -->
    <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">

        <!-- Judul Halaman -->
        <h1 class="text-xl text-center text-gray-700 font-semibold mb-4 border-b-2 pb-2 capitalize">Detail Materi : {{ $materi->judul }}</h1>

        <!-- Detail Materi -->
        <p class="text-gray-700">{{ $materi->deskripsi ?? 'Tidak ada deskripsi' }}</p>

        <!-- Nama Kursus -->
        <p class="mt-2 text-gray-700"><span class="font-semibold">Kursus :</span> {{ $materi->course->title ?? 'Kursus tidak tersedia' }}</p>

        <!-- Video Section -->
        <div class="mt-6">
        <h2 class="text-lg font-semibold text-gray-700">Video Materi</h2>

        <!-- Check if there are videos -->
        @if ($materi->videos->isEmpty())
            <p class="text-gray-700">Tidak ada video untuk materi ini.</p>
        @else
            <ul class="mt-4 space-y-4">
            @foreach ($materi->videos as $video)
                <li class="bg-gray-100 p-4 rounded-lg shadow-sm">
                <h3 class="font-semibold text-gray-800">{{ $video->title }}</h3>
                <p class="text-gray-600">{{ $video->description ?? 'Tidak ada deskripsi video' }}</p>
                <a href="{{ $video->link }}" class="text-blue-500 hover:underline" target="_blank">Tonton Video</a>
                </li>
            @endforeach
            </ul>
        @endif
        </div>
      
    </div>

    <div class="mt-6 flex justify-end space-x-2">
        <a href="{{ route('courses.show', $course->id) }}" class="bg-sky-400 hover:bg-sky-300 text-white font-semibold py-2 px-4 rounded">
            Kembali
        </a>
    </div>   
    
</div>

<!-- Modal Popup -->
<div id="deleteModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center hidden z-[1000]">
    <div class="bg-white p-5 rounded-lg shadow-lg w-96 mx-4">
        <h2 class="text-lg text-gray-700 text-center font-semibold mb-2">Konfirmasi Hapus</h2>
        <p class="text-gray-600 text-center mb-4">Apakah Anda yakin ingin menghapus kuis ini?</p>
        <div class="flex justify-center space-x-2">
            <button onclick="closeDeleteModal()" class="px-4 py-2 bg-sky-400 text-white hover:bg-sky-300 rounded-md">Batal</button>
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-400 hover:bg-red-300  text-white rounded-md">Hapus</button>
            </form>
        </div>
    </div>
</div>

<script>
    //untuk membuka/menutup popup konfirmasi penghapusa data
    function openDeleteModal(url) {
        document.getElementById('deleteForm').action = url;
        document.getElementById('deleteModal').classList.remove('hidden');
    }
    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }
</script>

@endsection
