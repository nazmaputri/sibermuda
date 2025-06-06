@extends('layouts.dashboard-mentor')
@section('title', 'Edit Kursus')
@section('content')
<div class="container mx-auto">
    <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200">
        <h2 class="text-lg font-semibold text-gray-700 text-center w-full border-b-2 border-gray-300 pb-2">Edit Kursus</h2>

        <!-- Form Edit Kursus -->
        <form action="{{ route('courses.update', $course->slug) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                <!-- Kolom Kiri -->
                <div>
                    <!-- Input untuk Judul -->
                    <div class="mb-4">
                        <label for="title" class="block text-gray-700 font-medium mb-2">Judul Kursus</label>
                        <input type="text" name="title" id="title" class="w-full p-2 text-sm text-gray-700 focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400 border rounded @error('title') border-red-500 @enderror" placeholder="Masukkan judul kursus" value="{{ old('title', $course->title) }}">
                        @error('title')
                            <span class="text-red-500 text-sm" id="error-title">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Input untuk Harga -->
                    <div class="mb-3">
                        <label for="price" class="block text-gray-700 font-medium mb-2">Harga</label>
                        <input type="text" name="price" id="price" class="w-full p-2 text-sm text-gray-700 focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400 border rounded @error('price') border-red-500 @enderror" placeholder="Masukkan harga kursus" value="{{ old('price', $course->price) }}">
                        @error('price')
                            <span class="text-red-500 text-sm" id="error-price">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Input untuk Start_date -->
                    <div class="mb-4">
                        <label for="start_date" class="block text-gray-700 font-medium mb-2">Tanggal Mulai</label>
                        <input type="date" name="start_date" id="start_date" class="w-full p-2 text-sm text-gray-700 focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400 border rounded @error('start_date') border-red-500 @enderror" value="{{ old('start_date', $course->start_date) }}" min="{{ \Carbon\Carbon::today()->toDateString() }}">
                        @error('start_date')
                            <span class="text-red-500 text-sm" id="error-start_date">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Input untuk End_date -->
                    <div class="mb-4">
                        <label for="end_date" class="block text-gray-700 font-medium mb-2">Tanggal Selesai</label>
                        <input type="date" name="end_date" id="end_date" class="w-full p-2 text-sm text-gray-700 focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400 border rounded @error('end_date') border-red-500 @enderror" value="{{ old('end_date', $course->end_date) }}" min="{{ \Carbon\Carbon::today()->toDateString() }}">
                        @error('end_date')
                            <span class="text-red-500 text-sm" id="error-end_date">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Input untuk Deskripsi -->
                    <div class="mb-1">
                        <label for="description" class="block text-gray-700 font-medium mb-2">Deskripsi</label>
                        <textarea name="description" id="description" rows="6" class="w-full p-2 text-sm text-gray-700 focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400 border rounded @error('description') border-red-500 @enderror" placeholder="Masukkan deskripsi kursus">{{ old('description', $course->description) }}</textarea>
                        @error('description')
                            <span class="text-red-500 text-sm" id="error-description">{{ $message }}</span>
                        @enderror
                    </div>

                </div>

                <!-- Kolom Kanan: Foto -->
                <div>
                    <!-- Input untuk Kategori -->
                    <div 
                        x-data="{
                            open: false, 
                            selected: '{{ old('category_id', $course->category?->name ?? '') }}',
                            selectedId: '{{ old('category_id', $course->category_id ?? '') }}',
                            categories: @js($categories)
                        }" 
                        class="relative mb-4"
                    >
                        <label for="category_id" class="block text-gray-700 font-medium mb-2">Kategori Kursus</label>

                        <!-- Hidden input yang akan dikirim ke backend -->
                        <input type="hidden" name="category_id" x-model="selectedId">

                        <!-- Tombol Dropdown -->
                        <button 
                            type="button"
                            @click="open = !open"
                            class="w-full p-2 text-sm text-left text-gray-700 border rounded focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400"
                            :class="{ 'border-red-500': '{{ $errors->has('category_id') }}' }"
                        >
                            <span x-text="selected || 'Pilih Kategori'"></span>
                        </button>

                        <!-- Dropdown List -->
                        <div 
                            x-show="open" 
                            @click.away="open = false"
                            x-transition
                            class="absolute z-10 w-full mt-1 bg-white text-gray-700 border border-gray-300 rounded shadow max-h-48 overflow-y-auto text-sm overflow-hidden"
                        >
                            <template x-for="category in categories" :key="category.id">
                                <div 
                                    @click="selected = category.name; selectedId = category.id; open = false"
                                    class="cursor-pointer px-4 py-2 hover:bg-gray-100"
                                    :class="{ 'bg-gray-100': selectedId == category.id }"
                                >
                                    <span x-text="category.name"></span>
                                </div>
                            </template>
                        </div>

                        <!-- Error message -->
                        @error('category_id')
                            <span class="text-red-500 text-sm" id="error-category">{{ $message }}</span>
                        @enderror
                    </div>


                    <!-- Input untuk Kapasitas -->
                    <div class="mt-3">
                        <label for="capacity" class="block text-gray-700 font-medium mb-2">Kapasitas Peserta</label>
                        <input type="number" name="capacity" id="capacity" class="w-full p-2 text-sm text-gray-700 focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400 border rounded @error('capacity') border-red-500 @enderror" value="{{ old('capacity', $course->capacity) }}">
                        @error('capacity')
                            <span class="text-red-500 text-sm" id="error-capacity">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Menampilkan gambar saat ini jika ada -->
                    @if($course->image_path)
                        <div class="mt-6">
                            <label class="block text-gray-700 font-medium mb-2">Gambar Saat Ini</label>
                            <img src="{{ asset('storage/' . $course->image_path) }}" alt="{{ $course->name }}" class="w-42 h-40 object-cover rounded">
                        </div>
                    @endif

                    <!-- Input untuk Foto -->
                    <div class="mb-4 mt-1">
                        <label for="image" class="block text-gray-700 font-medium mb-2">Unggah Gambar Baru</label>
                        <input type="file" name="image" id="image" class="w-full p-2 text-sm text-gray-700 focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400 border rounded @error('image') border-red-500 @enderror">
                        @error('image')
                            <span class="text-red-500 text-sm" id="error-image">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <label for="chat-toggle" class="flex items-center cursor-pointer">
                            <span class="mr-3 text-gray-700 font-medium">Aktifkan Fitur Chat</span>
                            <!-- Toggle Switch -->
                            <div class="relative">
                                <input type="checkbox" name="chat" id="chat-toggle" class="hidden peer" {{ old('chat', $course->chat ?? false) ? 'checked' : '' }} value="1"/>
                                <div class="block bg-gray-300 w-9 h-5 rounded-full peer-checked:bg-green-500 peer-checked:justify-end"></div>
                                <div class="dot absolute top-0.5 start-[2px] bg-white h-4 w-4 rounded-full transition-transform peer-checked:translate-x-full"></div>
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
                <a href="{{ route('courses.index') }}" class="bg-red-400 hover:bg-red-300 text-white font-medium py-2 px-4 rounded-lg">
                    Batal
                </a>
                <button type="submit" class="bg-sky-400 hover:bg-sky-300 text-white font-medium py-2 px-4 rounded-lg">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

 <script>
        // Menghapus error dan border merah saat pengguna mulai mengetik
        const inputs = document.querySelectorAll('input, textarea, select');
        inputs.forEach(input => {
            input.addEventListener('input', function() {
                const errorSpan = document.getElementById('error-' + input.id);
                if (errorSpan) {
                    errorSpan.style.display = 'none';  // Sembunyikan pesan error
                }
                input.classList.remove('border-red-500');  // Hapus border merah
            });
        });
        
        // Ambil elemen toggle dan pesan status
        const chatToggle = document.getElementById('chat-toggle');
        const chatStatus = document.getElementById('chat-status');
        const chatStatusInactive = document.getElementById('chat-status-inactive');

        // Fungsi untuk menampilkan atau menyembunyikan pesan berdasarkan status toggle
        function updateChatStatus() {
            if (chatToggle.checked) {
                chatStatus.classList.remove('hidden');
                chatStatusInactive.classList.add('hidden');
            } else {
                chatStatus.classList.add('hidden');
                chatStatusInactive.classList.remove('hidden');
            }
        }

        // Menampilkan status berdasarkan keadaan toggle saat pertama kali dimuat
        window.addEventListener('DOMContentLoaded', () => {
            updateChatStatus();  // Panggil fungsi untuk set status saat halaman pertama kali dimuat
        });

        // Menambahkan event listener untuk toggle
        chatToggle.addEventListener('change', function() {
            updateChatStatus();  // Panggil fungsi untuk set status saat toggle berubah
        });
</script>
@endsection
