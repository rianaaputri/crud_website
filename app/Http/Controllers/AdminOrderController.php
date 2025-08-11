<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Transaction;
class AdminOrderController extends Controller
{
  public function index()
    {
      
        $transactions = Transaction::with('product', 'user')->latest()->get();

        return view('admin.orders.index', compact('transactions'));
    }
}
