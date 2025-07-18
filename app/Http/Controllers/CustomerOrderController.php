<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Transaction;


class CustomerOrderController extends Controller
{
  public function index()
    {
        $customer = Auth::guard('customer')->user();

        $transactions = Transaction::where('customer_id', $customer->id)
            ->with('product')
            ->latest()
            ->get();

        return view('customer.orders', compact('transactions', 'customer'));
    }
public function incomingOrders()
{
    $customer = Auth::guard('customer')->user();

    $transactions =Transaction::whereHas('product', function ($query) use ($customer) {
        $query->where('customer_id', $customer->id);
    })->with('customer', 'product')->latest()->get();

    return view('customer.orders_incoming', compact('transactions', 'customer'));
}


}
