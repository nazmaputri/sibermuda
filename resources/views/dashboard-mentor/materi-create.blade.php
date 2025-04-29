@extends('layouts.dashboard-mentor')
@section('title', 'Tambah Materi')
@section('content')
<div class="container mx-auto">
    <div class="bg-white shadow-md rounded-lg p-6 border border-gray-200">
        <h2 class="text-xl font-semibold mb-4 border-b-2 pb-2 text-gray-700 text-center">Tambah Materi</h2>

        <form action="{{ route('materi.store', ['courseId' => $course->id]) }}" method="POST" enctype="multipart/form-data" class="w-full">
            @csrf
            <div class="grid grid-cols-1 gap-2">

                <!-- Judul dan Deskripsi -->
                <div>
                    <div class="mb-4">
                        <label for="judul" class="block text-gray-700 font-semibold mb-2">Judul Materi</label>
                        <input type="text" name="judul" id="judul" class="w-full p-2 border text-sm text-gray-700 rounded focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400" placeholder="Masukkan judul materi" value="{{ old('judul') }}">
                        @error('judul')
                            <div class="text-red-600">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="deskripsi" class="block text-gray-700 font-semibold mb-2">Deskripsi Materi</label>
                        <textarea name="deskripsi" id="deskripsi" rows="3" class="w-full p-2 text-sm text-gray-700 border rounded focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400" placeholder="Masukkan deskripsi materi">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <div class="text-red-600">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Materi Drive dan Youtube -->
                <div 
                x-data="{
                    materiDrive: [],
                    materiYoutube: [],
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
                        <!-- Drive Section -->
                        <div>
                            <template x-for="(item, index) in materiDrive" :key="'drive-' + index">
                                <div class="border p-4 rounded bg-white mb-2 space-y-2">
                                    <input type="hidden" :name="`type[]`" x-model="item.type">
                                    <input type="hidden" :name="`id[]`" :value="item.id">

                                    <label class="block text-gray-700 font-semibold mb-2">Judul Link Materi G-drive</label>
                                    <input type="text" :name="`title[]`" x-model="item.title" class="w-full p-2 border text-sm text-gray-700 rounded focus:outline-none focus:ring-1 focus:ring-gray-400">

                                    <label class="block text-gray-700 font-semibold mb-2">Deskripsi Link Materi G-drive</label>
                                    <textarea :name="`description[]`" x-model="item.description" class="w-full p-2 border text-sm text-gray-700 rounded focus:outline-none focus:ring-1 focus:ring-gray-400"></textarea>

                                    <label class="block text-gray-700 font-semibold mb-2">Link Materi G-drive</label>
                                    <input type="text" :name="`link[]`" x-model="item.link" class="w-full p-2 border text-sm text-gray-700 rounded focus:outline-none focus:ring-1 focus:ring-gray-400">

                                    <div class="text-right">
                                        <button type="button" @click="removeMateri('drive', index)" class="bg-red-400 hover:bg-red-300 text-white px-3 py-1 rounded text-sm">Hapus</button>
                                    </div>
                                </div>
                            </template>

                            <button type="button" @click="addMateri('drive')" class="bg-green-400 hover:bg-green-300 text-white px-4 py-2 text-sm rounded">
                                + Tambah Materi G-Drive
                            </button>
                        </div>

                        <!-- YouTube Section -->
                        <div>
                            <template x-for="(item, index) in materiYoutube" :key="'youtube-' + index">
                                <div class="border p-4 rounded bg-white mb-2 space-y-2">
                                    <input type="hidden" :name="`type[]`" x-model="item.type">
                                    <input type="hidden" :name="`id[]`" :value="item.id">

                                    <label class="block text-gray-700 font-semibold mb-2">Judul Link Materi YouTube</label>
                                    <input type="text" :name="`title[]`" x-model="item.title" class="w-full p-2 border text-sm text-gray-700 rounded focus:outline-none focus:ring-1 focus:ring-gray-400">

                                    <label class="block text-gray-700 font-semibold mb-2">Deskripsi Link Materi YouTube</label>
                                    <textarea :name="`description[]`" x-model="item.description" class="w-full p-2 border text-sm text-gray-700 rounded focus:outline-none focus:ring-1 focus:ring-gray-400"></textarea>

                                    <label class="block text-gray-700 font-semibold mb-2">Link Materi YouTube</label>
                                    <input type="text" :name="`link[]`" x-model="item.link" class="w-full p-2 border text-sm text-gray-700 rounded focus:outline-none focus:ring-1 focus:ring-gray-400">

                                    <div class="text-right">
                                        <button type="button" @click="removeMateri('youtube', index)" class="bg-red-400 hover:bg-red-300 text-white px-3 py-1 rounded text-sm">Hapus</button>
                                    </div>
                                </div>
                            </template>

                            <button type="button" @click="addMateri('youtube')" class="bg-blue-400 hover:bg-blue-300 text-white px-4 py-2 text-sm rounded">
                                + Tambah Materi YouTube
                            </button>
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