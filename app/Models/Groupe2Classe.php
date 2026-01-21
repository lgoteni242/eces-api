<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groupe2Classe extends Model
{
    use HasFactory;

    protected $table = 'groupe2_classes';

    protected $fillable = [
        'nom',
        'niveau',
        'annee_scolaire',
        'professeur_principal_id',
        'description',
    ];

    public function professeurPrincipal()
    {
        return $this->belongsTo(Groupe2User::class, 'professeur_principal_id');
    }

    public function etudiants()
    {
        return $this->belongsToMany(Groupe2User::class, 'groupe2_classe_etudiant', 'classe_id', 'etudiant_id')
                    ->withTimestamps();
    }

    public function emploisDuTemps()
    {
        return $this->hasMany(Groupe2EmploiDuTemps::class, 'classe_id');
    }

    public function presences()
    {
        return $this->hasMany(Groupe2Presence::class, 'classe_id');
    }
}
