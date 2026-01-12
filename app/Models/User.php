<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'groupe8_role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relations avec les groupes
    public function groupe2User()
    {
        return $this->hasOne(Groupe2User::class);
    }

    public function groupe3User()
    {
        return $this->hasOne(Groupe3User::class);
    }

    public function groupe4Profil()
    {
        return $this->hasOne(Groupe4Profil::class);
    }

    public function groupe4MessagesSent()
    {
        return $this->hasMany(Groupe4Message::class, 'sender_id');
    }

    public function groupe4MessagesReceived()
    {
        return $this->hasMany(Groupe4Message::class, 'receiver_id');
    }

    public function groupe6User()
    {
        return $this->hasOne(Groupe6User::class);
    }

    public function groupe10Employe()
    {
        return $this->hasOne(Groupe10Employe::class);
    }
}
