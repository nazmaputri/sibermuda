<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Payment;
use App\Models\Keranjang;
use App\Models\Purchase;
use App\Models\Discount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Chat;
use App\Models\User;
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
            $hargaPerItem = [];
    
            foreach ($keranjangItems as $item) {
                $originalPrice = $item->course->price;
                $price = $originalPrice;
    
                if ($discount && ($discount->apply_to_all || $discount->courses->contains($item->course->id))) {
                    $price = $originalPrice - ($originalPrice * $discount->discount_percentage / 100);
                }
    
                $totalAmount += $price;
                $hargaPerItem[$item->id] = $price; // simpan harga untuk tiap item berdasarkan ID keranjang
            }
    
            $orderId = 'ORDER-' . time();
    
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
                    'status'         => 'pending',
                    'harga_course'   => $hargaPerItem[$item->id],
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
                'error' => $e->getMessage(),
            ]);
        }
    }

    // public function updateStatus($id)
    // {
    //     $payment = Payment::findOrFail($id);
    
    //     // Update status pembayaran
    //     $payment->transaction_status = 'success';
    //     $payment->save();
    
    //     // Update semua pembelian dengan transaction_id yang sama
    //     Purchase::where('transaction_id', $payment->transaction_id)
    //         ->update(['status' => 'success']);
    
    //     return redirect()->back()->with('success', 'Status pembayaran dan semua pembelian terkait berhasil diubah.');
    // }   

    public function updateStatus(Request $request, $id)
    {
        // Ambil data pembayaran berdasarkan ID
        $payment = Payment::findOrFail($id);
        
        // Update status pembayaran
        $payment->transaction_status = 'success';
        $payment->save();
        
        // Update semua pembelian yang memiliki transaction_id yang sama
        Purchase::where('transaction_id', $payment->transaction_id)
            ->update(['status' => 'success' ]);
    
        // Cek jika statusnya sukses
        if (in_array($payment->transaction_status, ['success'])) {
    
            // Ambil data student dan course
            $student = User::find($payment->user_id);
            $course = Course::find($payment->course_id);
    
            // Cek apakah fitur chat aktif di kursus tersebut
            if ($course && $course->chat) {  // Pastikan fitur chat aktif (true)
                $mentorId = $course->mentor_id;
    
                // Buat chat jika belum ada
                $chat = Chat::firstOrCreate([
                    'mentor_id' => $mentorId,
                    'student_id' => $student->id,
                    'course_id' => $course->id,
                ]);
    
                // Cek apakah sudah pernah kirim pesan otomatis
                $alreadySent = $chat->messages()
                    ->where('sender_id', $mentorId)
                    ->where('message', 'Pesan otomatis dari mentor: Terima kasih telah membeli kursus ini. Jika ada pertanyaan, silakan chat ya!')
                    ->exists();
    
                if (!$alreadySent) {
                    // Kirim pesan otomatis dari mentor
                    $chat->messages()->create([
                        'sender_id' => $mentorId,
                        'message' => 'Pesan otomatis dari mentor: Terima kasih telah membeli kursus ini. Jika ada pertanyaan, silakan chat ya!',
                        'courses_id' => $course->id,
                    ]);
                }
            }
        }
        return redirect()->back()->with('success', 'Status pembayaran dan semua pembelian terkait berhasil diubah.');
    }
     
        
    // public function updatePaymentStatus(Request $request)
    // {
    //     $orderId = $request->input('order_id');
    //     $transactionStatus = $request->input('transaction_status');
    
    //     // Cari transaksi berdasarkan order_id
    //     $payment = Payment::where('transaction_id', $orderId)->first();
    
    //     if (!$payment) {
    //         return response()->json(['message' => 'Transaksi tidak ditemukan'], 404);
    //     }
    
    //     // Perbarui status pembayaran di tabel payments
    //     $payment->transaction_status = $transactionStatus;
    //     $payment->save();
    
    //     // Jika status transaksi sukses, perbarui status pembelian dan hapus keranjang
    //     if ($transactionStatus === 'success') {
    //         Purchase::where('transaction_id', $orderId)
    //             ->update(['status' => 'success']);
    
    //         Keranjang::where('user_id', $payment->user_id)->delete();
    //     }
    
    //     // Tidak perlu redirect di sini, karena ini dipanggil dari backend (webhook/callback)
    //     return response()->json([
    //         'message' => 'Status pembayaran berhasil diperbarui.',
    //     ]);
    // }
    
}

