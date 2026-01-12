<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groupe3Image extends Model
{
    use HasFactory;

    protected $table = 'groupe3_images';

    protected $fillable = [
        'url',
        'path',
        'filename',
        'salle_id',
    ];

    public function salle()
    {
        return $this->belongsTo(Groupe3Salle::class, 'salle_id');
    }
}
