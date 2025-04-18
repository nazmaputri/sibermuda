<!-- Courses Section -->
<section id="category" class="bg-white py-16">
    <div class="container mx-auto px-6">
        <div class="mb-6 text-center">
            <h3 class="text-xl font-bold text-[#08072a]" data-aos="fade-up">
                 Eksplorasi Kategori Kursus di Sibermuda
            </h3>
            <p class="text-md text-gray-700 mt-2" data-aos="fade-up">
                Temukan berbagai kategori menarik dengan kursus berkualitas untuk meningkatkan keterampilan Anda.
            </p>
        </div>

        <div class="overflow-x-auto hide-scrollbar"> 
            <div class="flex space-x-6 m-7">
                @foreach($categories as $category)
                    <div class="course-card bg-white border border-gray-300 rounded-lg shadow-md overflow-hidden flex-none w-72 flex-shrink-0 flex flex-col transition-transform duration-300 ease-in-out" data-aos="zoom-in-down">
                        <div class="flex justify-center mt-5">
                            <img src="{{ asset('storage/' . $category->image_path) }}" alt="{{ $category->name }}" class="w-36 h-32">
                        </div>
                        <div class="p-4 flex flex-col flex-grow">
                            <h4 class="text-xl font-semibold text-gray-800 text-center">{{ $category->name }}</h4>
                            <p class="text-gray-600 mt-2 flex-grow text-center text-sm">{{ Str::limit($category->description, 100) }}</p>
                            <div class="mt-4">
                                <a href="{{ route('category.detail',  $category->name) }}" class="inline-block w-full bg-[#08072a] hover:bg-opacity-90 text-white px-4 py-2 rounded-xl shadow-md shadow-[#08072a] text-center">
                                    Lihat Kursus
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <style>
        /* Tailwind Custom CSS untuk menyembunyikan scrollbar */
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        /* Animasi hover untuk card */
        .course-card:hover {
            transform: scale(1.05); 
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }
    </style>
</section>
