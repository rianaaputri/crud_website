<?php

namespace App\Http\Controllers\Admin;  
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeUserMail;
use App\Models\Customer;

class AuthController extends Controller
{
    
public function showRegisterForm()
{
    return view('admin.register');
}

public function register(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:100',
        'email' => 'required|email|unique:admins,email',
        'password' => 'required|min:6|confirmed', 
    ]);

    $admin = Admin::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    // Login otomatis setelah register (opsional)
    Mail::to($admin->email)->send(new WelcomeUserMail($admin));
    Auth::guard('admin')->login($admin);

    return redirect()->route('admin.login')->with('success', 'Registrasi admin berhasil!');
}
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['email' => 'Email atau password salah.']);
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
    public function dashboard()
{
    $customers = Customer::where('role', 'customer')->get();
    return view('admin.dashboard', compact('customers'));
}
}
