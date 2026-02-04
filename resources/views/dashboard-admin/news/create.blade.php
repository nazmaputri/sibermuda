@extends('layouts.dashboard-admin')
@section('title', 'Tambah Berita')
@section('content')
<div class="container mx-auto">
    <div class="bg-white rounded-lg p-6 border border-gray-200">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Tambah Berita Baru</h2>
            <p class="text-gray-600 text-sm mt-1">Lengkapi form di bawah untuk menambahkan berita baru</p>
        </div>

        <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Title -->
            <div class="mb-4">
                <label for="title" class="block text-gray-700 font-semibold mb-2">
                    Judul Berita <span class="text-red-500">*</span>
                </label>
                <input type="text" name="title" id="title"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-transparent @error('title') border-red-500 @enderror"
                    value="{{ old('title') }}"
                    placeholder="Masukkan judul berita">
                @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Category -->
            <div class="mb-4">
                <label for="category" class="block text-gray-700 font-semibold mb-2">
                    Kategori <span class="text-red-500">*</span>
                </label>
                <select name="category" id="category"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-transparent @error('category') border-red-500 @enderror">
                    <option value="">Pilih Kategori</option>
                    <option value="Teknologi" {{ old('category') == 'Teknologi' ? 'selected' : '' }}>Teknologi</option>
                    <option value="Pendidikan" {{ old('category') == 'Pendidikan' ? 'selected' : '' }}>Pendidikan</option>
                    <option value="Bisnis" {{ old('category') == 'Bisnis' ? 'selected' : '' }}>Bisnis</option>
                    <option value="Olahraga" {{ old('category') == 'Olahraga' ? 'selected' : '' }}>Olahraga</option>
                    <option value="Hiburan" {{ old('category') == 'Hiburan' ? 'selected' : '' }}>Hiburan</option>
                </select>
                @error('category')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Author -->
            <div class="mb-4">
                <label for="author" class="block text-gray-700 font-semibold mb-2">
                    Penulis <span class="text-red-500">*</span>
                </label>
                <input type="text" name="author" id="author"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-transparent @error('author') border-red-500 @enderror"
                    value="{{ old('author') }}"
                    placeholder="Nama penulis">
                @error('author')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Published Date -->
            <div class="mb-4">
                <label for="published_at" class="block text-gray-700 font-semibold mb-2">
                    Tanggal Publish
                </label>
                <input type="datetime-local" name="published_at" id="published_at"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-transparent @error('published_at') border-red-500 @enderror"
                    value="{{ old('published_at', now()->format('Y-m-d\TH:i')) }}">
                @error('published_at')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Image -->
            <div class="mb-4">
                <label for="image" class="block text-gray-700 font-semibold mb-2">
                    Gambar Berita
                </label>
                <input type="file" name="image" id="image" accept="image/*"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-transparent @error('image') border-red-500 @enderror"
                    onchange="previewImage(event)">
                @error('image')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <div id="imagePreview" class="mt-3 hidden">
                    <img id="preview" src="" alt="Preview" class="max-w-xs rounded-lg border border-gray-300">
                </div>
            </div>

            <!-- Content -->
            <div class="mb-6">
                <label for="content" class="block text-gray-700 font-semibold mb-2">
                    Konten Berita <span class="text-red-500">*</span>
                </label>
                <textarea name="content" id="content" rows="10"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-transparent @error('content') border-red-500 @enderror"
                    placeholder="Tulis konten berita di sini...">{{ old('content') }}</textarea>
                @error('content')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex items-center justify-end space-x-3">
                <a href="{{ route('admin.news.index') }}"
                    class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 font-semibold">
                    Batal
                </a>
                <button type="submit"
                    class="px-6 py-2 bg-blue-400 text-white rounded-lg hover:bg-blue-300 font-semibold shadow-md shadow-blue-100 hover:shadow-none">
                    Simpan Berita
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function previewImage(event) {
    const preview = document.getElementById('preview');
    const previewDiv = document.getElementById('imagePreview');
    const file = event.target.files[0];

    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            previewDiv.classList.remove('hidden');
        }
        reader.readAsDataURL(file);
    }
}
</script>
@endsection
