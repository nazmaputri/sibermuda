@extends('layouts.dashboard-mentor')
@section('title', 'Chat')
@section('content')

<div x-data="{ openSidebar: false }" class="relative h-[75vh] flex flex-col lg:flex-row border border-gray-200 rounded-md">
    <!-- Sidebar untuk layar kecil -->
    <aside
        x-show="openSidebar"
        @click.outside="openSidebar = false"
        x-transition
        class="fixed top-15 right-0 w-64 h-full bg-white max-h-[75vh] shadow-lg border-l border-gray-200 z-40 p-4 space-y-2 overflow-y-auto scrollbar-hide lg:hidden"
    >
        <div class="flex justify-between items-center mb-4">
            <h2 class="md:text-xl text-sm font-semibold text-gray-700">Chat</h2>
            <!-- button tutup sidebar  ketika sidebar nya dibuka-->
            <button @click="openSidebar = false" class="text-gray-500 hover:text-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-700">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- List Chat -->
        @foreach ($chats as $chat)
        <a href="{{ route('chat.mentor', ['courseId' => $chat->course_id, 'chatId' => $chat->id]) }}"
            class="flex items-center p-2 rounded-lg cursor-pointer
            {{ $activeChat && $activeChat->id == $chat->id ? 'bg-sky-100' : '' }}">
            <img src="{{ $chat->student->photo ? asset('storage/' . $chat->student->photo) : asset('storage/default-profile.jpg') }}" class="w-10 h-10 rounded-full" alt="profile peserta" />
            <div class="ml-4">
                <h3 class="text-gray-700 font-medium">{{ $chat->student->name }}</h3>
                <p class="text-gray-500 text-sm truncate">Pesan terbaru...</p>
            </div>
        </a>
        @endforeach

        <!-- Start New Chat Section -->
        <div>
            <h2 class="md:text-md text-sm font-semibold mt-4 text-gray-700">Mulai chat baru</h2>
            @if ($students->isNotEmpty())
                @foreach ($students as $student)
                    @if (!in_array($student->id, $chats->pluck('student_id')->toArray()))
                    <a href="{{ route('chat.start', ['studentId' => $student->id, 'courseId' => $course->id]) }}"
                        class="flex items-center p-2 bg-gray-100 rounded-lg cursor-pointer hover:bg-gray-200 mt-2">
                        <img src="{{ asset('storage/default-profile.jpg') }}" class="w-10 h-10 rounded-full" alt="profile-user"/>
                        <div class="ml-4">
                            <h3 class="text-gray-700 font-medium">{{ $student->name }}</h3>
                            <p class="text-gray-500 text-sm">Mulai chat baru...</p>
                        </div>
                    </a>
                    @endif
                @endforeach
            @else
                <p class="text-gray-500 mt-4">Belum ada peserta yang membeli kursus ini.</p>
            @endif
        </div>
    </aside>

    <!-- Sidebar untuk layar besar -->
    <aside class="hidden lg:block lg:w-1/3 bg-white rounded-md border-r border-b border-gray-200 h-[75vh] overflow-y-auto scrollbar-hide p-4 space-y-2">
        <h2 class="text-xl font-semibold mb-4 text-gray-700">Chat</h2>

        @foreach ($chats as $chat)
        <a href="{{ route('chat.mentor', ['courseId' => $chat->course_id, 'chatId' => $chat->id]) }}"
            class="flex items-center p-2 rounded-lg cursor-pointer
            {{ $activeChat && $activeChat->id == $chat->id ? 'bg-sky-100' : '' }}">
            <img src="{{ $chat->student->photo ? asset('storage/' . $chat->student->photo) : asset('storage/default-profile.jpg') }}" class="w-10 h-10 rounded-full" alt="profile peserta" />
            <div class="ml-4">
                <h3 class="text-gray-700 font-medium">{{ $chat->student->name }}</h3>
                <p class="text-gray-500 text-sm truncate">Pesan terbaru...</p>
            </div>
        </a>
        @endforeach

        <div>
            <h2 class="text-md font-semibold mt-6 text-gray-700">Mulai chat baru</h2>
            @if ($students->isNotEmpty())
                @foreach ($students as $student)
                    @if (!in_array($student->id, $chats->pluck('student_id')->toArray()))
                    <a href="{{ route('chat.start', ['studentId' => $student->id, 'courseId' => $course->id]) }}"
                        class="flex items-center p-2 bg-gray-100 rounded-lg cursor-pointer hover:bg-gray-200 mt-2">
                        <img src="{{ asset('storage/default-profile.jpg') }}" class="w-10 h-10 rounded-full" alt="profile-user"/>
                        <div class="ml-4">
                            <h3 class="text-gray-700 font-medium">{{ $student->name }}</h3>
                            <p class="text-gray-500 text-sm">Mulai chat baru...</p>
                        </div>
                    </a>
                    @endif
                @endforeach
            @else
                <p class="text-gray-500 mt-4">Belum ada peserta yang membeli kursus ini.</p>
            @endif
        </div>
    </aside>

    <!-- Main Chat Area -->
    <main class="flex-1 flex flex-col bg-white relative">
        @if ($activeChat && $activeChat->student)
        <!-- Profil Student -->
        <div class="bg-white border-b border-gray-200 p-2 flex items-center relative">
            <img src="{{ $activeChat->student->photo ? asset('storage/' . $activeChat->student->photo) : asset('storage/default-profile.jpg') }}" class="w-10 h-10 rounded-full" alt="profile peserta" />
            <div class="ml-4">
                <h3 class="text-gray-700 font-medium">{{ $activeChat->student->name }}</h3>
            </div>
            <!-- Tombol Kembali (muncul di layar medium ke atas saja) -->
            <a href="{{ route('courses.index') }}" 
            class="absolute right-4 top-1/2 transform -translate-y-1/2 hidden lg:block">
                <button type="button" id="prev-btn" 
                    class="border hover:bg-neutral-100/50 font-semibold text-white px-2 py-2 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" fill="currentColor" class="w-4 h-4 text-gray-700">
                        <path d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l192 192c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L77.3 256 246.6 86.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-192 192z"/>
                    </svg>
                </button>
            </a>

            <!-- Tombol Buka Sidebar (muncul di layar kecil saja) -->
            <div class="p-1 block lg:hidden absolute right-2 top-2.5">
                <button
                    @click="openSidebar = true"
                    class="bg-blue-400 hover:bg-blue-300 text-white p-1 rounded-md"
                >
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="white" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
                </button>
            </div>
        </div>

        <!-- Chat Messages -->
        <div class="flex-1 overflow-y-auto p-4 scrollbar-hide max-h-[calc(80vh-150px)] sm:max-h-full"> <!-- KALAU MAU PAKAI BACKGROUND, TAMBAH CLASS : bg-[url('{{ asset('storage/wp-chat.jpg') }}')] bg-repeat  -->
            @if (count($messages))
                @foreach ($messages as $message)
                    <div class="flex items-start mb-4 {{ $message->sender_id == auth()->id() ? 'justify-end' : 'justify-start' }}">
                        <div class="{{ $message->sender_id == auth()->id() ? 'bg-blue-500 text-white' : 'bg-white border-gray-200 border text-gray-800' }} p-2 rounded-lg shadow-sm">
                            <p class="text-sm">{{ $message->message }}</p>
                            <p class="text-xs  {{ $message->sender_id == auth()->id() ? 'text-white/65' : 'text-gray-400' }}">{{ $message->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="flex items-center justify-center p-4">
                    <p class="text-gray-500">Belum ada pesan. Mari mulai chat!</p>
                </div>
            @endif
        </div>

        <!-- Chat Input -->
        <div class="p-4 bg-white border border-gray-200 mb-4 md:mb-0">
            <form action="{{ route('chat.send', $activeChat->id) }}" method="POST" class="flex items-center">
                @csrf
                <input type="hidden" name="course_id" value="{{ $activeChat->course_id }}">
                <input type="text" name="message" placeholder="Tulis Pesan..." 
                    class="w-full px-3 py-1.5 text-gray-700 text-sm border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" required>
                <button type="submit" class="ml-4 px-3 py-1.5 text-sm bg-blue-500 text-white rounded-lg hover:bg-blue-400">
                    Kirim
                </button>
            </form>
        </div>
        @else
        <!-- Tombol Buka Sidebar (muncul di layar kecil saja) -->
        <div class="p-1 block lg:hidden absolute right-2 top-2.5">
                <button
                    @click="openSidebar = true"
                    class="bg-blue-400 hover:bg-blue-300 text-white p-1 rounded-md"
                >
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="white" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
                </button>
            </div>
        <div class="flex-1 flex items-center justify-center p-4">
            <p class="text-gray-500">Pilih peserta untuk memulai chat.</p>
        </div>
        @endif
    </main>
</div>
@endsection
