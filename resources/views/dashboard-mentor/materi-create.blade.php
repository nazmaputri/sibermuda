@extends('layouts.dashboard-mentor')
@section('title', 'Tambah Materi')
@section('content')
<div class="container mx-auto">
    <!-- Judul Utama -->
    <div class="bg-white shadow-md rounded-lg p-6 border border-gray-200">
        <h2 class="text-xl font-semibold mb-4 border-b-2 pb-2 text-gray-700 text-center">Tambah Materi</h2>

        <!-- Form Tambah Materi dan YouTube -->
        <form action="{{ route('materi.store', ['courseId' => $course->id]) }}" method="POST" enctype="multipart/form-data" class="w-full">
            @csrf
            <div class="grid grid-cols-1 gap-2">

                <!-- Kiri: Input Judul dan Deskripsi -->
                <div>
                    <!-- Input untuk Judul Materi -->
                    <div class="mb-4">
                        <label for="judul" class="block text-gray-700 font-medium mb-2">Judul Materi</label>
                        <input type="text" name="judul" id="judul" class="w-full p-2 border text-sm text-gray-700 rounded focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400 @error('judul') border-red-500 @enderror" placeholder="Masukkan judul materi" value="{{ old('judul') }}">
                        @error('judul')
                            <div class="text-red-500 text-sm">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Input untuk Deskripsi Materi -->
                    <div class="mb-4">
                        <label for="deskripsi" class="block text-gray-700 font-medium mb-2">Deskripsi Materi</label>
                        <textarea name="deskripsi" id="deskripsi" rows="3" class="w-full p-2 text-sm text-gray-700 border rounded focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400 @error('deskripsi') border-red-500 @enderror" placeholder="Masukkan deskripsi materi">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <div class="text-red-500 text-sm">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div x-data="{
                    materiDrive: {{ json_encode(old('title') ? collect(old('title'))->map(function($title, $index) {
                        return [
                            'id' => old('id')[$index] ?? null,
                            'title' => old('title')[$index] ?? '',
                            'description' => old('description')[$index] ?? '',
                            'link' => old('link')[$index] ?? '',
                            'type' => 'drive',
                        ];
                    }) : $materi->videos->map(function($drive) {
                        return [
                            'id' => $drive->id,
                            'title' => $drive->title,
                            'description' => $drive->description,
                            'link' => 'https://drive.google.com/file/d/' . $drive->link . '/preview',
                            'type' => 'drive',
                        ];
                    })) }},
                    
                    materiYoutube: {{ json_encode(old('youtube_title') ? collect(old('youtube_title'))->map(function($title, $index) {
                        return [
                            'id' => old('youtube_id')[$index] ?? null,
                            'title' => old('youtube_title')[$index] ?? '',
                            'description' => old('youtube_description')[$index] ?? '',
                            'link' => old('youtube_link')[$index] ?? '',
                            'type' => 'youtube',
                        ];
                    }) : $materi->youtube->map(function($yt) {
                        return [
                            'id' => $yt->id,
                            'title' => $yt->title,
                            'description' => $yt->description,
                            'link' => 'https://www.youtube.com/watch?v=' . $yt->link,
                            'type' => 'youtube',
                        ];
                    })) }},

                    addMateri(type) {
                        if (type === 'drive') {
                            this.materiDrive.push({ id: null, title: '', description: '', link: '', type: 'drive' });
                        } else if (type === 'youtube') {
                            this.materiYoutube.push({ id: null, title: '', description: '', link: '', type: 'youtube' });
                        }
                    },
                    removeMateri(type, index) {
                        if (type === 'drive') {
                            this.materiDrive.splice(index, 1);
                        } else if (type === 'youtube') {
                            this.materiYoutube.splice(index, 1);
                        }
                    }
                }">
                    <input type="hidden" name="courses_id" value="{{ $course->id }}">

                    <div class="grid grid-cols-1 gap-4">
                         <!-- Materi Drive -->
                        <div>
                            <template x-for="(item, index) in materiDrive" :key="'drive-' + index">
                                <div class="border p-4 rounded bg-white mb-2 space-y-2">
                                    <input type="hidden" name="type[]" x-model="item.type">
                                    <input type="hidden" name="id[]" :value="item.id">

                                    <div class="mb-2">
                                        <p class="font-medium text-gray-700 mb-2">Materi G-drive <span x-text="index + 1"></span></p>
                                    </div>

                                    <label class="text-gray-700 font-medium mb-2">Judul</label>
                                    <input type="text" name="title[]" x-model="item.title" placeholder="Masukkan judul materi" @input="delete $store.errors['title.' + index]" :class="{
                                        'w-full p-2 rounded text-sm text-gray-700 focus:outline-none': true,
                                        'border border-red-500 focus:ring-red-500 focus:border-red-500': $store.errors['title.' + index],
                                        'border border-gray-300 focus:ring-gray-400 focus:ring-1 focus:border-gray-400': !$store.errors['title.' + index]
                                    }">
                                    <template x-if="$store.errors['title.' + index]">
                                        <p class="text-red-500 text-sm" x-text="$store.errors['title.' + index]"></p>
                                    </template>

                                    <div class="mt-2 space-y-2">
                                        <label class="text-gray-700 font-medium mb-2">Deskripsi</label>
                                        <textarea name="description[]" x-model="item.description" placeholder="Masukkan deskripsi materi" @input="delete $store.errors['description.' + index]" :class="{
                                            'w-full p-2 rounded text-sm text-gray-700 focus:outline-none': true,
                                            'border border-red-500 focus:ring-red-500 focus:border-red-500': $store.errors['description.' + index],
                                            'border border-gray-300 focus:ring-gray-400 focus:ring-1 focus:border-gray-400': !$store.errors['description.' + index]
                                        }"></textarea>
                                        <template x-if="$store.errors['description.' + index]">
                                            <p class="text-red-500 text-sm" x-text="$store.errors['description.' + index]"></p>
                                        </template>
                                    </div>

                                    <label class="text-gray-700 font-medium mb-2">Link</label>
                                    <input type="text" name="link[]" x-model="item.link" placeholder="Masukkan link materi" @input="delete $store.errors['link.' + index]" :class="{
                                        'w-full p-2 rounded text-sm text-gray-700 focus:outline-none': true,
                                        'border border-red-500 focus:ring-red-500 focus:border-red-500': $store.errors['link.' + index],
                                        'border border-gray-300 focus:ring-gray-400 focus:ring-1 focus:border-gray-400': !$store.errors['link.' + index]
                                    }">
                                    <template x-if="$store.errors['link.' + index]">
                                        <p class="text-red-500 text-sm" x-text="$store.errors['link.' + index]"></p>
                                    </template>

                                    <div class="text-left" x-show="materiDrive.length > 0">
                                        <button type="button" @click="removeMateri('drive', index)" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-md bg-red-400 hover:bg-red-300 text-white text-sm shadow mt-1 transition">Hapus</button>
                                    </div>
                                </div>
                            </template>
                            <button type="button" @click="addMateri('drive')" class="inline-flex items-center gap-2 px-4 py-2 bg-green-400 hover:bg-green-300 text-white rounded-md text-sm shadow transition">Tambah Materi Drive</button>
                        </div>

                        <!-- YouTube -->
                        <div>
                            <template x-for="(item, index) in materiYoutube" :key="'youtube-' + index">
                                <div class="border p-4 rounded bg-white mb-2 space-y-2">
                                    <input type="hidden" :name="`youtube_type[]`" x-model="item.type">
                                    <input type="hidden" :name="`youtube_id[]`" :value="item.id">

                                    <p class="font-medium text-gray-700 mb-2">Materi Youtube <span x-text="index + 1"></span></p>

                                    <label class="block text-gray-700 font-medium mb-2">Judul</label>
                                    <input type="text" :name="`youtube_title[]`" x-model="item.title" placeholder="Masukkan judul materi" @input="delete $store.errors['youtube_title.' + index]" :class="{
                                        'w-full p-2 rounded text-sm text-gray-700 focus:outline-none': true,
                                        'border border-red-500 focus:ring-red-500 focus:border-red-500': $store.errors['youtube_title.' + index],
                                        'border border-gray-300 focus:ring-gray-400 focus:ring-1 focus:border-gray-400': !$store.errors['youtube_title.' + index]
                                    }">
                                    <template x-if="$store.errors['youtube_title.' + index]">
                                        <p class="text-red-500 text-sm" x-text="$store.errors['youtube_title.' + index]"></p>
                                    </template>

                                    <label class="block text-gray-700 font-medium mb-2">Deskripsi</label>
                                    <textarea :name="`youtube_description[]`" x-model="item.description" placeholder="Masukkan deskripsi materi" @input="delete $store.errors['youtube_description.' + index]" :class="{
                                        'w-full p-2 rounded text-sm text-gray-700 focus:outline-none': true,
                                        'border border-red-500 focus:ring-red-500 focus:border-red-500': $store.errors['youtube_description.' + index],
                                        'border border-gray-300 focus:ring-gray-400 focus:ring-1 focus:border-gray-400': !$store.errors['youtube_description.' + index]
                                    }"></textarea>
                                    <template x-if="$store.errors['youtube_description.' + index]">
                                        <p class="text-red-500 text-sm" x-text="$store.errors['youtube_description.' + index]"></p>
                                    </template>

                                    <label class="block text-gray-700 font-medium mb-2">Link</label>
                                    <input type="text" :name="`youtube_link[]`" x-model="item.link" placeholder="Masukkan link materi" @input="delete $store.errors['youtube_link.' + index]" :class="{
                                        'w-full p-2 rounded text-sm text-gray-700 focus:outline-none': true,
                                        'border border-red-500 focus:ring-red-500 focus:border-red-500': $store.errors['youtube_link.' + index],
                                        'border border-gray-300 focus:ring-gray-400 focus:ring-1 focus:border-gray-400': !$store.errors['youtube_link.' + index]
                                    }">
                                    <template x-if="$store.errors['youtube_link.' + index]">
                                        <p class="text-red-500 text-sm" x-text="$store.errors['youtube_link.' + index]"></p>
                                    </template>

                                    <div class="text-left" x-show="materiYoutube.length > 0">
                                        <button type="button" @click="removeMateri('youtube', index)" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-md bg-red-400 hover:bg-red-300 text-white text-sm shadow mt-1 transition">Hapus</button>
                                    </div>
                                </div>
                            </template>
                            <button type="button" @click="addMateri('youtube')" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-400 hover:bg-blue-300 text-white rounded-md text-sm shadow transition">Tambah Materi YouTube</button>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Tombol Submit -->
            <div class="mt-6 flex justify-end space-x-2">
                <a href="{{ route('courses.show', $course->slug)}}" class="bg-red-400 hover:bg-red-300 text-white font-medium py-2 px-4 rounded-md">
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
    // Menambahkan event listener untuk setiap input yang ada
    const inputs = document.querySelectorAll('input, textarea, select');

    inputs.forEach(input => {
        input.addEventListener('input', function() {
            // Menghapus kelas border merah saat input mulai diubah
            if (this.classList.contains('border-red-500')) {
                this.classList.remove('border-red-500');
            }

            // Menghapus pesan error jika ada
            const errorMessage = this.nextElementSibling;
            if (errorMessage && errorMessage.classList.contains('text-red-500')) {
                errorMessage.style.display = 'none';
            }
        });
    });

    // TAMBAH INI UNTUK MENGINISIALISASI ERROR PADA ALPHINE JS, DAN JANGAN DIHAPUS KARENA INI PENTING UNTUK PESAN ERROR GAGAL VALIDASI!!!
    document.addEventListener('alpine:init', () => {
        Alpine.store('errors', @json($errors->toArray()));
    });
</script>
@endsection