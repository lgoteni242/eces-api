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
        'equipements',
        'description',
    ];

    public function reservations()
    {
        return $this->hasMany(Groupe3Reservation::class, 'salle_id');
    }
}

