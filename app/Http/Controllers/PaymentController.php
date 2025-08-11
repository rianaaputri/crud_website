<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Snap;
use Midtrans\Config;


class PaymentController extends Controller
{
    
public function pay()
{
    // Setup Midtrans
    Config::$serverKey = config('midtrans.serverKey');
    Config::$isProduction = config('midtrans.isProduction');
    Config::$isSanitized = config('midtrans.isSanitized');
    Config::$is3ds = config('midtrans.is3ds');

    $params = [
        'transaction_details' => [
            'order_id' => 'DONASI-' . uniqid(),
            'gross_amount' => 20000,
        ],
        'customer_details' => [
            'first_name' => 'Riana',
            'email' => 'riana@example.com',
        ],
    ];

    $snapToken = Snap::getSnapToken($params);
    return view('donasi.bayar', compact('snapToken'));
}
use Midtrans\Notification;

public function callback(Request $request)
{
    $notif = new Notification();

    $transaction = $notif->transaction_status;
    $order_id = $notif->order_id;

    // Simpan ke database sesuai kebutuhan kamu
    if ($transaction == 'settlement') {
        // Pembayaran sukses
    } elseif ($transaction == 'pending') {
        // Menunggu pembayaran
    } elseif ($transaction == 'expire') {
        // Gagal
    }
}
}
