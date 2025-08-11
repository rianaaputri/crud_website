<?php

namespace App\Http\Controllers\Admin;  
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeUserMail;
use App\Models\User;

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

    return redirect()->route('login')->with('success', 'Registrasi admin berhasil!');
}
    public function showLoginForm()
    {
        return view('login');
    }

   public function login(Request $request)
{
    $credentials = $request->only('email', 'password');

    // Coba login admin dulu
    if (Auth::guard('admin')->attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->route('admin.dashboard');
    }

    // Kalau bukan admin, coba login customer
    if (Auth::guard('customer')->attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->route('products.index'); // dashboard customer
    }

    // Kalau gagal semua
    return back()->with('error', 'Email atau password salah');
}

public function logout(Request $request)
{
    if (Auth::guard('admin')->check()) {
        Auth::guard('admin')->logout();
    } elseif (Auth::guard('customer')->check()) {
        Auth::guard('customer')->logout();
    } else {
        Auth::guard('web')->logout();
    }

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/');
}

 
    public function dashboard()
{
    $customers = Customer::where('role', 'customer')->get();
    return view('admin.dashboard', compact('customers'));
}
}
