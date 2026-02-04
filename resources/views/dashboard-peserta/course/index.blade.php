@extends('layouts.dashboard-peserta')
@section('title', 'Kursus Saya')
@section('content')
<div class="container mx-auto">
    <div class="bg-white border border-gray-200 rounded-lg shadow-md p-6 mb-3">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse($courses as $course)
                <div class="border rounded-lg p-4 shadow-md bg-white flex flex-col">
                    <div class="w-full mb-2">
                        <img src="{{ asset('storage/' . $course->image_path) }}" alt="{{ $course->title }}" class="rounded-lg w-full h-40 object-cover">
                    </div>
                    <h2 class="text-md text-gray-700 font-medium capitalize">{{ $course->title }}</h2>
                    <!-- <p class="text-gray-600 text-sm mt-2 capitalize"><span class="">Mentor :</span> {{ $course->mentor->name }}</p>
                    <p class="text-gray-600 text-sm mb-5"><span class="">Masa Aktif :</span> {{ $course->duration }}</p> -->

                    <nav class="text-sm mt-auto whitespace-nowrap overflow-x-auto scrollbar-hide">
                        <ol class="flex space-x-2 text-gray-600 mt-2">
                            <li>
                                <a href="{{ route('detail-kursus', $course->slug) }}" class="hover:text-sky-500 hover:underline">Detail</a>
                            </li>
                            <li class="flex items-center">
                                <span>
                                    <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                                    </svg>
                                </span>
                            </li>
                            <li>
                                <a href="{{ route('study-peserta', ['slug' => $course->slug]) }}" class="hover:text-yellow-500 hover:underline">Belajar</a>
                            </li>
                            <li class="flex items-center">
                                <span>
                                    <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                                    </svg>
                                </span>
                            </li>
                            <li>
                                @if ($course->isChatActive)
                                    <a href="{{ route('chat.start', $course->slug) }}" class="hover:text-green-500 hover:underline">Chat</a>
                                @else
                                    <span class="text-gray-400 cursor-not-allowed" title="Chat tidak tersedia untuk kursus ini">Chat</span>
                                @endif
                            </li>
                        </ol>
                    </nav>
                </div>
            @empty
            <div class="col-span-full text-center items-center justify-center flex flex-col">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 mb-1 text-gray-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5m6 4.125 2.25 2.25m0 0 2.25 2.25M12 13.875l2.25-2.25M12 13.875l-2.25 2.25M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                </svg>
                <p class="text-gray-600 text-center text-sm">Kamu belum membeli kursus apapun.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
