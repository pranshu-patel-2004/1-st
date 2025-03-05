<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'f_name', 'l_name', 'email', 'phone', 'gender', 'photo', 'password',
    ];

    protected $hidden = ['password'];
}

