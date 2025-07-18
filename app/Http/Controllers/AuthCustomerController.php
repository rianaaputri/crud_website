<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeUserMail;

class AuthCustomerController extends Controller
{
    public function showRegisterForm() {
        return view('customer.register');
    }

    public function register(Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:customers',
            'password' => 'required|min:6|confirmed',
        ]);

        $customer = Customer::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

          Mail::to($customer->email)->send(new WelcomeUserMail($customer));

        // Login otomatis (jika mau)
        Auth::guard('customer')->login($customer);

        return redirect()->route('customer.login')->with('success', 'Registrasi berhasil, silakan cek email Anda!');                    
    }

    public function showLoginForm() {
        return view('customer.login');
    }

    public function login(Request $request) {
        $credentials = $request->only('email', 'password');

       if (Auth::guard('customer')->attempt($credentials)) {
        return redirect()->route('products.index');
    }

    return back()->withErrors(['email' => 'Login gagal']);
}

    public function logout() {
        auth('customer')->logout();
        return redirect()->route('products.index');
    }
}
