@extends('layouts.dashboard-mentor')
@section('title', 'Edit Materi')
@section('content')
<div class="container mx-auto">
    <!-- Judul Utama -->
    <div class="bg-white shadow-md rounded-lg p-6 border border-gray-200">
        <h2 class="text-lg font-semibold mb-8 border-b-2 pb-2 text-gray-700 text-center">Edit Materi</h2>

        <!-- Form Edit Materi -->
        <form action="{{ route('materi.update', ['courseId' => $course->id, 'materiId' => $materi->id]) }}" method="POST" enctype="multipart/form-data" class="w-full">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 gap-2">
                <!-- Kiri: Input Judul dan Deskripsi -->
                <div>
                    <!-- Input untuk Judul Materi -->
                    <div class="mb-4">
                        <label for="judul" class="block text-gray-700 font-medium mb-2">Judul Materi</label>
                        <input type="text" name="judul" id="judul" class="w-full p-2 text-sm text-gray-700 border rounded focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400 @error('judul') border-red-500 @enderror" placeholder="Masukkan judul materi" value="{{ old('judul', $materi->judul) }}">
                        @error('judul')
                            <div class="text-red-500 text-sm">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="deskripsi" class="block text-gray-700 font-medium mb-2">Deskripsi</label>
                        <textarea name="deskripsi" id="deskripsi" rows="4" class="w-full p-2 text-sm text-gray-700 border rounded focus:outline-none focus:ring-1 focus:ring-gray-500 text-sm focus:border-gray-400 @error('deskripsi') border-red-500 @enderror" placeholder="Masukkan deskripsi materi">{{ old('deskripsi', $materi->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <div class="text-red-500 text-sm">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Input materi -->
                <div 
                    x-data="{
                        allMateri: @js(old('type') ? collect(old('type'))->map(function($type, $i) {
                            return [
                                'title' => old('title')[$i] ?? '',
                                'description' => old('description')[$i] ?? '',
                                'link' => old('link')[$i] ?? '',
                                'type' => $type
                            ];
                        }) : collect($materi->videos)->map(function($drive) {
                            return [
                                'title' => $drive->title,
                                'description' => $drive->description,
                                'link' => 'https://drive.google.com/file/d/' . $drive->link . '/preview',
                                'type' => 'drive'
                            ];
                        })->concat(
                            collect($materi->youtube)->map(function($yt) {
                                return [
                                    'title' => $yt->title,
                                    'description' => $yt->description,
                                    'link' => 'https://www.youtube.com/watch?v=' . $yt->link,
                                    'type' => 'youtube'
                                ];
                            })
                        )),

                        addMateri(type) {
                            this.allMateri.push({ title: '', description: '', link: '', type });
                        },

                        removeMateri(item) {
                            // Hapus berdasarkan objek item yang diklik, bukan berdasarkan index filtered
                            const index = this.allMateri.indexOf(item);
                            if (index > -1) {
                                this.allMateri.splice(index, 1);
                            }
                        }
                    }"
                >
                    <input type="hidden" name="courses_id" value="{{ $course->id }}">

                    <!-- === GDRIVE SECTION === -->
                    <template x-for="(item, index) in allMateri" :key="index">
                        <template x-if="item.type === 'drive'">
                            <div class="materi-group border p-4 rounded space-y-2 bg-white mb-2">
                                <input type="hidden" name="courses_id[]" value="{{ $course->id }}">
                                <input type="hidden" :name="`type[]`" x-model="item.type">

                                <p class="font-medium text-gray-700">
                                    Materi G-drive <span x-text="allMateri.filter((item, i) => i <= index && item.type === 'drive').length"></span>
                                </p>

                                <div>
                                    <label class="block text-gray-700 font-medium mb-2">Judul</label>
                                    <input type="text" :name="`title[]`" x-model="item.title" placeholder="Masukkan judul materi"
                                        @input="delete $store.errors[`title.${index}`]"
                                        :class="{
                                            'w-full p-2 rounded text-sm text-gray-700 focus:outline-none': true,
                                            'border border-red-500 focus:ring-red-500 focus:border-red-500': $store.errors[`title.${index}`],
                                            'border border-gray-300 focus:ring-gray-400 focus:ring-1 focus:border-gray-400': !$store.errors[`title.${index}`]
                                        }">
                                    <template x-if="$store.errors[`title.${index}`]">
                                        <p class="text-red-500 text-sm" x-text="$store.errors[`title.${index}`]"></p>
                                    </template>
                                </div>

                                <div>
                                    <label class="block text-gray-700 font-medium mb-2">Deskripsi</label>
                                    <textarea :name="`description[]`" x-model="item.description" rows="3"
                                        placeholder="Masukkan deskripsi materi"
                                        @input="delete $store.errors[`description.${index}`]"
                                        :class="{
                                            'w-full p-2 rounded text-sm text-gray-700 focus:outline-none': true,
                                            'border border-red-500 focus:ring-red-500 focus:border-red-500': $store.errors[`description.${index}`],
                                            'border border-gray-300 focus:ring-gray-400 focus:ring-1 focus:border-gray-400': !$store.errors[`description.${index}`]
                                        }"></textarea>
                                    <template x-if="$store.errors[`description.${index}`]">
                                        <p class="text-red-500 text-sm" x-text="$store.errors[`description.${index}`]"></p>
                                    </template>
                                </div>

                                <div>
                                    <label class="block text-gray-700 font-medium mb-2">Link</label>
                                    <input type="text" :name="`link[]`" x-model="item.link" placeholder="Masukkan link materi"
                                        @input="delete $store.errors[`link.${index}`]"
                                        :class="{
                                            'w-full p-2 rounded text-sm text-gray-700 focus:outline-none': true,
                                            'border border-red-500 focus:ring-red-500 focus:border-red-500': $store.errors[`link.${index}`],
                                            'border border-gray-300 focus:ring-gray-400 focus:ring-1 focus:border-gray-400': !$store.errors[`link.${index}`]
                                        }">
                                    <template x-if="$store.errors[`link.${index}`]">
                                        <p class="text-red-500 text-sm" x-text="$store.errors[`link.${index}`]"></p>
                                    </template>
                                </div>

                                <div class="text-left">
                                    <!-- Ganti parameter dari index ke item -->
                                    <button type="button" @click="removeMateri(item)"
                                        class="inline-flex items-center gap-1 px-3 py-1.5 rounded-md bg-red-400 text-white text-sm shadow hover:bg-red-300 mt-1 transition">
                                        Hapus
                                    </button>
                                </div>
                            </div>
                        </template>
                    </template>

                    <div class="mb-6">
                        <button type="button" @click="addMateri('drive')"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-green-400 hover:bg-green-300 text-white rounded-md text-sm shadow transition">
                            Tambah Materi G-Drive
                        </button>
                    </div>

                    <!-- === YOUTUBE SECTION === -->
                    <template x-for="(item, index) in allMateri" :key="index">
                        <template x-if="item.type === 'youtube'">
                            <div class="materi-group border p-4 rounded space-y-2 bg-white mb-2">
                                <input type="hidden" name="courses_id[]" value="{{ $course->id }}">
                                <input type="hidden" :name="`type[]`" x-model="item.type">

                                <p class="font-medium text-gray-700">
                                    Materi YouTube <span x-text="allMateri.filter((item, i) => i <= index && item.type === 'youtube').length"></span>
                                </p>

                                <div>
                                    <label class="block text-gray-700 font-medium mb-2">Judul</label>
                                    <input type="text" :name="`title[]`" x-model="item.title" placeholder="Masukkan judul materi"
                                        @input="delete $store.errors[`title.${index}`]"
                                        :class="{
                                            'w-full p-2 rounded text-sm text-gray-700 focus:outline-none': true,
                                            'border border-red-500 focus:ring-red-500 focus:border-red-500': $store.errors[`title.${index}`],
                                            'border border-gray-300 focus:ring-gray-400 focus:ring-1 focus:border-gray-400': !$store.errors[`title.${index}`]
                                        }">
                                    <template x-if="$store.errors[`title.${index}`]">
                                        <p class="text-red-500 text-sm" x-text="$store.errors[`title.${index}`]"></p>
                                    </template>
                                </div>

                                <div>
                                    <label class="block text-gray-700 font-medium mb-2">Deskripsi</label>
                                    <textarea :name="`description[]`" x-model="item.description" rows="3"
                                        placeholder="Masukkan deskripsi materi"
                                        @input="delete $store.errors[`description.${index}`]"
                                        :class="{
                                            'w-full p-2 rounded text-sm text-gray-700 focus:outline-none': true,
                                            'border border-red-500 focus:ring-red-500 focus:border-red-500': $store.errors[`description.${index}`],
                                            'border border-gray-300 focus:ring-gray-400 focus:ring-1 focus:border-gray-400': !$store.errors[`description.${index}`]
                                        }"></textarea>
                                    <template x-if="$store.errors[`description.${index}`]">
                                        <p class="text-red-500 text-sm" x-text="$store.errors[`description.${index}`]"></p>
                                    </template>
                                </div>

                                <div>
                                    <label class="block text-gray-700 font-medium mb-2">Link</label>
                                    <input type="text" :name="`link[]`" x-model="item.link" placeholder="Masukkan link materi"
                                        @input="delete $store.errors[`link.${index}`]"
                                        :class="{
                                            'w-full p-2 rounded text-sm text-gray-700 focus:outline-none': true,
                                            'border border-red-500 focus:ring-red-500 focus:border-red-500': $store.errors[`link.${index}`],
                                            'border border-gray-300 focus:ring-gray-400 focus:ring-1 focus:border-gray-400': !$store.errors[`link.${index}`]
                                        }">
                                    <template x-if="$store.errors[`link.${index}`]">
                                        <p class="text-red-500 text-sm" x-text="$store.errors[`link.${index}`]"></p>
                                    </template>
                                </div>

                                <div class="text-left">
                                    <!-- Ganti parameter dari index ke item -->
                                    <button type="button" @click="removeMateri(item)"
                                        class="inline-flex items-center gap-1 px-3 py-1.5 rounded-md bg-red-400 text-white text-sm shadow hover:bg-red-300 mt-1 transition">
                                        Hapus
                                    </button>
                                </div>
                            </div>
                        </template>
                    </template>

                    <div>
                        <button type="button" @click="addMateri('youtube')"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-blue-400 hover:bg-blue-300 text-white rounded-md text-sm shadow transition">
                            Tambah Materi YouTube
                        </button>
                    </div>
                </div>

            <!-- Tombol Submit -->
            <div class="mt-6 flex justify-end space-x-2">
                <a href="{{ route('courses.show', $course->slug) }}" class="bg-red-400 hover:bg-red-300 text-white font-medium py-2 px-4 rounded-md">
                    Batal
                </a>
                <button type="submit" class="bg-sky-400 hover:bg-sky-300 text-white font-medium py-2 px-4 rounded-md">
                    Simpan
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
