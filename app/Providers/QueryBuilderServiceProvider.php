<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;


class QueryBuilderServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        Builder::macro('isUnique', function ($column, $value) {
            return !$this->where($column, $value)
                ->when($this->model->exists, function ($query) {
                    $query->where('id', '!=', $this->model->id);
                })
                ->exists();
        });



        /**
         * Sort a collection by a specific attribute of a related model.
         *
         * @param \Illuminate\Support\Collection $collection
         * @param string $relation
         * @param string $attribute
         * @return \Illuminate\Support\Collection
         */
        Collection::macro('sortByRelatedAttribute', function ($relationName, $attribute, $direction = 'asc') {
            return $this->sortBy(function ($item) use ($relationName, $attribute) {
                return optional($item->{$relationName})->{$attribute};
            }, SORT_REGULAR, $direction === 'desc');
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
