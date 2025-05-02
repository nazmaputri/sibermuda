<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use App\Models\Keranjang;
use App\Models\Purchase;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Auth\Events\Verified;

class LoginController extends Controller
{

    //Login Admin
    public function loginAdmin()
    {
        return view('auth.login-admin');
    }

     // verifikasi email
     public function verify(Request $request, $id, $hash)
     {
         $user = User::findOrFail($id);
     
         // Cek apakah hash cocok
         if (! hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
             return redirect()->route('login')->with('error', 'Link verifikasi tidak valid.');
         }
     
         // Cek apakah sudah diverifikasi
         if ($user->hasVerifiedEmail()) {
             return redirect()->route('login')->with('info', 'Email sudah diverifikasi sebelumnya.');
         }
     
         // Tandai email sebagai terverifikasi
         $user->markEmailAsVerified();
     
         event(new Verified($user));
     
         return redirect()->route('login')->with('success', 'Email berhasil diverifikasi. Silakan login.');
     }

    //Untuk mengirim email nya
    public function verifyHandler (Request $request) {
        $request->user()->sendEmailVerificationNotification();
     
        return back()->with('message', 'Verification link sent!');
    }

    // Menampilkan form login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Redirect user ke Google untuk login
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Callback yang menerima data dari Google dan login pengguna
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $email = $googleUser->getEmail();
    
            // Cari user berdasarkan email
            $user = User::where('email', $email)->first();
    
            // Kalau user tidak ditemukan
            if (!$user) {
                return redirect()->route('register')->withErrors([
                    'email' => 'Email Anda belum terdaftar. Silakan daftar terlebih dahulu.',
                ]);
            }
    
            // Cek verifikasi email
            if (is_null($user->email_verified_at)) {
                return redirect()->route('login')->withErrors([
                    'email' => 'Email Anda belum diverifikasi.',
                ]);
            }
    
            // Cek status akun
            if ($user->status !== 'active') {
                return redirect()->route('login')->withErrors([
                    'email' => 'Akun Anda tidak aktif.',
                ]);
            }
    
            // Login pengguna
            switch ($user->role) {
                case 'admin':
                    Auth::guard('admin')->login($user); 
                    return redirect()->route('welcome-admin');
                
                case 'mentor':
                    Auth::guard('mentor')->login($user); 
                    return redirect()->route('welcome-mentor');
                
                case 'student':
                    Auth::guard('student')->login($user);  
                    return redirect()->route('welcome-peserta');
                
                default:
                    Auth::logout();
                    return redirect('login')->withErrors(['email' => 'Role tidak dikenal.']);
            }
    
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors([
                'google' => 'Gagal login dengan Google. Coba lagi nanti.',
            ]);
        }
    }
    

    public function login(Request $request)
    {
        // Validasi input termasuk reCAPTCHA
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
            'g-recaptcha-response' => 'required|recaptcha',
        ], [
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password harus diisi.',
            'g-recaptcha-response.required' => 'Verifikasi bahwa anda bukan robot.',
            'g-recaptcha-response.recaptcha' => 'Verifikasi reCAPTCHA gagal.',
        ]);
    
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput($request->except('password'));
        }
    
        $user = User::where('email', $request->email)->first();
    
        if (!$user) {
            return back()->withErrors(['email' => 'Email tidak ditemukan.'])
                ->withInput($request->except('password'));
        }
    
        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Password salah.'])
                ->withInput($request->except('password'));
        }
    
        if (is_null($user->email_verified_at) && in_array($user->role, ['student'])) {
            return redirect()->route('login')->withErrors(['email' => 'Email Anda belum diverifikasi.']);
        }
    
        if ($user->status !== 'active') {
            return back()->withErrors(['email' => 'Akun Anda tidak aktif.']);
        }
    
        $request->session()->regenerate();
    
        switch ($user->role) {
            case 'admin':
                Auth::guard('admin')->login($user);
                return redirect()->route('welcome-admin');
    
            case 'mentor':
                Auth::guard('mentor')->login($user);
                return redirect()->route('welcome-mentor');
    
            case 'student':
                Auth::guard('student')->login($user);
    
                if (Session::has('kursus_id_pending')) {
                    $courseId = Session::pull('kursus_id_pending');
    
                    $hasPurchased = Purchase::where('user_id', $user->id)
                        ->where('course_id', $courseId)
                        ->where('status', 'success')
                        ->exists();
    
                    if ($hasPurchased) {
                        return redirect()->route('welcome-peserta')->with('error', 'Kursus ini sudah Anda beli.');
                    }
    
                    Keranjang::firstOrCreate([
                        'user_id' => $user->id,
                        'course_id' => $courseId,
                    ]);
    
                    return redirect()->route('cart.index')->with('success', 'Kursus berhasil ditambahkan ke keranjang.');
                }
    
                return redirect()->route('welcome-peserta');
    
            default:
                Auth::logout();
                return redirect('login')->withErrors(['email' => 'Role tidak dikenal.']);
        }
    }

    // Proses logout
    public function logout(Request $request)
    {
        Auth::guard('student')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('login')->with('success', 'Anda telah berhasil logout.');
    }

    public function logoutAdmin(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('login')->with('success', 'Anda telah berhasil logout.');
    }

    public function logoutMentor(Request $request)
    {
        Auth::guard('mentor')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('login')->with('success', 'Anda telah berhasil logout.');
    }

}
