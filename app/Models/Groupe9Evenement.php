<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groupe9Evenement extends Model
{
    use HasFactory;

    protected $table = 'groupe9_evenements';

    protected $fillable = [
        'titre',
        'description',
        'date',
        'lieu',
        'categorie',
        'capacite_max',
    ];

    protected $casts = [
        'date' => 'datetime',
    ];

    public function inscriptions()
    {
        return $this->hasMany(Groupe9Inscription::class, 'evenement_id');
    }
}

