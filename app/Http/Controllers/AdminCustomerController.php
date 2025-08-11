<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class AdminCustomerController extends Controller
{
     public function index()
    {
         $users = User::where('role', 'customer')->latest()->get();
    return view('admin.customer.index', compact('users'));
    }
    public function show($id)
{
    $users = User::findOrFail($id);
    return view('admin.customer.show', compact('user'));
}

}
