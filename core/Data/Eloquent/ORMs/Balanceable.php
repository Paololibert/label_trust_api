<?php

declare(strict_types=1);

namespace Core\Data\Eloquent\ORMs;

use App\Models\Finances\BalanceDeCompte;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait Balanceable
{
    /**
     * Get the user of the employee.
     *
     * @return MorphMany
     */
    public function balances(): MorphMany
    {
        return $this->morphMany(BalanceDeCompte::class, 'balanceable');
    }

    /**
     * Get the user of the employee.
     *
     */
    public function balance()
    {
        return $this->morphOne(BalanceDeCompte::class, 'balanceable')->whereNull("date_cloture")->orWhereNotNull("date_cloture")->orderByDesc("created_at");
    }

    /**
     * Delete the user associate with the employee
     */
    public static function bootBalanceable()
    {
        static::deleting(function ($model) {
            $model->balances()->delete();
        });
    }
}