<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth; 

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
            'email' => $request->query('email')
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

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                // Update password dan regenerate token
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->setRememberToken(Str::random(60));

                $user->save();

                // Logout semua session lain user (pastikan SESSION_DRIVER=database)
                Auth::logoutOtherDevices($password);

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('success-reset-password')
                             ->with('status', __('Password berhasil direset. Semua session lama telah di-logout.'));
        }

        return back()->withErrors(['email' => [__($status)]])
                     ->withInput($request->only('email'));
    }
}
