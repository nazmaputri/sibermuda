@extends('layouts.dashboard-mentor')

@section('title', 'Tambah Tugas Akhir')

@section('content')
<div class="container mx-auto">
    <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200">
        <!-- Judul Halaman -->
        <h2 class="text-lg font-semibold text-gray-700 text-center w-full border-b-2 border-gray-300 pb-2">Tambah Tugas Akhir</h2>

        <form action="{{ route('finaltask.store', ['courseId' => $courseId]) }}" method="POST" class="space-y-6">
            @csrf
            <input type="hidden" name="course_id" value="{{ $courseId }}">

            <!-- Input untuk Judul -->
            <div>
                <label for="title" class="block text-gray-700 font-medium mb-2">Judul Tugas Akhir</label>
                <input type="text" name="title" id="title"
                    class="w-full p-2 border rounded focus:outline-none text-sm focus:ring-1 focus:ring-gray-400 focus:border-gray-400 text-gray-700 @error('title') border-red-500 @enderror"
                    placeholder="Masukkan judul tugas akhir" value="{{ old('title') }}">
                @error('title')
                    <div class="text-red-700 text-sm mt-1" id="error-title">{{ $message }}</div>
                @enderror
            </div>

            <!-- Input untuk Deskripsi -->
            <div>
                <label for="description" class="block text-gray-700 font-medium mb-2">Deskripsi</label>
                <textarea name="description" id="description" rows="5"
                    class="w-full p-2 border rounded focus:outline-none text-sm focus:ring-1 focus:ring-gray-400 focus:border-gray-400 text-gray-700 @error('description') border-red-500 @enderror"
                    placeholder="Masukkan deskripsi tugas akhir">{{ old('description') }}</textarea>
                @error('description')
                    <div class="text-red-600 text-sm mt-1" id="error-description">{{ $message }}</div>
                @enderror
            </div>

            <!-- Tombol Submit -->
            <div class="mt-6 flex justify-end space-x-2">
                <a href="{{ route('courses.show', ['course' => $course->slug]) }}"
                    class="bg-red-400 hover:bg-red-300 text-white font-medium py-2 px-4 rounded-md">
                    Batal
                </a>
                <button type="submit"
                    class="bg-sky-400 hover:bg-sky-300 text-white font-medium py-2 px-4 rounded-md">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const inputs = document.querySelectorAll('input, textarea');
        inputs.forEach(input => {
            input.addEventListener('input', function () {
                if (this.classList.contains('border-red-500')) {
                    this.classList.remove('border-red-500');
                }
                const errorMessage = document.querySelector(`#error-${this.id}`);
                if (errorMessage) {
                    errorMessage.remove();
                }
            });
        });
    });
</script>
@endsection
