<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groupe3Salle extends Model
{
    use HasFactory;

    protected $table = 'groupe3_salles';

    protected $fillable = [
        'nom',
        'capacite',
        'prix',
        'equipements',
        'description',
    ];

    protected $casts = [
        'prix' => 'decimal:2',
    ];

    public function reservations()
    {
        return $this->hasMany(Groupe3Reservation::class, 'salle_id');
    }

    public function images()
    {
        return $this->hasMany(Groupe3Image::class, 'salle_id');
    }
}

