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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); //foreignn
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->integer('quantity');
            $table->bigInteger('total_price');        // Total harga = harga produk × quantity
            $table->bigInteger('payment_amount');     // Jumlah uang yang dibayarkan pembeli
            $table->bigInteger('change')->nullable(); // Kembalian (opsional)
            $table->string('payment_method')->nullable(); // Tunai, Transfer, QRIS
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
