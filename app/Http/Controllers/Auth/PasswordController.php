<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\PasswordReset;
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

        // Reset password menggunakan token dan email
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) use ($request) {
                if (!$user) {
                    // Log jika token tidak valid
                    Log::error('Invalid token or email during password reset: ' . $request->email);
                    return back()->withErrors(['email' => 'Token reset tidak valid.']);
                }

                // Update password di database
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();

                // Trigger event password reset
                event(new PasswordReset($user));

                // Log keberhasilan
                Log::info('Password successfully reset for user: ' . $user->email);
            }
        );

        // Cek status apakah password berhasil direset
        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('success-reset-password')
                             ->with('status', __('Password berhasil direset.'));
        }

        // Jika gagal, kembalikan dengan pesan error
        Log::error('Password reset failed with status: ' . $status);
        return back()->withErrors(['email' => [__($status)]])
                     ->withInput($request->only('email'));
    }
}

