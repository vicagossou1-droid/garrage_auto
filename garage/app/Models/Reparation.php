<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reparation extends Model
{
    protected $table = 'reparations';

    protected $fillable = [
        'vehicule_id',
        'client_id',
        'date_depot',
        'date_fin_prevue',
        'date_fin_reelle',
        'description_panne',
        'statut',
        'estimation_cout',
        'cout_final',
        'notes_admin',
    ];

    protected $casts = [
        'date_depot' => 'datetime',
        'date_fin_prevue' => 'datetime',
        'date_fin_reelle' => 'datetime',
        'estimation_cout' => 'decimal:2',
        'cout_final' => 'decimal:2',
    ];

    // Relationships
    public function vehicule()
    {
        return $this->belongsTo(Vehicule::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function interventions()
    {
        return $this->hasMany(InterventionTechnicien::class);
    }

    public function devis()
    {
        return $this->hasOne(Devis::class);
    }

    public function recu()
    {
        return $this->hasOne(Recu::class);
    }

    public function avis()
    {
        return $this->hasOne(AvisClient::class);
    }

    // Scopes
    public function scopeActives($query)
    {
        return $query->whereIn('statut', ['en_attente', 'en_cours']);
    }

    public function scopeTerminees($query)
    {
        return $query->whereIn('statut', ['termine', 'livree']);
    }

    // Methods
    public function estTerminee()
    {
        return in_array($this->statut, ['termine', 'livree']);
    }

    public function peutEtreModifiee()
    {
        return in_array($this->statut, ['en_attente']);
    }
}
