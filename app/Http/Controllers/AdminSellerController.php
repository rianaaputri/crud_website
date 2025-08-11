<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class AdminSellerController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'seller')->latest()->get();
        return view('admin.seller.index', compact('users'));
    }

    public function show($id)
    {
        $users = User::findOrFail($id);
        return view('admin.seller.show', compact('user'));
    }
}
