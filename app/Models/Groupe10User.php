<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groupe10User extends Model
{
    use HasFactory;

    protected $table = 'groupe10_users';

    protected $fillable = [
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function employe()
    {
        return $this->hasOne(Groupe10Employe::class, 'user_id', 'user_id');
    }
}

