<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groupe5Tache extends Model
{
    use HasFactory;

    protected $table = 'groupe5_taches';

    protected $fillable = [
        'projet_id',
        'user_id',
        'titre',
        'description',
        'status',
        'priorite',
    ];

    public function projet()
    {
        return $this->belongsTo(Groupe5Projet::class, 'projet_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

