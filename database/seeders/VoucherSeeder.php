<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Voucher;

class VoucherSeeder extends Seeder
{
    public function run()
    {
        Voucher::create([
            'code' => 'DISKON10',
            'discount' => 10, // misal 10%
            'valid_from' => now()->toDateString(),
            'valid_until' => now()->addDays(7)->toDateString(),
        ]);
    }
}
