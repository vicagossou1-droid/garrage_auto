<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Devis extends Model
{
    protected $table = 'devis';

    protected $fillable = [
        'reparation_id',
        'description_travaux',
        'montant_total',
        'date_emission',
        'validite_jours',
        'statut',
        'date_acceptation',
    ];

    protected $casts = [
        'montant_total' => 'decimal:2',
        'date_emission' => 'datetime',
        'date_acceptation' => 'datetime',
        'validite_jours' => 'integer',
    ];

    // Relationships
    public function reparation()
    {
        return $this->belongsTo(Reparation::class);
    }

    // Methods
    public function estValide()
    {
        return $this->date_emission->addDays($this->validite_jours)->isFuture();
    }

    public function accepter()
    {
        $this->statut = 'accepte';
        $this->date_acceptation = now();
        return $this->save();
    }

    public function refuser()
    {
        $this->statut = 'refuse';
        return $this->save();
    }

    public function getMontantFormatteAttribute()
    {
        return number_format((float)$this->montant_total, 2, '.', ' ') . ' XOF';
    }
}
