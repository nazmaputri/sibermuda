@extends('layouts.dashboard-mentor')
@section('title', 'Detail Tugas Akhir')
@section('content')

<!-- button kembali -->
<div class="mb-3 flex justify-start">
    <a href="{{ route('courses.show', ['course' => $course->id]) }}" class="text-midnight font-semibold p-1 bg-white border border-gray-200 rounded-full transition-transform duration-300 ease-in-out transform hover:scale-105">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
        </svg>
    </a>
</div>

<div class="container mx-auto">
    <!-- Final Task Detail -->
    <div class="bg-white rounded-lg shadow p-6 mb-6 border border-gray-200">
        <h1 class="text-lg font-semibold text-gray-700 mb-4 border-b-2 text-center">Detail Tugas Akhir</h1>
        <div class="space-y-2 text-sm text-gray-600">
            <div class="flex flex-wrap">
                <span class="font-semibold w-16 min-w-[0]">Judul</span><span class="mr-1">:</span>
                <span class="">{{ $finalTask->judul }}</span>
            </div>
            <div class="flex flex-wrap">
                <span class="font-semibold w-16 min-w-[0]">Deskripsi</span><span class="mr-1">:</span>
                <span class="">{{ $finalTask->desc }}</span>
            </div>
        </div>
    </div>

    <!-- Table: Peserta yang sudah mengumpulkan -->
    <div class="bg-white rounded-lg shadow p-6 mb-8 border border-gray-200">
        <h2 class="text-lg text-gray-700 font-semibold mb-4">Peserta yang Telah Mengumpulkan</h2>
        <div class="overflow-x-auto">
           <div class="min-w-full w-64">
           <table class="min-w-full border-separate border-spacing-0">
                <thead class="bg-gray-100">
                    <tr class="">
                        <th class="px-4 py-2 text-center text-sm text-gray-700 border-b border-l border-t border-gray-200 rounded-tl-lg">No</th>
                        <th class="px-4 py-2 text-center text-sm text-gray-700 border-b border-t border-gray-200">Nama</th>
                        <th class="px-4 py-2 text-center text-sm text-gray-700 border-b border-t border-gray-200">Tanggal</th>
                        <th class="px-4 py-2 text-center text-sm text-gray-700 border-b border-r border-t border-gray-200 rounded-tr-lg">Aksi</th>
                    </tr>
                </thead>
                <tbody class="">
                @if ($submissions->isEmpty())
                    <tr>
                        <td colspan="3" class="text-center py-4 text-sm text-gray-600 border-b border-l border-r border-gray-200">Data tidak tersedia</td>
                    </tr>
                @else
                    @foreach($submissions as $index => $submission)
                    <tr class="bg-white hover:bg-gray-50">
                        <td class="px-4 py-2 text-gray-600 text-sm text-center border-b border-l border-gray-200">{{ $index + 1 }}</td>
                        <td class="px-4 py-2 text-gray-600 text-sm border-b border-gray-200">{{ $submission->user->name }}</td>
                        <td class="px-4 py-2 text-gray-600 text-sm border-b border-gray-200">{{ $submission->created_at->translatedFormat('d F Y, H:i') }}</td>
                        <td class="px-4 py-2 text-center border-b border-r border-gray-200">
                            <div class="flex items-center justify-center space-x-6">
                                <!-- Tombol Lihat Detail -->
                                <a href="{{ route('finaltask.detailByUser', [
                                        'courseId' => $course->id,
                                        'taskId' => $submission->final_task_id,  // ✅ pakai ini, bukan $finalTask->id
                                        'userId' => $submission->user->id
                                    ]) }}" class="text-white bg-sky-300 p-1 rounded-md hover:bg-sky-200" title="Lihat">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                </a>

                                @if($submission->certificate_status == 'pending')
                                    <form action="{{ route('final-task.confirm', $submission->id) }}" method="POST" class="flex items-center justify-center" title="Konfirmasi Sertifikat">
                                        @csrf
                                        <button type="submit"
                                            class="font-semibold p-1 rounded-md 
                                                bg-green-300 hover:bg-green-200 text-white">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" 
                                                class="w-5 h-5 text-white" fill="currentColor">
                                                <path d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"/>
                                            </svg>
                                        </button>
                                    </form>
                                @elseif($submission->certificate_status == 'approved')
                                    <div class="font-semibold p-1 rounded-md bg-gray-300 text-white cursor-not-allowed inline-flex items-center justify-center" title="Sudah Dikonfirmasi">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" 
                                            class="w-5 h-5 text-white" fill="currentColor">
                                            <path d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"/>
                                        </svg>
                                    </div>
                                @else
                                    <span class="text-gray-500">-</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
           </div>
        </div>
        <div class="pagination mt-4">
            {{ $submissions->links('pagination::tailwind') }}
        </div>
    </div>
</div>
@endsection