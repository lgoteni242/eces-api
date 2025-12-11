<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groupe7Categorie extends Model
{
    use HasFactory;

    protected $table = 'groupe7_categories';

    protected $fillable = [
        'nom',
        'type',
        'couleur',
    ];

    public function transactions()
    {
        return $this->hasMany(Groupe7Transaction::class, 'categorie_id');
    }
}

