<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groupe5Label extends Model
{
    use HasFactory;

    protected $table = 'groupe5_labels';

    protected $fillable = [
        'nom',
        'couleur',
    ];

    public function taches()
    {
        return $this->belongsToMany(Groupe5Tache::class, 'groupe5_label_tache', 'label_id', 'tache_id');
    }
}
