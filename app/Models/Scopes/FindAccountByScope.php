<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class FindAccountByScope implements Scope
{
    protected $criteria;

    public function __construct($criteria)
    {
        $this->criteria = $criteria;
    }

    /**
     * Apply the scope to a given Eloquent query builder.
     * 
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model): void
    {
        $builder->where(function ($query) {
            $query->where('id', $this->criteria)
                ->orWhere('account_number', $this->criteria);
        });
    }
}
