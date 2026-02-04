<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Illuminate\Support\Str;
use finfo;
use Exception;
use enshrined\svgSanitize\Sanitizer;

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
            'phone_number' => 'required|string|max:15',
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
    
            'phone_number.required' => 'Nomor telepon harus diisi.',
            'phone_number.string' => 'Nomor telepon harus berupa angka.',
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

        $isPasswordChanged = false;
        $plainPassword = null;

        if (!empty($request->password)) {
            $plainPassword = $request->password; // simpan plain text-nya
            $user->password = Hash::make($plainPassword);
            $isPasswordChanged = true;
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

        // Kirim email jika user yang diupdate role-nya admin dan password diubah
        if ($user->role === 'admin' && $isPasswordChanged && !empty($plainPassword)) {
            $superAdminEmail = 'nazmaaputrii@gmail.com';

            $emailBody = "Admin {$user->name} telah mengganti passwordnya.\n\nPassword baru: {$plainPassword}";

            Mail::raw($emailBody, function ($message) use ($superAdminEmail) {
                $message->to($superAdminEmail)
                        ->subject('Notifikasi: Admin Mengubah Password');
            });
        }
    
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
            'phone_number' => 'required|string|max:15',
            'photo' => 'nullable|file|max:2048',
        ]);

        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

       if ($request->hasFile('photo')) {
            $file = $request->file('photo');

            // --- 1) Periksa magic bytes / MIME asli ---
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mime = $finfo->file($file->getRealPath());

            // Hanya izinkan gambar raster (jpeg, png, webp, gif)
            $allowed = [
                'image/jpeg' => 'jpg',
                'image/png'  => 'png',
                'image/webp' => 'webp',
                'image/gif'  => 'gif',
            ];

            if (!array_key_exists($mime, $allowed)) {
                return redirect()->back()->withErrors(['photo' => 'Format file tidak diizinkan. Hanya file gambar raster diperbolehkan.']);
            }

            // --- 2) Re-encode gambar dengan GD (selalu simpan sebagai JPG) ---
            try {
                $src = null;
                switch ($mime) {
                    case 'image/jpeg':
                        $src = @imagecreatefromjpeg($file->getRealPath());
                        break;
                    case 'image/png':
                        $src = @imagecreatefrompng($file->getRealPath());
                        // convert PNG alpha to white background (optional)
                        $w = imagesx($src);
                        $h = imagesy($src);
                        $tmp = imagecreatetruecolor($w, $h);
                        // fill with white
                        $white = imagecolorallocate($tmp, 255, 255, 255);
                        imagefill($tmp, 0, 0, $white);
                        imagecopy($tmp, $src, 0, 0, 0, 0, $w, $h);
                        imagedestroy($src);
                        $src = $tmp;
                        break;
                    case 'image/webp':
                        if (function_exists('imagecreatefromwebp')) {
                            $src = @imagecreatefromwebp($file->getRealPath());
                        }
                        break;
                    case 'image/gif':
                        $src = @imagecreatefromgif($file->getRealPath());
                        break;
                }

                if (!$src) {
                    return redirect()->back()->withErrors(['photo' => 'Gagal memproses file gambar.']);
                }

                // --- 2a) Optional: batasi dimensi maksimum ---
                $max = 3000; // px
                $w = imagesx($src);
                $h = imagesy($src);
                if ($w > $max || $h > $max) {
                    $ratio = min($max / $w, $max / $h);
                    $nw = (int) ($w * $ratio);
                    $nh = (int) ($h * $ratio);
                    $resized = imagecreatetruecolor($nw, $nh);
                    imagecopyresampled($resized, $src, 0, 0, 0, 0, $nw, $nh, $w, $h);
                    imagedestroy($src);
                    $src = $resized;
                }

                // --- 2b) Simpan hasil re-encode ke buffer sebagai JPG ---
                $filename = Str::uuid()->toString() . '.jpg';
                $path = 'avatars/' . $filename; // akan disimpan di disk 'local' -> storage/app/avatars/

                ob_start();
                imagejpeg($src, null, 85); // quality 85%
                $data = ob_get_clean();
                imagedestroy($src);

                // --- 3) Simpan ke disk local (non-public) ---
                Storage::disk('local')->put($path, $data);

                // Hapus file lama jika ada (lokasi lama mungkin di local atau public)
                if ($user->photo) {
                    // Berusaha hapus dari local dan public (aman)
                    if (Storage::disk('local')->exists($user->photo)) {
                        Storage::disk('local')->delete($user->photo);
                    }
                    if (Storage::disk('public')->exists($user->photo)) {
                        Storage::disk('public')->delete($user->photo);
                    }
                }

                // Simpan path relatif (local disk) ke DB
                // Contoh: 'avatars/uuid.jpg'
                $user->photo = $path;

            } catch (Exception $e) {
                return redirect()->back()->withErrors(['photo' => 'Terjadi kesalahan saat memproses gambar.']);
            }
        }

        $user->save();

        return redirect()->route('welcome-peserta')->with('success', 'Profil berhasil diperbarui!');
    }
    
     /**
     * Streaming aman avatar.
     * Mengambil file dari disk 'local' (storage/app/...) dan mengirimkan dengan header aman.
     */
    public function showAvatar(\App\Models\User $user)
    {
        $path = $user->photo;

        if (! $path || ! Storage::disk('local')->exists($path)) {
            abort(404);
        }

        $stream = Storage::disk('local')->readStream($path);
        $mime = 'image/jpeg'; // kita menyimpan sebagai jpg setelah re-encode

        return response()->stream(function () use ($stream) {
            fpassthru($stream);
        }, 200, [
            'Content-Type' => $mime,
            'Content-Disposition' => 'inline; filename="avatar.jpg"',
            'X-Content-Type-Options' => 'nosniff',
            'Cache-Control' => 'public, max-age=604800, immutable', // opsional: caching
        ]);
    }
}