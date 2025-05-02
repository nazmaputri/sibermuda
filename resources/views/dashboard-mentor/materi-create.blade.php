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
                        <label for="judul" class="block text-gray-700 font-semibold mb-2">Judul Materi</label>
                        <input type="text" name="judul" id="judul" class="w-full p-2 border text-sm text-gray-700 rounded focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400" placeholder="Masukkan judul materi" value="{{ old('judul') }}">
                        @error('judul')
                            <div class="text-red-600">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Input untuk Deskripsi Materi -->
                    <div class="mb-4">
                        <label for="deskripsi" class="block text-gray-700 font-semibold mb-2">Deskripsi Materi</label>
                        <textarea name="deskripsi" id="deskripsi" rows="3" class="w-full p-2 text-sm text-gray-700 border rounded focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400" placeholder="Masukkan deskripsi materi">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <div class="text-red-600">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div x-data="{
                    materiDrive: [
                        @foreach ($materi->videos as $drive)
                            {
                                id: {{ $drive->id }},
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
                                id: {{ $yt->id }},
                                title: @js($yt->title),
                                description: @js($yt->description),
                                link: 'https://www.youtube.com/watch?v={{ $yt->link }}',
                                type: 'youtube'
                            },
                        @endforeach
                    ],
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
                        <!-- Drive -->
                        <div>
                            <template x-for="(item, index) in materiDrive" :key="'drive-' + index">
                                <div class="border p-4 rounded bg-white mb-2 space-y-2">
                                    <input type="hidden" :name="type[]" x-model="item.type">
                                    <input type="hidden" :name="id[]" :value="item.id">

                                    <label>Judul Link Materi G-drive</label>
                                    <input type="text" :name="title[]" x-model="item.title" class="w-full border p-2 rounded">

                                    <label>Deskripsi Link Materi G-drive</label>
                                    <textarea :name="description[]" x-model="item.description" class="w-full border p-2 rounded"></textarea>

                                    <label>Link Materi G-drive</label>
                                    <input type="text" :name="link[]" x-model="item.link" class="w-full border p-2 rounded">

                                    <div class="text-right" x-show="materiDrive.length > 1">
                                        <button type="button" @click="removeMateri('drive', index)" class="bg-red-500 text-white px-3 py-1 rounded">Hapus</button>
                                    </div>
                                </div>
                            </template>
                            <button type="button" @click="addMateri('drive')" class="bg-green-500 text-white px-4 py-2 rounded">+ Tambah Materi Drive</button>
                        </div>

                        <!-- YouTube -->
                        <div>
                            <template x-for="(item, index) in materiYoutube" :key="'youtube-' + index">
                                <div class="border p-4 rounded bg-white mb-2 space-y-2">
                                    <input type="hidden" :name="type[]" x-model="item.type">
                                    <input type="hidden" :name="id[]" :value="item.id">

                                    <label>Judul Link Materi YouTube</label>
                                    <input type="text" :name="title[]" x-model="item.title" class="w-full border p-2 rounded">

                                    <label>Deskripsi Link Materi YouTube</label>
                                    <textarea :name="description[]" x-model="item.description" class="w-full border p-2 rounded"></textarea>

                                    <label>Link Materi YouTube</label>
                                    <input type="text" :name="link[]" x-model="item.link" class="w-full border p-2 rounded">

                                    <div class="text-right" x-show="materiYoutube.length > 1">
                                        <button type="button" @click="removeMateri('youtube', index)" class="bg-red-500 text-white px-3 py-1 rounded">Hapus</button>
                                    </div>
                                </div>
                            </template>
                            <button type="button" @click="addMateri('youtube')" class="bg-blue-500 text-white px-4 py-2 rounded">+ Tambah Materi YouTube</button>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Tombol Submit -->
            <div class="mt-6 flex justify-end space-x-2">
                <a href="{{ route('courses.show', $course->id)}}" class="bg-red-400 hover:bg-red-300 text-white font-semibold py-2 px-4 rounded-md">
                    Batal
                </a>
                <button type="submit" class="bg-sky-400 hover:bg-sky-300 text-white font-semibold py-2 px-4 rounded-md">
                    Tambah 
                </button>
            </div>
        </form>
    </div>
</div>

@endsection