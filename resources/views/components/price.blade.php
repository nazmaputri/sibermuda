<!-- Price Section -->
<section id="price" class="bg-white py-16 mx-4">
    <div class="container mx-auto px-2 md:px-12">
        <div class="mb-6 text-center">
            <h3 class="text-xl md:text-2xl font-['poppins'] font-semibold text-[#08072a]" data-aos="fade-down">Rekomendasi Kursus Sibermuda</h3>
            <p class="text-lg  text-gray-700 mt-2" data-aos="fade-down">Pilih kursus yang sesuai dengan kebutuhan Anda.</p>
        </div>
        <div class="overflow-x-auto scrollbar-hide py-5">
            <div class="flex space-x-6">
                @foreach($courses as $course)
                    <div class="flex">
                    <a href="{{ route('kursus.detail', $course->slug) }}" class="block rounded-lg transition-transform transform hover:scale-105 duration-300">
                        <!-- Card Kursus -->
                        <div class="bg-white border border-gray-300 rounded-lg shadow-md  hover:shadow-lg h-full w-72 flex flex-col overflow-hidden" data-aos="zoom-in">
                            <!-- Gambar Kursus -->
                            <div class="w-full">
                                <img src="{{ asset('storage/' . $course->image_path) }}" alt="{{ $course->title }}" class="w-full h-48 object-cover">
                            </div>

                            <!-- Konten Kursus -->
                            <div class="p-4 flex flex-col">
                                <!-- Judul Kursus -->
                                <h1 class="text-lg font-semibold text-gray-800 mb-2">{{ Str::limit($course->title, 23, '...') }}</h1>
                                
                                <!-- Nama Mentor -->
                                <p class="text-sm text-gray-600 mb-2">
                                    Mentor : {{ $course->mentor ? $course->mentor->name : 'Mentor tidak ditemukan' }}
                                </p>                        
                                
                                <!-- Rating -->
                                <div class="flex">
                                    @for ($i = 0; $i < 5; $i++)
                                        @if ($i < floor($course->average_rating)) <!-- Rating Penuh -->
                                            <svg class="w-4 h-4 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927a1 1 0 011.902 0l1.715 4.993 5.274.406a1 1 0 01.593 1.75l-3.898 3.205 1.473 4.74a1 1 0 01-1.516 1.11L10 15.347l-4.692 3.783a1 1 0 01-1.516-1.11l1.473-4.74-3.898-3.205a1 1 0 01.593-1.75l5.274-.406L9.049 2.927z"></path>
                                            </svg>
                                        @elseif ($i < ceil($course->average_rating)) <!-- Rating Setengah -->
                                            <svg class="w-4 h-4" viewBox="0 0 20 20">
                                                <defs>
                                                    <linearGradient id="half-star-{{ $i }}">
                                                        <stop offset="50%" stop-color="rgb(234,179,8)" /> <!-- Kuning -->
                                                        <stop offset="50%" stop-color="rgb(209,213,219)" /> <!-- Abu-abu -->
                                                    </linearGradient>
                                                </defs>
                                                <path fill="url(#half-star-{{ $i }})" d="M9.049 2.927a1 1 0 011.902 0l1.715 4.993 5.274.406a1 1 0 01.593 1.75l-3.898 3.205 1.473 4.74a1 1 0 01-1.516 1.11L10 15.347l-4.692 3.783a1 1 0 01-1.516-1.11l1.473-4.74-3.898-3.205a1 1 0 01.593-1.75l5.274-.406L9.049 2.927z"></path>
                                            </svg>
                                        @else <!-- Rating Kosong -->
                                            <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927a1 1 0 011.902 0l1.715 4.993 5.274.406a1 1 0 01.593 1.75l-3.898 3.205 1.473 4.74a1 1 0 01-1.516 1.11L10 15.347l-4.692 3.783a1 1 0 01-1.516-1.11l1.473-4.74-3.898-3.205a1 1 0 01.593-1.75l5.274-.406L9.049 2.927z"></path>
                                            </svg>
                                        @endif
                                    @endfor
                                    <!-- Jumlah Rating -->
                                    <span class="ml-2 text-yellow-500 text-sm">{{ number_format($course->average_rating, 1) }} / 5</span>
                                </div>                 
                        
                                <!-- Harga Kursus -->
                                    <!-- menerima variabel untuk menampilkan harga setelah ada diskon -->
                                    @if($course->discounted_price)
                                        @php
                                            $discountPercentage = 100 - (($course->discounted_price / $course->price) * 100);
                                        @endphp
                                        <p class="text-red-500 inline-flex text-sm rounded-xl font-semibold mx-3">
                                            Rp. {{ number_format($course->discounted_price, 0, ',', '.') }}
                                            <span class="line-through text-gray-400 text-sm ml-2">
                                                Rp. {{ number_format($course->price, 0, ',', '.') }}
                                            </span>
                                            <span class="text-xs ml-2 font-medium text-red-500 p-0.5 bg-red-100 rounded-sm">
                                            - {{ $discountPercentage }}%!
                                            </span>
                                        </p>
                                    @else
                                        <p class="text-gray-700 inline-flex text-sm rounded-xl font-semibold mx-3">
                                            Rp. {{ number_format($course->price, 0, ',', '.') }}
                                        </p>
                                    @endif 
                            </div>
                        </div>
                    </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- Hero Section -->
<section class="relative bg-cover bg-center h-[80vh]">
    <!-- Background Image with Parallax Effect -->
    <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ asset('storage/programmer.jpg') }}'); background-attachment: fixed;">
    </div>

    <!-- Overlay Color to Darken the Background -->
    <div class="absolute inset-0 bg-midnight bg-opacity-30"></div>

    <div class="absolute inset-0 bg-black/50"></div>
    <div class="relative z-10 max-w-7xl mx-auto px-6 md:px-12 flex flex-col justify-center h-full text-white">
      <p class="text-white uppercase tracking-widest text-sm font-medium mb-4">Selamat Datang di Sibermuda!</p>
      <h1 class="text-3xl md:text-5xl font-semibold leading-tight">
      Mulailah Bangun Masa Depanmu<br />
      Bersama <span class="text-white">Sibermuda!</span> 
      </h1>
      <div class="flex gap-8 mt-4">
        <div class="text-center">
            <p class="text-3xl font-bold text-white">{{ $totalMentor }}</p>
            <p class="text-white">Mentor Profesional</p>
        </div>
        <div class="text-center">
            <p class="text-3xl font-bold text-white">{{ $totalStudent }}</p>
            <p class="text-white">Peserta Terdaftar</p>
        </div>
       </div>
      <a href="{{ route('tutorial.beli') }}" class="mt-6 flex gap-4">
        <button class="border border-white px-5 py-2 rounded-md text-sm hover:bg-white hover:text-midnight transition-transform duration-300 ease-in-out transform hover:scale-105">Lihat Cara Pembelian</button>
      </a>
    </div>
</section>