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
         Schema::table('transactions', function (Blueprint $table) {
    $table->decimal('diskon', 10, 2)->nullable();
    $table->decimal('total', 10, 2)->nullable();
    $table->string('voucher_kode')->nullable();
});

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
