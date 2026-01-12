<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groupe8Image extends Model
{
    use HasFactory;

    protected $table = 'groupe8_images';

    protected $fillable = [
        'url',
        'path',
        'filename',
        'imageable_type',
        'imageable_id',
    ];

    /**
     * Relation polymorphique : peut être associée à un établissement ou un avis
     */
    public function imageable()
    {
        return $this->morphTo();
    }
}
