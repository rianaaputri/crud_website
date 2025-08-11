<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Voucher;
class VoucherController extends Controller
{
    public function customerIndex()
{
    $vouchers = Voucher::whereDate('valid_until', '>=', now())->get();
    return view('customer.vouchers.index', compact('vouchers'));
}  
public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:vouchers,code',
            'discount' => 'required|numeric|min:1|max:100',
            'valid_from' => 'nullable|date',
            'valid_until' => 'nullable|date|after_or_equal:valid_from',
        ]);

        Voucher::create($request->all());

        return redirect()->route('vouchers.index')->with('success', 'Voucher berhasil dibuat!');
    }

    public function apply(Request $request)
    {
        $request->validate([
            'voucher_code' => 'required|string'
        ]);

        $voucher = Voucher::where('code', $request->voucher_code)->first();

        if (!$voucher) {
            return response()->json(['error' => 'Voucher tidak ditemukan.'], 404);
        }

        if (!$voucher->isValid()) {
            return response()->json(['error' => 'Voucher sudah tidak berlaku.'], 400);
        }

        return response()->json([
            'success' => true,
            'discount' => $voucher->discount
        ]);
    }
}
