<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groupe10Conge extends Model
{
    use HasFactory;

    protected $table = 'groupe10_conges';

    protected $fillable = [
        'employe_id',
        'date_debut',
        'date_fin',
        'raison',
        'status',
    ];

    protected $casts = [
        'date_debut' => 'date',
        'date_fin' => 'date',
    ];

    public function employe()
    {
        return $this->belongsTo(Groupe10Employe::class, 'employe_id');
    }
}

