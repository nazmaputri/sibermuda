@extends('layouts.dashboard-mentor')
@section('title', 'Tambah Kursus')
@section('content')
<div class="container mx-auto"> 
    <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200">
        <h2 class="text-lg font-semibold text-gray-700 text-center w-full border-b-2 border-gray-300 pb-2">Tambah Kursus</h2>

        <!-- Form Tambah Kursus -->
        <form action="{{ route('courses.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                <!-- Kolom Kiri -->
                <div>
                    <!-- Input untuk Judul -->
                    <div class="mb-4">
                        <label for="title" class="block font-medium text-gray-700 pb-2">Judul Kursus</label>
                        <input type="text" name="title" id="title" class="w-full p-2 text-sm text-gray-700 border rounded focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400 @error('title') border-red-500 @enderror" placeholder="Masukkan judul kursus" value="{{ old('title') }}">
                        @error('title')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Input untuk Start_date -->
                    <div class="mb-4">
                        <label for="start_date" class="block font-medium text-gray-700 pb-2">Tanggal Mulai</label>
                        <input type="date" name="start_date" id="start_date" class="w-full p-2 text-sm text-gray-700 border rounded focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400 @error('start_date') border-red-500 @enderror" placeholder="Masukkan Waktu Mulai" min="{{ \Carbon\Carbon::today()->toDateString() }}">
                        <small class="text-gray-600">Jika tidak di isi maka "Akses seumur hidup"</small>
                        @error('start_date')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Input untuk End_date -->
                    <div class="mb-4">
                        <label for="end_date" class="block font-medium text-gray-700 pb-2">Tanggal Selesai</label>
                        <input type="date" name="end_date" id="end_date" class="w-full p-2 text-sm text-gray-700 border rounded focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400 @error('end_date') border-red-500 @enderror" placeholder="Masukkan Waktu Selesai" min="{{ \Carbon\Carbon::today()->toDateString() }}">
                        <small class="text-gray-600">Jika tidak di isi maka "Akses seumur hidup"</small>
                        @error('end_date')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Input untuk Deskripsi -->
                    <div class="mb-1">
                        <label for="description" class="block font-medium text-gray-700 pb-2">Deskripsi</label>
                        <textarea name="description" id="description" rows="4" class="w-full p-2 text-sm text-gray-700 border rounded focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400 @error('description') border-red-500 @enderror" placeholder="Masukkan deskripsi kursus">{{ old('description') }}</textarea>
                        @error('description')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                </div>

                <!-- Kolom Kanan -->
                <div>
                    <!-- Input untuk Kategori -->
                    <div 
                        x-data="{
                            open: false, 
                            selected: '', 
                            selectedId: '', 
                            categories: @js($categories),
                            hasError: {{ $errors->has('category_id') ? 'true' : 'false' }},
                            selectCategory(category) {
                                this.selected = category.name;
                                this.selectedId = category.id;
                                this.open = false;
                                this.hasError = false;
                            }
                        }" 
                        class="relative mb-4"
                    >
                        <label for="category_id" class="block font-medium text-gray-700 pb-2">Kategori Kursus</label>

                        <!-- Display Selected -->
                        <button 
                            @click="open = !open" 
                            type="button"
                            class="w-full p-2 text-sm text-left text-gray-700 border rounded focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400"
                            :class="hasError ? 'border-red-500' : ''"
                        >
                            <span x-text="selected || 'Pilih Kategori'"></span>
                        </button>

                        <!-- Dropdown List -->
                        <div 
                            x-show="open" 
                            @click.away="open = false"
                            class="absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded shadow max-h-48 overflow-y-auto text-sm scrollbar-hide text-gray-700"
                        >
                            <template x-for="category in categories" :key="category.id">
                                <div 
                                    @click="selectCategory(category)"
                                    class="cursor-pointer px-4 py-2 hover:bg-gray-100"
                                    :class="{ 'bg-gray-100': selectedId === category.id }"
                                >
                                    <span x-text="category.name"></span>
                                </div>
                            </template>
                        </div>

                        <!-- Hidden Input to Submit -->
                        <input type="hidden" name="category_id" :value="selectedId">

                        <!-- Error Message -->
                        <template x-if="hasError">
                            <span class="text-red-500 text-sm">{{ $errors->first('category_id') }}</span>
                        </template>
                    </div>

                    <!-- Input untuk Harga -->
                    <div class="mb-4">
                        <label for="price" class="block font-medium text-gray-700 pb-2">Harga</label>
                        <input type="text" name="price" id="price" class="w-full p-2 text-sm text-gray-700 border rounded focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400 @error('price') border-red-500 @enderror" placeholder="Masukkan harga kursus.contoh:3000 " value="{{ old('price') }}">
                        @error('price')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Input untuk Kapasitas -->
                    <div class="mb-4">
                        <label for="capacity" class="block font-medium text-gray-700 pb-2">Kapasitas Peserta</label>
                        <input type="number" name="capacity" id="capacity" class="w-full p-2 text-sm text-gray-700 border rounded focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400 @error('capacity') border-red-500 @enderror" placeholder="Masukkan kapasitas kursus" value="{{ old('capacity') }}">
                        <small class="text-gray-600">Jika tidak di isi maka kapasitasnya tidak terbatas</small>
                        @error('capacity')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Input untuk Foto -->
                    <div class="mb-4">
                        <label for="image" class="block font-medium text-gray-700 pb-2">Foto Kursus</label>
                        <input type="file" name="image" id="image" class="w-full p-2 text-sm text-gray-700 border rounded @error('image') border-red-500 @enderror">
                        <small class="text-gray-600 block">Format gambar yang diperbolehkan: jpg, png, jpeg</small>
                        @error('image')
                            <span class="text-red-500 text-sm block">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="mt-4">
                        <label for="chat-toggle" class="flex items-center cursor-pointer">
                            <span class="mr-3 text-gray-700 font-medium">Aktifkan Fitur Chat</span>
                            <!-- Toggle Switch -->
                            <div class="relative ">
                                <input type="checkbox" name="chat" id="chat-toggle" class="hidden peer" {{ old('chat', $course->chat ?? false) ? 'checked' : '' }} value="1"/>
                                <div class="block bg-gray-300 w-9 h-5 rounded-full peer-checked:bg-green-500 peer-checked:justify-end"></div>
                                <div class="dot absolute top-0.5 start-[2px] bg-white w-4 h-4 rounded-full transition-transform peer-checked:translate-x-full"></div>
                            </div>
                        </label>
                    
                        <!-- Pesan saat fitur chat diaktifkan -->
                        <div id="chat-status" class="mt-1 hidden">
                            <p class="text-green-500 font-medium">Fitur Chat Aktif!</p>
                        </div>
                    
                        <!-- Pesan saat fitur chat dinonaktifkan -->
                        <div id="chat-status-inactive" class="mt-1 hidden">
                            <p class="text-red-500 font-medium">Fitur Chat Dinonaktifkan!</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tombol Submit -->
            <div class="mt-6 flex justify-end space-x-2">
                <a href="{{ route('courses.index') }}" class="bg-red-400 hover:bg-red-300 text-white font-medium py-2 px-4 rounded-md">
                    Batal
                </a>
                <button type="submit" class="bg-sky-400 hover:bg-sky-300 text-white font-medium py-2 px-4 rounded-md">
                    Tambah 
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Menambahkan event listener untuk toggle
    document.getElementById('chat-toggle').addEventListener('change', function() {
        var chatStatus = document.getElementById('chat-status');
        var chatStatusInactive = document.getElementById('chat-status-inactive');
                    
        // Menampilkan atau menyembunyikan pesan berdasarkan status toggle
        if (this.checked) {
            chatStatus.classList.remove('hidden');
            chatStatusInactive.classList.add('hidden');
        } else {
            chatStatus.classList.add('hidden');
            chatStatusInactive.classList.remove('hidden');
        }
    });
    
    // Menambahkan event listener untuk setiap input yang ada
    const inputs = document.querySelectorAll('input, textarea, select');

        inputs.forEach(input => {
            const eventName = input.type === 'file' ? 'change' : 'input';

            input.addEventListener(eventName, function () {
                // Hapus border merah
                this.classList.remove('border-red-500');

                // Cari parent (misalnya .mb-4)
                const parent = this.closest('div');

                if (parent) {
                    // Cari pesan error di dalam parent
                    const error = parent.querySelector('.text-red-500');

                    if (error) {
                        error.style.display = 'none';
                    }
                }
            });
        });
</script>
@endsection
