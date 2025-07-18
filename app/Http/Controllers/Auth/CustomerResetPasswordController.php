<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CustomerResetPasswordController extends Controller
{
    public function showResetForm(Request $request, $token)
    {
        return view('auth.customer.reset-password', [
            'token' => $token,
            'email' => $request->email
        ]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
        ]);

        $status = Password::broker('customers')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($customer, $password) {
                $customer->password = Hash::make($password);
                $customer->setRememberToken(Str::random(60));
                $customer->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login.customer')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }
}



