<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $table = 'vouchers';
       protected $fillable = [
        'kode',
        'jenis_diskon',
        'nilai_diskon',
        'minimal_belanja',
        'tanggal_kadaluarsa',
    ];

    // Jika kolom tanggal_kadaluarsa kamu berupa date:
    protected $dates = ['tanggal_kadaluarsa'];
}
