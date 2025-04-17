@extends('layouts.dashboard-mentor')
@section('title', 'Tambah Materi')
@section('content')
<div class="container mx-auto">
    <!-- Judul Utama -->
    <div class="bg-white shadow-md rounded-lg p-6 border border-gray-200">
        <h2 class="text-xl font-semibold mb-8 border-b-2 pb-2 text-gray-700 text-center">Tambah Materi</h2>

        <!-- Form Tambah Materi dan YouTube -->
        <form action="{{ route('materi.store', ['courseId' => $course->id]) }}" method="POST" enctype="multipart/form-data" class="w-full">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Kiri: Input Judul dan Deskripsi -->
                <div>
                    <!-- Input untuk Judul Materi -->
                    <div class="mb-4">
                        <label for="judul" class="block text-gray-700 font-semibold mb-2">Judul Materi</label>
                        <input type="text" name="judul" id="judul" class="w-full p-2 border text-sm text-gray-700 rounded focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500" placeholder="Masukkan judul materi" value="{{ old('judul') }}">
                        @error('judul')
                            <div class="text-red-600">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Input untuk Deskripsi Materi -->
                    <div class="mb-4">
                        <label for="deskripsi" class="block text-gray-700 font-semibold mb-2">Deskripsi Materi</label>
                        <textarea name="deskripsi" id="deskripsi" rows="3" class="w-full p-2 text-sm text-gray-700 border rounded focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500" placeholder="Masukkan deskripsi materi">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <div class="text-red-600">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Kanan: Input Materi dan YouTube -->
                <div x-data="{
                    materi: [{
                        title: '',
                        description: '',
                        link: ''
                    }],
                    youtube: [{
                        title: '',
                        description: '',
                        link: ''
                    }],
                    addMateri() {
                        this.materi.push({ title: '', description: '', link: '' });
                    },
                    removeMateri(index) {
                        this.materi.splice(index, 1);
                    },
                    addYouTube() {
                        this.youtube.push({ title: '', description: '', link: '' });
                    },
                    removeYouTube(index) {
                        this.youtube.splice(index, 1);
                    }
                }">

                    <!-- Input untuk Materi -->
                    <template x-for="(item, index) in materi" :key="index">
                        <div class="materi-group border p-4 rounded space-y-1 bg-gray-50 mb-4">
                            <input type="hidden" name="courses_id[]" value="{{ $course->id }}">

                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Judul Link Materi</label>
                                <input type="text" :name="`title[]`" x-model="item.title" placeholder="Masukkan judul"
                                    class="w-full p-2 border text-sm text-gray-700 rounded focus:outline-none focus:ring-1 focus:ring-sky-500">
                            </div>

                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Deskripsi Link Materi</label>
                                <textarea :name="`description[]`" x-model="item.description" rows="3"
                                        placeholder="Masukkan deskripsi materi"
                                        class="w-full p-2 border text-sm text-gray-700 rounded focus:outline-none focus:ring-1 focus:ring-sky-500"></textarea>
                            </div>

                            <div class="mb-2">
                                <label class="block text-gray-700 font-semibold mb-2">Link Materi</label>
                                <input type="link" :name="`link[]`" x-model="item.link" placeholder="Masukkan link"
                                    class="w-full p-2 border text-sm text-gray-700 rounded focus:outline-none focus:ring-1 focus:ring-sky-500">
                            </div>

                            <!-- Tombol Hapus Materi -->
                            <div class="text-right" x-show="materi.length > 1">
                                <button type="button"
                                    @click="removeMateri(index)"
                                    class="inline-flex items-center gap-1 px-3 py-1.5 rounded-md bg-red-400 text-white text-sm shadow hover:bg-red-300 mt-2 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                    Hapus
                                </button>
                            </div>

                        </div>
                    </template>

                    <!-- Tombol Tambah Materi -->
                    <div>
                        <button type="button"
                            @click="addMateri"
                            class="inline-flex items-center gap-2 px-4 py-2 mt-2 bg-green-400 text-white rounded-md text-sm shadow hover:bg-green-300 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"> 
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                            </svg>
                            Tambah Materi
                        </button>
                    </div>

                    <!-- Input untuk YouTube -->
                    <template x-for="(item, index) in youtube" :key="index">
                        <div class="materi-group border p-4 rounded space-y-1 bg-gray-50 mb-4">

                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Judul Video YouTube</label>
                                <input type="text" :name="`youtube_title[]`" x-model="item.title" placeholder="Masukkan judul video"
                                    class="w-full p-2 border text-sm text-gray-700 rounded focus:outline-none focus:ring-1 focus:ring-sky-500">
                            </div>

                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Deskripsi Video YouTube</label>
                                <textarea :name="`youtube_description[]`" x-model="item.description" rows="3"
                                        placeholder="Masukkan deskripsi video"
                                        class="w-full p-2 border text-sm text-gray-700 rounded focus:outline-none focus:ring-1 focus:ring-sky-500"></textarea>
                            </div>

                            <div class="mb-2">
                                <label class="block text-gray-700 font-semibold mb-2">Link YouTube</label>
                                <input type="text" :name="`youtube_link[]`" x-model="item.link" placeholder="Masukkan link video"
                                    class="w-full p-2 border text-sm text-gray-700 rounded focus:outline-none focus:ring-1 focus:ring-sky-500">
                            </div>

                            <!-- Tombol Hapus YouTube -->
                            <div class="text-right" x-show="youtube.length > 1">
                                <button type="button"
                                    @click="removeYouTube(index)"
                                    class="inline-flex items-center gap-1 px-3 py-1.5 rounded-md bg-red-400 text-white text-sm shadow hover:bg-red-300 mt-2 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                    Hapus
                                </button>
                            </div>

                        </div>
                    </template>

                    <!-- Tombol Tambah YouTube -->
                    <div>
                        <button type="button"
                            @click="addYouTube"
                            class="inline-flex items-center gap-2 px-4 py-2 mt-2 bg-blue-400 text-white rounded-md text-sm shadow hover:bg-blue-300 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"> 
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                            </svg>
                            Tambah YouTube
                        </button>
                    </div>

                </div>

            </div>

            <!-- Tombol Submit -->
            <div class="mt-6 flex justify-end space-x-2">
                <a href="{{ route('courses.show', $course->id)}}" class="bg-red-400 hover:bg-red-300 text-white font-semibold py-2 px-4 rounded-lg">
                    Batal
                </a>
                <button type="submit" class="bg-sky-400 hover:bg-sky-300 text-white font-semibold py-2 px-4 rounded-lg">
                    Tambah 
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
