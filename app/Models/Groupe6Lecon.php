<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groupe6Lecon extends Model
{
    use HasFactory;

    protected $table = 'groupe6_lecons';

    protected $fillable = [
        'cours_id',
        'titre',
        'contenu',
        'video_url',
        'ordre',
    ];

    public function cours()
    {
        return $this->belongsTo(Groupe6Cours::class, 'cours_id');
    }

    public function progressions()
    {
        return $this->hasMany(Groupe6Progression::class, 'lecon_id');
    }
}

