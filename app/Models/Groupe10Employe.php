<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groupe10Employe extends Model
{
    use HasFactory;

    protected $table = 'groupe10_employes';

    protected $fillable = [
        'user_id',
        'role',
        'service_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service()
    {
        return $this->belongsTo(Groupe10Service::class, 'service_id');
    }

    public function conges()
    {
        return $this->hasMany(Groupe10Conge::class, 'employe_id');
    }
}

