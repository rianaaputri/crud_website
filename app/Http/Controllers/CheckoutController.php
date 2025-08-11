<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\Voucher;

class CheckoutController extends Controller
{
   public function index(Request $request)
{
    if (!$request->has('product_id')) {
        abort(404, 'Produk tidak ditemukan');
    }

    $product = Product::findOrFail($request->product_id);

    return view('checkout.index', [
        'product' => $product
    ]);
}


    // STEP 1 → Tampilkan halaman pembayaran (cek voucher)
      public function showpaymentPage(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'total_price' => 'required|numeric|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);
        $total = $product->price * $request->quantity;

        $voucher = null;
        if ($request->voucher_code) {
        $voucher = Voucher::where('code', $request->voucher_code)->first();

    if ($voucher) {
        $today = now()->toDateString();
        if (
            ($voucher->valid_from && $today < $voucher->valid_from) ||
            ($voucher->valid_until && $today > $voucher->valid_until)
        ) {
            return back()->with('error', 'Voucher sudah tidak berlaku.');
        }

        // Hitung diskon
        $diskon = ($voucher->discount / 100) * $total;
        $total -= $diskon;
    }
}


        return view('checkout.payment', [
            'product' => $product,
            'quantity' => $request->quantity,
            'total' => $total,
            'voucher' => $voucher
        ]);
    }

    // Proses transaksi
    public function process(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'total' => 'required|integer|min:0',
            'payment_amount' => 'required|integer|min:' . $request->total
        ]);

        $change = $request->payment_amount - $request->total;

        Transaction::create([
            'product_id' => $request->product_id,
            'user_id' => auth('customer')->id(),
            'quantity' => $request->quantity,
            'total_price' => $request->total,
            'payment_amount' => $request->payment_amount,
            'change' => $change,
            'status' => 'menunggu',
            'voucher_id' => $request->voucher_id
        ]);

        return redirect()->route('customer.orders')
            ->with('success', 'Pembayaran berhasil! Kembalian: Rp ' . number_format($change, 0, ',', '.'));
    }
}
