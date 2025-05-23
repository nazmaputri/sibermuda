@extends('layouts.dashboard-peserta')
@section('title', 'Chat')
@section('content')
<div class="inline-block h-[75vh] sm:h-[450px] flex border border-gray-200 rounded rounded-md">
    <!-- Main Chat Area -->
    <main class="flex-1 flex flex-col">
        @if ($activeChat)
            <!-- Header Chat -->
            <div class="bg-white border-b border-gray-200 p-4 flex items-center relative">
                <div class="flex items-center">
                    <!-- Foto Avatar Mentor -->
                    @if($activeChat->mentor->photo)
                        <!-- Jika mentor memiliki foto profil -->
                        <img 
                            src="{{ asset('storage/' . $activeChat->mentor->photo) }}" 
                            class="w-10 h-10 rounded-full" 
                            alt="{{ $activeChat->mentor->name }} Avatar">
                    @else
                        <!-- Jika mentor tidak memiliki foto profil -->
                        <img 
                            src="{{ asset('storage/default-profile.jpg') }}" 
                            class="w-10 h-10 rounded-full" 
                            alt="profile peserta">
                    @endif
                    <!-- Informasi Mentor -->
                    <div class="ml-4">
                        <h3 class="text-gray-700 font-medium tex-sm">{{ $activeChat->mentor->name }}</h3>
                        {{-- <p class="text-gray-500 text-sm">
                            {{ $activeChat->mentor->is_online ? 'Online' : 'Offline' }}
                        </p> --}}
                    </div>
                </div>                
                <!-- Tombol Kembali di samping kanan header -->
                <a href="{{ route('daftar-kursus') }}" class=" text-white font-semibold py-2 px-4 absolute right-1 top-1/2 transform -translate-y-1/2 rounded-full">
                    <button type="button" id="prev-btn"  class="border  hover:bg-neutral-100/50 font-semibold text-white px-2 py-2 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 320 512" class="w-4 h-4 text-gray-700">
                            <path d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l192 192c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L77.3 256 246.6 86.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-192 192z"/>
                        </svg>
                    </button>
                </a>        
            </div>            

            <!-- Pesan Chat -->
            <div class="flex-1 overflow-y-auto p-4 bg-white scrollbar-hide max-h-[calc(100vh-250px)] sm:max-h-full"> <!-- KALAU MAU PAKAI BACKGROUND, TAMBAH CLASS : bg-[url('{{ asset('storage/wp-chat.jpg') }}')] bg-repeat  -->
                @foreach ($messages as $message)
                    <div class="flex items-start mb-4 @if($message->sender_id == auth()->id()) justify-end @else justify-start @endif">
                        <!-- Pesan Mentor (Gray) -->
                        @if($message->sender_id == auth()->id())
                            <div class="bg-blue-500 text-white p-2 rounded-lg shadow-md">
                                <p class="text-sm">{{ $message->message }}</p>
                                <p class="text-xs text-white/65 mt-1">{{ $message->created_at->diffForHumans() }}</p>
                            </div>
                        <!-- Pesan Student (Blue) -->
                        @else
                            <div class="border text-gray-600 p-2 rounded-lg shadow-md bg-white">
                                <p class="text-sm">{{ $message->message }}</p>
                                <p class="text-xs text-gray-400 mt-1">{{ $message->created_at->diffForHumans() }}</p>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            <!-- Input Pesan -->
            <div class="p-4 bg-white border-t border-gray-200">
                <form action="{{ route('chat.send', $activeChat->id) }}" method="POST" class="flex items-center">
                    @csrf
                    <!-- Menambahkan hidden input untuk course_id -->
                    <input type="hidden" name="course_id" value="{{ $activeChat->course_id }}"> <!-- Menambahkan course_id -->
                    <input type="text" name="message" placeholder="Ketikkan pesan..." 
                           class="w-full text-sm text-gray-700 px-4 py-1.5 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" required>
                    <button type="submit" class="ml-4 px-4 py-1.5 text-sm bg-blue-500 text-white rounded-lg hover:bg-blue-400">
                        Kirim
                    </button>
                </form>
            </div>
        @else
            <div class="flex-1 flex items-center justify-center p-4 bg-gray-50">
                <p class="text-gray-500">Tidak ditemukan chat aktif. Silahkan kirimkan pesan baru.</p>
            </div>
        @endif
    </main>
</div>
@endsection
