<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Technicien extends Model
{
    protected $table = 'techniciens';

    protected $fillable = [
        'utilisateur_id',
        'specialite',
        'taux_horaire',
        'competences',
        'statut',
    ];

    // Relationships
    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class);
    }

    public function interventions()
    {
        return $this->hasMany(InterventionTechnicien::class);
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

    public function isDisponible()
    {
        return $this->statut === 'disponible';
    }
}
