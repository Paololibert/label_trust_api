<?php

declare(strict_types=1);

namespace Core\Data\Eloquent\ORMs;

use App\Models\Finances\Account;
use App\Models\Finances\BalanceDeCompte;
use App\Models\Finances\SubAccount;
use Core\Utils\Exceptions\ApplicationException;
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
    
    /* 
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

    public function scopeOrdoring(Builder $query, string $column = "account_number"){
        return $query->orderByRaw("CAST($column AS INTEGER) ASC");
    }


    public function scopeBalanceDeCompte(Builder $query, string $type = "debiteur", string $exercice_comptable_id, string $start_at, string $end_at)
    {
        $solde = 0.00;

        //if($this->account_number === "711") dd($this->balances);
        if (!$this->balance) {
            throw new ApplicationException("Veuillez reporter le solde du compte: " . $this->account_number, 400);
        }

        $balance = $this->balance()->where("exercice_comptable_id", $exercice_comptable_id)->first();

        switch ($type) {
            case 'crediteur':
                $solde = $this->mouvementDebit(exercice_comptable_id: $exercice_comptable_id, start_at: $start_at, end_at: $end_at) - ($this->mouvementCredit(exercice_comptable_id: $exercice_comptable_id, start_at: $start_at, end_at: $end_at) + ($balance->type_solde_compte->value === "crediteur" ? $balance->solde :  0));
                break;

            default:
                $solde = (($balance->type_solde_compte->value === "debiteur" ? $balance->solde : 0) + $this->mouvementDebit(exercice_comptable_id: $exercice_comptable_id, start_at: $start_at, end_at: $end_at)) - $this->mouvementCredit(exercice_comptable_id: $exercice_comptable_id, start_at: $start_at, end_at: $end_at);
                break;
        }

        if($solde < 0) return $solde * -1;
        
        return $solde;
    }

}
