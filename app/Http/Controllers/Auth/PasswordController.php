<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PasswordController extends Controller
{
    // Tampilkan form untuk request reset link
    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    // Kirim email link reset password
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? redirect()->route('success-forgot-password')->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    
    }

    // Tampilkan form reset password dari link email
    public function showResetForm(Request $request, $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->query('email') // pastikan email dikirim lewat URL (query string)
        ]);
    }

    // Proses update password
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);
    
        // Proses reset password
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                // Update password user
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();
    
                // Trigger event
                event(new PasswordReset($user));
    
                Log::info('Password successfully reset for user: ' . $user->email);
            }
        );
    
        // Cek hasil reset
        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('success-reset-password')
                             ->with('status', __('Password berhasil direset.'));
        }
    
        // Gagal reset
        Log::error('Password reset failed for email: ' . $request->email . ' | Status: ' . $status);
        return back()->withErrors(['email' => [__($status)]])
                     ->withInput($request->only('email'));
    }
    
}

