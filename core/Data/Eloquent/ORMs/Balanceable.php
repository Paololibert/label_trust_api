<?php

declare(strict_types=1);

namespace Core\Data\Eloquent\ORMs;

use App\Models\Finances\BalanceDeCompte;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait Balanceable
{
    /**
     * Get balances of an account.
     *
     * @return MorphMany
     */
    public function balances(): MorphMany
    {
        return $this->morphMany(BalanceDeCompte::class, 'balanceable');
    }

    /**
     * Get an account balance.
     *
     */
    public function balance()
    {
        return $this->morphOne(BalanceDeCompte::class, 'balanceable')->whereNull("date_cloture")->orderBy("created_at", "asc");
    }

    /**
     * Get an account balance.
     *
     */
    public function close_balance()
    {
        return $this->morphOne(BalanceDeCompte::class, 'balanceable')->whereNotNull("date_cloture")->orderBy("created_at", "desc");
    }

    /**
     *  
     */
    public static function bootBalanceable()
    {
        static::deleting(function ($model) {
            $model->balances()->delete();
        });
    }
}