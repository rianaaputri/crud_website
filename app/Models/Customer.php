<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'is_seller',             
        'store_name',          
        'store_description',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
    public function products()
{
    return $this->hasMany(Product::class);
}

}


