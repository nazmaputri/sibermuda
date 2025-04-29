<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keranjang;
use App\Models\Discount;
use App\Models\Payment;
use App\Models\Purchase;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KeranjangController extends Controller
{
    // Menampilkan halaman keranjang
    public function index(Request $request)
    {
        // Hapus keranjang jika kursusnya sudah dibeli
        Keranjang::where('user_id', Auth::id())->get()->each(function ($cart) {
            $purchased = Purchase::where('user_id', Auth::id())
                ->where('course_id', $cart->course_id)
                ->where('status', 'success')
                ->exists();
    
            if ($purchased) {
                $cart->delete();
            }
        });
    
        // Ambil data keranjang user yang belum dibeli
        $carts = Keranjang::where('user_id', Auth::id())
            ->with('course')
            ->get();

        $pendingTransactions = [];

        $purchases = Purchase::where('user_id', auth()->id())
            ->with('payment') // pastikan relasi payment sudah didefinisikan di model
            ->get();
            
        foreach ($purchases as $purchase) {
            if ($purchase->payment && $purchase->payment->transaction_status === 'pending') {
                $pendingTransactions[] = $purchase->course_id;
            }
        }
            
        // Filter keranjang yang tidak dalam transaksi pending
        $availableCarts = $carts->filter(function ($cart) use ($pendingTransactions) {
            return !in_array($cart->course_id, $pendingTransactions);
        });

        // Hitung total harga dari kursus yang tidak pending
        $totalPrice = $availableCarts->sum(fn($cart) => $cart->course->price);

        // Ambil diskon yang aktif
        $activeDiscount = Discount::where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->first();

        $totalPriceAfterDiscount = $totalPrice;
        $couponCode = $request->query('coupon');

        if ($couponCode) {
            $discount = Discount::where('coupon_code', $couponCode)
                ->where('start_date', '<=', now())
                ->where('end_date', '>=', now())
                ->first();

            if ($discount) {
                if ($discount->apply_to_all) {
                    $discountAmount = $totalPrice * ($discount->discount_percentage / 100);
                } else {
                    $discountAmount = 0;
                    foreach ($availableCarts as $cart) {
                        if ($discount->courses->contains($cart->course->id)) {
                            $discountAmount += $cart->course->price * ($discount->discount_percentage / 100);
                        }
                    }
                }

                $totalPriceAfterDiscount = $totalPrice - $discountAmount;
            }
        }

         // Ambil nomor telepon admin
        $nomorAdmin = DB::table('users')
        ->where('role', 'admin')
        ->value('phone_number');
    
        return view('dashboard-peserta.keranjang', compact(
            'carts', 'activeDiscount', 'totalPrice', 'totalPriceAfterDiscount', 'couponCode', 'nomorAdmin',  'pendingTransactions'
        ));
    }
    
    // Menambahkan kursus ke keranjang (hanya bisa ditambahkan sekali)
    public function addToCart(Request $request, $courseId)
    {
        // Cek apakah kursus sudah ada di keranjang user
        $existingCart = Keranjang::where('user_id', Auth::id())->where('course_id', $courseId)->first();

        if ($existingCart) {
            return redirect()->route('cart.index')->with('warning', 'Kursus ini sudah ada di keranjang Anda.');
        }

        // Jika belum ada, tambahkan ke keranjang
        Keranjang::create([
            'user_id' => Auth::id(),
            'course_id' => $courseId,
        ]);

        return redirect()->route('cart.index')->with('success', 'Kursus berhasil ditambahkan ke keranjang!');
    }

    public function handlePurchase($courseId)
    {
        if (!Auth::check()) {
            // Simpan ID kursus ke session agar bisa diproses setelah login
            Session::put('kursus_id_pending', $courseId);
            return redirect()->route('login')->with('message', 'Silakan login terlebih dahulu untuk membeli kursus.');
        }
    
        // Cek jika user yang login adalah role student
        if (Auth::user()->role !== 'student') {
            return redirect()->back()->with('warning', 'Hanya peserta yang dapat membeli kursus.');
        }
    
        // Cek apakah kursus sudah dibeli sebelumnya
        $hasPurchased = Purchase::where('user_id', Auth::id())
                                ->where('course_id', $courseId)
                                ->where('status', 'success')
                                ->exists();
    
        if ($hasPurchased) {
            return redirect()->back()->with('error', 'Kursus ini sudah Anda beli.');
        }
    
        // Tambahkan ke keranjang jika belum dibeli
        return $this->addToCart(new Request(), $courseId);
    }    

    // Menghapus kursus dari keranjang
    public function removeFromCart($cartId)
    {
        $cart = Keranjang::findOrFail($cartId);
        $cart->delete();

        return redirect()->route('cart.index')->with('success', 'Kursus berhasil dihapus dari keranjang.');
    }
}


