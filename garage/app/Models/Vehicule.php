<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicule extends Model
{
    protected $table = 'vehicules';

    protected $fillable = [
        'client_id',
        'marque',
        'modele',
        'plaque_immatriculation',
        'couleur',
        'annee',
        'kilometrage',
        'type_carrosserie',
        'energie',
        'numero_chassis',
        'image',
    ];

    // Relationships
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function reparations()
    {
        return $this->hasMany(Reparation::class);
    }

    // Getters
    public function getDescriptionAttribute()
    {
        return "{$this->annee} {$this->marque} {$this->modele}";
    }
}
