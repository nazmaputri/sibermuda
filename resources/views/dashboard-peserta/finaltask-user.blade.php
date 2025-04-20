@extends('layouts.dashboard-peserta')

@section('content')
    <form action="{{ route('finaltaskstore-user') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <input type="hidden" name="final_task_id" value="{{ $finalTask->id }}">
        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
        <input type="hidden" name="course_id" value="{{ $course->id }}"> <!-- Pastikan course_id ada di view -->
        <input type="hidden" name="certificate_status" value="pending">

        <div>
            <label class="block font-semibold mb-1">Judul Tugas</label>
            <input type="text" name="title" class="w-full border rounded p-2" required>
        </div>

        <div>
            <label class="block font-semibold mb-1">Deskripsi Tugas</label>
            <textarea name="description" id="description" class="summernote"></textarea>
        </div>

        <div>
            <label class="block font-semibold mb-1">Upload Foto Tugas (Opsional)</label>
            <input type="file" name="photo" accept="image/*" class="block">
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Upload Tugas Akhir
        </button>
    </form>

    {{-- Jika ada tugas yang sudah diupload --}}
    @if($finalTaskUser = Auth::user()->finalTaskUser->first()) 
        <h3 class="mt-5">Tugas Akhir yang Diupload</h3>
        <h4>{{ $finalTaskUser->title }}</h4>
        <p>{!! $finalTaskUser->description !!}</p> {{-- Tampilkan deskripsi dengan HTML --}}
        @if($finalTaskUser->photo)
            <img src="{{ asset('storage/'.$finalTaskUser->photo) }}" alt="Foto Tugas" class="mt-2">
        @endif
    @endif

@endsection

@push('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.css" rel="stylesheet">
@endpush

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#description').summernote({
                placeholder: 'Tulis deskripsi tugas akhir kamu...',
                tabsize: 2,
                height: 250,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['paragraph', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                    ['align', ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull']],
                    ['insert', ['link', 'picture']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ],
                callbacks: {
                    onInit: function () {
                        const isEmpty = $('#description').summernote('isEmpty');
                        if (!isEmpty) {
                            $('.note-placeholder').hide(); // Sembunyikan placeholder saat ada konten
                        }
                    },
                    onChange: function (contents) {
                        if (contents.trim() === '') {
                            $('.note-placeholder').show(); // Menampilkan placeholder jika textarea kosong
                        } else {
                            $('.note-placeholder').hide(); // Menyembunyikan placeholder jika ada konten
                        }
                    }
                }
            });

            $('form').on('submit', function () {
                var markupStr = $('#description').summernote('code');
                $('textarea[name="description"]').val(markupStr);
            });
        });
    </script>
@endpush
