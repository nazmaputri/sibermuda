<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Payment;
use App\Models\Keranjang;
use App\Models\Purchase;
use App\Models\Discount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Snap;
use Log;
 
class PaymentController extends Controller
{
    
    public function createPayment(Request $request)
    {
        try {
            $user = Auth::guard('student')->user();
            if (!$user) {
                return response()->json(['success' => false, 'message' => 'User tidak ditemukan'], 401);
            }
        
            $keranjangItems = Keranjang::where('user_id', $user->id)->with('course')->get();
            if ($keranjangItems->isEmpty()) {
                return response()->json(['success' => false, 'message' => 'Keranjang kosong'], 400);
            }
        
            $couponCode = $request->input('coupon_code');
            $discount = null;
        
            if ($couponCode) {
                $discount = Discount::where('coupon_code', $couponCode)
                    ->where('start_date', '<=', now())
                    ->where('end_date', '>=', now())
                    ->first();
            }
        
            $totalAmount = 0;
            foreach ($keranjangItems as $item) {
                $originalPrice = $item->course->price;
                $price = $originalPrice;
        
                if ($discount && ($discount->apply_to_all || $discount->courses->contains($item->course->id))) {
                    $price = $originalPrice - ($originalPrice * $discount->discount_percentage / 100);
                }
        
                $totalAmount += $price;
            }
        
            $orderId = 'ORDER-' . time();
        
            // Pastikan hanya field yang valid yang dikirim ke Payment::create()
            $payment = Payment::create([
                'user_id'            => $user->id,
                'transaction_id'     => $orderId,
                'payment_type'       => 'whatsapp',
                'transaction_status' => 'pending',
                'amount'             => $totalAmount
            ]);
        
            foreach ($keranjangItems as $item) {
                Purchase::create([
                    'user_id'        => $user->id,
                    'course_id'      => $item->course_id,
                    'transaction_id' => $orderId,
                    'status'         => 'pending'
                ]);
            }
        
            return response()->json([
                'success'   => true,
                'message'   => 'Transaksi berhasil dicatat.',
                'order_id'  => $orderId
            ]);
        } catch (\Exception $e) {
            \Log::error('Gagal menyimpan payment: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan data.',
                'error' => $e->getMessage(), // tambahkan baris ini untuk debug cepat
            ]);
        }
    }
     
    public function updateStatus($id)
    {
        $payment = Payment::findOrFail($id);
    
        // Update status pembayaran
        $payment->transaction_status = 'success';
        $payment->save();
    
        // Update semua pembelian dengan transaction_id yang sama
        Purchase::where('transaction_id', $payment->transaction_id)
            ->update(['status' => 'success']);
    
        return redirect()->back()->with('success', 'Status pembayaran dan semua pembelian terkait berhasil diubah.');
    }    
        
    public function updatePaymentStatus(Request $request)
    {
        $orderId = $request->input('order_id');
        $transactionStatus = $request->input('transaction_status');
    
        // Cari transaksi berdasarkan order_id
        $payment = Payment::where('transaction_id', $orderId)->first();
    
        if (!$payment) {
            return response()->json(['message' => 'Transaksi tidak ditemukan'], 404);
        }
    
        // Perbarui status pembayaran di tabel payments
        $payment->transaction_status = $transactionStatus;
        $payment->save();
    
        // Jika status transaksi sukses, perbarui status pembelian dan hapus keranjang
        if ($transactionStatus === 'success') {
            Purchase::where('transaction_id', $orderId)
                ->update(['status' => 'success']);
    
            Keranjang::where('user_id', $payment->user_id)->delete();
        }
    
        // Tidak perlu redirect di sini, karena ini dipanggil dari backend (webhook/callback)
        return response()->json([
            'message' => 'Status pembayaran berhasil diperbarui.',
        ]);
    }
 
    
}

