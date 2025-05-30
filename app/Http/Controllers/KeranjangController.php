<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keranjang;
use App\Models\Discount;
use App\Models\Course;
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

        $purchasesWithPrices = $purchases->map(function ($purchase) {
            // Ambil harga kursus dari tabel courses
            $course = Course::find($purchase->course_id);
            $purchase->course_price = $course ? $course->price : 0;
            $purchase->harga_course = $purchase->harga_course; // Harga yang dibayar peserta
            return $purchase;
        });
            
        // Filter keranjang yang tidak dalam transaksi pending
        $availableCarts = $carts->filter(function ($cart) use ($pendingTransactions) {
            return !in_array($cart->course_id, $pendingTransactions);
        });

        $pendingCarts = $carts->filter(function ($cart) use ($pendingTransactions) {
            return in_array($cart->course_id, $pendingTransactions);
        });
        
        $pendingCount = $pendingCarts->count();        
        $availableCount = $availableCarts->count();

        // Hitung total harga dari kursus yang tidak pending
        $totalPrice = $availableCarts->sum(fn($cart) => $cart->course->price);

        $totalPrice = 0;
        $totalPriceAfterDiscount = 0;
        $couponCode = $request->query('coupon');
        $couponDiscount = null;

        // Ambil diskon global untuk ditampilkan di banner
        $globalDiscount = Discount::where('start_date', '<=', now())
        ->where('end_date', '>=', now())
        ->where('apply_to_all', true)
        ->first();

        // Ambil diskon global yang valid jika user masukkan kode kupon
        $couponDiscount = null;
        if ($couponCode) {
        $couponDiscount = Discount::where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->where('apply_to_all', true)
            ->where('coupon_code', $couponCode)
            ->first();
        }

        // Ambil semua diskon spesifik
        $courseSpecificDiscounts = Discount::where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->where('apply_to_all', false)
            ->get();

        foreach ($availableCarts as $cart) {
            $course = $cart->course;
            $price = $course->price;
            $courseDiscount = null;

            foreach ($courseSpecificDiscounts as $discount) {
                if ($discount->courses->contains($course->id)) {
                    $courseDiscount = $discount;
                    break;
                }
            }

            // Harga asli
            $totalPrice += $price;

            if ($courseDiscount) {
                $discounted = $price * ($courseDiscount->discount_percentage / 100);
                $finalPrice = $price - $discounted;
                $cart->final_price = $finalPrice;
                $cart->applied_discount = $courseDiscount;
            } elseif ($couponDiscount) {
                $discounted = $price * ($couponDiscount->discount_percentage / 100);
                $finalPrice = $price - $discounted;
                $cart->final_price = $finalPrice;
                $cart->applied_discount = $couponDiscount;
            } else {
                $finalPrice = $price;
                $cart->final_price = $finalPrice;
                $cart->applied_discount = null;
            }

            // Harga setelah diskon
            $totalPriceAfterDiscount += $finalPrice;
        }

        $subtotal = $totalPrice;
        
        // Ambil nomor telepon admin
        $nomorAdmin = DB::table('users')
        ->where('role', 'admin')
        ->value('phone_number');
    
        return view('dashboard-peserta.keranjang', compact(
            'availableCarts','carts', 'couponDiscount', 'totalPrice', 'totalPriceAfterDiscount', 'couponCode', 'nomorAdmin',  'pendingTransactions', 'subtotal', 'courseSpecificDiscounts', 'availableCount', 'pendingCount', 'globalDiscount', 'purchasesWithPrices'
           
        ));
    }

    public function keranjangpending(Request $request)
    {
        // Ambil data pembelian dengan status pending
        $purchases = Purchase::where('user_id', auth()->id())
            ->whereHas('payment', function ($query) {
                $query->where('transaction_status', 'pending');
            })
            ->with('payment') // Pastikan relasi payment sudah didefinisikan di model
            ->get();
    
        // Ambil harga kursus dari tabel courses dan harga yang dibayar dari tabel purchases
        $purchasesWithPrices = $purchases->map(function ($purchase) {
            // Cek apakah harga_course ada sebelum mengaksesnya
            $purchase->harga_course = $purchase->harga_course ?? 0; // Default ke 0 jika tidak ada
    
            // Ambil harga kursus dari tabel courses
            $course = Course::find($purchase->course_id);
            if ($course) {
                $purchase->course_price = $course->price;
            } else {
                $purchase->course_price = 0; // Default ke 0 jika course tidak ditemukan
            }
    
            return $purchase;
        });
    
        // Ambil data keranjang user
        $carts = Keranjang::where('user_id', Auth::id())
            ->with('course') // Pastikan relasi course sudah didefinisikan di model
            ->get();
    
        // Ambil course yang dalam status pending transaksi
        $pendingTransactions = $purchases->filter(function ($purchase) {
            return $purchase->payment && $purchase->payment->transaction_status === 'pending';
        })->pluck('course_id')->toArray();
    
        // Filter keranjang yang dalam transaksi pending
        $pendingCarts = $carts->filter(function ($cart) use ($pendingTransactions) {
            return in_array($cart->course_id, $pendingTransactions);
        });
    
        // Filter keranjang yang tidak dalam transaksi pending
        $availableCarts = $carts->filter(function ($cart) use ($pendingTransactions) {
            return !in_array($cart->course_id, $pendingTransactions);
        });
    
        $availableCount = $availableCarts->count();
        $pendingCount = $pendingCarts->count();
    
        return view('dashboard-peserta.keranjang-pending', compact('pendingCarts', 'pendingCount', 'availableCount', 'purchasesWithPrices'));
    }
    
    // Menambahkan kursus ke keranjang (hanya bisa ditambahkan sekali)
    public function addToCart(Request $request, $slug)
    {
        // Ambil course berdasarkan slug
        $course = Course::where('slug', $slug)->firstOrFail();
        $courseId = $course->id;

        // Cek apakah kursus sedang ada di tabel purchases dengan status pending
        $pendingPurchase = Purchase::where('user_id', Auth::id())
            ->where('course_id', $courseId)
            ->where('status', 'pending')
            ->first();

        if ($pendingPurchase) {
            return redirect()->route('keranjang-pending')->with('warning', 'Kursus ini sedang menunggu konfirmasi admin.');
        }

        // Cek apakah kursus sudah ada di keranjang user
        $existingCart = Keranjang::where('user_id', Auth::id())
            ->where('course_id', $courseId)
            ->first();

        if ($existingCart) {
            return redirect()->route('cart.index')->with('warning', 'Kursus ini sudah ada di keranjang Anda.');
        }

        // Tambahkan ke keranjang
        Keranjang::create([
            'user_id' => Auth::id(),
            'course_id' => $courseId,
        ]);

        return redirect()->route('cart.index')->with('success', 'Kursus berhasil ditambahkan ke keranjang!');
    }

   public function handlePurchase($slug)
    {
        // Cari course berdasarkan slug
        $course = Course::where('slug', $slug)->first();

        if (!$course) {
            return redirect()->back()->with('error', 'Kursus tidak ditemukan.');
        }

        $courseId = $course->id; // simpan id untuk kebutuhan lain

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


