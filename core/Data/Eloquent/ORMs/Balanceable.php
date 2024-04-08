<?php

declare(strict_types=1);

namespace Core\Data\Eloquent\ORMs;

use App\Models\Finances\Account;
use App\Models\Finances\BalanceDeCompte;
use App\Models\Finances\SubAccount;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\DB;

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
    }/* 

    public function scopeSoldeDesComptes(Builder $query, string $exercice_comptable_id, string $start_date = null, string $end_date = null)
    {
        return $query->with("balance", function ($query) use ($exercice_comptable_id) {
            $query->where("exercice_comptable_id", $exercice_comptable_id);
        })->recursive($exercice_comptable_id);
    }

    public function scopeRecursive(Builder $query, string $exercice_comptable_id) {
        if($query->getModel() instanceof Account){
            $query = $query->whereHas("sous_comptes", function ($query) use ($exercice_comptable_id) {
                $query->soldeDesComptes($exercice_comptable_id);
            });
        }
        else if($query->getModel() instanceof SubAccount){
            $query = $query->whereHas("sub_divisions", function($query) use ($exercice_comptable_id) {
                $query->soldeDesComptes($exercice_comptable_id);
            });
        }
        
        return $query;
    } */

    /**
     *  
     */
    public static function bootBalanceable()
    {
    }
}
