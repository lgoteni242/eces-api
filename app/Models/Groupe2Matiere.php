<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groupe2Matiere extends Model
{
    use HasFactory;

    protected $table = 'groupe2_matieres';

    protected $fillable = [
        'nom',
        'description',
    ];

    public function notes()
    {
        return $this->hasMany(Groupe2Note::class, 'matiere_id');
    }
}

