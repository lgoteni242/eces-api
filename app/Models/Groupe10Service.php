<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groupe10Service extends Model
{
    use HasFactory;

    protected $table = 'groupe10_services';

    protected $fillable = [
        'nom',
        'description',
    ];

    public function employes()
    {
        return $this->hasMany(Groupe10Employe::class, 'service_id');
    }
}

