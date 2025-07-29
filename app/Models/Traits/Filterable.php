<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;

trait Filterable
{
    public function scopeFilter(Builder $query, array $filters = []): Builder
    {
        if (($filters['search'] ?? false) && property_exists($this, 'searchable')) {
            $searchTerm = $filters['search'];

            $query->where(function ($q) use ($searchTerm) {
                foreach ($this->searchable as $field) {
                    $q->orWhere($field, 'like', '%' . $searchTerm . '%');
                }
            });
        }
        return $query;
    }
}
