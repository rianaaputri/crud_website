<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class transaction extends Model
{
    protected $fillable = [
    'product_id',
    'user_id',
    'quantity',
    'total_price',
    'payment_amount',
    'change',
    'payment_method',
    'status'
];


public function product()
{
    return $this->belongsTo(Product::class);
}
   public function user()
    {
        return $this->belongsTo(User::class);
    }


}
