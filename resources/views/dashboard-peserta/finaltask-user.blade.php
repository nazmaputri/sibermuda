@extends('layouts.dashboard-peserta')
@section('title', 'Tugas Akhir')
@section('content')
    <div class="bg-white border border-gray-200 rounded-lg px-6 shadow-sm pb-2">
    <form action="{{ route('finaltaskstore-user') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <!-- Judul Halaman -->
        <h2 class="text-xl font-semibold text-gray-700 text-center w-full border-b-2 border-gray-300 pb-2">Tambah Tugas Akhir</h2>

        <input type="hidden" name="final_task_id" value="{{ $finalTask->id }}">
        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
        <input type="hidden" name="course_id" value="{{ $course->id }}"> <!-- Pastikan course_id ada di view -->
        <input type="hidden" name="certificate_status" value="pending">

        <div>
            <label class="block font-semibold mb-1 text-gray-700">Judul Tugas</label>
            <input type="text" name="title" class="w-full text-gray-600 border border-gray-200 rounded-md focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400 p-2 @error('title') border-red-500 @enderror">
            @error('title')
                <span class="text-red-500 text-sm" id="title-error">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label class="block font-semibold mb-1 text-gray-700">Deskripsi Tugas</label>
            <textarea name="description" id="description" class="w-full p-2 text-gray-600 border border-gray-200 rounded-md focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400"></textarea>
        </div>

        <div>
            <label class="block font-semibold mb-1 text-gray-700">Upload Foto Tugas (Opsional)</label>
            <input type="file" name="photo" accept="image/*" class="block w-full p-2 text-sm text-gray-700 border rounded focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400">
        </div>

        <div class="flex justify-end mr-1 mb-2">
            <button type="submit" class="bg-blue-400 text-white px-4 py-2 rounded hover:bg-blue-300 text-sm">
                Kirim Tugas Akhir
            </button>
        </div>
    </form>
    </div>

    <!-- {{-- Jika ada tugas yang sudah diupload --}}
    @if($finalTaskUser = Auth::user()->finalTaskUser->first()) 
        <h3 class="mt-5">Tugas Akhir yang Diupload</h3>
        <h4>{{ $finalTaskUser->title }}</h4>
        <p>{!! $finalTaskUser->description !!}</p> {{-- Tampilkan deskripsi dengan HTML --}}
        @if($finalTaskUser->photo)
            <img src="{{ asset('storage/'.$finalTaskUser->photo) }}" alt="Foto Tugas" class="mt-2">
        @endif
    @endif -->

@endsection

@push('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.css" rel="stylesheet">
@endpush

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.js"></script>
    <!-- tambahin class summernote di class descriptionnya kalau mau pakai kayak word -->
    <script>
        // $(document).ready(function () {
        //     $('#description').summernote({
        //         placeholder: 'Tulis deskripsi tugas akhir kamu...',
        //         tabsize: 2,
        //         height: 250,
        //         toolbar: [
        //             ['style', ['bold', 'italic', 'underline', 'clear']],
        //             ['font', ['strikethrough', 'superscript', 'subscript']],
        //             ['fontsize', ['fontsize']],
        //             ['color', ['color']],
        //             ['paragraph', ['ul', 'ol', 'paragraph']],
        //             ['height', ['height']],
        //             ['align', ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull']],
        //             ['insert', ['link', 'picture']],
        //             ['view', ['fullscreen', 'codeview', 'help']]
        //         ],
        //         callbacks: {
        //             onInit: function () {
        //                 const isEmpty = $('#description').summernote('isEmpty');
        //                 if (!isEmpty) {
        //                     $('.note-placeholder').hide(); // Sembunyikan placeholder saat ada konten
        //                 }
        //             },
        //             onChange: function (contents) {
        //                 if (contents.trim() === '') {
        //                     $('.note-placeholder').show(); // Menampilkan placeholder jika textarea kosong
        //                 } else {
        //                     $('.note-placeholder').hide(); // Menyembunyikan placeholder jika ada konten
        //                 }
        //             }
        //         }
        //     });

        //     $('form').on('submit', function () {
        //         var markupStr = $('#description').summernote('code');
        //         $('textarea[name="description"]').val(markupStr);
        //     });
        // });

        function removeErrorStyles(inputId) {
        const input = document.getElementById(inputId);
        if (input) {
            input.classList.remove('border-red-500'); // Menghapus border merah
            const errorMessage = document.getElementById(inputId + '-error');
            if (errorMessage) {
                errorMessage.style.display = 'none'; // Menyembunyikan pesan error
            }
        }
    }
    </script>
@endpush
