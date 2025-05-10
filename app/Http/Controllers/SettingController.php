<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class SettingController extends Controller
{
    public function admin()
    {
        // Ambil informasi pengguna yang sedang login
        $user = Auth::user();
    
        // Periksa apakah pengguna memiliki peran admin
        if ($user && $user->role === 'admin') {
            return view('dashboard-admin.setting', compact('user'));
        }
    
        // Jika bukan admin, redirect ke halaman lain (contoh: dashboard utama) dengan pesan error
        return redirect()->route('welcome-admin')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
    
    public function mentor()
    {
        $user = Auth::user();
        
        return view('dashboard-mentor.setting', compact('user'));
    }

    public function student()
    {
        $user = Auth::user();
        
        return view('dashboard-peserta.setting', compact('user'));
    }
    
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
            'password' => 'nullable|confirmed|min:8',
            'phone_number' => 'nullable|string|max:15',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', 
        ], [
            'name.required' => 'Nama wajib diisi.',
            'name.string' => 'Nama harus berupa string.',
            'name.max' => 'Nama tidak boleh lebih dari 255 karakter.',
    
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Email tidak valid.',
            'email.max' => 'Email tidak boleh lebih dari 255 karakter.',
            'email.unique' => 'Email sudah terdaftar.',
    
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            'password.min' => 'Kata sandi harus memiliki minimal 8 karakter.',
    
            'phone_number.string' => 'Nomor telepon harus berupa string.',
            'phone_number.max' => 'Nomor telepon tidak boleh lebih dari 15 karakter.',
    
            'photo.image' => 'File yang diupload harus berupa gambar.',
            'photo.mimes' => 'Gambar harus memiliki format: jpeg, png, jpg, gif, svg.',
            'photo.max' => 'Ukuran gambar maksimal 2MB.',
        ]);
    
        $user = Auth::user();
    
        // Update field umum
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
    
        // Hanya update password jika ada input baru
        if (!empty($request->password)) {
            $user->password = Hash::make($request->password);
        }
    
        // Update foto jika diunggah
        if ($request->hasFile('photo')) {
            // Hapus foto lama
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
    
            // Simpan foto baru
            $user->photo = $request->file('photo')->store('images/profile', 'public');
        }
    
        $user->save();
    
        // Redirect sesuai role
        if ($user->role === 'admin') {
            return redirect()->route('welcome-admin')->with('success', 'Profil berhasil diperbarui!');
        } elseif ($user->role === 'mentor') {
            return redirect()->route('welcome-mentor')->with('success', 'Profil berhasil diperbarui!');
        } elseif ($user->role === 'student') {
            return redirect()->route('welcome-peserta')->with('success', 'Profil berhasil diperbarui!');
        }
    
        // Default redirect jika role tidak dikenali
        return redirect('/')->with('success', 'Profil berhasil diperbarui!');
    }
    

    public function updatePeserta(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
            'password' => 'nullable|confirmed|min:8',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($request->hasFile('photo')) {
            if ($user->photo) {
                Storage::delete('public/' . $user->photo);
            }

            $path = $request->file('photo')->store('images/profile', 'public');
            $user->photo = $path;
        }

        $user->save();

        return redirect()->route('welcome-peserta')->with('success', 'Profil berhasil diperbarui!');
    }
}