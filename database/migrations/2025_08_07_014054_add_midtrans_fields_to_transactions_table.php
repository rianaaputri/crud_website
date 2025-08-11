<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       Schema::table('transactions', function (Blueprint $table) {
    $table->string('midtrans_transaction_id')->nullable();   // ID dari Midtrans (ex: f139129-... )
    $table->string('midtrans_status')->default('pending');   // pending, settlement, expire, etc.
    $table->timestamp('payment_time')->nullable();           // Waktu pembayaran sukses
    $table->string('payment_type')->nullable();              // credit_card, qris, bank_transfer, dll
    $table->string('snap_token')->nullable();                // Opsional (untuk Snap popup)
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            //
        });
    }
};
