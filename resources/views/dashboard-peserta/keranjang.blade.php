@extends('layouts.dashboard-peserta')
@section('title', 'Keranjang')
@section('content')
    <div class="bg-white border border-gray-200 p-8 rounded-lg shadow-md">

        <!-- Pemberitahuan Diskon (Tetap Ada di Atas Keranjang) -->
        @if($globalDiscount)
        <div class="bg-yellow-100 text-yellow-700 p-4 mb-4 rounded-lg">
            <h3 class="font-bold text-lg">
            🎉 Kode Kupon Aktif: <span>{{ $globalDiscount->coupon_code }}</span>
            </h3>
            <p class="text-sm">
            Diskon <strong>{{ $globalDiscount->discount_percentage }}%</strong>  
            hingga  
            <span id="discount-end">
                {{ \Carbon\Carbon::parse($globalDiscount->end_date)->translatedFormat('d F Y') }}
                {{ $globalDiscount->end_time }}
            </span>.
            </p>
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

    <!-- MENU BREADCRUMB -->
    <nav class="flex mb-2" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
            <li class="inline-flex items-center">
                <a href="{{ route('cart.index') }}"
                class="inline-flex items-center text-sm hover:text-midnight 
                    {{ request()->routeIs('cart.index') ? 'text-gray-700 font-medium' : 'text-gray-600' }}">
                    Keranjang
                    <span class="text-green-300 bg-green-100 ml-1 px-1 py-0.5 rounded-md"> {{ $availableCount ?? 0 }}</span>
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <a href="{{ route('keranjang-pending') }}"
                    class="ms-1 text-sm hover:text-midnight md:ms-2 
                        {{ request()->routeIs('keranjang-pending') ? 'text-gray-700 font-medium' : 'text-gray-600' }}">
                        Pending
                    </a>
                    <span class="text-orange-300 bg-orange-100 ml-1 px-1 py-0.5 text-sm rounded-md"> {{ $pendingCount ?? 0 }}</span>
                </div>
            </li>
        </ol>
    </nav>

    @php
    $pendingCarts = [];
    $availableCarts = [];
    $subtotal = 0;

    foreach ($carts as $cart) {
        if (in_array($cart->course_id, $pendingTransactions)) {
            $pendingCarts[] = $cart;
        } else {
            $availableCarts[] = $cart;
            $subtotal += $cart->course->price;
        }
    }
@endphp

@if (count($availableCarts) > 0)
    <!-- TAMPILAN KURSUS YANG BISA DIBELI -->
    <div class="flex flex-col lg:flex-row gap-6">
        <div class="flex flex-col bg-white border border-gray-200 p-3 rounded-lg shadow lg:w-2/3">
            @foreach ($availableCarts as $cart)
                <div class="flex items-center space-x-4 mb-3 pb-2 @if(!$loop->last || $loop->first && !$loop->last) border-b border-gray-200 @endif">
                    <img src="{{ asset('storage/' . $cart->course->image_path) }}" alt="Course Image" class="w-24 h-24 object-cover rounded-md"/>
                    <div class="flex-1 space-y-1">
                        <h2 class="text-md font-medium text-gray-700 capitalize">{{ $cart->course->title }}</h2>
                        @if($cart->final_price < $cart->course->price)
                            <p class="text-sm font-medium text-red-500">
                                Rp. {{ number_format($cart->final_price, 0, ',', '.') }}
                                <span class="line-through text-gray-400 text-xs ml-1">
                                    Rp. {{ number_format($cart->course->price, 0, ',', '.') }}
                                </span>

                                @if($cart->applied_discount)
                                    <span class="ml-2 text-[10px] text-red-500 font-semibold bg-red-100 px-2 py-0.5 rounded-sm">
                                        -{{ $cart->applied_discount->discount_percentage }}%
                                    </span>
                                @endif
                            </p>
                        @else
                            <p class="text-sm font-medium text-gray-700">
                                Rp. {{ number_format($cart->course->price, 0, ',', '.') }}
                            </p>
                        @endif
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

        <!-- Sidebar total & checkout -->
        <div class="bg-white border border-gray-200 p-3 rounded-lg shadow flex-1 max-h-40">
        <!-- Input Kupon -->
        <div class="flex space-x-2 items-center mt-1 pb-2">
            <input type="text" id="coupon-code" class="w-full basis-3/4 border border-gray-300 text-sm text-gray-700 rounded-lg p-1.5 focus:outline-none focus:ring-1 focus:ring-green-500" placeholder="Masukkan Kode Kupon">
            <button id="apply-coupon" class="basis-1/4 bg-green-400 flex text-sm text-white p-1.5 px-3 font-semibold rounded-lg hover:bg-green-300">Gunakan</button>
        </div>

            <!-- Total Harga -->
            <div class="md:pt-2 pt-1">
                <div class="flex justify-between items-center flex-wrap gap-2">
                    <h3 class="font-semibold text-gray-700 text-sm">
                        Total:
                    </h3>
                    <div class="flex items-center space-x-2">
                        @if ($totalPriceAfterDiscount < $subtotal)
                            <!-- <span class="ml-1 text-red-600 text-[10px] font-semibold bg-red-100 px-1 py-0.5 rounded-sm">
                                - Rp.{{ number_format($subtotal - $totalPriceAfterDiscount, 0, ',', '.') }}
                            </span> -->
                            <span class="text-gray-500 line-through text-[12px] font-medium">
                                Rp {{ number_format($subtotal, 0, ',', '.') }}
                            </span>
                        @endif
                        <span id="total-price" class="text-red-500 font-semibold text-sm">
                            Rp {{ number_format($totalPriceAfterDiscount, 0, ',', '.') }}
                        </span>
                    </div>
                </div>

                <button 
                    class="bg-green-400 text-white font-semibold py-1.5 px-3 rounded-lg hover:bg-green-300 w-full mt-3 text-sm" 
                    id="pay-now" 
                    data-total-price="{{ $subtotal }}">
                    Beli Sekarang
                </button>
            </div>
        </div>
    </div>
@else
    <!-- TAMPILAN SAAT KERANJANG SEPENUHNYA KOSONG -->
    <div class="text-center py-3">
        <p class="text-gray-500 text-sm">Keranjang Kamu masih kosong. Yuk, pilih kursus favoritmu!</p>
        <a href="{{ route('kategori-peserta') }}"
            class="mt-4 font-semibold inline-block bg-sky-400 text-white py-1.5 px-5 rounded-md text-sm hover:bg-sky-300 transition shadow-md">
            Jelajahi Kursus
        </a>
    </div>
@endif

</div>

<!-- Modal Overlay -->
<div id="registration-modal" class="fixed px-4 inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-50">
    <!-- Modal Box -->
    <div id="modal-box" class="bg-white w-full max-w-sm md:max-w-md mx-auto rounded-2xl shadow-2xl px-6 py-6 relative transform scale-90 opacity-0 transition-all duration-300 ease-out">
        <!-- Tombol Close -->
        <button id="close-modal" class="absolute top-4 right-4 text-gray-500 hover:text-gray-600 text-2xl font-medium">
            &times;
        </button>

        <!-- Judul -->
        <h3 class="text-xl font-bold text-center text-gray-700 mb-2">Formulir Pembelian</h3>
        <div class="w-16 h-1 bg-gray-700 mx-auto mb-6 rounded"></div>

        <!-- Formulir -->
        <form id="wa-form" class="text-sm text-gray-700 space-y-3 max-h-[70vh] overflow-y-auto">
            <div class="">
                <p class="font-semibold">Nama Lengkap:</p>
                <p class="text-gray-700 border-b border-gray-200">{{ Auth::user()->name }}</p>
            </div>

            <div class="">
                <p class="font-semibold">Email:</p>
                <p class="text-gray-700 border-b border-gray-200">{{ Auth::user()->email }}</p>
            </div>
           
            <div>
                <p class="font-semibold">No Telepon:</p>
                <p class="text-gray-700 border-b border-gray-200">{{ Auth::user()->phone_number }}</p>
            </div>

            @php
                $availableCartsCollection = collect($availableCarts);

                $courseTitles = $availableCartsCollection->pluck('course.title')->toArray();
                $courseList = implode(', ', $courseTitles);
            @endphp

            <input type="hidden" id="name" value="{{ Auth::user()->name }}">
            <input type="hidden" id="email" value="{{ Auth::user()->email }}">
            <input type="hidden" id="no_telp" value="{{ Auth::user()->phone_number }}">
            <input type="hidden" id="nama-kursus" value="{{ $courseList }}">
            <input type="hidden" id="total-harga" value="Rp {{ number_format($totalPriceAfterDiscount, 0, ',', '.') }}">

            <div>
                <p class="font-semibold">Kursus:</p>
                <ul class="list-disc list-inside text-gray-700 border-b border-gray-200 py-1">
                    @foreach ($courseTitles as $title)
                        <li>{{ $title }}</li>
                    @endforeach
                </ul>
            </div>
           
            <div>
                <p class="font-semibold">Total Harga:</p>
                <p class="text-red-400 font-semibold border-b border-gray-200">Rp {{ number_format($totalPriceAfterDiscount, 0, ',', '.') }}</p>
            </div>
            
            <div>
                <p class="font-semibold">No Rek. Admin:</p>
                <p class="text-gray-700 mb-2 border-b border-gray-200">Seabank : 901328065980 A.N (Rama Ahmad Ramdani) </p>
            </div>
            
            <p class="text-sm text-gray-600">*Refresh halaman ini jika kamu sudah kirim bukti pembayaran</p>

            <!-- Tombol WhatsApp -->
            <div class="mt-4">
            <a id="kirim-wa"
               href="#"
               target="_blank"
               class="block text-center bg-green-500 hover:bg-green-400 text-white font-medium py-2 px-1 rounded-lg w-full transition-all duration-200">
                Kirim Bukti Pembayaran via WhatsApp
            </a>
            </div>
        </form>
    </div>
</div>

<script>
    const payNowBtn = document.getElementById('pay-now');
    const modal = document.getElementById('registration-modal');
    const modalBox = document.getElementById('modal-box'); // Ambil box dalam modal
    const closeModalBtn = document.getElementById('close-modal');

    // Buka Modal
    payNowBtn.addEventListener('click', function () {
        modal.classList.remove('hidden');
        modal.classList.add('flex');

        // Animasi buka
        setTimeout(() => {
            modalBox.classList.remove('scale-90', 'opacity-0');
            modalBox.classList.add('scale-100', 'opacity-100');
        }, 10); 
    });

    // Tutup Modal
    function closeModal() {
        // Animasi tutup
        modalBox.classList.remove('scale-100', 'opacity-100');
        modalBox.classList.add('scale-90', 'opacity-0');

        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }, 300); // Sesuai durasi animasi 300ms
    }

    closeModalBtn.addEventListener('click', closeModal);

    // Tutup kalau klik di luar box
    window.addEventListener('click', function (e) {
        if (e.target === modal) {
            closeModal();
        }
    });

    document.getElementById('kirim-wa').addEventListener('click', function (e) {
        e.preventDefault();

        const name = document.getElementById('name')?.value || 'Tidak Ada';
        const email = document.getElementById('email')?.value || 'Tidak Ada';
        const telepon = document.getElementById('no_telp')?.value || 'Tidak Ada';
        const kursus = document.getElementById('nama-kursus')?.value || 'Tidak Ada';
        const harga = document.getElementById('total-harga')?.value || '{{ $totalPriceAfterDiscount }}';

        const nomorAdmin = @json($nomorAdmin); 
        const pesan = `Halo Admin, saya ingin mengkonfirmasi pembayaran untuk:\n\n` +
            `👤 Nama: ${name}\n📧 Email: ${email}\n📱 Telepon: ${telepon}\n\n` +
            `💻 Kursus: ${kursus}\n💰 Total: ${harga}\n\n` +
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
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: data.message || 'Gagal menyimpan data ke server.',
                });
            }
        })
        
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Kesalahan',
                text: 'Terjadi kesalahan saat mengirim data.',
            });
        });
    });
     
    document.getElementById('apply-coupon').addEventListener('click', function() {
        let couponCode = document.getElementById('coupon-code').value;
        if (couponCode) {
            window.location.href = "{{ route('cart.index') }}?coupon=" + couponCode;
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'Oops!',
                text: 'Masukkan kode kupon terlebih dahulu!',
            });
        }
    });
</script>
@endsection