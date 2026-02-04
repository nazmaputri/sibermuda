@extends('layouts.dashboard-admin')
@section('title', 'Tambah Bootcamp')
@section('content')
<div class="container mx-auto bg-white rounded-lg p-5 border border-gray-200">
    <!-- Header -->
    <div class="mb-6 flex items-center justify-between">
        <h2 class="text-2xl font-bold text-gray-700">Tambah Bootcamp Baru</h2>
        <a href="{{ route('admin.bootcamp.index') }}" class="inline-flex items-center space-x-2 text-gray-600 hover:text-gray-800">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
            </svg>
            <span>Kembali</span>
        </a>
    </div>

    <!-- Form -->
    <form action="{{ route('admin.bootcamp.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Judul Bootcamp -->
        <div class="mb-4">
            <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">Judul Bootcamp <span class="text-red-500">*</span></label>
            <input type="text" name="title" id="title" value="{{ old('title') }}"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-sky-400 @error('title') border-red-500 @enderror"
                placeholder="Contoh: Full Stack Web Development Bootcamp" required>
            @error('title')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Deskripsi -->
        <div class="mb-4">
            <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi <span class="text-red-500">*</span></label>
            <textarea name="description" id="description" rows="4"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-sky-400 @error('description') border-red-500 @enderror"
                placeholder="Deskripsi lengkap bootcamp..." required>{{ old('description') }}</textarea>
            @error('description')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Durasi dan Level -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label for="duration" class="block text-sm font-semibold text-gray-700 mb-2">Durasi <span class="text-red-500">*</span></label>
                <input type="text" name="duration" id="duration" value="{{ old('duration') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-sky-400 @error('duration') border-red-500 @enderror"
                    placeholder="Contoh: 12 Minggu" required>
                @error('duration')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="level" class="block text-sm font-semibold text-gray-700 mb-2">Level <span class="text-red-500">*</span></label>
                <select name="level" id="level"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-sky-400 @error('level') border-red-500 @enderror" required>
                    <option value="">Pilih Level</option>
                    <option value="Pemula" {{ old('level') == 'Pemula' ? 'selected' : '' }}>Pemula</option>
                    <option value="Pemula - Menengah" {{ old('level') == 'Pemula - Menengah' ? 'selected' : '' }}>Pemula - Menengah</option>
                    <option value="Menengah" {{ old('level') == 'Menengah' ? 'selected' : '' }}>Menengah</option>
                    <option value="Menengah - Lanjutan" {{ old('level') == 'Menengah - Lanjutan' ? 'selected' : '' }}>Menengah - Lanjutan</option>
                    <option value="Lanjutan" {{ old('level') == 'Lanjutan' ? 'selected' : '' }}>Lanjutan</option>
                </select>
                @error('level')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Jadwal -->
        <div class="mb-4">
            <label for="schedule" class="block text-sm font-semibold text-gray-700 mb-2">Jadwal <span class="text-red-500">*</span></label>
            <input type="text" name="schedule" id="schedule" value="{{ old('schedule') }}"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-sky-400 @error('schedule') border-red-500 @enderror"
                placeholder="Contoh: Senin - Jumat, 19.00 - 21.00 WIB" required>
            @error('schedule')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Harga -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label for="price" class="block text-sm font-semibold text-gray-700 mb-2">Harga Normal <span class="text-red-500">*</span></label>
                <input type="text" name="price" id="price" value="{{ old('price') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-sky-400 @error('price') border-red-500 @enderror"
                    placeholder="Contoh: Rp 5.000.000" required>
                @error('price')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="discount_price" class="block text-sm font-semibold text-gray-700 mb-2">Harga Diskon</label>
                <input type="text" name="discount_price" id="discount_price" value="{{ old('discount_price') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-sky-400 @error('discount_price') border-red-500 @enderror"
                    placeholder="Contoh: Rp 3.500.000">
                @error('discount_price')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Upload Gambar -->
        <div class="mb-4">
            <label for="image" class="block text-sm font-semibold text-gray-700 mb-2">Gambar Bootcamp</label>
            <input type="file" name="image" id="image" accept="image/*"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-sky-400 @error('image') border-red-500 @enderror">
            <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, GIF. Maksimal 2MB</p>
            @error('image')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
            <div id="imagePreview" class="mt-2 hidden">
                <img id="preview" src="" alt="Preview" class="w-32 h-32 object-cover rounded-lg border border-gray-300">
            </div>
        </div>

        <!-- Features -->
        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Fitur Bootcamp</label>
            <div id="featuresContainer">
                <div class="flex items-center space-x-2 mb-2">
                    <input type="text" name="features[]"
                        class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-sky-400"
                        placeholder="Contoh: Live Class dengan Mentor Expert">
                    <button type="button" onclick="addFeature()" class="bg-green-400 text-white px-3 py-2 rounded-lg hover:bg-green-300">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Syllabus -->
        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Silabus Bootcamp</label>
            <div id="syllabusContainer">
                <div class="flex items-center space-x-2 mb-2">
                    <input type="text" name="syllabus[]"
                        class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-sky-400"
                        placeholder="Contoh: HTML & CSS Fundamentals">
                    <button type="button" onclick="addSyllabus()" class="bg-green-400 text-white px-3 py-2 rounded-lg hover:bg-green-300">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Status -->
        <div class="mb-6">
            <label class="flex items-center space-x-2 cursor-pointer">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                    class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                <span class="text-sm font-semibold text-gray-700">Aktifkan Bootcamp</span>
            </label>
        </div>

        <!-- Buttons -->
        <div class="flex items-center space-x-3">
            <button type="submit" class="bg-blue-400 text-white px-6 py-2 rounded-lg hover:bg-blue-300 font-semibold">
                Simpan Bootcamp
            </button>
            <a href="{{ route('admin.bootcamp.index') }}" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-200 font-semibold">
                Batal
            </a>
        </div>
    </form>
</div>

<script>
    // Preview Image
    document.getElementById('image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('imagePreview').classList.remove('hidden');
                document.getElementById('preview').src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    });

    // Add Feature
    function addFeature() {
        const container = document.getElementById('featuresContainer');
        const div = document.createElement('div');
        div.className = 'flex items-center space-x-2 mb-2';
        div.innerHTML = `
            <input type="text" name="features[]"
                class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-sky-400"
                placeholder="Contoh: Live Class dengan Mentor Expert">
            <button type="button" onclick="removeField(this)" class="bg-red-400 text-white px-3 py-2 rounded-lg hover:bg-red-300">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        `;
        container.appendChild(div);
    }

    // Add Syllabus
    function addSyllabus() {
        const container = document.getElementById('syllabusContainer');
        const div = document.createElement('div');
        div.className = 'flex items-center space-x-2 mb-2';
        div.innerHTML = `
            <input type="text" name="syllabus[]"
                class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-sky-400"
                placeholder="Contoh: HTML & CSS Fundamentals">
            <button type="button" onclick="removeField(this)" class="bg-red-400 text-white px-3 py-2 rounded-lg hover:bg-red-300">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        `;
        container.appendChild(div);
    }

    // Remove Field
    function removeField(button) {
        button.parentElement.remove();
    }
</script>
@endsection
