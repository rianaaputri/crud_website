<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class AdminProdukController extends Controller
{
     public function index()
    {
        $products = Product::latest()->get();
        return view('admin.produk.index', compact('products'));
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('admin.produk')->with('success', 'Produk berhasil dihapus.');
    }
}
