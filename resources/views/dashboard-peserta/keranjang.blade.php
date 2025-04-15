@extends('layouts.dashboard-peserta')
@section('content')
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
                    <img src="{{ asset('storage/' . $cart->course->image_path) }}" alt="Course Image" class="w-24 h-24 object-cover rounded-md"/>
        
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
    <div class="bg-white w-full max-w-md mx-auto rounded-2xl shadow-2xl p-8 relative animate__animated animate__fadeInDown">
        <!-- Tombol Close -->
        <button id="close-modal" class="absolute top-4 right-4 text-red-500 hover:text-red-600 text-2xl font-bold">
            &times;
        </button>

        <h3 class="text-2xl font-semibold mb-6 text-gray-800 text-center">Formulir Pendaftaran</h3>

        <form id="wa-form">
            <div class="space-y-4">
                <label class="block">
                    <span class="text-gray-700 font-medium">Nama Lengkap</span>
                    <input id="nama" type="text" class="mt-1 block w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-sky-500"
                        value="{{ Auth::user()->name }}" readonly>
                </label>
                <label class="block">
                    <span class="text-gray-700 font-medium">Email</span>
                    <input id="email" type="email" class="mt-1 block w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-sky-500"
                        value="{{ Auth::user()->email }}" readonly>
                </label>
                <label class="block">
                    <span class="text-gray-700 font-medium">No Telepon</span>
                    <input id="telepon" type="telp" class="mt-1 block w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-sky-500"
                        value="{{ Auth::user()->phone_number }}" readonly>
                </label>
            </div>

            <!-- Kursus dari keranjang -->
            @php
                $courseTitles = $carts->pluck('course.title')->toArray();
                $courseList = implode(', ', $courseTitles);
            @endphp

            <input type="hidden" id="nama-kursus" value="{{ $courseList }}">
            <input type="hidden" id="total-harga" value="Rp {{ number_format($totalPriceAfterDiscount, 0, ',', '.') }}">

            <div class="mt-6 text-gray-700 space-y-1 text-sm">
                <p><strong>Kursus:</strong> {{ $courseList }}</p>
                <p><strong>Total Harga:</strong> Rp {{ number_format($totalPriceAfterDiscount, 0, ',', '.') }}</p>
                <p><strong>No Rekening Admin:</strong> 0895365544316 (Dana/Bank)</p>
            </div>

            <!-- Tombol WhatsApp -->
            <a id="kirim-wa"
               href="#"
               target="_blank"
               class="mt-6 block text-center bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded-lg w-full transition-all duration-200">
                Kirim Bukti Pembayaran via WhatsApp
            </a>
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

    document.getElementById('kirim-wa').addEventListener('click', function (e) {
        e.preventDefault();

        const nama = document.getElementById('nama')?.value || 'Tidak Ada';
        const email = document.getElementById('email')?.value || 'Tidak Ada';
        const telepon = document.getElementById('telepon')?.value || 'Tidak Ada';
        const kursus = document.getElementById('nama-kursus')?.value || 'Tidak Ada';
        const harga = document.getElementById('total-harga')?.value || '{{ $totalPriceAfterDiscount }}';

        const nomorAdmin = '62895365544316';
        const pesan = `Halo Admin, saya ingin mengkonfirmasi pembayaran untuk:\n\n` +
            `👤 Nama: ${nama}\n📧 Email: ${email}\n📱 Telepon: ${telepon}\n\n` +
            `💻 Kursus: ${kursus}\n💰 Total: Rp ${harga}\n\n` +
            `Saya sudah melakukan pembayaran, berikut bukti transfernya.`;

        const whatsappUrl = `https://wa.me/${nomorAdmin}?text=${encodeURIComponent(pesan)}`;

        fetch(`{{ route('create-payment') }}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: JSON.stringify({
                whatsapp_url: whatsappUrl,
                coupon_code: '{{ $couponCode ?? '' }}',
            }),
        })
        .then(response => {
            if (!response.ok) throw new Error('Gagal menyimpan data.');
            return response.json();
        })
        .then(data => {
            if (data.success) {
                window.open(whatsappUrl, '_blank');
            } else {
                alert(data.message || 'Gagal menyimpan data ke server.');
            }
        })
        
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat mengirim data.');
        });
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