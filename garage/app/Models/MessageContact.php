<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MessageContact extends Model
{
    protected $table = 'messages_contact';

    protected $fillable = [
        'nom',
        'email',
        'telephone',
        'sujet',
        'message',
        'statut',
    ];

    // Scopes
    public function scopeNonLus($query)
    {
        return $query->where('statut', 'non_lu')->orderBy('created_at', 'desc');
    }

    public function scopeLus($query)
    {
        return $query->where('statut', '!=', 'non_lu');
    }

    // Methods
    public function marquerCommeLue()
    {
        $this->statut = 'lu';
        return $this->save();
    }

    public function marquerCommeRepondu()
    {
        $this->statut = 'repondu';
        return $this->save();
    }

    public function estNonLu()
    {
        return $this->statut === 'non_lu';
    }

    public static function nonLusCount()
    {
        return self::where('statut', 'non_lu')->count();
    }
}
