<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'add_products';

    protected $fillable = [
        'customer_id', 'product_name', 'description', 'tags', 'created_at', 'updated_at'
    ];
    

    public function variants()
    {
        return $this->hasMany(ProductVariant::class, 'product_id');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }

    public function customer()
    {
        return $this->belongsTo(CustomerProduct::class, 'customer_id', 'id'); 

    }
}
