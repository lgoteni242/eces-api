<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groupe2Presence extends Model
{
    use HasFactory;

    protected $table = 'groupe2_presences';

    protected $fillable = [
        'etudiant_id',
        'classe_id',
        'date',
        'statut',
        'commentaire',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function etudiant()
    {
        return $this->belongsTo(Groupe2User::class, 'etudiant_id');
    }

    public function classe()
    {
        return $this->belongsTo(Groupe2Classe::class, 'classe_id');
    }
}
