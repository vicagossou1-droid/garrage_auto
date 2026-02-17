<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recu extends Model
{
    protected $table = 'recus';

    protected $fillable = [
        'reparation_id',
        'numero_recu',
        'montant_total',
        'methode_paiement',
        'details',
        'date_paiement',
    ];

    protected $casts = [
        'montant_total' => 'decimal:2',
        'date_paiement' => 'datetime',
    ];

    // Relationships
    public function reparation()
    {
        return $this->belongsTo(Reparation::class);
    }

    // Methods
    public function getMontantFormatteAttribute()
    {
        return number_format((float)$this->montant_total, 2, '.', ' ') . ' XOF';
    }

    public function getMethodePaiementFormatteAttribute()
    {
        $methodes = [
            'especes' => 'Espèces',
            'cheque' => 'Chèque',
            'carte' => 'Carte Bancaire',
            'virement' => 'Virement Bancaire',
            'mobile_money' => 'Mobile Money',
        ];
        return $methodes[$this->methode_paiement] ?? $this->methode_paiement;
    }
}
