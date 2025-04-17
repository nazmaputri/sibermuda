<!-- Home Section -->
<section id="home" class="flex items-center h-screen bg-[#08072a] text-sky-600" data-aos="fade-up">
    <div class="container mx-auto px-2 md:px-12 py-8 mt-4">
        <div class="flex flex-col-reverse lg:flex-row items-center">
            <!-- Text Content -->
            <div class="w-full lg:w-1/2 flex flex-col justify-center space-y-6 pt-8 lg:pt-0">
                <h1 class="text-3xl font-bold leading-tight text-white">Sibermuda.Idn</h1>
                <h2 class="text-md md:text-xl text-white">
                    Membangun generasi muda dengan literasi pendidikan 
                </h2>
                <div class="flex space-x-4 mt-4">
                    <a href="/login" class="px-6 py-2 bg-white border border-[#08072a] text-[#08072a] font-bold rounded-full hover:bg-white hover:scale-[0.95] transform transition-all duration-300 ease-in-out z-20">
                        Belajar Sekarang!
                    </a>
                </div>
            </div>
            <!-- Image Content -->
            <div class="w-full lg:w-1/2 flex justify-center">
                <img src="{{ asset('storage/logo-sibermuda.png') }}" alt="Hero Image" class="w-full h-auto lg:max-w-sm transform hover:scale-105 transition-transform duration-500 animate-smallbounce">
            </div>
        </div>
    </div>
</section>

<!-- Card Section -->
<div class="bg-white z-10 pb-6 lg:pb-20 md:pt-6">
    <div class="container mx-auto px-6 md:px-12">
        <p class="text-center font-semibold text-[#08072a] text-xl mb-2 md:mb-5  mt-2" data-aos="fade-up">Mengapa Sibermuda.Idn Adalah Pilihan Tepat?</p>
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-6" data-aos="fade-up">
            <!-- Card 1 -->
            <div class="bg-white shadow-lg rounded-xl overflow-hidden transform transition-transform hover:scale-105">
                <div class="flex justify-center py-4">
                    <div class="p-3 rounded-full bg-[#08072a] bg-opacity-90">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="white" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                        </svg>
                    </div>
                </div>
                <div class="p-4 pt-1 text-center">
                    <h3 class="font-bold text-lg text-[#08072a]">Mentor Gaul</h3>
                    <p class="text-gray-600 text-sm">Dengan adanya pembelajaran yang asik, dapat mempermudah untuk memahami pembelajaran.</p>
                </div>
            </div>
            <!-- Card 2 -->
            <div class="bg-white shadow-lg rounded-xl overflow-hidden transform transition-transform hover:scale-105">
                <div class="flex justify-center py-4">
                    <div class="p-3 rounded-full bg-[#08072a] bg-opacity-90">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="white" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" />
                    </svg>
                    </div>
                </div>
                <div class="p-4 pt-1 text-center">
                    <h3 class="font-bold text-lg text-[#08072a]">Privasi</h3>
                    <p class="text-gray-600 text-sm">Privasi Pemuda 100% Terjaga dengan baik oleh Siber Muda Indonesia.</p>
                </div>
            </div>
            <!-- Card 3 -->
            <div class="bg-white shadow-lg rounded-xl overflow-hidden transform transition-transform hover:scale-105">
                <div class="flex justify-center py-4">
                    <div class="p-3 rounded-full bg-[#08072a] bg-opacity-90">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="white" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
                    </svg>
                    </div>
                </div>
                <div class="p-4 pt-1 text-center">
                    <h3 class="font-bold text-lg text-[#08072a]">Perkembangan pemuda</h3>
                    <p class="text-gray-600 text-sm">Cukup mengikuti course ini dalam 1 kali, pemuda sudah bisa berkarir dengan handal.</p>
                </div>
            </div>
            <!-- Card 4 -->
            <div class="bg-white shadow-lg rounded-xl overflow-hidden transform transition-transform hover:scale-105">
                <div class="flex justify-center py-4">
                    <div class="p-3 rounded-full bg-[#08072a] bg-opacity-90">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="white" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 11.25v8.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5v-8.25M12 4.875A2.625 2.625 0 1 0 9.375 7.5H12m0-2.625V7.5m0-2.625A2.625 2.625 0 1 1 14.625 7.5H12m0 0V21m-8.625-9.75h18c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125h-18c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                    </svg>
                    </div>
                </div>
                <div class="p-4 pt-1 text-center">
                    <h3 class="font-bold text-lg text-[#08072a]">Sertifikat</h3>
                    <p class="text-gray-600 text-sm">Dapatkan sertifikat setelah menyelesaikan kursus.</p>
                </div>
            </div>
            <!-- Card 5 -->
            <div class="bg-white shadow-lg rounded-xl overflow-hidden transform transition-transform hover:scale-105">
                <div class="flex justify-center py-4">
                    <div class="p-3 rounded-full bg-[#08072a] bg-opacity-90">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="white" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    </div>
                </div>
                <div class="p-4 pt-1 text-center">
                    <h3 class="font-bold text-lg text-[#08072a]">Materi 24 jam</h3>
                    <p class="text-gray-600 text-sm">Akses materi belajar kapan saja, 24 jam penuh.</p>
                </div>
            </div>
        </div>
    </div>
</div>
