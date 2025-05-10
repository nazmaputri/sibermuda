<div class="bg-blue-400 rounded-2xl px-6 py-10 md:px-12 md:py-14 text-white mx-4 md:mx-24 -mb-24 mt-10 relative overflow-hidden">
  <!-- Background motif bisa ditambahkan pakai pseudo-element atau SVG pattern jika perlu -->
  <div class="md:flex md:items-center md:justify-between">
    <div class="text-center md:text-left">
      <h2 class="text-lg md:text-2xl font-semibold leading-tight">
      Belajar Tanpa Batas, <br />Berkembang Tanpa Henti!!
      </h2>
    </div>
    <div class="mt-6 md:mt-0 md:ml-8 flex justify-center md:justify-end">
      <a href="/login" class="group inline-flex items-center px-6 py-3 bg-[#171738] text-white font-medium rounded-xl hover:bg-opacity-95 transform transition-transform duration-300 group-hover:translate-x-2">
        Daftar Sekarang
        <svg class="w-4 h-4 ml-2 transform transition-transform duration-300 group-hover:translate-x-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
        </svg>
      </a>
    </div>
  </div>
</div>

<footer class="bg-[#08072a] text-white py-10">
    <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 pt-24">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 text-center justify-center place-items-center sm:text-left">
            <!-- Logo & Deskripsi -->
            <div class="flex flex-col items-center sm:items-start">
                <a href="#" class="flex items-center space-x-3">
                    <div class="w-14 h-14 flex items-center justify-center">
                        <img src="{{ asset('storage/logo-sibermuda.png') }}" alt="EduFlix Logo" class="object-cover w-full h-full">
                    </div>
                    <span class="text-xl font-semibold text-white">Sibermuda.Idn</span>
                </a>
                <p class="mt-4 text-sm">
                    Sibermuda adalah platform kursus online dengan berbagai topik menarik yang disampaikan melalui video. Tersedia juga fitur konsultasi via chat untuk membantu siswa memahami materi dengan lebih baik.
                </p>
            </div>

            <!-- Menu Navigasi -->
            <div class="flex flex-col items-center sm:items-start">
                <h4 class="font-semibold mb-4">Navigasi</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('landingpage') }}" class="hover:text-blue-200 transition">Beranda</a></li>
                    <li><a href="{{ route('tentang.kami') }}" class="hover:text-blue-200 transition">Tentang</a></li>
                    <li><a href="{{ route('category') }}" class="hover:text-blue-200 transition">Kategori</a></li>
                    <li><a href="{{ route('visi.misi') }}" class="hover:text-blue-200 transition">Visi</a></li>
                    <li><a href="{{ route('register') }}" class="hover:text-blue-200 transition">Daftar</a></li>
                    <li><a href="/login" class="hover:text-blue-200 transition">Masuk</a></li>
                </ul>
            </div>
            <!-- Kontak & Sosial Media -->
            <div class="flex flex-col items-center sm:items-start">
                <h4 class="font-semibold mb-4">Kontak Kami</h4>
                <p class="text-sm">Email : support@sibermuda.id</p>
                @php
                    $adminPhone = \App\Models\User::where('role', 'admin')->first()?->phone_number ?? 'Belum ada nomor';
                @endphp
                <p class="text-sm">Telp : +{{ $adminPhone }}</p>
            </div>
        </div>

        <!-- Footer Bawah -->
        <div class="mt-8 border-t border-white pt-4 text-center text-sm">
            <p>Copyright &copy; 2025 <span class="text-white">Sibermuda.Idn</span> All rights reserved. Powered by PPLG SMKN 1 Ciomas</p>
        </div>
    </div>
</footer>
