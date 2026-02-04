@extends('layouts.dashboard-affiliate')
@section('title', 'Tugas Akhir')
@section('content')
    <div class="bg-white border border-gray-200 rounded-lg px-6 shadow-sm pb-2">
    <form action="{{ route('finaltaskstore-user') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <!-- Judul Halaman -->
        <h2 class="md:text-xl text-md font-semibold text-gray-700 text-center w-full border-b-2 border-gray-300 pb-2">Tambah Tugas Akhir</h2>

        <input type="hidden" name="final_task_id" value="{{ $finalTask->id }}">
        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
        <input type="hidden" name="course_id" value="{{ $course->id }}"> <!-- Pastikan course_id ada di view -->
        <input type="hidden" name="certificate_status" value="pending">

        <div>
            <label class="block font-medium mb-1 text-gray-700 text-sm">Judul Tugas</label>
            <input type="text" name="title" id="title" class="w-full text-gray-700 text-sm border border-gray-200 rounded focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400 p-2 @error('title') border-red-500 @enderror" placeholder="Masukkan judul tugas akhir">
            @error('title')
                <span class="text-red-500 text-sm" id="title-error">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label class="block font-medium mb-1 text-gray-700 text-sm">Deskripsi Tugas</label>
            <textarea name="description" id="description" class="w-full p-2 text-gray-700 text-sm border border-gray-200 rounded focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400 @error('description') border-red-500 @enderror" placeholder="Masukkan deskripsi tugas akhir"></textarea>
            @error('description')
                <span class="text-red-500 text-sm" id="description-error">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label class="block font-medium mb-1 text-gray-700 text-sm">Upload Foto Tugas</label>
            <input type="file" name="photo[]" accept="image/*" multiple id="photo-input" class="block w-full p-2 text-sm text-gray-700 border rounded focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400 @error('photo') border-red-500 @enderror">
            <small class="text-gray-600 block">*Format gambar yang diperbolehkan: jpg, png, jpeg</small>
            @error('photo')
                <span class="text-red-500 text-sm block" id="photo-error">{{ $message }}</span>
            @enderror
        </div>

        <!-- Tempat untuk menampilkan path foto yang dipilih -->
        <div id="photo-list" class="flex flex-wrap gap-4 mt-4"></div>

        <div class="flex space-x-2 justify-end mr-1 mb-2">
            <a href="{{ route('study-affiliate', ['slug' => $course->slug]) }}" class="bg-red-400 hover:bg-red-300 text-white text-sm py-2 px-4 rounded">
                Batal
            </a>
            <button type="submit" class="bg-blue-400 text-white px-4 py-2 rounded hover:bg-blue-300 text-sm">
                Kirim
            </button>
        </div>
    </form>
    </div>

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

        // remove style error
        document.addEventListener('DOMContentLoaded', function () {
            const inputs = document.querySelectorAll('input, textarea'); // Memilih input dan textarea
            inputs.forEach(input => {
                input.addEventListener('input', function () { // Memperbaiki event listener
                    removeErrorStyles(input.id);
                });
            });
        });

        // remove style error validasi
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

    // pilih file foto lebih dari 1
    const selectedFiles = [];

    // manipulasi dom untuk jumlah file foto jika ada yg dihapus
    document.getElementById('photo-input').addEventListener('change', function(event) {
        const fileList = Array.from(event.target.files);

        selectedFiles.push(...fileList);

        // Update kembali input.files agar semua file tersimpan di dalam form
        const dataTransfer = new DataTransfer();
        selectedFiles.forEach(file => dataTransfer.items.add(file));
        event.target.files = dataTransfer.files;

        renderPhotos();
    });

    // function untuk render foto yg diinput, juga untuk menampilkan preview file foto dan style nya
    function renderPhotos() {
        const photoList = document.getElementById('photo-list');
        photoList.innerHTML = '';

        selectedFiles.forEach((file, index) => {
            const reader = new FileReader();

            reader.onload = function(e) {
                const container = document.createElement('div');
                container.className = 'relative w-40 h-40 border rounded flex items-center justify-center bg-gray-100 overflow-hidden';

                const deleteButton = document.createElement('button');
                deleteButton.innerHTML = '✕';
                deleteButton.className = 'absolute top-1 right-1 bg-red-500 text-white text-xs rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-700';

                deleteButton.onclick = function() {
                    selectedFiles.splice(index, 1); // Hapus dari array

                    // Update input.files
                    const dataTransfer = new DataTransfer();
                    selectedFiles.forEach(file => dataTransfer.items.add(file));
                    document.getElementById('photo-input').files = dataTransfer.files;

                    renderPhotos(); // Render ulang
                };

                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'max-w-full max-h-full object-contain';

                container.appendChild(deleteButton);
                container.appendChild(img);
                photoList.appendChild(container);
            };

            reader.readAsDataURL(file);
        });
    }
    </script>
@endpush
