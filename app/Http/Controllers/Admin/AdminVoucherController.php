<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Voucher;
class AdminVoucherController extends Controller
{
   public function index()
{
    $vouchers = Voucher::latest()->get();
    return view('admin.voucher.index', compact('vouchers'));
}
  public function create()
    {
        return view('admin.voucher.create');
    }

    // Simpan voucher baru
    public function store(Request $request)
{
    $request->validate([
        'kode' => 'required|unique:vouchers,kode',
        'jenis_diskon' => 'required|in:persen,nominal',
        'nilai_diskon' => 'required|numeric|min:0',
        'minimal_belanja' => 'nullable|numeric|min:0',
        'tanggal_kadaluarsa' => 'required|date|after:today',
    ]);

    Voucher::create([
        'kode' => $request->kode,
        'jenis_diskon' => $request->jenis_diskon,
        'nilai_diskon' => $request->nilai_diskon,
        'minimal_belanja' => $request->minimal_belanja ?? 0,
        'tanggal_kadaluarsa' => $request->tanggal_kadaluarsa,
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
        'kode' => 'required|unique:vouchers,kode,' . $voucher->id,
        'jenis_diskon' => 'required|in:persen,nominal',
        'nilai_diskon' => 'required|numeric|min:0',
        'minimal_belanja' => 'nullable|numeric|min:0',
        'tanggal_kadaluarsa' => 'required|date|after:today',
    ]);

    $voucher->update([
        'kode' => $request->kode,
        'jenis_diskon' => $request->jenis_diskon,
        'nilai_diskon' => $request->nilai_diskon,
        'minimal_belanja' => $request->minimal_belanja ?? 0,
        'tanggal_kadaluarsa' => $request->tanggal_kadaluarsa,
    ]);

    return redirect()->route('admin.voucher.index')->with('success', 'Voucher berhasil diperbarui.');
}

    // Hapus voucher
    public function destroy($id)
    {
        $voucher = Voucher::findOrFail($id);
        $voucher->delete();

        return redirect()->route('admin.voucher.index')->with('success', 'Voucher berhasil dihapus.');
    }

}
