<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groupe1Product extends Model
{
    use HasFactory;

    protected $table = 'groupe1_products';

    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'image',
    ];

    public function cartItems()
    {
        return $this->hasMany(Groupe1Cart::class, 'product_id');
    }

    public function orderItems()
    {
        return $this->hasMany(Groupe1OrderItem::class, 'product_id');
    }
}

