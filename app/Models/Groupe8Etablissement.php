<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groupe8Etablissement extends Model
{
    use HasFactory;

    protected $table = 'groupe8_etablissements';

    protected $fillable = [
        'nom',
        'type',
        'adresse',
        'telephone',
        'description',
    ];

    public function avis()
    {
        return $this->hasMany(Groupe8Avis::class, 'etablissement_id');
    }

    public function images()
    {
        return $this->morphMany(Groupe8Image::class, 'imageable');
    }
}

