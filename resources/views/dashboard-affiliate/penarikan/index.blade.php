@extends('layouts.dashboard-affiliate')
@section('title', 'Penarikan Dana')
@section('content')
    {{-- Header Section --}}
    <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6 mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Penarikan Dana</h1>
        <p class="text-gray-600 mt-1">Kelola penarikan komisi affiliate Anda</p>
    </div>

    {{-- Saldo Section --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        {{-- Saldo Tersedia --}}
        <div class="bg-white rounded-lg shadow-md p-5 flex items-center border border-gray-200 border-l-4 border-l-green-500">
            <div class="p-2 bg-green-500 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="white" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a2.25 2.25 0 0 0-2.25-2.25H15a3 3 0 1 1-6 0H5.25A2.25 2.25 0 0 0 3 12m18 0v6a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 18v-6m18 0V9M3 12V9m18 0a2.25 2.25 0 0 0-2.25-2.25H5.25A2.25 2.25 0 0 0 3 9m18 0V6a2.25 2.25 0 0 0-2.25-2.25H5.25A2.25 2.25 0 0 0 3 6v3" />
                </svg>
            </div>
            <div class="ml-4">
                <h2 class="text-sm font-medium text-gray-500">Saldo Tersedia</h2>
                <p class="text-xl font-bold text-green-600">Rp {{ number_format($saldoTersedia ?? 0, 0, ',', '.') }}</p>
            </div>
        </div>

        {{-- Saldo Pending --}}
        <div class="bg-white rounded-lg shadow-md p-5 flex items-center border border-gray-200 border-l-4 border-l-yellow-500">
            <div class="p-2 bg-yellow-500 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="white" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </div>
            <div class="ml-4">
                <h2 class="text-sm font-medium text-gray-500">Saldo Pending</h2>
                <p class="text-xl font-bold text-yellow-600">Rp {{ number_format($saldoPending ?? 0, 0, ',', '.') }}</p>
            </div>
        </div>

        {{-- Minimal Penarikan --}}
        <div class="bg-white rounded-lg shadow-md p-5 flex items-center border border-gray-200 border-l-4 border-l-blue-500">
            <div class="p-2 bg-blue-500 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="white" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                </svg>
            </div>
            <div class="ml-4">
                <h2 class="text-sm font-medium text-gray-500">Minimal Penarikan</h2>
                <p class="text-xl font-bold text-blue-600">Rp {{ number_format($minimalPenarikan ?? 0, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>

    {{-- Form Penarikan --}}
    <div class="bg-white shadow-md border border-gray-200 rounded-lg p-6 mb-6">
        <div class="flex flex-col items-center mb-4">
            <h2 class="text-lg font-semibold inline-block pb-1 text-gray-700">Request Penarikan Dana</h2>
            <div class="border-b-2 w-full mt-1"></div>
        </div>

        <form action="#" method="POST" class="max-w-2xl mx-auto">
            @csrf

            {{-- Jumlah Penarikan --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah Penarikan *</label>
                <input type="number" name="jumlah"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="Masukkan jumlah"
                    min="{{ $minimalPenarikan }}"
                    max="{{ $saldoTersedia }}"
                    required>
                <p class="text-xs text-gray-500 mt-1">
                    Minimal penarikan: Rp {{ number_format($minimalPenarikan, 0, ',', '.') }}
                </p>
            </div>

            {{-- Metode Pembayaran --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Metode Pembayaran *</label>
                <select name="metode" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                    <option value="">Pilih Metode</option>
                    <option value="bank_bca">Bank Transfer - BCA</option>
                    <option value="bank_mandiri">Bank Transfer - Mandiri</option>
                    <option value="bank_bni">Bank Transfer - BNI</option>
                    <option value="bank_bri">Bank Transfer - BRI</option>
                    <option value="gopay">E-Wallet - GoPay</option>
                    <option value="ovo">E-Wallet - OVO</option>
                    <option value="dana">E-Wallet - DANA</option>
                </select>
            </div>

            {{-- Nomor Rekening/E-Wallet --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Rekening / E-Wallet *</label>
                <input type="text" name="nomor_rekening"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="Masukkan nomor rekening atau e-wallet"
                    required>
            </div>

            {{-- Nama Pemilik Rekening --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Pemilik Rekening *</label>
                <input type="text" name="nama_rekening"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="Masukkan nama sesuai rekening"
                    required>
            </div>

            {{-- Catatan --}}
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Catatan (Opsional)</label>
                <textarea name="catatan" rows="3"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="Tambahkan catatan jika diperlukan"></textarea>
            </div>

            {{-- Submit Button --}}
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-2 rounded-lg transition flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    Ajukan Penarikan
                </button>
            </div>
        </form>
    </div>

    {{-- Riwayat Penarikan --}}
    <div class="bg-white shadow-md border border-gray-200 rounded-lg p-6">
        <div class="flex flex-col items-center mb-4">
            <h2 class="text-lg font-semibold inline-block pb-1 text-gray-700">Riwayat Penarikan</h2>
            <div class="border-b-2 w-full mt-1"></div>
        </div>

        @if(isset($riwayatPenarikan) && count($riwayatPenarikan) > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Penarikan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Metode</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($riwayatPenarikan as $penarikan)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $penarikan->nomor_penarikan }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $penarikan->tanggal_request->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                Rp {{ number_format($penarikan->jumlah, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                {{ $penarikan->metode }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($penarikan->status == 'completed')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Selesai
                                    </span>
                                @elseif($penarikan->status == 'processing')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Diproses
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Ditolak
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $penarikan->keterangan }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <p class="mt-4 text-gray-500 font-medium">Belum ada riwayat penarikan</p>
            </div>
        @endif
    </div>
@endsection
