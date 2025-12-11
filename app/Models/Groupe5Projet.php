<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groupe5Projet extends Model
{
    use HasFactory;

    protected $table = 'groupe5_projets';

    protected $fillable = [
        'user_id',
        'nom',
        'description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function taches()
    {
        return $this->hasMany(Groupe5Tache::class, 'projet_id');
    }
}

