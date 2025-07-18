<?php

use Illuminate\Support\Facades\Route;

// ============================
// Public Area
// ============================

use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\AuthCustomerController;
use App\Http\Controllers\CustomerProfileController;
use App\Http\Controllers\CustomerOrderController;
use App\Http\Controllers\Auth\AdminForgotPasswordController;
use App\Http\Controllers\Auth\AdminResetPasswordController;
use App\Http\Controllers\Auth\CustomerForgotPasswordController;
use App\Http\Controllers\Auth\CustomerResetPasswordController;

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\AdminProdukController;
use App\Http\Controllers\AdminCustomerController;
use App\Http\Controllers\AdminSellerController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\Admin\AdminVoucherController;

// ============================
// Homepage
// ============================

Route::get('/', function () {
    return view('welcome');
});

// ============================
// Produk & Transaksi Umum
// ============================

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/product-suggestions', [ProductController::class, 'suggestions'])->name('products.suggestions');
Route::resource('/products', ProductController::class)->only(['index', 'show', 'destroy']);
Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');
Route::post('/transaction/{id}/status/{status}', [TransactionController::class, 'updateStatus'])->name('transaction.update-status');

// ============================
// Auth Customer
// ============================

Route::get('/register', [AuthCustomerController::class, 'showRegisterForm'])->name('customer.register');
Route::post('/register', [AuthCustomerController::class, 'register']);
Route::get('/login', [AuthCustomerController::class, 'showLoginForm'])->name('customer.login');
Route::post('/login', [AuthCustomerController::class, 'login']);
Route::post('/logout', [AuthCustomerController::class, 'logout'])->name('customer.logout');

// ============================
// Lupa Password Customer
// ============================

Route::prefix('customer')->group(function () {
    Route::get('forgot-password', [CustomerForgotPasswordController::class, 'showLinkRequestForm'])->name('customer.password.request');
    Route::post('forgot-password', [CustomerForgotPasswordController::class, 'sendResetLinkEmail'])->name('customer.password.email');
    Route::get('reset-password/{token}', [CustomerResetPasswordController::class, 'showResetForm'])->name('customer.password.reset');
    Route::post('reset-password', [CustomerResetPasswordController::class, 'reset'])->name('customer.password.update');
});

// ============================
// Halaman Customer (Login Diperlukan)
// ============================

Route::middleware('auth:customer')->group(function () {
    Route::get('/profile', [CustomerProfileController::class, 'index'])->name('customer.profile');
    Route::get('/profile/products', [ProductController::class, 'myProducts'])->name('customer.products');
    Route::get('/toko-saya', [CustomerProfileController::class, 'shop'])->name('customer.shop');
    Route::get('/customer/orders', [CustomerOrderController::class, 'index'])->name('customer.orders');
});

// ============================
// Form Jadi Penjual
// ============================

Route::get('/daftar-penjual', [CustomerProfileController::class, 'showBecomeSellerForm'])->name('customer.seller.form');
Route::post('/daftar-penjual', [CustomerProfileController::class, 'registerAsSeller'])->name('customer.seller.register');

// ============================
// Admin Auth
// ============================

Route::get('/admin/login', [AuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login']);
Route::get('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');
Route::get('/admin/register', [AuthController::class, 'showRegisterForm'])->name('admin.register');
Route::post('/admin/register', [AuthController::class, 'register']);

// ============================
// Admin Reset Password
// ============================

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/forgot-password', [AdminForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [AdminForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [AdminResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [AdminResetPasswordController::class, 'reset'])->name('password.update');
});

// ============================
// Admin Area (Login Required)
// ============================

Route::prefix('admin')->middleware('auth:admin')->name('admin.')->group(function () {
    Route::get('/dashboard', fn() => view('admin.dashboard'))->name('dashboard');

    Route::get('/produk', [AdminProdukController::class, 'index'])->name('produk');
    Route::delete('/produk/{id}', [AdminProdukController::class, 'destroy'])->name('produk.destroy');

    Route::get('/customer', [AdminCustomerController::class, 'index'])->name('customer.index');
    Route::get('/customer/{id}', [AdminCustomerController::class, 'show'])->name('customer.show');

    Route::get('/seller', [AdminSellerController::class, 'index'])->name('seller.index');
    Route::get('/seller/{id}', [AdminSellerController::class, 'show'])->name('seller.show');

    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders');

    // Voucher CRUD
   
    // Route untuk voucher
   
    Route::get('/voucher', [AdminVoucherController::class, 'index'])->name('voucher.index');
    Route::get('/voucher/create', [AdminVoucherController::class, 'create'])->name('voucher.create');
    Route::post('/voucher', [AdminVoucherController::class, 'store'])->name('voucher.store');

});
