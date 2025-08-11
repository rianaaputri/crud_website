<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void
    {
        Schema::rename('customers', 'users');
    }

    public function down(): void
    {
        Schema::rename('users', 'customers');
    }
};

