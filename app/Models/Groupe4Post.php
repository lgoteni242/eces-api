<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groupe4Post extends Model
{
    use HasFactory;

    protected $table = 'groupe4_posts';

    protected $fillable = [
        'user_id',
        'contenu',
        'image',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->hasMany(Groupe4Like::class, 'post_id');
    }

    public function comments()
    {
        return $this->hasMany(Groupe4Comment::class, 'post_id');
    }
}

