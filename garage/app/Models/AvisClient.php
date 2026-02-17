<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AvisClient extends Model
{
    protected $table = 'avis_clients';

    protected $fillable = [
        'client_id',
        'reparation_id',
        'note',
        'commentaire',
        'date_avis',
    ];

    protected $casts = [
        'note' => 'integer',
        'date_avis' => 'datetime',
    ];

    // Relationships
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function reparation()
    {
        return $this->belongsTo(Reparation::class);
    }

    // Scopes
    public function scopeRecents($query)
    {
        return $query->orderBy('date_avis', 'desc');
    }

    public function scopePositifs($query)
    {
        return $query->where('note', '>=', 4);
    }

    // Methods
    public function getNoteEtoilesAttribute()
    {
        return str_repeat('⭐', $this->note);
    }

    public static function noteMoyenne()
    {
        return self::selectRaw('AVG(note) as moyenne')->first()->moyenne ?? 0;
    }
}
