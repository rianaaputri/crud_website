<?php

namespace App\Http\Controllers;
use App\Models\Customer;
use Illuminate\Http\Request;

class AdminSellerController extends Controller
{
   public function index()
    {
         $customers = Customer::where('role', 'seller')->latest()->get();
    return view('admin.seller.index', compact('customers'));
    }
    public function show($id)
{
    $customer = Customer::findOrFail($id);
    return view('admin.seller.show', compact('customer'));
}
}
