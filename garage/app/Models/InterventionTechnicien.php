<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InterventionTechnicien extends Model
{
    protected $table = 'interventions_technicien';

    protected $fillable = [
        'reparation_id',
        'technicien_id',
        'date_debut',
        'date_fin',
        'duree_minutes',
        'commentaires',
        'cout_intervention',
    ];

    protected $casts = [
        'date_debut' => 'datetime',
        'date_fin' => 'datetime',
        'duree_minutes' => 'integer',
        'cout_intervention' => 'decimal:2',
    ];

    // Relationships
    public function reparation()
    {
        return $this->belongsTo(Reparation::class);
    }

    public function technicien()
    {
        return $this->belongsTo(Technicien::class);
    }

    // Methods
    public function calculerDuree()
    {
        if ($this->date_debut && $this->date_fin) {
            $this->duree_minutes = $this->date_debut->diffInMinutes($this->date_fin);
            return $this;
        }
        return $this;
    }

    public function getDureeFormateeAttribute()
    {
        $heures = intdiv($this->duree_minutes, 60);
        $minutes = $this->duree_minutes % 60;
        return "{$heures}h {$minutes}m";
    }

    public function getCoutFormatteAttribute()
    {
        return number_format($this->cout_intervention ?? 0, 2, '.', ' ') . ' XOF';
    }
}
