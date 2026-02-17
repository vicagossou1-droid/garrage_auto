<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notifications';

    protected $fillable = [
        'utilisateur_id',
        'titre',
        'message',
        'type',
        'reparation_id',
        'date_lecture',
    ];

    protected $casts = [
        'date_lecture' => 'datetime',
    ];

    // Relationships
    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class);
    }

    public function reparation()
    {
        return $this->belongsTo(Reparation::class);
    }

    // Scopes
    public function scopeNonLues($query)
    {
        return $query->whereNull('date_lecture')->orderBy('created_at', 'desc');
    }

    public function scopeLues($query)
    {
        return $query->whereNotNull('date_lecture');
    }

    // Methods
    public function marquerCommeLue()
    {
        $this->date_lecture = now();
        return $this->save();
    }

    public function estNonLue()
    {
        return is_null($this->date_lecture);
    }

    public static function nonLuesCount($utilisateur_id)
    {
        return self::where('utilisateur_id', $utilisateur_id)
            ->whereNull('date_lecture')
            ->count();
    }
}
