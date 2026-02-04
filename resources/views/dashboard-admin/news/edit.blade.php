@extends('layouts.dashboard-admin')
@section('title', 'Edit Berita')
@section('content')
<div class="container mx-auto">
    <div class="bg-white rounded-lg p-6 border border-gray-200">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Edit Berita</h2>
            <p class="text-gray-600 text-sm mt-1">Perbarui informasi berita</p>
        </div>

        <form action="{{ route('admin.news.update', $news->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Title -->
            <div class="mb-4">
                <label for="title" class="block text-gray-700 font-semibold mb-2">
                    Judul Berita <span class="text-red-500">*</span>
                </label>
                <input type="text" name="title" id="title"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-transparent @error('title') border-red-500 @enderror"
                    value="{{ old('title', $news->title) }}"
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
                    <option value="Teknologi" {{ old('category', $news->category) == 'Teknologi' ? 'selected' : '' }}>Teknologi</option>
                    <option value="Pendidikan" {{ old('category', $news->category) == 'Pendidikan' ? 'selected' : '' }}>Pendidikan</option>
                    <option value="Bisnis" {{ old('category', $news->category) == 'Bisnis' ? 'selected' : '' }}>Bisnis</option>
                    <option value="Olahraga" {{ old('category', $news->category) == 'Olahraga' ? 'selected' : '' }}>Olahraga</option>
                    <option value="Hiburan" {{ old('category', $news->category) == 'Hiburan' ? 'selected' : '' }}>Hiburan</option>
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
                    value="{{ old('author', $news->author) }}"
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
                    value="{{ old('published_at', $news->published_at->format('Y-m-d\TH:i')) }}">
                @error('published_at')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Current Image -->
            @if($news->image_path)
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Gambar Saat Ini</label>
    <img
                                        src="{{ Storage::url($news->image_path) }}"
                                        alt="{{ $news->title }}"
                                        class="w-16 h-12 object-cover rounded"
                                    />            </div>
            @endif

            <!-- Image -->
            <div class="mb-4">
                <label for="image" class="block text-gray-700 font-semibold mb-2">
                    Gambar Baru (Opsional)
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
                    placeholder="Tulis konten berita di sini...">{{ old('content', $news->content) }}</textarea>
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
                    Update Berita
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
