<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groupe2Note extends Model
{
    use HasFactory;

    protected $table = 'groupe2_notes';

    protected $fillable = [
        'etudiant_id',
        'matiere_id',
        'professeur_id',
        'note',
        'commentaire',
    ];

    public function etudiant()
    {
        return $this->belongsTo(Groupe2User::class, 'etudiant_id');
    }

    public function professeur()
    {
        return $this->belongsTo(Groupe2User::class, 'professeur_id');
    }

    public function matiere()
    {
        return $this->belongsTo(Groupe2Matiere::class, 'matiere_id');
    }
}

