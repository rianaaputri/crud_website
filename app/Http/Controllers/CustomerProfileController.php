<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;


class CustomerProfileController extends Controller
{
    /**
     * Menampilkan profil customer beserta produk miliknya
     */
    public function index()
    {
        $customer = Auth::guard('customer')->user();
        $products = Product::where('customer_id', $customer->id)->get(); 

        return view('customer.profile', compact('customer', 'products'));
    }

    /**
     * Menampilkan form pendaftaran penjual
     */
    public function showBecomeSellerForm()
    {
        return view('customer.become_seller');
    }

    /**
     * Menyimpan data pendaftaran penjual
     */
    public function registerAsSeller(Request $request)
    {
        $request->validate([
            'store_name' => 'required|string|max:100',
            'store_description' => 'required|string|min:10',
        ]);

        $customer = auth('customer')->user();

        $customer->update([
            'store_name' => $request->store_name,
            'store_description' => $request->store_description,
            'is_seller' => true,
             'role' => 'seller',
        ]);

        return redirect()->route('customer.profile')->with('success', 'Selamat! Akun Anda sudah menjadi penjual.');
    }
    public function shop()
{
    $customer = auth('customer')->user();
    $products = $customer->products;

    return view('customer.shop', compact('customer', 'products'));
}
public function tokoPublic($id)
{
    $customer = \App\Models\Customer::findOrFail($id);
    $products = $customer->products; // relasi harus ada

    return view('customer.shop', compact('customer', 'products'));
}

}
