<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Voucher;

class AdminVoucherController extends Controller
{
    // Menampilkan daftar voucher
    public function index()
    {
        $vouchers = Voucher::latest()->get();
        return view('admin.voucher.index', compact('vouchers'));
    }

    // Form membuat voucher baru
    public function create()
    {
        return view('admin.voucher.create');
    }

    // Simpan voucher baru
    public function store(Request $request)
    {
        $request->validate([
            'code'        => 'required|string|unique:vouchers,code',
            'discount'    => 'required|numeric|min:0',
            'valid_from'  => 'nullable|date',
            'valid_until' => 'nullable|date|after_or_equal:valid_from',
        ]);

        Voucher::create([
            'code'        => $request->code,
            'discount'    => $request->discount,
            'valid_from'  => $request->valid_from,
            'valid_until' => $request->valid_until,
        ]);

        return redirect()->route('admin.voucher.index')->with('success', 'Voucher berhasil dibuat.');
    }

    // Form edit voucher
    public function edit($id)
    {
        $voucher = Voucher::findOrFail($id);
        return view('admin.voucher.edit', compact('voucher'));
    }

    // Simpan perubahan voucher
    public function update(Request $request, $id)
    {
        $voucher = Voucher::findOrFail($id);

        $request->validate([
            'code'        => 'required|string|unique:vouchers,code,' . $voucher->id,
            'discount'    => 'required|numeric|min:0',
            'valid_from'  => 'nullable|date',
            'valid_until' => 'nullable|date|after_or_equal:valid_from',
        ]);

        $voucher->update([
            'code'        => $request->code,
            'discount'    => $request->discount,
            'valid_from'  => $request->valid_from,
            'valid_until' => $request->valid_until,
        ]);

        return redirect()->route('admin.voucher.index')->with('success', 'Voucher berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $voucher = Voucher::findOrFail($id);
        $voucher->delete();

        return redirect()->route('admin.voucher.index')->with('success', 'Voucher berhasil dihapus.');
    }
}
