<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Utilisateur extends Authenticatable
{
    use Notifiable;

    protected $table = 'utilisateurs';

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'telephone',
        'password',
        'type_utilisateur',
        'statut',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Relationships
    public function client()
    {
        return $this->hasOne(Client::class);
    }

    public function technicien()
    {
        return $this->hasOne(Technicien::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    // Getters
    public function getNomCompletAttribute()
    {
        return "{$this->prenom} {$this->nom}";
    }
}
