<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Transaction;


class CustomerOrderController extends Controller
{
  public function index()
    {
        $user= Auth::guard('customer')->user();

        $transactions = Transaction::where('user_id', $user->id)
            ->with('product')
            ->latest()
            ->get();

        return view('customer.orders', compact('transactions', 'user'));
    }
public function incomingOrders()
{
    $user = Auth::guard('customer')->user();

    $transactions =Transaction::whereHas('product', function ($query) use ($user) {
        $query->where('user_id', $user->id);
    })->with('user', 'product')->latest()->get();

    return view('customer.orders_incoming', compact('transactions', 'user'));
}


}
