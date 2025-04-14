<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    // Menampilkan form pendaftaran untuk student
    public function show()
    {
        return view('auth.register');
    }

    // Menampilkan form pendaftaran untuk mentor
    public function showmentor()
    {
        return view('auth.register-mentor');
    }

    public function register(Request $request)
    {
        // Validasi dasar untuk semua pengguna
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone_number' => 'required|string|max:15',
        ], [
            'name.required' => 'Nama lengkap harus diisi.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password harus diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'phone_number.required' => 'Nomor telepon harus diisi.',
        ]);
    
        // Validasi tambahan untuk mentor, KECUALI jika ditambahkan oleh admin
        if ($request->role === 'mentor' && !$request->has('added_by_admin')) {
            $request->validate([
                'experience' => 'required|string|max:255',
            ], [
                'experience.required' => 'Pengalaman harus diisi.',
                'experience.string' => 'Pengalaman harus berupa teks.',
                'experience.max' => 'Pengalaman tidak boleh lebih dari 255 karakter.',
            ]);
        }
    
        // Jika ditambahkan oleh admin, maka status langsung aktif dan email dianggap terverifikasi
        $isAddedByAdmin = $request->has('added_by_admin');
        $status = ($request->role === 'mentor' && !$isAddedByAdmin) ? 'pending' : 'active';
    
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'email_verified_at' => $isAddedByAdmin ? now() : null, // dianggap verifikasi jika ditambahkan oleh admin
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone_number,
            'role' => $request->role,
            'status' => $status,
            'experience' => $request->experience ?? null,
        ]);
    
        // Jika bukan ditambahkan oleh admin, kirim event verifikasi email
        if (!$isAddedByAdmin && $request->role === 'student') {
            event(new Registered($user));
        }
    
        // Redirect sesuai konteks
        if ($isAddedByAdmin) {
            if ($request->role === 'student') {
                return redirect()->route('datapeserta-admin')->with('success', 'Peserta berhasil ditambahkan oleh admin!');
            } else {
                return redirect()->route('datamentor-admin')->with('success', 'Mentor berhasil ditambahkan oleh admin!');
            }
        }        
    
        if ($request->role === 'student') {
            return redirect()->route('login')->with('success', 'Email verifikasi telah dikirim. Silakan periksa inbox Anda.');
        } else {
            return redirect()->route('login')->with('success', 'Permintaan Anda akan diproses oleh admin dalam 1x24 jam.');
        }
    }    

}
