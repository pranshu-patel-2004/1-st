<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'name', 'email', 'phone', 'address', 'country_id', 'state_id', 'city_id', 'status', 'password'
    ];



    
    public function user()
{
    return $this->belongsTo(User::class, 'user_id', 'id'); 
}

    
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    
    public function state()
    {
        return $this->belongsTo(State::class);
    }

    
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'customer_id', 'id'); 
        
    }
}
