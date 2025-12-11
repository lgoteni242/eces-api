<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groupe4Comment extends Model
{
    use HasFactory;

    protected $table = 'groupe4_comments';

    protected $fillable = [
        'user_id',
        'post_id',
        'contenu',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
        return $this->belongsTo(Groupe4Post::class, 'post_id');
    }
}

