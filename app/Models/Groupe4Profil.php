<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groupe4Profil extends Model
{
    use HasFactory;

    protected $table = 'groupe4_profils';

    protected $fillable = [
        'user_id',
        'bio',
        'avatar',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

