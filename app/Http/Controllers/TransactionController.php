<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth; 

use App\Models\Voucher;
class TransactionController extends Controller
{
   public function store(Request $request)
{
    $request->validate([
        'product_id'     => 'required|exists:products,id',
        'quantity'       => 'required|integer|min:1',
        'payment_amount' => 'required|numeric|min:0',
        'payment_method' => 'required|string|max:50',
        'voucher'        => 'nullable|string',
    ]);

    $product = Product::findOrFail($request->product_id);
    $subtotal = $product->price * $request->quantity;

    if ($product->stock < $request->quantity) {
        return back()->with('error', 'Stok tidak mencukupi.');
    }

    $diskon = 0;

    // Proses voucher jika diisi
    if ($request->filled('voucher')) {
        $voucher = Voucher::where('kode', $request->voucher)
            ->where('tanggal_kadaluarsa', '>=', now())
            ->first();

        if ($voucher) {
            if ($subtotal >= $voucher->minimal_belanja) {
                if ($voucher->jenis_diskon === 'persen') {
                    $diskon = ($voucher->nilai_diskon / 100) * $subtotal;
                } else {
                    $diskon = $voucher->nilai_diskon;
                }
            } else {
                return back()->withErrors(['voucher' => 'Minimal belanja tidak mencukupi untuk menggunakan voucher ini.']);
            }
        } else {
            return back()->withErrors(['voucher' => 'Kode voucher tidak valid atau telah kadaluarsa.']);
        }
    }

    $totalSetelahDiskon = max(0, $subtotal - $diskon);

    if ($request->payment_amount < $totalSetelahDiskon) {
        return back()->with('error', 'Pembayaran kurang dari total setelah diskon.');
    }

    $change = $request->payment_amount - $totalSetelahDiskon;

    // Simpan transaksi
    Transaction::create([
        'product_id'     => $product->id,
        'customer_id'    => Auth::guard('customer')->id(),
        'quantity'       => $request->quantity,
        'total_price'    => $subtotal,
        'diskon'         => $diskon,
        'total'          => $totalSetelahDiskon,
        'voucher_kode'   => $request->voucher ?? null,
        'payment_amount' => $request->payment_amount,
        'change'         => $change,
        'payment_method' => $request->payment_method,
    ]);

    // Kurangi stok
    $product->decrement('stock', $request->quantity);

    return redirect()->route('products.index')->with('success', 'Transaksi berhasil!');
}
    public function updateStatus($id, $status)
{
    $allowed = ['sedang dikemas', 'diantarkan'];

    if (!in_array($status, $allowed)) {
        return back()->with('error', 'Status tidak valid.');
    }

    $trx = Transaction::findOrFail($id);
    $trx->status = $status;
    $trx->save();

    return back()->with('success', "Status pesanan diperbarui menjadi '$status'.");
}

}
