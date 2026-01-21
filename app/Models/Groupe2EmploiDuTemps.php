<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groupe2EmploiDuTemps extends Model
{
    use HasFactory;

    protected $table = 'groupe2_emplois_du_temps';

    protected $fillable = [
        'classe_id',
        'matiere_id',
        'professeur_id',
        'jour_semaine',
        'heure_debut',
        'heure_fin',
        'salle',
    ];

    public function classe()
    {
        return $this->belongsTo(Groupe2Classe::class, 'classe_id');
    }

    public function matiere()
    {
        return $this->belongsTo(Groupe2Matiere::class, 'matiere_id');
    }

    public function professeur()
    {
        return $this->belongsTo(Groupe2User::class, 'professeur_id');
    }
}
