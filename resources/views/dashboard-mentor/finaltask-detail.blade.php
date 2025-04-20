@extends('layouts.dashboard-mentor')

@section('content')
<div class="container mx-auto p-6">
    <!-- Final Task Detail -->
    <div class="bg-white rounded-2xl shadow p-6 mb-8">
        <h1 class="text-2xl font-bold mb-4">Detail Tugas Akhir</h1>
        <div class="space-y-2">
            <p><span class="font-semibold">Judul:</span> {{ $finalTask->judul }}</p>
            <p><span class="font-semibold">Deskripsi:</span> {{ $finalTask->desc }}</p>
        </div>
    </div>

    <!-- Table: Peserta yang sudah mengumpulkan -->
    <div class="bg-white rounded-2xl shadow p-6 mb-8">
        <h2 class="text-xl font-semibold mb-4">Peserta yang Telah Mengumpulkan</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">No</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Nama</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Judul</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Deskripsi</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Foto</th>
                        <th class="px-4 py-2 text-center text-sm font-medium text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($submissions as $index => $submission)
                    <tr>
                        <td class="px-4 py-2">{{ $index + 1 }}</td>
                        <td class="px-4 py-2">{{ $submission->user->name }}</td>
                        <td class="px-4 py-2">{{ $submission->title }}</td>
                        <td class="px-4 py-2">{{ Str::limit($submission->description, 50) }}</td>
                        <td class="px-4 py-2">
                            @if($submission->photo)
                                <img src="{{ Storage::url($submission->photo) }}" alt="Foto Tugas" class="h-16 w-16 object-cover rounded" />
                            @else
                                <span class="text-gray-400 text-sm">-</span>
                            @endif
                        </td>
                        <td class="px-4 py-2 text-center">
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
                </tbody>
            </table>
        </div>
    </div>
@endsection