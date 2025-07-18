<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('vouchers', function (Blueprint $table) {
        $table->id();
        $table->string('kode')->unique();
        $table->enum('jenis_diskon', ['persen', 'nominal']);
        $table->decimal('nilai_diskon', 10, 2);
        $table->decimal('minimal_belanja', 10, 2)->default(0);
        $table->date('tanggal_kadaluarsa');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
