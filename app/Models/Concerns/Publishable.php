<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;

/**
 * Adds a published() scope to models with an is_published column.
 */
trait Publishable
{
    /**
     * Limit the query to published rows.
     */
    #[Scope]
    protected function published(Builder $query): void
    {
        $query->where($query->qualifyColumn('is_published'), true);
    }
}
