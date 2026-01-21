<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groupe2User extends Model
{
    use HasFactory;

    protected $table = 'groupe2_users';

    protected $fillable = [
        'user_id',
        'role',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function notes()
    {
        return $this->hasMany(Groupe2Note::class, 'etudiant_id');
    }

    public function classes()
    {
        return $this->belongsToMany(Groupe2Classe::class, 'groupe2_classe_etudiant', 'etudiant_id', 'classe_id')
                    ->withTimestamps();
    }

    public function presences()
    {
        return $this->hasMany(Groupe2Presence::class, 'etudiant_id');
    }

    public function emploisDuTemps()
    {
        return $this->hasMany(Groupe2EmploiDuTemps::class, 'professeur_id');
    }
}

