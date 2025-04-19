@extends('layouts.dashboard-mentor')
@section('title', 'Detail Kursus')
@section('content')

<div class="mb-3 flex justify-start">
    <a href="{{ route('courses.index') }}" class="text-midnight font-semibold p-1 bg-white border border-gray-200 rounded-full transition-transform duration-300 ease-in-out transform hover:scale-105">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
        </svg>
    </a>
</div>

<div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
    <h2 class="text-lg font-semibold mb-8 border-b-2 pb-2 text-gray-700 text-center">Detail Kursus</h2>
    <!-- Card Informasi Kursus -->
    <div class="flex flex-col lg:flex-row mb-4">
        <div class="w-full sm:w-1/4 md:w-1/5 mb-4 lg:mb-0">
            <img src="{{ asset('storage/' . $course->image_path) }}" alt="{{ $course->title }}" class="rounded-lg w-full h-auto">
        </div>
        <div class="ml-4 w-2/3 space-y-3">
            <h2 class="text-md font-semibold text-gray-700 mb-2 capitalize">{{ $course->title }}</h2>
            <p class="text-gray-700 mb-2 text-md">{{ $course->description }}</p>
            <p class="text-gray-600 text-sm capitalize">Mentor :{{ $course->mentor->name }}</p>
            <p class="text-gray-600 text-sm">Harga :<span class="text-red-400">Rp {{ number_format($course->price, 0, ',', '.') }}</span></p>
                @if($course->start_date && $course->end_date)
                    <p class="text-gray-600 text-sm">Tanggal Mulai: {{ \Carbon\Carbon::parse($course->start_date)->translatedformat('d F Y') }} - {{ \Carbon\Carbon::parse($course->end_date)->translatedformat('d F Y') }}</p>
                @endif
                @if($course->duration)
                    <p class="text-gray-600 text-sm">Masa Aktif :{{ $course->duration }}</p>
                @endif
                @if($course->capacity)
                    <p class="text-gray-600 text-sm">Kapasitas :{{ $course->capacity }} Peserta</p>
                @endif                  
            <p class="text-gray-600 text-sm capitalize">Status :{{ $course->status }}</p>
            <p class="text-sm {{ $course->chat ? 'text-green-500' : 'text-red-500' }}">
                {{ $course->chat ? 'Fitur Chat Aktif' : 'Fitur Chat Tidak Aktif' }}
            </p> 
            <!-- Tombol untuk melihat sertifikat -->
            <p id="view-certificate-btn" class="cursor-pointer text-blue-500 hover:underline text-sm">Lihat Sertifikat</p>
        </div>
     </div>          
                
    <div class="mb-2 flex items-center justify-between p-1 border-b-2">
        <h2 class="text-lg font-semibold text-gray-700 pt-2">
            Materi Kursus
        </h2>                                                     
    </div>
                    
    <div class="text-right">
        <a href="{{ route('materi.create', ['courseId' => $course->id]) }}" class="mt-2 inline-flex shadow-md shadow-blue-100 hover:shadow-none items-center space-x-2 text-white bg-blue-400 hover:bg-blue-300 font-semibold py-2 px-4 rounded-md">
            <!-- Ikon muncul pada semua ukuran layar -->
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            <!-- Teks hanya muncul pada mode desktop (sm dan lebih besar) -->
            <span class="ml-2 text-sm">Tambah Materi</span>
        </a> 
    </div>
        
    <!-- Tabel Materi -->
    <div class="overflow-hidden overflow-x-auto w-full">
        <div class="min-w-full w-64">
            <table class="min-w-full mt-4 border-separate border-spacing-0">
                <thead>
                    <tr class="bg-gray-100 text-sm text-gray-500">
                        <th class="px-4 py-2 border-b border-t border-l border-gray-200 rounded-tl-lg">No</th>
                        <th class="px-4 py-2  border-b border-t border-gray-200">Judul</th>
                        <th class="px-4 py-2  border-b border-t border-gray-200">Kursus</th>
                        <th class="px-4 py-2  border-b border-t border-r border-gray-200 rounded-tr-lg">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm">
                @php
                $startNumber = ($materi->currentPage() - 1) * $materi->perPage() + 1;
                @endphp

                @if ($materi->isEmpty())
                    <tr>
                        <td colspan="4" class="text-center text-gray-500 py-2 text-sm border-l border-b border-r">Belum ada materi untuk kursus ini.</td>
                    </tr>
                @else
                    @foreach ($materi as $index => $materiItem)
                        <tr class="bg-white hover:bg-gray-50 user-row text-sm text-gray-500">
                            <td class="px-4 py-2 text-center border-b border-l  border-gray-200">{{ $startNumber + $index }}</td>
                            <td class="px-4 py-2 border-b border-gray-200">{{ $materiItem->judul }}</td>
                            <td class="px-4 py-2 border-b border-gray-200">{{ $materiItem->course->title ?? 'Kursus tidak ditemukan' }}</td>
                            <td class="py-2 px-4 text-center border-b  border-r border-gray-200">
                            <div class="flex items-center justify-center space-x-4">
                                <!-- Toggle preview -->
                                <form action="{{ route('materi.togglePreview', $materiItem->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <label for="preview-toggle-{{ $materiItem->id }}" class="flex items-center cursor-pointer" title="{{ $materiItem->is_preview ? 'Sembunyikan Preview' : 'Tampilkan Preview' }}">
                                        <div class="relative">
                                            <input type="checkbox" name="is_preview" id="preview-toggle-{{ $materiItem->id }}" class="hidden peer" {{ $materiItem->is_preview ? 'checked' : '' }} value="1" onchange="this.form.submit()" />
                                            <div class="block bg-gray-300 w-9 h-5 rounded-full peer-checked:bg-green-500 peer-checked:justify-end"></div>
                                            <div class="dot absolute top-0.5 start-[2px] bg-white h-4 w-4 rounded-full transition-transform peer-checked:translate-x-full"></div>
                                        </div>
                                    </label>
                                </form>

                                <!-- button lihat detail materi -->
                                <a href="{{ route('materi.show', ['courseId' => $course->id, $materiItem->id]) }}" class="text-white bg-sky-300 p-1 rounded-md hover:bg-sky-200" title="Lihat">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                </a>

                                <!-- button edit materi -->
                                <a href="{{ route('materi.edit', ['courseId' => $course->id, $materiItem->id]) }}" class="text-white bg-yellow-300 p-1 rounded-md hover:bg-yellow-200" title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>
                                </a>

                                <!-- Tombol untuk membuka modal -->
                                <form action="{{ route('materi.destroy', ['courseId' => $course->id, 'materiId' => $materiItem->id]) }}" method="POST" class="inline" title="Hapus">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn-delete text-white bg-red-400 p-1 rounded-md hover:bg-red-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-4">
        {{ $materi->links() }}
    </div>
</div>

<!-- Section Tugas Akhir -->
<div class="bg-white p-6 rounded-lg shadow-md mt-6 border border-gray-200">
    <div class="mb-2 flex items-center justify-between p-1 border-b-2">
        <h2 class="text-lg font-semibold text-gray-700 pt-2">Kuis dari Keseluruhan Materi</h2>                                                     
    </div>
    <div class="text-right">
        <a href="{{ route('quiz.create', ['courseId' => $course->id]) }}" class="mt-2 inline-flex shadow-md shadow-blue-100 hover:shadow-none items-center space-x-2 text-white bg-blue-400 hover:bg-blue-300 font-semibold py-2 px-4 rounded-md">
            <!-- Ikon muncul pada semua ukuran layar -->
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            <!-- Teks hanya muncul pada mode desktop (sm dan lebih besar) -->
            <span class="ml-2 text-sm">Tambah Kuis</span>
        </a> 
    </div>
     <!-- Kuis -->
    <div class="overflow-hidden overflow-x-auto w-full">
        <div class="min-w-full w-64">
            <table class="min-w-full mt-4 border-separate border-spacing-0">
                <thead>
                    <tr class="bg-gray-100 text-gray-600 text-sm">
                        <th class="px-2 py-2 border-b border-l border-t border-gray-200 rounded-tl-lg">No</th>
                        <th class="px-4 py-2 border-b border-t border-gray-200">Judul</th>
                        <th class="px-4 py-2 border-b border-t border-gray-200">Durasi</th>
                        <th class="px-4 py-2 border-b border-t border-r border-gray-200 rounded-tr-lg">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($quizzes as $index => $quiz)
                    <tr class="bg-white hover:bg-gray-50 user-row text-sm text-gray-600">
                        <td class="px-2 py-2 text-center border-b border-l  border-gray-200">{{ $startNumber + $index }}</td>
                        <td class="px-4 py-2 text-center border-b border-gray-200">{{ $quiz->title }}</td>
                        <td class="px-4 py-2 text-center border-b border-gray-200">{{ $quiz->duration }} menit</td>
                        <td class="px-4 py-2 border-b  border-r border-gray-200">
                            <div class="flex items-center justify-center space-x-6">
                                <a href="{{ route('quiz-detail', ['course' => $course->id, 'quiz' => $quiz->id]) }}" class="text-white bg-sky-300 p-1 rounded-md hover:bg-sky-200" title="Lihat">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                </a>
                                <a href="{{ route('quiz-edit', ['courseId' => $course->id, 'quiz' => $quiz->id]) }}" class="text-white bg-yellow-300 p-1 rounded-md hover:bg-yellow-200" title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>
                                </a>
                                <form action="{{ route('quiz.destroy', [$course, $quiz->id]) }}" method="POST" class="inline" title="Hapus">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn-delete text-white bg-red-400 p-1 rounded-md hover:bg-red-300" title="Hapus">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    @if ($quizzes->isEmpty())
                    <tr>
                        <td colspan="4" class="text-center py-2 text-sm text-gray-600 border-b border-l border-r border-gray-200">Belum ada tugas akhir untuk kursus ini.</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- <!-- Section Tugas Akhir -->
<div class="bg-white p-6 rounded-lg shadow-md mt-6">
    <div class="mb-2 flex items-center justify-between p-1 border-b-2">
        <h2 class="text-xl font-semibold text-gray-700 pt-2">Tugas Akhir</h2>                                                     
    </div>
    <div class="text-right">
        <a href="{{ route('final-task.create', ['courseId' => $course->id]) }}" class="mt-2 inline-flex shadow-md shadow-blue-100 hover:shadow-none items-center space-x-2 text-white bg-blue-400 hover:bg-blue-300 font-semibold py-2 px-4 rounded-md">
            <!-- Ikon muncul pada semua ukuran layar -->
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            <!-- Teks hanya muncul pada mode desktop (sm dan lebih besar) -->
            <span class="ml-2">Tugas Akhir </span>
        </a> 
    </div>
     <!-- Kuis -->
    <div class="overflow-hidden overflow-x-auto w-full">
        <div class="min-w-full w-64">
            <table class="min-w-full mt-4 border-separate border-spacing-0">
                <thead>
                    <tr class="bg-gray-100 text-gray-500 text-sm">
                        <th class="px-2 py-2 border-b border-l border-t border-gray-200 rounded-tl-lg">No</th>
                        <th class="px-4 py-2 border-b border-t border-gray-200">Judul</th>
                        <th class="px-4 py-2 border-b border-t border-gray-200">Durasi</th>
                        <th class="px-4 py-2 border-b border-r border-gray-200 rounded-tr-lg">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($finalQuizzes as $index => $quiz)
                    <tr class="bg-white hover:bg-gray-50 user-row text-sm text-gray-500">
                        <td class="px-2 py-2 text-center border-b border-l  border-gray-200">{{ $startNumber + $index }}</td>
                        <td class="px-4 py-2 text-center border-b border-gray-200">{{ $quiz->title }}</td>
                        <td class="px-4 py-2 text-center border-b border-gray-200">{{ $quiz->duration }} menit</td>
                        <td class="px-4 py-2 border-b  border-r border-gray-200">
                            <div class="flex items-center justify-center space-x-6">
                                <a href="{{ route('final-detail', ['course' => $course->id, 'quiz' => $quiz->id]) }}" class="text-white bg-sky-300 p-1 rounded-md hover:bg-sky-200" title="Lihat">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                </a>
                                <a href="{{ route('final-edit', ['courseId' => $course->id, 'id' => $quiz->id]) }}" class="text-white bg-yellow-300 p-1 rounded-md hover:bg-yellow-200" title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>
                                </a>
                                <button type="button" class="text-white bg-red-400 p-1 rounded-md hover:bg-red-300" onclick="openDeleteModalTask('{{ route('final-destroy', [$course, $quiz->id]) }}')" title="Hapus">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    @if ($finalQuizzes->isEmpty())
                    <tr>
                        <td colspan="4" class="text-center py-2 text-sm text-gray-500 border-b border-l border-r border-gray-200">Belum ada tugas akhir untuk kursus ini.</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div> --}}

<!-- Tabel Peserta Terdaftar -->
<div class="mt-6 bg-white p-6 rounded-lg shadow-md border border-gray-200">
    <h3 class="text-lg font-semibold mb-4 border-b-2 pb-2 text-gray-700">Peserta Terdaftar</h3>
    <div class="overflow-x-auto">
        <div class="min-w-full w-64">
            <table class="min-w-full mt-2 border-separate border-spacing-0" id="courseTable">
                <thead>
                    <tr class="bg-gray-100 text-gray-500 text-sm">
                        <th class="py-2 px-2 border-b border-t border-l border-gray-200 rounded-tl-lg">No</th>
                        <th class="py-2 px-4 border-b border-t border-gray-200">Nama Peserta</th>
                        <th class="py-2 px-4 border-b border-t border-gray-200">Email</th>
                        <th class="py-2 border-b border-r border-t border-gray-200 rounded-tr-lg">Status Pembayaran</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($participants as $index => $participant)
                    <tr class="bg-white hover:bg-gray-50 user-row text-sm text-gray-500">
                        <td class="py-2 px-4 text-center border-b border-l border-gray-200">{{ $index + 1 }}</td>
                        <td class="py-2 px-4 border-b border-gray-200">{{ $participant->user->name }}</td>
                        <td class="py-2 px-4 border-b border-gray-200">{{ $participant->user->email }}</td>
                        <td class="py-2 text-center border-b  border-r border-gray-200">
                            <span class="bg-green-200/50 border border-2 border-green-300 text-green-500 px-2 py-0.5 rounded-xl">{{ $participant->status }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-2 text-center border-b border-l border-r border-gray-200 text-gray-500 text-sm">Belum ada peserta terdaftar.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div> 
    <div class="mt-4">
        {{ $participants->links() }}
    </div>       
</div>

<!-- Tabel Rating -->
<div class="bg-white mt-6 p-6 rounded-lg shadow-md border border-gray-200">
    <h2 class="text-lg font-semibold mb-4 border-b-2 pb-2 text-gray-700">Rating Kursus</h2>
    <!-- Tabel rating kursus -->
    <div class="overflow-x-auto">
        <div class="min-w-full w-64">
            <table class="min-w-full text-sm mt-2 border-separate border-spacing-0">
                <thead>
                    <tr class="bg-gray-100 text-gray-500">
                        <th class="px-2 py-2 border-b border-l border-t border-gray-200 rounded-tl-lg">No</th>
                        <th class="px-4 py-2 border-b border-t border-gray-200">Nama</th>
                        <th class="px-4 py-2 border-b border-t border-gray-200">Rating</th>
                        <th class="px-4 py-2 border-b border-t border-gray-200">Komentar</th>
                        <th class="px-4 py-2 border-b border-t border-gray-200">Status</th>
                        <th class="px-4 py-2 border-b border-t border-r border-gray-200 rounded-tr-lg">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($ratings as $index => $rating)
                    <tr class="bg-white hover:bg-gray-50 user-row text-sm text-gray-500">
                        <td class="text-center px-4 py-2 border-b border-l border-gray-200">{{ $index + 1 }}</td>
                        <td class="px-4 py-2 border-b border-gray-200">{{ $rating->user->name }}</td>
                        <td class="px-4 py-2 border-b border-gray-200 text-center">
                            @for ($i = 1; $i <= 5; $i++)
                                <span class="{{ $i <= $rating->stars ? 'text-yellow-400' : 'text-gray-300' }}">★</span>
                            @endfor
                        </td>
                        <td class="px-4 py-2 rounded-md border-b border-gray-200">
                            <span>{{ $rating->comment }}</span>
                        </td>
                        <td class="px-4 py-2 text-center border-b border-gray-200">
                            @php
                                $displayStatus = $rating->display
                                    ? ['label' => 'Ditampilkan', 'bg' => 'bg-green-200/50', 'border' => 'border-green-300', 'text' => 'text-green-500']
                                    : ['label' => 'Disembunyikan', 'bg' => 'bg-red-200/50', 'border' => 'border-red-300', 'text' => 'text-red-500'];
                            @endphp
                            <span class="inline-block min-w-[120px] px-2 py-0.5 rounded-xl border-2 text-center
                                {{ $displayStatus['bg'] }} {{ $displayStatus['border'] }} {{ $displayStatus['text'] }}">
                                {{ $displayStatus['label'] }}
                            </span>
                        </td>
                        <td class="px-4 py-2  text-center rounded-md border-b border-r border-gray-200">                              
                            <div class="flex items-center justify-center space-x-4 ">
                            <form action="{{ route('toggle.displaymentor', $rating->id) }}" method="POST">
                                @csrf
                                @method('POST') <!-- Menggunakan metode POST untuk keamanan -->
                                <label for="rating-toggle-{{ $rating->id }}" class="flex items-center cursor-pointer" title="{{ $rating->display ? 'Sembunyikan' : 'Tampilkan' }}">
                                    <!-- Toggle Switch -->
                                    <div class="relative">
                                        <input type="checkbox" name="display" id="rating-toggle-{{ $rating->id }}" class="hidden peer"
                                            {{ $rating->display ? 'checked' : '' }} value="1"/>
                                        <div class="block bg-gray-300  w-9 h-5 rounded-full peer-checked:bg-green-500 peer-checked:justify-end"></div>
                                        <div class="dot absolute top-0.5 start-[2px] bg-white w-4 h-4 rounded-full transition-transform peer-checked:translate-x-full"></div>
                                    </div>
                                </label>
                            </form>

                            <!-- Button Hapus Rating -->
                            <form action="{{ route('ratingmentor.destroy', $rating->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn-delete text-white bg-red-400 p-1 rounded-md hover:bg-red-300" title="Hapus">
                                    <!-- Icon -->
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>
                                </button>
                            </form>
                            </div>
                        </td>                                                             
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-gray-500 py-2 border-b border-l border-r border-gray-200 text-sm">Belum ada rating</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-4">
        {{ $ratings->links() }}
    </div>
</div>

<!-- Popup Container Menampilkan Sertifikat -->
<div id="certificate-popup" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden z-[1000]">
    <div class="bg-white p-4 rounded-lg shadow-lg max-w-2xl w-full relative mx-4">
        <button id="close-popup" class="absolute bg-red-100 px-2 rounded-md top-2 right-2 text-red-500 hover:text-red-400 text-lg">&times;</button>
        <h2 class="text-lg font-semibold mb-2 text-gray-700">Sertifikat</h2>
        <iframe id="certificate-frame" class="w-full h-96" frameborder="0"></iframe>
    </div>
</div>

<!-- Modal Konfirmasi Hapus Tugas Akhir -->
<div id="deleteModalTask" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center hidden z-[1000]">
    <div class="bg-white p-5 rounded-md w-96 justify-center mx-4">
        <div class="flex justify-center mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-16 h-16 text-gray-600">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 5.25h.008v.008H12v-.008Z" />
            </svg>
        </div>
        <p class="text-gray-600 text-center">Apakah Anda yakin ingin menghapus tugas akhir ini?</p>
        <div class="flex justify-center space-x-4">
            <button onclick="closeDeleteModalTask()" class="bg-red-400 font-semibold px-4 py-2 rounded-md hover:bg-red-300 text-white mt-4">Batal</button>
            <form id="confirmDeleteFormTask" action="" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-green-400 font-semibold text-white px-4 py-2 rounded-md hover:bg-green-300 mt-4">Hapus</button>
            </form>
        </div>
    </div>
</div>

<script>
    function openDeleteModalTask(deleteUrl) {
        const modal = document.getElementById('deleteModalTask');
        const form = document.getElementById('confirmDeleteFormTask');
        form.action = deleteUrl;
        modal.classList.remove('hidden');
    }

    function closeDeleteModal() {
        const modal = document.getElementById('deleteModalTask');
        modal.classList.add('hidden');
    }

    // Menambahkan event listener untuk toggle
    document.querySelectorAll('[id^="rating-toggle-"]').forEach(function(toggle) {
        toggle.addEventListener('change', function() {
            var ratingId = this.id.split('-').pop();  // Mendapatkan id rating dari ID toggle
            var form = this.closest('form');
                                    
            // Mengirim formulir untuk mengubah status display
            form.submit();
        });
    });

    // Menampilkan/menutup popup sertifikat kursus
    document.getElementById("view-certificate-btn").addEventListener("click", function () {
        fetch('/certificate/{{ $course->id }}')
            .then(response => response.url)
            .then(url => {
                document.getElementById("certificate-frame").src = url;
                document.getElementById("certificate-popup").classList.remove("hidden");
            })
            .catch(error => console.error("Error fetching certificate:", error));
    });
    
    document.getElementById("close-popup").addEventListener("click", function () {
        document.getElementById("certificate-popup").classList.add("hidden");
    });
</script>
@endsection