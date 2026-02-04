@extends('layouts.dashboard-admin')
@section('title', 'Detail Berita')
@section('content')
<div class="container mx-auto">
    <div class="bg-white rounded-lg p-6 border border-gray-200">
        <!-- Header -->
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Detail Berita</h2>
                <p class="text-gray-600 text-sm mt-1">Informasi lengkap berita</p>
            </div>
            <a href="{{ route('news.index') }}"
                class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 font-semibold">
                Kembali
            </a>
        </div>

        <!-- Content -->
        <div class="space-y-6">
            <!-- Image -->
            @if($news->image_path)
            <div>
                <img src="{{ $news->image_path }}" alt="{{ $news->title }}" class="w-full max-h-96 object-cover rounded-lg">
            </div>
            @endif

            <!-- Title -->
            <div>
                <label class="block text-gray-600 font-semibold mb-2">Judul Berita</label>
                <p class="text-gray-800 text-lg">{{ $news->title }}</p>
            </div>

            <!-- Meta Info -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-gray-600 font-semibold mb-2">Kategori</label>
                    <span class="inline-block px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-semibold">
                        {{ $news->category }}
                    </span>
                </div>
                <div>
                    <label class="block text-gray-600 font-semibold mb-2">Penulis</label>
                    <p class="text-gray-800">{{ $news->author }}</p>
                </div>
                <div>
                    <label class="block text-gray-600 font-semibold mb-2">Tanggal Publish</label>
                    <p class="text-gray-800">{{ $news->published_at->format('d M Y H:i') }}</p>
                </div>
            </div>

            <!-- Views -->
            <div>
                <label class="block text-gray-600 font-semibold mb-2">Jumlah Views</label>
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-gray-800">{{ number_format($news->views) }}</span>
                </div>
            </div>

            <!-- Content -->
            <div>
                <label class="block text-gray-600 font-semibold mb-2">Konten Berita</label>
                <div class="text-gray-800 leading-relaxed whitespace-pre-line bg-gray-50 p-4 rounded-lg">
                    {{ $news->content }}
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center space-x-3 pt-4 border-t">
                <a href="{{ route('news.edit', $news->id) }}"
                    class="px-4 py-2 bg-yellow-300 text-white rounded-lg hover:bg-yellow-200 font-semibold">
                    Edit Berita
                </a>
                <form action="{{ route('news.destroy', $news->id) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="px-4 py-2 bg-red-400 text-white rounded-lg hover:bg-red-300 font-semibold"
                        onclick="return confirm('Apakah Anda yakin ingin menghapus berita ini?')">
                        Hapus Berita
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
