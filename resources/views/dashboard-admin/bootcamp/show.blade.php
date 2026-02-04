@extends('layouts.dashboard-admin')
@section('title', 'Detail Bootcamp')
@section('content')
<div class="container mx-auto bg-white rounded-lg p-5 border border-gray-200">
    <!-- Header -->
    <div class="mb-6 flex items-center justify-between">
        <h2 class="text-2xl font-bold text-gray-700">Detail Bootcamp</h2>
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.bootcamp.edit', $bootcamp->id) }}" class="inline-flex items-center space-x-2 bg-yellow-300 text-white px-4 py-2 rounded-lg hover:bg-yellow-200">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                </svg>
                <span>Edit</span>
            </a>
            <a href="{{ route('admin.bootcamp.index') }}" class="inline-flex items-center space-x-2 text-gray-600 hover:text-gray-800">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Gambar Bootcamp -->
            @if($bootcamp->image)
            <div class="rounded-lg overflow-hidden border border-gray-200">
                <img src="{{ asset('storage/' . $bootcamp->image) }}" alt="{{ $bootcamp->title }}" class="w-full h-64 object-cover">
            </div>
            @endif

            <!-- Informasi Utama -->
            <div class="border border-gray-200 rounded-lg p-5">
                <h3 class="text-xl font-bold text-gray-700 mb-4">{{ $bootcamp->title }}</h3>
                <p class="text-gray-600 text-sm leading-relaxed mb-4">{{ $bootcamp->description }}</p>

                <div class="flex items-center space-x-4 text-sm text-gray-600">
                    <span class="px-3 py-1 bg-purple-100 text-purple-600 rounded-full">{{ $bootcamp->level }}</span>
                    <span class="flex items-center space-x-1">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        <span>{{ $bootcamp->duration }}</span>
                    </span>
                </div>
            </div>

            <!-- Fitur Bootcamp -->
            @if($bootcamp->features && count($bootcamp->features) > 0)
            <div class="border border-gray-200 rounded-lg p-5">
                <h4 class="text-lg font-bold text-gray-700 mb-3">Fitur Bootcamp</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    @foreach($bootcamp->features as $feature)
                    <div class="flex items-start space-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        <span class="text-sm text-gray-600">{{ $feature }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Silabus -->
            @if($bootcamp->syllabus && count($bootcamp->syllabus) > 0)
            <div class="border border-gray-200 rounded-lg p-5">
                <h4 class="text-lg font-bold text-gray-700 mb-3">Silabus Pembelajaran</h4>
                <div class="space-y-2">
                    @foreach($bootcamp->syllabus as $index => $item)
                    <div class="flex items-start space-x-3 p-3 bg-gray-50 rounded-lg">
                        <span class="flex-shrink-0 w-8 h-8 bg-blue-400 text-white rounded-full flex items-center justify-center text-sm font-semibold">
                            {{ $index + 1 }}
                        </span>
                        <span class="text-sm text-gray-700 mt-1">{{ $item }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Info Card -->
            <div class="border border-gray-200 rounded-lg p-5">
                <h4 class="text-lg font-bold text-gray-700 mb-4">Informasi Bootcamp</h4>

                <!-- Harga -->
                <div class="mb-4 pb-4 border-b border-gray-200">
                    <p class="text-sm text-gray-500 mb-1">Harga</p>
                    @if($bootcamp->discount_price)
                        <p class="text-sm text-gray-400 line-through">{{ $bootcamp->price }}</p>
                        <p class="text-2xl font-bold text-green-600">{{ $bootcamp->discount_price }}</p>
                    @else
                        <p class="text-2xl font-bold text-gray-700">{{ $bootcamp->price }}</p>
                    @endif
                </div>

                <!-- Jadwal -->
                <div class="mb-4 pb-4 border-b border-gray-200">
                    <p class="text-sm text-gray-500 mb-1">Jadwal</p>
                    <p class="text-sm text-gray-700">{{ $bootcamp->schedule }}</p>
                </div>

                <!-- Durasi -->
                <div class="mb-4 pb-4 border-b border-gray-200">
                    <p class="text-sm text-gray-500 mb-1">Durasi Program</p>
                    <p class="text-sm text-gray-700">{{ $bootcamp->duration }}</p>
                </div>

                <!-- Level -->
                <div class="mb-4 pb-4 border-b border-gray-200">
                    <p class="text-sm text-gray-500 mb-1">Level</p>
                    <p class="text-sm text-gray-700">{{ $bootcamp->level }}</p>
                </div>

                <!-- Status -->
                <div class="mb-4">
                    <p class="text-sm text-gray-500 mb-1">Status</p>
                    @if($bootcamp->is_active)
                        <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-600">Aktif</span>
                    @else
                        <span class="px-3 py-1 text-xs rounded-full bg-red-100 text-red-600">Nonaktif</span>
                    @endif
                </div>
            </div>

            <!-- Metadata -->
            <div class="border border-gray-200 rounded-lg p-5">
                <h4 class="text-lg font-bold text-gray-700 mb-4">Metadata</h4>

                <div class="mb-3">
                    <p class="text-xs text-gray-500">Slug</p>
                    <p class="text-sm text-gray-700 font-mono">{{ $bootcamp->slug }}</p>
                </div>

                <div class="mb-3">
                    <p class="text-xs text-gray-500">Dibuat Pada</p>
                    <p class="text-sm text-gray-700">{{ $bootcamp->created_at->format('d M Y, H:i') }}</p>
                </div>

                <div>
                    <p class="text-xs text-gray-500">Terakhir Diupdate</p>
                    <p class="text-sm text-gray-700">{{ $bootcamp->updated_at->format('d M Y, H:i') }}</p>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="space-y-2">
                <a href="{{ route('admin.bootcamp.edit', $bootcamp->id) }}" class="block w-full text-center bg-yellow-300 text-white px-4 py-2 rounded-lg hover:bg-yellow-200 font-semibold">
                    Edit Bootcamp
                </a>
                <form action="{{ route('admin.bootcamp.destroy', $bootcamp->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus bootcamp ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full bg-red-400 text-white px-4 py-2 rounded-lg hover:bg-red-300 font-semibold">
                        Hapus Bootcamp
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
