<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groupe1OrderItem extends Model
{
    use HasFactory;

    protected $table = 'groupe1_order_items';

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
    ];

    public function order()
    {
        return $this->belongsTo(Groupe1Order::class, 'order_id');
    }

    public function product()
    {
        return $this->belongsTo(Groupe1Product::class, 'product_id');
    }
}

