<?php
// App\Models\Admin.php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $table = 'admins';

    protected $fillable = [
        'name',
        'email',
        'password',
    ];  

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Auto insert into 'users' when an Admin is created
    protected static function booted()
    {
        static::created(function ($admin) {
            User::create([
                'name' => $admin->name,
                'email' => $admin->email,
                'password' => $admin->password, // Sudah dalam bentuk hash
                'role' => 'admin',
            ]);
        });
    }
}
