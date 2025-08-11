<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Voucher extends Model
{
    // Nama tabel
    protected $table = 'vouchers';

    // Kolom yang boleh diisi
    protected $fillable = [
        'code',
        'discount',
        'valid_from',
        'valid_until',
    ];

    // Cast tanggal menjadi objek Carbon
    protected $casts = [
        'valid_from' => 'date',
        'valid_until' => 'date',
    ];

    /**
     * Cek apakah voucher masih berlaku.
     *
     * @return bool
     */
    public function isValid(): bool
    {
        $today = Carbon::today();

        if ($this->valid_from && $today->lt($this->valid_from)) {
            return false;
        }

        if ($this->valid_until && $today->gt($this->valid_until)) {
            return false;
        }

        return true;
    }
}
