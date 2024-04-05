<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class FindAccountScope implements Scope
{
    protected $accountNumber;

    public function __construct($accountNumber)
    {
        $this->accountNumber = $accountNumber;
    }

    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        $this->applyRecursive($builder, $this->accountNumber);
    }

    /**
     * Apply the scope recursively to search for the account number at all levels.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  string  $accountNumber
     * @return void
     */
    protected function applyRecursive(Builder $builder, $accountNumber)
    {
        /* $builder->whereH('account_number', $accountNumber)
            ->orWhereHas('sub_accounts', function ($query) use ($accountNumber) {
                $query->where('account_number', $accountNumber);
            })->orWhereHas('sub_divisions', function ($query) use ($accountNumber) {
                $this->applyRecursive($query, $accountNumber);
            })->orWhereHas('sub_divisions.sub_divisions', function ($query) use ($accountNumber) {
                $this->applyRecursive($query, $accountNumber);
            }); */
    }
}
