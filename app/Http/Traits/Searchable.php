<?php

namespace App\Http\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

trait Searchable
{
    public function scopeSearch(Builder $builder, string $search = null)
    {
        if (!$this->search_fields) {
            throw new \Exception("Please define the search_fields property .");
        }

        foreach ($this->search_fields as $field) {
            if (str_contains($field, '.')) {
                $relation = Str::beforeLast($field, '.');
                $column = Str::afterLast($field, '.');

                $builder->orWhereRelation($relation, $column, 'like', '%' . $search . '%');
                continue;
            }

            $builder->orWhere($field, 'like', '%' . $search . '%');
        }

        return $builder;
    }
}
