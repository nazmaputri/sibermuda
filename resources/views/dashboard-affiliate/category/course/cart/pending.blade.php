@extends('layouts.dashboard-affiliate')
@section('title', 'Keranjang')
@section('content')
<div class="bg-white border border-gray-200 p-8 rounded-lg shadow-md">

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

    <!-- Kursus dengan status pending -->
    @if ($pendingCarts->isNotEmpty())
        <div class="mt-3 bg-white border border-gray-200 p-4 rounded-lg shadow {{ empty($availableCarts) ? 'w-full' : 'lg:w-2/3' }}">
            <div class="flex items-center p-3 mb-4 text-sm text-yellow-600 rounded-lg bg-yellow-100" role="alert">
                <svg class="shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                </svg>
                <span class="sr-only">Info</span>
                <div>
                    <span class="font-medium md:text-ms text-sm">Menunggu Konfirmasi Pembayaran Oleh Admin</span>
                </div>
            </div>
            @foreach ($pendingCarts as $cart)
                <div class="flex items-center space-x-4 mb-3 pb-2 @if(!$loop->last || $loop->first && !$loop->last) border-b border-gray-200 @endif">
                    <img src="{{ asset('storage/' . $cart->course->image_path) }}" alt="Course Image" class="w-24 h-24 object-cover rounded-md" />
                    <div class="flex-1">
                        <h2 class="text-md font-medium text-gray-700 capitalize">{{ $cart->course->title }}</h2>

                        @foreach($purchasesWithPrices as $purchase)
                            @if($purchase->course_id == $cart->course_id)
                                <p class="text-sm font-medium text-red-500">
                                    Rp. {{ number_format($purchase->harga_course, 0, ',', '.') }}
                                </p>
                            @endif
                        @endforeach

                        <p class="text-xs text-gray-600">status : <span class="text-yellow-500">pending</span></p>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="mt-3 text-center text-sm text-gray-500">tidak ada data pembayaran yang sedang menunggu konfirmasi</p>
    @endif

</div>
@endsection
