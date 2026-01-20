<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groupe5Commentaire extends Model
{
    use HasFactory;

    protected $table = 'groupe5_commentaires';

    protected $fillable = [
        'tache_id',
        'user_id',
        'contenu',
    ];  

    public function tache()
    {
        return $this->belongsTo(Groupe5Tache::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
