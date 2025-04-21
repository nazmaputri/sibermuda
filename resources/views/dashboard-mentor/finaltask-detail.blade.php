@extends('layouts.dashboard-mentor')
@section('title', 'Detail Tugas Akhir')
@section('content')
<div class="container mx-auto">
    <!-- Final Task Detail -->
    <div class="bg-white rounded-lg shadow p-6 mb-6 border border-gray-200">
        <h1 class="text-lg font-semibold text-gray-700 mb-4">Detail Tugas Akhir</h1>
        <div class="space-y-2">
            <p><span class="font-semibold text-gray-600 text-sm">Judul: {{ $finalTask->judul }}</p></span>
            <p><span class="font-semibold text-gray-600 text-sm">Deskripsi: {{ $finalTask->desc }}</p></span>
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
                        <th class="px-4 py-2 text-left text-sm text-gray-700 border-b border-l border-t border-gray-200 rounded-tl-lg">No</th>
                        <th class="px-4 py-2 text-left text-sm text-gray-700 border-b border-t border-gray-200">Nama</th>
                        <th class="px-4 py-2 text-left text-sm text-gray-700 border-b border-t border-gray-200">Judul</th>
                        <th class="px-4 py-2 text-left text-sm text-gray-700 border-b border-t border-gray-200">Deskripsi</th>
                        <th class="px-4 py-2 text-left text-sm text-gray-700 border-b border-t border-gray-200">Foto</th>
                        <th class="px-4 py-2 text-center text-sm text-gray-700 border-b border-r border-t border-gray-200 rounded-tr-lg">Aksi</th>
                    </tr>
                </thead>
                <tbody class="">
                @if ($submissions->isEmpty())
                    <tr>
                        <td colspan="6" class="text-center py-4 text-sm text-gray-600 border-b border-l border-r border-gray-200">Data tidak tersedia</td>
                    </tr>
                @else
                    @foreach($submissions as $index => $submission)
                    <tr class="bg-white hover:bg-gray-50">
                        <td class="px-4 py-2 text-gray-600 text-sm border-b border-l border-gray-200">{{ $index + 1 }}</td>
                        <td class="px-4 py-2 text-gray-600 text-sm border-b border-gray-200">{{ $submission->user->name }}</td>
                        <td class="px-4 py-2 text-gray-600 text-sm border-b border-gray-200">{{ $submission->title }}</td>
                        <td class="px-4 py-2 text-gray-600 text-sm border-b border-gray-200">{{ Str::limit($submission->description, 50) }}</td>
                        <td class="px-4 py-2 text-gray-600 text-sm border-b border-gray-200">
                            @if($submission->photo)
                                <img src="{{ Storage::url($submission->photo) }}" alt="Foto Tugas" class="h-16 w-16 object-cover rounded" />
                            @else
                                <span class="text-gray-400 text-sm">-</span>
                            @endif
                        </td>
                        <td class="px-4 py-2 text-center border-b border-r border-gray-200">
                            @if($submission->certificate_status == 'pending')
                                <form action="{{ route('final-task.confirm', $submission->id) }}" method="POST">
                                    @csrf
                                    <button type="submit">Konfirmasi Sertifikat</button>
                                </form>
                            @elseif($submission->certificate_status == 'approved')
                                <span class="text-green-600 font-medium">Disetujui</span>
                            @else
                                <span class="text-gray-500">-</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
           </div>
        </div>
    </div>
@endsection