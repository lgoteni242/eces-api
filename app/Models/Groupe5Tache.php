<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Groupe5Label;

class Groupe5Tache extends Model
{
    use HasFactory;

    protected $table = 'groupe5_taches';

    protected $fillable = [
        'projet_id',
        'user_id',
        'titre',
        'description',
        'deadline',
        'status',
        'priorite',
    ];

    protected $casts = [
        'deadline' => 'datetime',
    ];

    public function projet()
    {
        return $this->belongsTo(Groupe5Projet::class, 'projet_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function labelsRelation()
    {
        return $this->belongsToMany(Groupe5Label::class, 'groupe5_label_tache', 'tache_id', 'label_id');
    }

    public function commentaires()
    {
        return $this->hasMany(Groupe5Commentaire::class, 'tache_id');
    }

    /**
     * Relation pour les pièces jointes
     */
    public function piecesJointes()
    {
        return $this->hasMany(Groupe5PieceJointe::class, 'tache_id');
    }

    public function assignes() 
    {
        return $this->belongsToMany(User::class, 'groupe5_tache_user', 'tache_id', 'user_id');
    }
}