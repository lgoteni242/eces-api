<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groupe6Quiz extends Model
{
    use HasFactory;

    protected $table = 'groupe6_quiz';

    protected $fillable = [
        'cours_id',
        'question',
        'reponses',
        'reponse_correcte',
    ];

    protected $casts = [
        'reponses' => 'array',
    ];

    public function cours()
    {
        return $this->belongsTo(Groupe6Cours::class, 'cours_id');
    }
}

