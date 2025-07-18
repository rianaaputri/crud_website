<?php

namespace App\Http\Controllers;
use App\Models\Customer;
use Illuminate\Http\Request;

class AdminCustomerController extends Controller
{
     public function index()
    {
         $customers = Customer::where('role', 'customer')->latest()->get();
    return view('admin.customer.index', compact('customers'));
    }
    public function show($id)
{
    $customer = Customer::findOrFail($id);
    return view('admin.customer.show', compact('customer'));
}

}
