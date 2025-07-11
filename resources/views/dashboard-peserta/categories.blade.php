@extends('layouts.dashboard-peserta')
@section('title', 'Kursus')
@section('content')
    <div class="bg-white border border-gray-200 rounded-lg shadow-md p-6 mb-3">
        <!-- Form untuk memilih kategori -->
        <form action="{{ route('kategori-peserta') }}" method="GET">
            <label for="kategori" class="block text-sm text-gray-700 mb-2">Pilih Kategori</label>

            <div class="flex flex-col sm:flex-row sm:items-center sm:gap-4 mb-3 md:mb-5">
                <div 
                    x-data="dropdownKategori()"
                    class="relative w-full sm:w-80 mb-2 sm:mb-0"
                >
                    <!-- Input tersembunyi -->
                    <input type="hidden" name="kategori" :value="selectedId">

                    <!-- Search/Input sekaligus tombol -->
                    <div class="relative">
                        <input 
                            type="text"
                            @click="open = true"
                            x-model="search"
                            :placeholder="selectedName || 'Pilih kategori'"
                            class="p-2 bg-white border border-gray-300 rounded-md shadow-sm text-sm text-gray-600 capitalize w-full focus:outline-none cursor-pointer"
                        >
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg :class="{ 'rotate-180': open }" class="w-4 h-4 ml-2 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>

                    <!-- Dropdown options -->
                    <div 
                        x-show="open"
                        @click.away="open = false"
                        x-transition
                        class="absolute z-10 mt-1 w-full bg-white border border-gray-200 rounded-md shadow-lg max-h-60 overflow-y-auto text-sm"
                    >
                        <ul class="max-h-40 overflow-y-auto shidecrollbar-">
                            <li 
                                @click="clearSelection"
                                class="px-4 py-2 hover:bg-gray-100 cursor-pointer text-gray-500 italic truncate"
                            >
                                Pilih kategori
                            </li>

                            <template x-for="kategori in filteredCategories" :key="kategori.id">
                                <li 
                                    @click="selectCategory(kategori)"
                                    class="px-4 py-2 hover:bg-gray-100 cursor-pointer capitalize text-gray-700 truncate"
                                    :class="{ 'bg-gray-100': selectedId == kategori.id }"
                                    x-text="kategori.name"
                                ></li>
                            </template>

                            <div x-show="filteredCategories.length === 0" class="px-4 py-2 text-gray-500 italic text-sm">
                                Tidak ada hasil.
                            </div>
                        </ul>
                    </div>
                </div>

                <!-- Tombol Submit -->
                <button 
                    type="submit"
                    class="bg-midnight text-white px-4 py-2 text-sm rounded-md hover:bg-opacity-90 w-full sm:w-auto sm:mx-0 mx-auto"
                >
                    Tampilkan Kursus
                </button>
            </div>
        </form>

        @if($courses->isEmpty())
            <!-- Pesan jika tidak ada kursus -->
            <div class="col-span-full text-center items-center justify-center flex flex-col">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 mb-1 text-gray-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5m6 4.125 2.25 2.25m0 0 2.25 2.25M12 13.875l2.25-2.25M12 13.875l-2.25 2.25M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                </svg>
                <p class="text-gray-600 text-center text-sm">Belum ada kursus.</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($courses->whereIn('status', ['approved', 'published', 'nopublished']) as $course)
                    @php
                        $isPurchased = $course->purchases()
                            ->where('user_id', auth()->id())
                            ->where('status', 'success')
                            ->exists();
                    @endphp
                    <div class="bg-white border border-gray-200 rounded-lg shadow-md overflow-hidden flex flex-col">
                        <img class="w-full h-48 object-cover" src="{{ asset('storage/' . $course->image_path) }}" alt="{{ $course->title }}">
                        <div class="flex flex-col flex-grow">
                            <h3 class="text-md font-semibold text-gray-700 capitalize mx-3 mt-1">{{ $course->title }}</h3>
                            <p class="text-sm text-gray-600 mx-3 capitalize">Mentor : {{ $course->mentor?->name ?? 'Tidak diketahui'}}</p>
                            {{-- <p class="text-red-500 inline-flex items-center text-sm rounded-xl font-semibold mx-3" id="course-price-{{ $course->id }}">
                                Rp. {{ number_format($course->discounted_price ?? $course->price, 0, ',', '.') }}
                            </p>   --}}
                            @if($course->discounted_price)
                                @php
                                    $discountPercentage = 100 - (($course->discounted_price / $course->price) * 100);
                                @endphp
                                <p class="text-red-500 inline-flex items-center text-sm rounded-xl font-semibold mx-3">
                                    Rp. {{ number_format($course->discounted_price, 0, ',', '.') }}
                                    <span class="line-through text-gray-400 text-sm ml-2">
                                        Rp. {{ number_format($course->price, 0, ',', '.') }}
                                    </span>
                                    <span class="text-xs ml-2 font-medium text-red-500 p-0.5 bg-red-100 rounded-sm">
                                       - {{ $discountPercentage }}%!
                                    </span>
                                </p>
                            @else
                                <p class="text-red-500 inline-flex items-center text-sm rounded-xl font-semibold mx-3">
                                    Rp. {{ number_format($course->price, 0, ',', '.') }}
                                </p>
                            @endif  
                            <div class="items-center mt-1 flex-grow">
                                <div class="flex my-2 mx-3">
                                    @for ($i = 0; $i < 5; $i++)
                                        @if ($i < floor($course->average_rating)) 
                                            <svg class="w-4 h-4 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927a1 1 0 011.902 0l1.715 4.993 5.274.406a1 1 0 01.593 1.75l-3.898 3.205 1.473 4.74a1 1 0 01-1.516 1.11L10 15.347l-4.692 3.783a1 1 0 01-1.516-1.11l1.473-4.74-3.898-3.205a1 1 0 01.593-1.75l5.274-.406L9.049 2.927z"></path>
                                            </svg>
                                        @else
                                            <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927a1 1 0 011.902 0l1.715 4.993 5.274.406a1 1 0 01.593 1.75l-3.898 3.205 1.473 4.74a1 1 0 01-1.516 1.11L10 15.347l-4.692 3.783a1 1 0 01-1.516-1.11l1.473-4.74-3.898-3.205a1 1 0 01.593-1.75l5.274-.406L9.049 2.927z"></path>
                                            </svg>
                                        @endif
                                    @endfor
                                    <span class="text-yellow-500 text-sm sm:ml-2 sm:mt-0">{{ number_format($course->average_rating, 1) }} / 5</span>
                                </div>
                            </div>

                            <!-- LABEL -->
                            <div class="mt-auto">
                                <div class="flex w-full h-[30px]">
                                    <div class="w-1/2 {{ $isPurchased ? 'bg-green-500 hover:bg-green-400' : 'bg-red-500 hover:bg-red-400' }} flex justify-center items-center p-4">
                                        @if (!$isPurchased)
                                            <form action="{{ route('cart.add', ['slug' => $course->slug]) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="flex items-center space-x-3 text-white">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" class="w-5 h-5">
                                                        <path d="M0 24C0 10.7 10.7 0 24 0L69.5 0c22 0 41.5 12.8 50.6 32l411 0c26.3 0 45.5 25 38.6 50.4l-41 152.3c-8.5 31.4-37 53.3-69.5 53.3l-288.5 0 5.4 28.5c2.2 11.3 12.1 19.5 23.6 19.5L488 336c13.3 0 24 10.7 24 24s-10.7 24-24 24l-288.3 0c-34.6 0-64.3-24.6-70.7-58.5L77.4 54.5c-.7-3.8-4-6.5-7.9-6.5L24 48C10.7 48 0 37.3 0 24zM128 464a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm336-48a48 48 0 1 1 0 96 48 48 0 1 1 0-96z" fill="white"/>
                                                    </svg>
                                                    <span class="text-sm">Keranjang</span>
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-sm text-white px-3 py-1 rounded cursor-not-allowed">
                                                Dibeli
                                            </span>
                                        @endif
                                    </div>

                                    <div class="w-1/2 bg-sky-400 hover:bg-sky-300 flex justify-center items-center p-4">
                                        <a href="{{ route('kursus-peserta', ['slug' => $course->slug, 'categorySlug' => $course->category->slug]) }}"
                                        class="text-white py-1.5 px-5 rounded-lg flex items-center space-x-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                                            <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                            <path fill-rule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z" clip-rule="evenodd" />
                                        </svg>
                                        <span class="text-sm">Detail</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

<!-- Alpine Data Untuk Dropdown -->
<script>
    function dropdownKategori() {
        return {
            open: false,
            search: '',
            selectedName: '{{ request('kategori') ? ($categories->firstWhere('id', request('kategori'))?->name ?? 'Pilih kategori') : 'Pilih kategori' }}',
            selectedId: '{{ request('kategori') ?? '' }}',
            categories: @json($categories),
            get filteredCategories() {
                if (this.search === '') {
                    return this.categories;
                }
                return this.categories.filter(c => c.name.toLowerCase().includes(this.search.toLowerCase()));
            },
            selectCategory(kategori) {
                this.selectedId = kategori.id;
                this.selectedName = kategori.name;
                this.search = kategori.name;
                this.open = false;
            },
            clearSelection() {
                this.selectedId = '';
                this.selectedName = 'Pilih kategori';
                this.search = '';
                this.open = false;
            }
        }
    }
</script>
@endsection
