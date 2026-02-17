<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = 'clients';

    protected $fillable = [
        'utilisateur_id',
        'adresse',
        'ville',
        'code_postal',
        'numero_client',
        'date_inscription',
    ];

    protected $casts = [
        'date_inscription' => 'datetime',
    ];

    // Relationships
    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class);
    }

    public function vehicules()
    {
        return $this->hasMany(Vehicule::class);
    }

    public function reparations()
    {
        return $this->hasMany(Reparation::class);
    }

    public function avis()
    {
        return $this->hasMany(AvisClient::class);
    }

    // Getters
    public function getNomCompletAttribute()
    {
        return $this->utilisateur->nom_complet ?? 'Non disponible';
    }

    public function getEmailAttribute()
    {
        return $this->utilisateur->email ?? 'Non disponible';
    }

    public function getTelephoneAttribute()
    {
        return $this->utilisateur->telephone ?? 'Non disponible';
    }
}
