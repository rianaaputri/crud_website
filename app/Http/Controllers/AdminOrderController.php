<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Transaction;
class AdminOrderController extends Controller
{
  public function index()
    {
        // Ambil semua transaksi beserta relasi product dan customer
        $transactions = Transaction::with('product', 'customer')->latest()->get();

        return view('admin.orders.index', compact('transactions'));
    }
}
