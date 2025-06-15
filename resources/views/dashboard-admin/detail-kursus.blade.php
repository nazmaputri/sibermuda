@extends('layouts.dashboard-admin')
@section('title', 'Detail Kursus')
@section('content')

<!-- Tombol Kembali -->
<div class="flex justify-start mb-2">
    <a href="{{ route('categories.show', $category->id) }}" class="text-midnight font-semibold p-1 bg-white border border-gray-200 rounded-full transition-transform duration-300 ease-in-out transform hover:scale-105 inline-flex items-center">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
        </svg>
    </a>
</div>

<div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
    <!-- Card Informasi Kursus -->
    <div class="flex flex-col lg:flex-row mb-4">
        <div class="w-full lg:w-1/3 mb-4 lg:mb-0">
            <img src="{{ asset('storage/' . $course->image_path) }}" alt="{{ $course->title }}" class="rounded-lg w-80 h-35">
        </div>
        <!-- Informasi Kursus -->
        <div class="md:ml-4 md:w-2/3 w-full mt-1 md:mt-0 space-y-1">
            <h2 class="text-lg font-semibold text-gray-700 mb-2 capitalize">{{ $course->title }}</h2>
            <p class="text-gray-700 mb-2 text-sm">{{ $course->description }}</p>
                <div class="flex flex-wrap">
                    <span class="w-24 text-sm text-gray-700">Mentor</span><span class="mr-1">:</span>
                    <span class="text-gray-700 text-sm">{{ Str::limit($course->mentor->name ?? 'Tidak Ada Mentor', 25, '...') }}</span>
                </div>
                <div class="flex flex-wrap">
                    <span class="w-24 text-sm text-gray-700">Harga</span><span class="mr-1">:</span>
                    <span class="text-gray-700 text-sm">Rp {{ number_format($course->price, 0, ',', '.') }}</span>
                </div>
                <div class="flex flex-wrap">
                    <span class="w-24 text-sm text-gray-700">Masa Aktif</span><span class="mr-1">:</span>
                    <span class="text-gray-700 text-sm">{{ $course->duration }}</span>
                </div>
                <div class="flex flex-wrap">
                    <span class="w-24 text-sm text-gray-700">Fitur Chat</span><span class="mr-1">:</span>
                    <span class="text-gray-700 text-sm">{{ $course->chat ? 'Aktif' : 'Tidak Aktif' }}</span>
                </div>
                <div class="flex flex-wrap">
                    <span class="w-24 text-sm text-gray-700">Total Peserta</span><span class="mr-1">:</span>
                    <span class="text-gray-700 text-sm">Peserta</span>
                </div>
            <!-- <p class="text-gray-600 text-sm">Kapasitas : {{ $course->capacity }} peserta</p>  -->
            <!-- <p class="text-gray-600 text-sm">Tanggal Mulai : {{ $course->start_date }}</p> -->
        </div>
    </div>

    <!-- Silabus -->
    <div class="mt-10">
        <h3 class="text-md font-semibold text-gray-700 mb-6 border-b-2 border-gray-300 pb-2">Materi Kursus</h3>
        <div class="space-y-6">
            @if($course->materi->isEmpty())
                <div class="col-span-full text-center items-center justify-center flex flex-col">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 mb-1 text-gray-600">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5m6 4.125 2.25 2.25m0 0 2.25 2.25M12 13.875l2.25-2.25M12 13.875l-2.25 2.25M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                    </svg>
                    <p class="text-gray-600 text-center text-sm">Belum ada materi untuk kursus ini.</p>
                </div>
            @else
            @foreach($course->materi as $materi)
            <div class="bg-white border border-gray-200 p-2.5 rounded-lg shadow-sm">
                <div x-data="{ open: false }">
                    <!-- Judul Materi dengan Toggle Dropdown -->
                    <div @click="open = !open" class="flex justify-between items-center cursor-pointer">
                        <!-- Menambahkan nomor urut di sebelah kiri judul -->
                        <span class="text-gray-700 text-sm font-medium mr-2">
                            {{ sprintf('%02d', $loop->iteration) }}.
                        </span>
                        
                        <h4 class="text-sm font-medium text-gray-700 flex-1 capitalize">{{ $materi->judul }}</h4>
                                                
                        <!-- Tombol Toggle -->
                        <svg :class="open ? 'transform rotate-180' : ''" class="w-5 h-5 text-gray-600 transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>

                    <!-- Deskripsi Materi -->
                    <p class="text-gray-700 text-sm mb-2 mt-2" x-show="open" x-transition>{{ $materi->deskripsi }}</p>

                    <!-- Video (Tampilkan hanya jika open adalah true) -->
                    <div x-show="open" x-transition>
                        @if($materi->videos->isEmpty() && $materi->youtube->isEmpty())
                        <p class="text-gray-700 text-sm">Tidak ada video untuk materi ini.</p>
                        @else
                            <ul class="mt-4 space-y-4">
                                {{-- Google Drive Videos --}}
                                @foreach ($materi->videos as $video)
                                    <li class="bg-gray-100 p-4 rounded-lg shadow-sm">
                                        <h3 class="font-medium text-sm text-gray-700 mb-1.5">{{ $video->title ?: 'Tidak ada judul video' }}</h3>
                                        @if ($video->link)
                                            <iframe
                                                src="https://drive.google.com/file/d/{{ $video->link }}/preview"
                                                width="100%" height="480"
                                                allow="autoplay"
                                                allowfullscreen
                                                class="rounded-lg shadow-sm">
                                            </iframe>
                                        @else
                                            <p class="text-gray-700 text-sm">Video Google Drive tidak tersedia.</p>
                                        @endif
                                        <p class="text-gray-600 text-sm mt-1.5">{{ $video->description ?: 'Tidak ada deskripsi video G-drive' }}</p>
                                    </li>
                                @endforeach
            
                                {{-- YouTube Videos --}}
                                @foreach ($materi->youtube as $yt)
                                    <li class="bg-gray-100 p-4 rounded-lg shadow-sm">
                                        <h3 class="font-semibold text-gray-700 text-sm mb-1.5">{{ $yt->title ?: 'Tidak ada judul video' }}</h3>
                                        @if ($yt->link)
                                            <iframe
                                                width="100%" height="480"
                                                src="https://www.youtube.com/embed/{{ $yt->link }}"
                                                frameborder="0"
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                allowfullscreen
                                                class="rounded-lg shadow-sm">
                                            </iframe>
                                        @else
                                            <p class="text-gray-700 text-sm">Video YouTube tidak tersedia.</p>
                                        @endif
                                        <p class="text-gray-700 text-sm mt-1.5">{{ $yt->description ?: 'Tidak ada deskripsi video Youtube' }}</p>
                                    </li>
                                @endforeach
                            </ul>
                    @endif                             
                    </div>
                </div>
            </div>
            @endforeach
            @endif
        </div>

        @php
            $catName = strtolower($course->category->name ?? '');
            $isCyber = in_array($catName, ['cyber security', 'siber', 'cybersecurity', 'cyber']);
        @endphp

        <!-- Tugas Akhir atau Kuis -->
        <div class="mt-8">
            <h3 class="text-lg font-semibold text-gray-700 mb-6 border-b-2 border-gray-300 pb-2">
                @if($isCyber)
                    Tugas Akhir
                @else
                    Kuis
                @endif
            </h3>

            @if($isCyber)
                @if(empty($course->finalTask))
                <div class="col-span-full text-center items-center justify-center flex flex-col">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 mb-1 text-gray-600">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5m6 4.125 2.25 2.25m0 0 2.25 2.25M12 13.875l2.25-2.25M12 13.875l-2.25 2.25M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                    </svg>
                    <p class="text-gray-600 text-center text-sm">Belum ada tugas akhir untuk kursus ini.</p>
                </div>
                @else
                    <div x-data="{ open: false }" class="bg-white p-2.5 rounded-lg shadow-sm border border-gray-200">
                        <!-- Judul Tugas Akhir -->
                        <div @click="open = !open" class="flex justify-between items-center cursor-pointer">
                            <span class="text-gray-700 text-sm font-semibold mr-2">
                                01.
                            </span>
                            <span class="flex-1 text-sm font-semibold text-gray-700 capitalize">{{ $course->finalTask->judul }}</span>
                            <svg :class="open ? 'transform rotate-180' : ''" class="w-5 h-5 text-gray-600 transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>

                        <!-- Deskripsi Tugas Akhir -->
                        <div x-show="open" x-transition class="mt-3 text-sm text-gray-700">
                            <p><span class="font-semibold">Deskripsi:</span> {{ $course->finalTask->desc ?: 'Tidak ada deskripsi' }}</p>
                        </div>
                    </div>
                @endif
            @else
                @if($course->quizzes->isEmpty())
                <div class="col-span-full text-center items-center justify-center flex flex-col">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 mb-1 text-gray-600">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5m6 4.125 2.25 2.25m0 0 2.25 2.25M12 13.875l2.25-2.25M12 13.875l-2.25 2.25M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                    </svg>
                    <p class="text-gray-600 text-center text-sm">Belum ada kuis untuk kursus ini.</p>
                </div>
                @else
                    <div class="space-y-4">
                        @foreach($course->quizzes as $quiz)
                            <div x-data="{ open: false }" class="bg-white p-2.5 rounded-lg shadow-sm border border-gray-200">
                                <!-- Judul Kuis -->
                                <div @click="open = !open" class="flex justify-between items-center cursor-pointer">
                                    <!-- Menambahkan nomor urut di sebelah kiri judul -->
                                    <span class="text-gray-700 text-sm font-semibold mr-2">
                                        {{ sprintf('%02d', $loop->iteration) }}.
                                    </span>
                                    <span class="flex-1 text-sm font-semibold text-gray-700 capitalize">{{ $quiz->title }}</span>
                                    <svg :class="open ? 'transform rotate-180' : ''" class="w-5 h-5 text-gray-600 transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>

                                <!-- Detail Kuis -->
                                <div x-show="open" x-transition class="mt-3 text-sm text-gray-700 space-y-2">
                                    <div class="flex flex-wrap">
                                        <span class="w-24 text-sm text-gray-700">Deskripsi</span><span class="mr-1">:</span>
                                        <span class="text-gray-700 text-sm">{{ $quiz->description ?: 'Tidak ada deskripsi' }}</span>
                                    </div>
                                    <div class="flex flex-wrap">
                                        <span class="w-24 text-sm text-gray-700">Durasi</span><span class="mr-1">:</span>
                                        <span class="text-gray-700 text-sm">{{ $quiz->duration }} menit</span>
                                    </div>
                                    <div class="flex flex-wrap">
                                        <span class="w-24 text-sm text-gray-700">Total Soal</span><span class="mr-1">:</span>
                                        <span class="text-gray-700 text-sm">{{ $quiz->questions->count() }} soal</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            @endif
        </div>

    </div>
</div>

    <!-- Tabel Peserta Terdaftar -->
    <div class="bg-white mt-6 p-6 rounded-lg shadow-md border border-gray-200">
        <!-- Header dan tombol di satu baris -->
        <div class="flex justify-between items-center mb-3">
            <h3 class="text-lg font-semibold text-gray-700">Peserta Terdaftar</h3>
            
            <!-- button tambah -->
            <div class="inline-flex shadow-md shadow-blue-100 hover:shadow-none items-center space-x-2 text-white bg-blue-400 hover:bg-blue-300 font-semibold py-2 px-4 rounded-md cursor-pointer" 
                onclick="document.getElementById('manualImportModal').classList.remove('hidden')">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="white" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <p class="text-sm text-white rounded transition duration-300">Import</p>
            </div>
        </div>

            <div class="overflow-x-auto">
                <!-- Modal -->
                <div id="manualImportModal" class="fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center hidden">
                    <div class="bg-white rounded-xl p-6 mx-4 w-full max-w-sm md:max-w-xl shadow-lg relative overflow-hidden">
                        <!-- <button
                            class="absolute top-2 right-2 text-gray-500 hover:text-red-500"
                            onclick="document.getElementById('manualImportModal').classList.add('hidden')"
                        >✕</button> -->

                         <button onclick="document.getElementById('manualImportModal').classList.add('hidden')" class="absolute top-6 right-6 text-gray-600 hover:text-gray-500 text-xl font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 8.586L15.95 2.636a1 1 0 111.414 1.414L11.414 10l5.95 5.95a1 1 0 01-1.414 1.414L10 11.414l-5.95 5.95a1 1 0 01-1.414-1.414L8.586 10 2.636 4.05a1 1 0 011.414-1.414L10 8.586z" clip-rule="evenodd" />
                                </svg>
                            </button>

                        <h2 class="text-xl font-semibold text-gray-700 mb-1 text-center">Import Peserta Manual</h2>
                        <div class="w-16 h-1 bg-gray-600 mx-auto mb-4 rounded"></div>

                        <form method="POST" action="{{ route('admin.import.manual') }}">
                            @csrf

                            <!-- Hidden input untuk course_id -->
                            <input type="hidden" name="course_id" value="{{ $course->id }}">

                            <!-- Tampilkan nama kursus -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Kursus</label>
                                <p class="text-gray-700 font-semibold">{{ $course->title }}</p>
                            </div>

                            <!-- Dropdown Pilih Peserta -->
                            <div class="mb-4" x-data="{ open: false, selectedUsers: [], searchTerm: '' }">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Peserta</label>

                                <!-- Bungkus dengan relative agar dropdown position absolute bisa mengacu ke sini -->
                                <div class="relative w-full">
                                    <!-- Button untuk membuka dropdown -->
                                    <button @click="open = !open" type="button"
                                        class="border px-4 py-2 text-sm text-gray-700 w-full rounded-lg bg-white flex justify-between items-center focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500">
                                        <span class="block text-sm overflow-x-auto whitespace-nowrap scrollbar-thin scrollbar-thumb-rounded scrollbar-thumb-gray-300">
                                            <span x-text="selectedUsers.length > 0 ? selectedUsers.map(u => u.name).join(', ') : 'Pilih Peserta'"></span>
                                        </span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" :class="{ 'rotate-180': open }" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>

                                    <!-- Dropdown menu -->
                                    <div x-show="open" @click.away="open = false"
                                        class="mt-1 w-full bg-white border rounded-lg shadow-lg max-h-60 overflow-y-auto"> <!-- disini tambah class absolute aja kalau mau agar dropdownnya responsive-->
                                        <div class="p-2">
                                            <input type="text" placeholder="Cari peserta..." x-model="searchTerm"
                                                class="w-full text-sm text-gray-700 px-4 py-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500">
                                        </div>
                                        <ul>
                                            @foreach($users as $user)
                                                @php
                                                    $sudahBeli = \App\Models\Purchase::where('user_id', $user->id)
                                                        ->where('course_id', $course->id)
                                                        ->exists();
                                                @endphp
                                                <li 
                                                    class="px-4 py-2 {{ $sudahBeli ? 'text-gray-400 cursor-not-allowed' : 'hover:bg-blue-100 cursor-pointer text-gray-700' }} text-sm flex items-center"
                                                    @click="
                                                        @if (!$sudahBeli)
                                                            const existing = selectedUsers.find(u => u.id === {{ $user->id }});
                                                            if (existing) {
                                                                selectedUsers = selectedUsers.filter(u => u.id !== {{ $user->id }});
                                                            } else {
                                                                selectedUsers.push({ id: {{ $user->id }}, name: '{{ $user->name }} ({{ $user->email }})' });
                                                            }
                                                        @endif
                                                    "
                                                    x-show="'{{ strtolower($user->name . ' ' . $user->email) }}'.includes(searchTerm.toLowerCase())"
                                                >
                                                    <input 
                                                        type="checkbox" 
                                                        class="mr-2" 
                                                        :checked="selectedUsers.some(u => u.id === {{ $user->id }})"
                                                        {{ $sudahBeli ? 'disabled' : '' }}
                                                    >
                                                    {{ $user->name }} ({{ $user->email }})
                                                    @if($sudahBeli)
                                                        <span class="text-xs text-red-500 ml-2">Sudah terdaftar</span>
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>

                                <!-- Hidden input untuk dikirim -->
                                <template x-for="user in selectedUsers" :key="user.id">
                                    <input type="hidden" name="user_ids[]" :value="user.id">
                                </template>

                                <p class="text-sm text-gray-500 mt-1">* Klik untuk memilih peserta, bisa lebih dari satu.</p>
                            </div>

                            <!-- Submit -->
                            <div class="flex justify-end space-x-2">
                                <a class="text-sm bg-red-400 hover:bg-red-300 text-white font-semibold py-2 px-4 rounded-md cursor-pointer" onclick="document.getElementById('manualImportModal').classList.add('hidden')">
                                    Batal
                                </a>
                                <button type="submit" class="tex-sm bg-sky-400 hover:bg-sky-300 text-white font-semibold px-4 py-2 rounded-md transition">
                                    <p class="text-sm">Import</p>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="min-w-full w-64">
                <table class="min-w-full border-separate border-spacing-0" id="courseTable">
                    <thead>
                        <tr class="bg-gray-100 text-gray-600 text-sm">
                            <th class="py-2 px-2 border-b border-l border-t border-gray-200  rounded-tl-lg">No</th>
                            <th class="py-2 px-4 border-b border-t border-gray-200">Nama</th>
                            <th class="py-2 px-4 border-b border-t border-gray-200">Email</th>
                            <th class="py-2 border-b border-r border-t border-gray-200  rounded-tr-lg">Status Pembayaran</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($participants as $index => $participant)
                        <tr class="bg-white hover:bg-gray-50 user-row text-sm">
                            <td class="py-2 px-4 text-center text-gray-600 text-sm border-b border-l border-gray-200">{{ $index + 1 }}</td>
                            <td class="py-2 px-4 text-gray-600 text-sm border-b border-gray-200">{{ Str::limit($participant->user->name, 30, '...') }}</td>
                            <td class="py-2 px-4 text-gray-600 text-sm border-b border-gray-200">{{ $participant->user->email }}</td>
                            <td class="py-2 px-2 text-center text-sm border-b border-r border-gray-200">
                                @php
                                    $statusClass = '';
                                    $statusLabel = '';
                                    
                                    // Menentukan status dan kelas warna berdasarkan status
                                    if ($participant->status == 'pending') {
                                        $statusClass = 'bg-yellow-200/50 border-yellow-300 text-yellow-500';
                                        $statusLabel = 'Pending';
                                    } elseif ($participant->status == 'success') {
                                        $statusClass = 'bg-green-200/50 border-green-300 text-green-500';
                                        $statusLabel = 'Success';
                                    } elseif ($participant->status == 'paid') {
                                        $statusClass = 'bg-red-200/50 border-red-300 text-red-500';
                                        $statusLabel = 'Paid';
                                    }
                                @endphp
                                <span class="inline-block max-w-[120px] px-2 py-0.5 rounded-xl border-2 text-center 
                                    {{ $statusClass }}">
                                    {{ $statusLabel }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="py-2 text-center text-sm text-gray-600 border-l border-b border-r border-gray-200">Belum ada peserta terdaftar.</td>
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
@endsection
