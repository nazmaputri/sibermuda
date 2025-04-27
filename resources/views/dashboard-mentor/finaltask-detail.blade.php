@extends('layouts.dashboard-mentor')
@section('title', 'Detail Tugas Akhir')
@section('content')

<!-- button kembali -->
<div class="mb-3 flex justify-start">
    <a href="{{ route('courses.show', ['course' => $course->id]) }}" class="text-midnight font-semibold p-1 bg-white border border-gray-200 rounded-full transition-transform duration-300 ease-in-out transform hover:scale-105">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
        </svg>
    </a>
</div>

<div class="container mx-auto">
    <!-- Final Task Detail -->
    <div class="bg-white rounded-lg shadow p-6 mb-6 border border-gray-200">
        <h1 class="text-lg font-semibold text-gray-700 mb-4">Detail Tugas Akhir</h1>
        <div class="space-y-2">
            <p><span class="font-semibold text-gray-600 text-sm">Judul: {{ $finalTask->judul }}</p></span>
            <p><span class="font-semibold text-gray-600 text-sm">Deskripsi: {{ $finalTask->desc }}</p></span>
        </div>
    </div>

    <!-- Table: Peserta yang sudah mengumpulkan -->
    <div class="bg-white rounded-lg shadow p-6 mb-8 border border-gray-200">
        <h2 class="text-lg text-gray-700 font-semibold mb-4">Peserta yang Telah Mengumpulkan</h2>
        <div class="overflow-x-auto">
           <div class="min-w-full w-64">
           <table class="min-w-full border-separate border-spacing-0">
                <thead class="bg-gray-100">
                    <tr class="">
                        <th class="px-4 py-2 text-left text-sm text-gray-700 border-b border-l border-t border-gray-200 rounded-tl-lg">No</th>
                        <th class="px-4 py-2 text-left text-sm text-gray-700 border-b border-t border-gray-200">Nama</th>
                        <th class="px-4 py-2 text-left text-sm text-gray-700 border-b border-t border-gray-200">Judul</th>
                        <th class="px-4 py-2 text-left text-sm text-gray-700 border-b border-t border-gray-200">Deskripsi</th>
                        <th class="px-4 py-2 text-left text-sm text-gray-700 border-b border-t border-gray-200">Foto</th>
                        <th class="px-4 py-2 text-center text-sm text-gray-700 border-b border-r border-t border-gray-200 rounded-tr-lg">Aksi</th>
                    </tr>
                </thead>
                <tbody class="">
                @if ($submissions->isEmpty())
                    <tr>
                        <td colspan="6" class="text-center py-4 text-sm text-gray-600 border-b border-l border-r border-gray-200">Data tidak tersedia</td>
                    </tr>
                @else
                    @foreach($submissions as $index => $submission)
                    <tr class="bg-white hover:bg-gray-50">
                        <td class="px-4 py-2 text-gray-600 text-sm border-b border-l border-gray-200">{{ $index + 1 }}</td>
                        <td class="px-4 py-2 text-gray-600 text-sm border-b border-gray-200">{{ $submission->user->name }}</td>
                        <td class="px-4 py-2 text-gray-600 text-sm border-b border-gray-200">{{ $submission->title }}</td>
                        <td class="px-4 py-2 text-gray-600 text-sm border-b border-gray-200">{{ Str::limit($submission->description, 50) }}</td>
                        <td class="px-4 py-2 text-gray-600 text-sm border-b border-gray-200">
                            @if($submission->photo)
                                <img 
                                    src="{{ Storage::url($submission->photo) }}" 
                                    alt="Foto Tugas" 
                                    class="h-16 w-16 object-cover rounded cursor-pointer"
                                    onclick="showImageModal('{{ Storage::url($submission->photo) }}')"
                                />
                            @else
                                <span class="text-gray-400 text-sm">-</span>
                            @endif
                        </td>
                        <td class="px-4 py-2 text-center border-b border-r border-gray-200">
                            @if($submission->certificate_status == 'pending')
                                <form action="{{ route('final-task.confirm', $submission->id) }}" method="POST" class="flex items-center justify-center" title="Konfirmasi Sertifikat">
                                    @csrf
                                    <button type="submit"
                                        class="font-semibold p-1 rounded-md 
                                            bg-green-300 hover:bg-green-200 text-white">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" 
                                            class="w-5 h-5 text-white" fill="currentColor">
                                            <path d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"/>
                                        </svg>
                                    </button>
                                </form>
                            @elseif($submission->certificate_status == 'approved')
                                <div class="font-semibold p-1 rounded-md bg-gray-300 text-white cursor-not-allowed inline-flex items-center justify-center" title="Sudah Dikonfirmasi">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" 
                                        class="w-5 h-5 text-white" fill="currentColor">
                                        <path d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"/>
                                    </svg>
                                </div>
                            @else
                                <span class="text-gray-500">-</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
           </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="relative bg-white rounded-lg w-[90vw] h-[80vh] max-w-3xl p-4">
        <button onclick="closeImageModal()" 
                class="absolute top-2 right-2 text-gray-700 hover:text-red-500 text-2xl font-bold">
            &times;
        </button>
        <div class="w-full h-full flex items-center justify-center">
            <img id="modalImage" src="" alt="Preview Foto" class="max-w-full max-h-full object-contain rounded" />
        </div>
    </div>
</div>

<script>
    function showImageModal(imageUrl) {
        const modal = document.getElementById('imageModal');
        const modalImg = document.getElementById('modalImage');
        modalImg.src = imageUrl;
        modal.classList.remove('hidden');
    }

    function closeImageModal() {
        const modal = document.getElementById('imageModal');
        modal.classList.add('hidden');
    }

    // Tambahan: Tutup modal jika klik di luar gambar
    window.addEventListener('click', function(e) {
        const modal = document.getElementById('imageModal');
        const modalImg = document.getElementById('modalImage');
        if (e.target === modal) {
            closeImageModal();
        }
    });
</script>
@endsection