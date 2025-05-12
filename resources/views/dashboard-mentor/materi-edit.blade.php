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
                        <input type="text" name="judul" id="judul" class="w-full p-2 text-sm text-gray-700 border rounded focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400" placeholder="Masukkan judul materi" value="{{ old('judul', $materi->judul) }}">
                        @error('judul')
                            <div class="text-red-400">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="deskripsi" class="block text-gray-700 font-medium mb-2">Deskripsi</label>
                        <textarea name="deskripsi" id="deskripsi" rows="4" class="w-full p-2 text-sm text-gray-700 border rounded focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400" placeholder="Masukkan deskripsi materi">{{ old('deskripsi', $materi->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <div class="text-red-400">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div x-data="{
                    materiDrive: [
                        @foreach ($materi->videos as $drive)
                            {
                                title: @js($drive->title),
                                description: @js($drive->description),
                                link: 'https://drive.google.com/file/d/{{ $drive->link }}/preview',
                                type: 'drive'
                            },
                        @endforeach
                    ],
                    materiYoutube: [
                        @foreach ($materi->youtube as $yt)
                            {
                                title: @js($yt->title),
                                description: @js($yt->description),
                                link: 'https://www.youtube.com/watch?v={{ $yt->link }}',
                                type: 'youtube'
                            },
                        @endforeach
                    ],
                    addMateri(type) {
                        if (type === 'drive') {
                            this.materiDrive.push({ title: '', description: '', link: '', type: 'drive' });
                        } else if (type === 'youtube') {
                            this.materiYoutube.push({ title: '', description: '', link: '', type: 'youtube' });
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
                        <!-- Drive Template -->
                        <div>
                            <template x-for="(item, index) in materiDrive" :key="'drive-' + index">
                                <div class="materi-group border p-4 rounded space-y-2 bg-white mb-2">
                                    <input type="hidden" name="courses_id[]" value="{{ $course->id }}">
                                    <input type="hidden" :name="`type[]`" x-model="item.type">

                                    <div>
                                        <label class="block text-gray-700 font-medium mb-2">Judul Link Materi G-drive</label>
                                        <input type="text" :name="`title[]`" x-model="item.title" placeholder="Masukkan judul"
                                            class="w-full p-2 border text-sm text-gray-700 rounded focus:outline-none focus:ring-2 focus:ring-gray-400">
                                    </div>

                                    <div>
                                        <label class="block text-gray-700 font-medium mb-2">Deskripsi Link Materi G-drive</label>
                                        <textarea :name="`description[]`" x-model="item.description" rows="3"
                                            placeholder="Masukkan deskripsi materi"
                                            class="w-full p-2 border text-sm text-gray-700 rounded focus:outline-none focus:ring-2 focus:ring-gray-400"></textarea>
                                    </div>

                                    <div>
                                        <label class="block text-gray-700 font-medium mb-2">Link Materi G-drive</label>
                                        <input type="text" :name="`link[]`" x-model="item.link" placeholder="Masukkan link"
                                            class="w-full p-2 border text-sm text-gray-700 rounded focus:outline-none focus:ring-2 focus:ring-gray-400">
                                    </div>

                                    <div class="text-left" x-show="materiDrive.length > 0">
                                        <button type="button" @click="removeMateri('drive', index)"
                                            class="inline-flex items-center gap-1 px-3 py-1.5 rounded-md bg-red-400 hover:bg-red-300 text-white text-sm shadow mt-1 transition">
                                            Hapus
                                        </button>
                                    </div>
                                </div>
                            </template>
                            <button type="button" @click="addMateri('drive')"
                                class="inline-flex items-center gap-2 px-4 py-2 bg-green-400 hover:bg-green-300 text-white rounded-md text-sm shadow  transition">
                                Tambah Materi G-Drive
                            </button>
                        </div>

                        <!-- YouTube Template -->
                        <div>
                            <template x-for="(item, index) in materiYoutube" :key="'youtube-' + index">
                                <div class="materi-group border p-4 rounded space-y-2 bg-white mb-2">
                                    <input type="hidden" name="courses_id[]" value="{{ $course->id }}">
                                    <input type="hidden" :name="`type[]`" x-model="item.type">

                                    <div>
                                        <label class="block text-gray-700 font-medium mb-2">Judul Link Materi Youtube</label>
                                        <input type="text" :name="`title[]`" x-model="item.title" placeholder="Masukkan judul"
                                            class="w-full p-2 border text-sm text-gray-700 rounded focus:outline-none focus:ring-2 focus:ring-gray-400">
                                    </div>

                                    <div>
                                        <label class="block text-gray-700 font-medium mb-2">Deskripsi Link Materi Youtube</label>
                                        <textarea :name="`description[]`" x-model="item.description" rows="3"
                                            placeholder="Masukkan deskripsi materi"
                                            class="w-full p-2 border text-sm text-gray-700 rounded focus:outline-none focus:ring-2 focus:ring-gray-400"></textarea>
                                    </div>

                                    <div>
                                        <label class="block text-gray-700 font-medium mb-2">Link Materi Youtube</label>
                                        <input type="text" :name="`link[]`" x-model="item.link" placeholder="Masukkan link"
                                            class="w-full p-2 border text-sm text-gray-700 rounded focus:outline-none focus:ring-2 focus:ring-gray-400">
                                    </div>

                                    <div class="text-left" x-show="materiYoutube.length > 0">
                                        <button type="button" @click="removeMateri('youtube', index)"
                                            class="inline-flex items-center gap-1 px-3 py-1.5 rounded-md bg-red-400 text-white text-sm shadow hover:bg-red-300 mt-1 transition">
                                            Hapus
                                        </button>
                                    </div>
                                </div>
                            </template>
                            <button type="button" @click="addMateri('youtube')"
                                class="inline-flex items-center gap-2 px-4 py-2 bg-blue-400 hover:bg-blue-300 text-white rounded-md text-sm shadow transition">
                                Tambah Materi YouTube
                            </button>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Tombol Submit -->
            <div class="mt-6 flex justify-end space-x-2">
                <a href="{{ route('courses.show', $course->id) }}" class="bg-red-400 hover:bg-red-300 text-white font-medium py-2 px-4 rounded-md">
                    Batal
                </a>
                <button type="submit" class="bg-sky-400 hover:bg-sky-300 text-white font-medium py-2 px-4 rounded-md">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
