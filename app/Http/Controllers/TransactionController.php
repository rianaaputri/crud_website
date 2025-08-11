<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth; 
use App\Models\Voucher;
use Illuminate\Support\Carbon;
use Midtrans\Snap;
use Midtrans\Config;

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
   $kodeVoucher = $request->voucher ?? session('voucher.kode');
if ($kodeVoucher) {
    $voucher = Voucher::where('kode', $kodeVoucher)
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

public function applyVoucher(Request $request)
{
    $request->validate(['voucher' => 'required|string']);
    
    $voucher = Voucher::where('kode', $request->voucher)
        ->where('tanggal_kadaluarsa', '>=', Carbon::today())
        ->first();

    if (!$voucher) {
        return back()->withErrors(['voucher' => 'Kode voucher tidak valid atau sudah kedaluwarsa.']);
    }

    // Simpan di session agar bisa dihitung saat pembayaran
    session([
        'voucher' => [
            'kode' => $voucher->kode,
            'jenis_diskon' => $voucher->jenis_diskon,
            'nilai_diskon' => $voucher->nilai_diskon,
            'minimal_belanja' => $voucher->minimal_belanja,
        ]
    ]);

    return back()->with('success', 'Voucher berhasil diterapkan!');
}

public function getSnapToken(Request $request)
{
    $product = Product::findOrFail($request->product_id);
    $customer = auth('customer')->user();

    $orderId = 'ORDER-' . uniqid();

    $params = [
        'transaction_details' => [
            'order_id' => $orderId,
            'gross_amount' => $product->price * $request->quantity,
        ],
        'customer_details' => [
            'first_name' => $customer->name,
            'email' => $customer->email,
        ],
        'item_details' => [[
            'id' => $product->id,
            'price' => $product->price,
            'quantity' => $request->quantity,
            'name' => $product->title
        ]],
    ];

    Config::$serverKey = config('midtrans.serverKey');
    Config::$isProduction = config('midtrans.isProduction');
    Config::$isSanitized = true;
    Config::$is3ds = true;

    $snapToken = Snap::getSnapToken($params);

    return response()->json(['snap_token' => $snapToken]);
}
public function success()
{
    return view('transactions.success');
}

public function pending()
{
    return view('transactions.pending');
}

}
