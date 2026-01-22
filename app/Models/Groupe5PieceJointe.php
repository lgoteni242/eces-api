<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Groupe5PieceJointe extends Model
{
    protected $fillable = [
        'tache_id', 
        'nom_original', 
        'chemin', 
        'type_mime',
        'taille'
    ];

    public function tache()
    {
        return $this->belongsTo(Groupe5Tache::class, 'tache_id');
    }
}
