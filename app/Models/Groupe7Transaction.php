<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groupe7Transaction extends Model
{
    use HasFactory;

    protected $table = 'groupe7_transactions';

    protected $fillable = [
        'user_id',
        'type',
        'montant',
        'categorie_id',
        'date',
        'description',
    ];

    protected $casts = [
        'date' => 'date',
        'montant' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categorie()
    {
        return $this->belongsTo(Groupe7Categorie::class, 'categorie_id');
    }
}

