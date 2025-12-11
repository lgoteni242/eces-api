<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groupe6Progression extends Model
{
    use HasFactory;

    protected $table = 'groupe6_progressions';

    protected $fillable = [
        'etudiant_id',
        'lecon_id',
        'termine',
    ];

    protected $casts = [
        'termine' => 'boolean',
    ];

    public function etudiant()
    {
        return $this->belongsTo(Groupe6User::class, 'etudiant_id');
    }

    public function lecon()
    {
        return $this->belongsTo(Groupe6Lecon::class, 'lecon_id');
    }
}

