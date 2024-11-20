<?php

namespace App\Http\Traits;

use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait CanLoadRelationships
{
    /**
     * Load relationships
     *
     * @param Model|QueryBuilder|EloquentBuilder|HasMany $for ,
     * @param array|null $relations
     * @return Model|QueryBuilder|EloquentBuilder|HasMany
     */
    public function loadRelationships(
        Model|QueryBuilder|EloquentBuilder|HasMany $for,
        ?array                                     $relations = null
    ): Model|QueryBuilder|EloquentBuilder|HasMany
    {
        $relations = $relations ?? $this->relations ?? [];
        foreach ($relations as $relation) {
            $for->when(
                $this->shouldIncludeRelation($relation),
                fn($query) => $for instanceof Model ? $for->load($relation) : $query->with($relation)
            );
        }
        return $for;
    }

    /**
     * Check if the relation should be included
     *
     * @param string $relation
     * @return bool
     */
    protected function shouldIncludeRelation(string $relation): bool
    {
        $include = request()->query('include', '');

        $relations = array_map('trim', explode(',', $include));

        return in_array($relation, $relations);
    }

}
