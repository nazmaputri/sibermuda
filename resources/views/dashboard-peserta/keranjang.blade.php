@extends('layouts.dashboard-peserta')

@section('content')
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>

    <div class="bg-white p-8 rounded-lg shadow-md">
        <h2 class="text-xl text-gray-700 font-semibold mb-6 border-b-2 border-gray-300 pb-2 text-center">Keranjang Saya</h2>

        <!-- <div id="flash-container"></div> -->

        <!-- Pemberitahuan Diskon (Tetap Ada di Atas Keranjang) -->
        @if ($activeDiscount)
        <div class="bg-yellow-100 text-yellow-700 p-4 mb-4 rounded-lg">
            <h3 class="font-bold text-lg">🎉 Kode kupon: <span class="">{{ $activeDiscount->coupon_code }}</span></h3>
            <p class="text-sm">Diskon sebesar <strong>{{ $activeDiscount->discount_percentage }}%</strong> berlaku hingga <span id="discount-end">{{ $activeDiscount->end_date }} {{ $activeDiscount->end_time }}</span>.</p>
            <div class="text-red-600 font-semibold text-sm mt-2" id="countdown-timer"></div>
        </div>
        @endif
        <!-- Tambahkan Countdown Timer -->
        <script>
            function startCountdown(endDate) {
                let countDownDate = new Date(endDate).getTime();

                let x = setInterval(function() {
                    let now = new Date().getTime();
                    let distance = countDownDate - now;

                    if (distance < 0) {
                        clearInterval(x);
                        document.getElementById("countdown-timer").innerHTML = "⏳ Diskon telah berakhir.";
                        return;
                    }

                    let days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    let hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    let seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    document.getElementById("countdown-timer").innerHTML = ⏳ Berakhir dalam: ${days} hari, ${hours} jam, ${minutes} menit, ${seconds} detik;
                }, 1000);
            }

            let discountEnd = document.getElementById("discount-end")?.textContent;
            if (discountEnd) startCountdown(discountEnd);
        </script>
        @if ($carts->isEmpty())
            <!-- Jika keranjang kosong -->
            <div class="text-center py-3">
                <p class="text-gray-500">Keranjang Kamu masih kosong. Yuk, pilih kursus favoritmu!</p>
                <a href="{{ route('kategori-peserta') }}"
                    class="mt-4 font-semibold inline-block bg-sky-400 text-white py-1.5 px-5 rounded-lg hover:bg-sky-300 transition shadow-lg">
                    Jelajahi Kursus
                </a>
            </div>
        @else
        <div class="flex flex-col lg:flex-row gap-6">
        <!-- kontainer untuk kursus yang ada di keranjang -->
        <div class="flex flex-col bg-white p-3 rounded-lg shadow lg:w-2/3 md:min-h-40">
        @foreach ($carts as $cart)
            <div class="flex items-center space-x-4 mb-3 pb-2 @if(!$loop->last || $loop->first && !$loop->last) border-b border-gray-200 @endif">
                <img 
                    src="{{ asset('storage/' . $cart->course->image_path) }}" 
                    alt="Course Image" 
                    class="w-24 h-24 object-cover rounded-md"
                />
                
                <!-- Informasi Produk -->
                <div class="flex-1 space-y-1">
                    <h2 class="text-lg font-semibold text-gray-700">{{ $cart->course->title }}</h2>
                    <p class="text-sm font-semibold text-red-400">Rp. <span class="">{{ number_format($cart->course->price, 0, ',', '.') }}</span></p>
                    <form action="{{ route('cart.remove', $cart->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="flex text-center items-center justify-center rounded-md text-red text-xs" type="submit">
                            <span class="text-sm text-red-400">Hapus</span>
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
         </div>

        <!-- kontainer untuk apply kupon, total harga dan beli -->
        <div class="bg-white p-3 rounded-lg shadow flex-1 max-h-40">
            <!-- Input Kupon -->
            <div class="flex space-x-2 items-center mt-1">
                <input type="text" id="coupon-code" class="border border-gray-300 text-gray-700 rounded-lg p-1.5 w-full sm:w-3/4 md:w-2/3 focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500" placeholder="Masukkan Kode Kupon" value="{{ $couponCode ?? '' }}">
                <button id="apply-coupon" class="bg-sky-400 flex text-white p-1.5 px-3 font-semibold rounded-lg hover:bg-sky-300">Gunakan</button>
            </div>

            <!-- Total Harga -->
            <div class="mt-3">
                <div class="flex justify-between items-center flex-wrap gap-2">
                    <h3 class="font-semibold text-gray-700">
                        Total:
                    </h3>
                    <div class="flex items-center space-x-2">
                        @if ($couponCode)
                            <span class="text-gray-500 line-through">
                                Rp {{ number_format($totalPrice, 0, ',', '.') }}
                            </span>
                        @endif
                        <span id="total-price" class="text-red-500 font-semibold">
                            Rp {{ number_format($totalPriceAfterDiscount, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
                <button 
                    class="bg-sky-400 text-white font-semibold py-1.5 px-3 rounded-lg hover:bg-sky-300 w-full mt-3" 
                    id="pay-now" 
                    data-total-price="{{ $totalPriceAfterDiscount }}">
                    Beli
                </button>
            </div>

         </div>
        </div>
        @endif
    </div>

<!-- Modal Overlay -->
<div id="registration-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-50">
    <!-- Modal Box -->
    <div class="bg-white w-full max-w-md mx-auto rounded-lg shadow-lg p-6 relative">
        <!-- Tombol Close -->
        <button id="close-modal" class="absolute top-2 right-2 text-gray-500 hover:text-red-500 text-xl font-bold">&times;</button>
        
        <h3 class="text-xl font-semibold mb-4 text-gray-700 text-center">Formulir Pendaftaran</h3>
        <form id="wa-form">
            <label class="block mb-3">
                <span class="text-gray-700">Nama Lengkap</span>
                <input id="nama" type="text" class="mt-1 block w-full border border-gray-300 rounded p-2 focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500" value="{{ Auth::user()->name }}" {{ Auth::user()->name ? 'readonly' : '' }} >
            </label>
            <label class="block mb-3">
                <span class="text-gray-700">Email</span>
                <input id="email" type="email"  class="mt-1 block w-full border border-gray-300 rounded p-2 focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500" value="{{ Auth::user()->email }}" {{ Auth::user()->email ? 'readonly' : '' }}>
            </label>
            <label class="block mb-4">
                <span class="text-gray-700">No Telepon</span>
                <input id="telepon" type="tel"  class="mt-1 block w-full border border-gray-300 rounded p-2 focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500" value="{{ Auth::user()->phone_number }}" {{ Auth::user()->phone_number ? 'readonly' : '' }}>
            </label>

            <!-- Tambahkan data kursus dan total harga sebagai <input hidden> jika ingin dikirim -->
            <input type="hidden" id="nama-kursus" value="Kursus Pemrograman Laravel">
            <input type="hidden" id="total-harga" value="Rp 150.000">

            <p class="pb-2 text-gray-700">Kursus Yang Dibeli</p>
            <p class="pb-2 text-gray-700">Total harga</p>
            <p class="pb-2 text-gray-700">No Rekening Admin : 0895365544316</p>

            <button type="submit" class="bg-sky-500 text-white px-4 py-2 rounded hover:bg-sky-400 w-full">
                Kirim Bukti Pembayaran
            </button>
        </form>
    </div>
</div>

<script>
    const payNowBtn = document.getElementById('pay-now');
    const modal = document.getElementById('registration-modal');
    const closeModalBtn = document.getElementById('close-modal');

    payNowBtn.addEventListener('click', function () {
        modal.classList.remove('hidden');
        modal.classList.add('flex'); // agar bisa tampil sebagai flex (centered)
    });

    closeModalBtn.addEventListener('click', function () {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    });

    // Opsional: Tutup modal jika klik di luar box
    window.addEventListener('click', function (e) {
        if (e.target === modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    });

     // WA Form Submit Handler
     document.getElementById('wa-form').addEventListener('submit', function (e) {
        e.preventDefault();

        const nama = document.getElementById('nama').value;
        const email = document.getElementById('email').value;
        const telepon = document.getElementById('telepon').value;

        const pesan = `Halo Admin, saya ingin mengkonfirmasi pembayaran:\n\nNama: ${nama}\nEmail: ${email}\nNo Telepon: ${telepon}\n\nSaya telah melakukan pembayaran untuk kursus. Terima kasih.`;

        const nomor = "62895365544316"; // Gunakan format internasional (62 untuk Indonesia)
        const url = `https://wa.me/${nomor}?text=${encodeURIComponent(pesan)}`;

        window.open(url, '_blank'); // Buka link di tab baru
    });
        
    document.getElementById('apply-coupon').addEventListener('click', function() {
        let couponCode = document.getElementById('coupon-code').value;
        if (couponCode) {
            window.location.href = "{{ route('cart.index') }}?coupon=" + couponCode;
        } else {
            alert("Masukkan kode kupon terlebih dahulu!");
        }
    });
</script>
@endsection