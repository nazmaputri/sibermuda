@extends('layouts.dashboard-peserta')
@section('title', 'Detail Kursus')
@section('content')

<!-- Tombol Kembali -->
<div class="flex justify-start mb-2">
    <a href="{{ route('daftar-kursus') }}" class="text-midnight font-semibold p-1 bg-white border border-gray-200 rounded-full transition-transform duration-300 ease-in-out transform hover:scale-105 inline-flex items-center">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
        </svg>
    </a>
</div>

<div class="container mx-auto">
    <div class="bg-white p-8 border border-gray-200 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold mb-4 border-b-2 border-gray-300 pb-2 text-gray-700 text-center">Detail Kursus</h2>

        <!-- Card Informasi Kursus -->
        <div class="flex flex-col lg:flex-row mb-4">
            <div class="w-full sm:w-1/4 md:w-1/5 mb-4 lg:mb-0">
                @if($course && $course->image_path)
                    <img src="{{ asset('storage/' . $course->image_path) }}" alt="{{ $course->title }}" class="rounded-lg w-full h-auto">
                @else
                    <img src="https://via.placeholder.com/400x300" alt="Default Course Image" class="rounded-lg w-full h-auto">
                @endif
            </div>
            <div class="ml-4 md:w-2/3 w-full space-y-1">
                <h2 class="text-lg font-medium capitalize text-gray-700">{{ $course->title }}</h2>
                <p class="text-gray-700 text-sm">{{ $course->description }}</p>
                <div class="text-gray-600 text-sm space-y-1">
                <div class="flex flex-wrap">
                    <span class="w-24 capitalize">Mentor</span><span class="mr-1">:</span>
                    <span>{{ $course->mentor->name }}</span>
                </div>

                <div class="flex flex-wrap">
                    <span class="w-24">Harga</span><span class="mr-1">:</span>
                    <span class="text-red-500">Rp {{ number_format($course->price, 0, ',', '.') }}</span>
                </div>

                @if($course->start_date && $course->end_date)
                    <div class="flex flex-wrap">
                        <span class="w-24">Tanggal Mulai</span><span class="mr-1">:</span>
                        <span>{{ \Carbon\Carbon::parse($course->start_date)->translatedFormat('d F Y') }} - {{ \Carbon\Carbon::parse($course->end_date)->translatedFormat('d F Y') }}</span>
                    </div>
                @endif

                @if($course->duration)
                    <div class="flex flex-wrap">
                        <span class="w-24">Masa Aktif</span><span class="mr-1">:</span>
                        <span>{{ $course->duration }}</span>
                    </div>
                @endif

                @if($course->capacity)
                    <div class="flex flex-wrap">
                        <span class="w-24">Kapasitas</span><span class="mr-1">:</span>
                        <span>{{ $course->capacity }} peserta</span>
                    </div>
                @endif
                </div>
            </div>
        </div>

         <!-- Tombol Rating di kanan bawah -->
         <div class="flex justify-end mt-6">
            @if(!$hasRated)
            <button id="ratingButton" class="bg-yellow-400 hover:bg-yellow-300 text-white font-semibold py-1.5 px-3 rounded-md text-sm">
                Beri Rating
            </button>
            @else
            <button id="ratingdone" class="bg-gray-400 hover:bg-gray-300 text-white font-semibold py-1.5 px-3 rounded-md text-sm cursor-not-allowed">
                Beri Rating
            </button>
            @endif
        </div>
    </div>
</div>

<!-- Modal Pop-up -->
<div id="ratingModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
    <div id="modalBox" class="bg-white p-6 rounded-lg shadow-lg md:w-1/3 w-full mx-4 transform transition-all duration-300 ease-out scale-90 opacity-0">
        <h2 class="text-lg text-gray-700 text-center font-semibold mb-4">Beri Rating Kursus</h2>
        <form id="ratingForm" method="POST" action="{{ route('ratings.store', ['course_id' => $course->id]) }}">
            @csrf
            <input type="hidden" name="course_id" value="{{ $course->id }}">
                <div class="mb-4">
                    <label for="stars" class="block text-sm font-medium text-gray-600 mb-2 font-semibold">Rating</label>
                    <div id="starRating" class="flex space-x-1">
                        @for ($i = 1; $i <= 5; $i++)
                            <svg data-value="{{ $i }}" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 cursor-pointer hover:text-yellow-500" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 .587l3.668 7.451 8.332 1.151-6.064 5.865 1.486 8.246L12 18.897l-7.422 4.403 1.486-8.246L.667 9.189l8.332-1.151z" />
                            </svg>
                        @endfor
                    </div>
                    <input type="hidden" name="stars" id="stars" required>
                </div>
                <script>
                    const stars = document.querySelectorAll('#starRating svg');
                    const starInput = document.getElementById('stars');
                
                    stars.forEach(star => {
                        star.addEventListener('click', () => {
                            const value = star.getAttribute('data-value');
                            starInput.value = value;
                
                            // Reset warna semua bintang
                            stars.forEach(s => s.classList.remove('text-yellow-500'));
                            stars.forEach(s => s.classList.add('text-gray-400'));
                
                            // Warnai bintang sesuai rating yang dipilih
                            for (let i = 0; i < value; i++) {
                                stars[i].classList.remove('text-gray-400');
                                stars[i].classList.add('text-yellow-500');
                            }
                        });
                    });
                </script>                
                <div class="mb-4">
                    <label for="comment" class="block text-sm text-gray-600 font-semibold">Komentar</label>
                    <textarea name="comment" id="comment" class="w-full text-sm text-gray-700 border rounded px-2 py-1 focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400" rows="4" placeholder="Tulis komentar Anda (opsional)"></textarea>
                </div>
                <div class="flex justify-end">
                    <button type="button" id="closeRatingModal" class="bg-red-400 hover:bg-red-300 text-white font-semibold py-2 px-4 rounded-lg mr-2 text-center text-sm">
                        Batal
                    </button>
                    <button type="submit" class="bg-sky-400 hover:bg-sky-300 text-white font-semibold py-2 px-4 rounded-lg text-center text-sm">
                        Kirim
                    </button>
                </div>
        </form>
    </div>
</div>

<script>
    const ratingModal = document.getElementById('ratingModal');
    const modalBox = document.getElementById('modalBox');

    document.getElementById('ratingButton').addEventListener('click', function () {
        ratingModal.classList.remove('hidden');

        // Delay agar animasi terlihat
        setTimeout(() => {
            modalBox.classList.remove('opacity-0', 'scale-90');
            modalBox.classList.add('opacity-100', 'scale-100');
        }, 10);
    });

    document.getElementById('closeRatingModal').addEventListener('click', function () {
        modalBox.classList.remove('opacity-100', 'scale-100');
        modalBox.classList.add('opacity-0', 'scale-90');

        // Tunggu animasi selesai sebelum menyembunyikan modal
        setTimeout(() => {
            ratingModal.classList.add('hidden');
        }, 300); // harus sesuai dengan duration Tailwind (300ms)
    });
</script>
@endsection
