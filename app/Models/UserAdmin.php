<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class UserAdmin extends Authenticatable
{
    protected $table = 'user_admin'; 

    
    protected $fillable = ['name', 'email', 'phone', 'password'];

   
    protected $hidden = ['password'];

   
}
