<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groupe3Reservation extends Model
{
    use HasFactory;

    protected $table = 'groupe3_reservations';

    protected $fillable = [
        'user_id',
        'salle_id',
        'date_debut',
        'date_fin',
        'raison',
        'status',
    ];

    protected $casts = [
        'date_debut' => 'datetime',
        'date_fin' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function salle()
    {
        return $this->belongsTo(Groupe3Salle::class, 'salle_id');
    }
}

