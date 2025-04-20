<style>
    /* Animasi hover untuk card testimoni */
    .hover\:shadow-lg:hover {
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- import sweetalert untuk popup -->
@vite('resources/js/app.js') <!-- tambah ini untuk menginisialisasi sweetalert yang sudah diimport di app.js dan alert.js di folder js -->

<!-- Testimoni Section -->
<section id="rating" class="bg-white py-16">
    <div class="container mx-auto px-2 md:px-12">
        <div class="mb-6 text-center">
            <h3 class="text-xl font-bold text-[#08072a]" data-aos="fade-down">
                Kata Mereka Tentang Sibermuda
            </h3>
            <p class="text-md text-gray-700 mt-2" data-aos="fade-down">
                Kami percaya, mereka yang telah lulus dari Sibermuda punya cerita sukses yang menginspirasi.
            </p>
        </div>
        <div class="overflow-x-auto hide-scrollbar">
        @if ($ratings->isEmpty())
            <div class="text-center text-gray-500 text-md" data-aos="fade-down">
                Belum ada rating
            </div>
        @else
            <div class="flex space-x-6 py-2">
                @foreach ($ratings as $rating)
                    @if ($rating->display) 
                        <div class="bg-white border border-gray-200 rounded-lg shadow-md w-full md:w-1/2 lg:w-1/3 p-6 mt-6 mx-2 hover:shadow-lg transition-shadow duration-300 ease-in-out" data-aos="zoom-in-up">
                            <div class="flex items-center mb-1 w-[300px]">
                                <!-- Gambar avatar (ikon user) -->
                                <div class="w-14 h-14 rounded-full flex items-center justify-center">
                                    <img width="44" height="44" src="{{ asset('storage/default-profile.jpg') }}" alt="Default Profile"/>
                                </div>
        
                                <!-- Nama dan Rating -->
                                <div class="ml-4">
                                    <!-- Nama User -->
                                    <h4 class="text-md font-semibold text-midnight">{{ $rating->nama }}</h4>
                                    <div class="flex items-center">
                                        <!-- Menampilkan bintang berdasarkan rating -->
                                        @for ($i = 0; $i < 5; $i++)
                                            <span class="{{ $i < $rating->rating ? 'text-yellow-500' : 'text-gray-300' }}">&starf;</span>
                                        @endfor
                                    </div>
                                    <h4 class="text-xs text-gray-600 mt-1">{{ \Carbon\Carbon::parse($rating->created_at)->translatedFormat('d F Y') }}</h4>
                                </div>
                            </div>
                            <p class="text-gray-700">{{ $rating->comment }}</p>
                        </div>
                    @endif
                @endforeach
            </div>
            @endif
        </div>
        
        <div id="openRatingBtn" class="mb-6 text-center" data-aos="zoom-in-up">
            <button class="text-md px-6 py-2 rounded-full bg-white border border-gray-700 hover:bg-[#08072a] hover:text-white mt-2 text-midnight font-semibold shadow-md hover:bg-opacity-90 transition-transform duration-300 ease-in-out transform hover:scale-105">
                Berikan Rating Sibermuda
            </button>
        </div>

    </div>

<!-- Rating Section -->
<section id="ratingform" class="fixed inset-0 w-full h-full bg-black bg-opacity-50 items-center justify-center p-4 hidden z-[1000] flex">
    <div class="container mx-auto md:mx-16 my-2 rounded rounded-md px-2 bg-white max-w-xl w-full">
        <div class="flex flex-col items-center space-y-2 p-3">
            <!-- Close Button with Icon -->
            <button id="closeRatingBtn" class="flex items-center text-sm text-red-500 hover:text-red-600 gap-1 self-end">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="gray-700">
                    <path fill-rule="evenodd" d="M10 8.586L15.95 2.636a1 1 0 111.414 1.414L11.414 10l5.95 5.95a1 1 0 01-1.414 1.414L10 11.414l-5.95 5.95a1 1 0 01-1.414-1.414L8.586 10 2.636 4.05a1 1 0 011.414-1.414L10 8.586z" clip-rule="evenodd" />
                </svg>
            </button>

            <!-- Rating Form -->
            <form class="space-y-2 w-full" method="POST" action="{{ route('rating.store') }}">
                @csrf
                <h1 class="text-center font-semibold text-gray-700 text-lg">Form Penilaian Sibermuda</h1>
                <!-- Nama -->
                <div>
                    <label for="nama" class="block text-md text-gray-700">Nama :</label>
                    <input type="text" id="nama" name="nama" class="text-gray-600 border rounded-md p-2 w-full focus:outline-none focus:ring-1 focus:ring-gray-600 focus:border-gray-600 @error('nama') border-red-500 @enderror" placeholder="Masukkan nama Anda"/>
                    @error('nama')
                        <span class="text-red-500 text-sm block mt-1" id="error-nama">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-md text-gray-700">Email :</label>
                    <input type="email" id="email" name="email" class="text-gray-600 border rounded-md p-2 w-full focus:outline-none focus:ring-1 focus:ring-gray-600 focus:border-gray-600 @error('email') border-red-500 @enderror" placeholder="Masukkan email Anda"/>
                    @error('email')
                        <span class="text-red-500 text-sm block mt-1" id="error-email">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Rating -->
                <div>
                    <label for="rating" class="block text-md text-gray-700">Rating :</label>
                    <div id="rating" class="flex space-x-1 border rounded-md p-2.5 bg-white w-full">
                        @for ($i = 1; $i <= 5; $i++)
                            <svg data-value="{{ $i }}" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 cursor-pointer transition-colors duration-200" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 .587l3.668 7.451 8.332 1.151-6.064 5.865 1.486 8.246L12 18.897l-7.422 4.403 1.486-8.246L.667 9.189l8.332-1.151z" />
                            </svg>
                        @endfor
                    </div>
                    <input type="hidden" name="rating" id="rating-input" value="0" class="@error('rating') border-red-500 @enderror">
                    @error('rating')
                        <span class="text-red-500 text-sm block mt-1" id="error-rating">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Komentar -->
                <div>
                    <label for="comment" class="block text-md text-gray-700">Komentar :</label>
                    <textarea id="comment" name="comment" rows="4" class="text-gray-600 border rounded-md p-2 w-full focus:outline-none focus:ring-1 focus:ring-gray-600 focus:border-gray-600 @error('comment') border-red-500 @enderror" placeholder="Tulis ulasan Anda di sini..."></textarea>
                    @error('comment')
                        <span class="text-red-500 text-sm block mt-1" id="error-comment">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit" class="bg-[#08072a] text-white px-4 py-2 rounded-md hover:bg-opacity-90 focus:outline-none flex items-center gap-2 transition-transform duration-300 ease-in-out transform hover:scale-105">
                    Kirim
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="white" viewBox="0 0 50 50">
                        <path d="M46.137,6.552c-0.75-0.636-1.928-0.727-3.146-0.238l-0.002,0C41.708,6.828,6.728,21.832,5.304,22.445c-0.259,0.09-2.521,0.934-2.288,2.814c0.208,1.695,2.026,2.397,2.248,2.478l8.893,3.045c0.59,1.964,2.765,9.21,3.246,10.758c0.3,0.965,0.789,2.233,1.646,2.494c0.752,0.29,1.5,0.025,1.984-0.355l5.437-5.043l8.777,6.845l0.209,0.125c0.596,0.264,1.167,0.396,1.712,0.396c0.421,0,0.825-0.079,1.211-0.237c1.315-0.54,1.841-1.793,1.896-1.935l6.556-34.077C47.231,7.933,46.675,7.007,46.137,6.552z M22,32l-3,8l-3-10l23-17L22,32z"></path>
                    </svg>
                </button>
            </form>
        </div>
    </div>
</section>

<!-- Script -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const stars = document.querySelectorAll('#rating svg');
        const ratingInput = document.getElementById('rating-input');
        let selectedRating = 0;

        stars.forEach((star, index) => {
            const value = parseInt(star.getAttribute('data-value'));

            // Hover effect
            star.addEventListener('mouseenter', () => {
                highlightStars(value);
            });

            // Remove hover effect when mouse leaves the container
            star.parentElement.addEventListener('mouseleave', () => {
                highlightStars(selectedRating);
            });

            // Set rating when clicked
            star.addEventListener('click', () => {
                selectedRating = value;
                ratingInput.value = selectedRating;
                highlightStars(selectedRating);
            });
        });

        function highlightStars(rating) {
            stars.forEach((star) => {
                const starValue = parseInt(star.getAttribute('data-value'));
                if (starValue <= rating) {
                    star.classList.replace('text-gray-400', 'text-yellow-400');
                } else {
                    star.classList.replace('text-yellow-400', 'text-gray-400');
                }
            });
        }

        // Remove error styling on input
        const inputs = document.querySelectorAll('input, textarea, select');
        inputs.forEach(input => {
            input.addEventListener('input', function () {
                const errorSpan = document.getElementById('error-' + input.id);
                if (errorSpan) errorSpan.style.display = 'none';
                input.classList.remove('border-red-500');
            });
        });

        // Handle open popup (optional if you have a trigger button)
        const openRatingBtn = document.getElementById('openRatingBtn');
        const ratingSection = document.getElementById('ratingform');

        if (openRatingBtn) {
            openRatingBtn.addEventListener('click', function () {
                ratingSection.classList.remove('hidden');
                ratingSection.scrollIntoView({ behavior: 'smooth' });
            });
        }

        // Handle close popup
        const closeRatingBtn = document.getElementById('closeRatingBtn');
        if (closeRatingBtn) {
            closeRatingBtn.addEventListener('click', function () {
                ratingSection.classList.add('hidden');
            });
        }
    });
</script>

    <!-- tambah ini untuk menangkap popup pesan backend menggunakan sweetalert -->
    @if(session('success') || session('error') || session('info') || session('warning'))
        <div id="sweetalert-data"
            data-type="{{ session('success') ? 'success' : (session('error') ? 'error' : (session('info') ? 'info' : 'warning')) }}"
            data-message="{{ session('success') ?? session('error') ?? session('info') ?? session('warning') }}">
        </div>
    @endif
</section>
