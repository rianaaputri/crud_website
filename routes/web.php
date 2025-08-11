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

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\AdminProdukController;
use App\Http\Controllers\AdminCustomerController;
use App\Http\Controllers\AdminSellerController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\Admin\AdminVoucherController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\VoucherController;
// ============================
// Homepage
// ============================

Route::get('/', [ProductController::class, 'index'])->name('home');



// ============================
// Produk & Transaksi Umum
// ============================
Route::resource('products', ProductController::class);
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
Route::get('/product-suggestions', [ProductController::class, 'suggestions'])->name('products.suggestions');
Route::resource('/products', ProductController::class)->only(['index', 'show', 'destroy']);
Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');
Route::post('/transaction/{id}/status/{status}', [TransactionController::class, 'updateStatus'])->name('transaction.update-status');

// ============================
// Auth Customer
// ============================

Route::get('/register', [AuthCustomerController::class, 'showRegisterForm'])->name('customer.register');
Route::post('/register', [AuthCustomerController::class, 'register']);
Route::get('/login', [AuthCustomerController::class, 'showUnifiedLoginForm'])->name('login');
Route::post('/login', [AuthCustomerController::class, 'login']);
Route::match(['get', 'post'], '/logout', [AuthCustomerController::class, 'logout'])->name('logout');


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
    Route::get('/customer/orders', [App\Http\Controllers\CustomerOrderController::class, 'index'])->name('customer.orders');
Route::get('/customer/orders/incoming', [CustomerOrderController::class, 'incomingOrders'])->name('customer.orders.incoming');
});

// ============================
// Form Jadi Penjual
// ============================

Route::get('/daftar-penjual', [CustomerProfileController::class, 'showBecomeSellerForm'])->name('customer.seller.form');
Route::post('/daftar-penjual', [CustomerProfileController::class, 'registerAsSeller'])->name('customer.seller.register');

// ============================
// Admin Auth
// ============================

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

Route::post('/checkout/apply-voucher', [CheckoutController::class, 'applyVoucher'])->name('checkout.apply-voucher');
Route::post('/checkout/remove-voucher', [CheckoutController::class, 'removeVoucher'])->name('checkout.remove-voucher');

});
// ============================
// Checkout Payment (Mid Trans)
// ============================
Route::post('/midtrans/callback', [PaymentController::class, 'callback'])->name('transactions.callback');
Route::post('/midtrans/token', [TransactionController::class, 'getSnapToken'])->name('midtrans.token');
Route::get('/midtrans/success', [TransactionController::class, 'success'])->name('transactions.success');
Route::get('/midtrans/pending', [TransactionController::class, 'pending'])->name('transactions.pending');

use Illuminate\Support\Facades\Auth;

Route::post('/logout', function () {
    if (Auth::guard('admin')->check()) {
        Auth::guard('admin')->logout();
    } elseif (Auth::guard('customer')->check()) {
        Auth::guard('customer')->logout();
    } elseif (Auth::check()) {
        Auth::logout(); // default guard
    }

    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect()->route('login'); // atau ganti ke route yang kamu inginkan
})->name('logout');

Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');

// voucher

Route::middleware(['auth'])->group(function () {
    Route::get('/customer/vouchers', [VoucherController::class, 'index'])->name('customer.vouchers');
    Route::post('/customer/vouchers/apply', [VoucherController::class, 'apply'])->name('customer.vouchers.apply');
});
Route::get('/vouchers', [VoucherController::class, 'customerIndex'])->name('customer.vouchers');
Route::get('/check-voucher', function (Request $request) {
    $voucher = \App\Models\Voucher::where('kode', $request->code)
        ->where('tanggal_kadaluarsa', '>=', now())
        ->first();

    $product = \App\Models\Product::find($request->product_id);
    $qty = $request->qty;
    $subtotal = $product->price * $qty;

    if ($voucher && $subtotal >= $voucher->minimal_belanja) {
        $diskon = $voucher->jenis_diskon === 'persen'
            ? ($voucher->nilai_diskon / 100) * $subtotal
            : $voucher->nilai_diskon;

        return response()->json([
            'valid' => true,
            'discount' => $diskon,
            'final_total' => $subtotal - $diskon
        ]);
    }

    return response()->json(['valid' => false]);
});
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.show');
Route::post('/checkout/voucher', [CheckoutController::class, 'applyVoucher'])->name('checkout.voucher');
Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
Route::delete('/checkout/voucher', [CheckoutController::class, 'removeVoucher'])->name('checkout.voucher.remove');
Route::get('/checkout/payment', [CheckoutController::class, 'showPaymentPage'])->name('checkout.paymentPage.show');
Route::post('/checkout/payment', [CheckoutController::class, 'showPaymentPage'])->name('checkout.paymentPage');


