<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groupe9Inscription extends Model
{
    use HasFactory;

    protected $table = 'groupe9_inscriptions';

    protected $fillable = [
        'user_id',
        'evenement_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function evenement()
    {
        return $this->belongsTo(Groupe9Evenement::class, 'evenement_id');
    }
}

