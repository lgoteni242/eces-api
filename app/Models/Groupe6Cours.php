<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groupe6Cours extends Model
{
    use HasFactory;

    protected $table = 'groupe6_cours';

    protected $fillable = [
        'formateur_id',
        'titre',
        'description',
        'image',
    ];

    public function formateur()
    {
        return $this->belongsTo(Groupe6User::class, 'formateur_id');
    }

    public function lecons()
    {
        return $this->hasMany(Groupe6Lecon::class, 'cours_id');
    }

    public function quiz()
    {
        return $this->hasMany(Groupe6Quiz::class, 'cours_id');
    }
}

