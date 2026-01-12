<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groupe8Avis extends Model
{
    use HasFactory;

    protected $table = 'groupe8_avis';

    protected $fillable = [
        'user_id',
        'etablissement_id',
        'note',
        'commentaire',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function etablissement()
    {
        return $this->belongsTo(Groupe8Etablissement::class, 'etablissement_id');
    }

    public function images()
    {
        return $this->morphMany(Groupe8Image::class, 'imageable');
    }
}

