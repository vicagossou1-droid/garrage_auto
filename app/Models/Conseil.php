<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conseil extends Model
{
    protected $table = 'conseils';

    protected $fillable = [
        'titre',
        'contenu',
        'categorie',
        'image',
        'statut',
    ];

    // Scopes
    public function scopePublies($query)
    {
        return $query->where('statut', 'publie')->orderBy('created_at', 'desc');
    }

    public function scopeParCategorie($query, $categorie)
    {
        return $query->where('categorie', $categorie);
    }

    // Methods
    public function publier()
    {
        $this->statut = 'publie';
        return $this->save();
    }

    public function depublier()
    {
        $this->statut = 'brouillon';
        return $this->save();
    }

    public function estPublie()
    {
        return $this->statut === 'publie';
    }

    public function getExcerptAttribute($length = 150)
    {
        return substr(strip_tags($this->contenu), 0, $length) . '...';
    }
}
