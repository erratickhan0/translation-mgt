<?php

namespace App\Filters;

use App\Models\Locale\Tag;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;

class TranslationFilters
{
    /**
     * @param EloquentBuilder|QueryBuilder $query
     * @param array $filters
     * @return EloquentBuilder|QueryBuilder
     */
    public function apply(EloquentBuilder|QueryBuilder $query, array $filters)
    {

        // Search by query (key or value)
        if (!empty($filters['query'])) {
            $term = $filters['query'];

            // Searching in both key and value fields
            $query->where(function ($q) use ($term) {
                $q->where('key', 'like', "%{$term}%")
                    ->orWhere('value', 'like', "%{$term}%");
            });
        }

        // Search by tag slug if provided
        if (!empty($filters['tag'])) {
            $tag = Tag::where('slug', $filters['tag'])->first();

            if ($tag) {
                $query->where('tag_id', $tag->id);
            } else {
                // If the tag doesn't exist, force empty result
                $query->whereRaw('0 = 1');
            }
        }

        return $query;
    }

}
