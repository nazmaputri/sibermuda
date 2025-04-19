@extends('layouts.dashboard-mentor')

@section('title', 'Edit Tugas Akhir')

@section('content')
<div class="container mx-auto">
    <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200">
        <!-- Judul Halaman -->
        <h2 class="text-xl font-semibold text-gray-700 text-center w-full border-b-2 border-gray-300 pb-2">Edit Tugas Akhir</h2>

        <form action="{{ route('finaltask.update', ['course' => $course->id, 'id' => $finalTask->id]) }}" method="POST" class="space-y-6">
           @csrf
           @method('PUT') 

           <input type="hidden" name="course_id" value="{{ $course->id }}">

            <!-- Input untuk Judul -->
            <div>
                <label for="judul" class="block text-gray-700 font-bold mb-2">Judul Tugas Akhir</label>
                <input type="text" name="judul" id="judul"
                    class="w-full p-2 border rounded focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500 text-gray-600 @error('judul') border-red-500 @enderror"
                    placeholder="Masukkan judul tugas akhir" value="{{ old('judul', $finalTask->judul) }}">
                @error('judul')
                    <div class="text-red-600 text-sm mt-1" id="error-judul">{{ $message }}</div>
                @enderror
            </div>

            <!-- Input untuk Deskripsi -->
            <div>
                <label for="desc" class="block text-gray-700 font-bold mb-2">Deskripsi</label>
                <textarea name="desc" id="desc" rows="5"
                    class="w-full p-2 border rounded focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500 text-gray-600 @error('desc') border-red-500 @enderror"
                    placeholder="Masukkan deskripsi tugas akhir">{{ old('desc', $finalTask->desc) }}</textarea>
                @error('desc')
                    <div class="text-red-600 text-sm mt-1" id="error-desc">{{ $message }}</div>
                @enderror
            </div>

            <!-- Tombol Submit -->
            <div class="mt-6 flex justify-end space-x-2">
                <a href="{{ route('courses.show', ['course' => $course]) }}"
                    class="bg-red-400 hover:bg-red-300 text-white font-semibold py-2 px-4 rounded-lg">
                    Batal
                </a>
                <button type="submit"
                    class="bg-sky-400 hover:bg-sky-300 text-white font-semibold py-2 px-4 rounded-lg">
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
