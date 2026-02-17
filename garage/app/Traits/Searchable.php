<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait Searchable
{
    /**
     * Applique une recherche simple sur le modèle
     */
    public function scopeSearch(Builder $query, ?string $search, array $columns = []): Builder
    {
        if (!$search) {
            return $query;
        }

        return $query->where(function (Builder $query) use ($search, $columns) {
            foreach ($columns as $column) {
                $query->orWhere($column, 'like', "%{$search}%");
            }
        });
    }

    /**
     * Applique des filtres sur le modèle
     */
    public function scopeFilter(Builder $query, array $filters = []): Builder
    {
        foreach ($filters as $column => $value) {
            if ($value !== null && $value !== '') {
                $query->where($column, $value);
            }
        }
        return $query;
    }
}
