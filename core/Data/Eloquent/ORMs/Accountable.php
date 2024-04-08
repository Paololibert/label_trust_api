<?php

declare(strict_types=1);

namespace Core\Data\Eloquent\ORMs;

use App\Models\Finances\Account;
use App\Models\Finances\LigneEcritureComptable;
use App\Models\Finances\SubAccount;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\DB;

/**
 * 
 */
trait Accountable
{
    /**
     * Get an account transactions
     *
     * @return MorphMany
     */
    public function transactions(): MorphMany
    {
        return $this->morphMany(LigneEcritureComptable::class, 'accountable');
    }

    /**
     * Get an account transactions
     *
     */
    public function mouvement_credit()
    {
        return $this->morphMany(LigneEcritureComptable::class, 'accountable')->where("type_ecriture_compte", "credit");
    }

    /**
     * Get an account transactions
     *
     */
    public function mouvement_debit()
    {
        return $this->morphMany(LigneEcritureComptable::class, 'accountable')->where("type_ecriture_compte", "debit");
    }

    /* public function scopeTransactions(Builder $query, $exercice_comptable_id)
    {
        return $query->with("transactions", function ($query) use ($exercice_comptable_id) {
            $query
                //->select("type_ecriture_compte", DB::raw('SUM(montant) as total')) // Specify the columns you want to select
                ->where("ligneable_type", "App\Models\Finances\EcritureComptable")
                ->whereHas("ligneable.exercice_comptable_journal", function ($ligne_query) use ($exercice_comptable_id) {
                    $ligne_query->where("exercice_comptable_id", $exercice_comptable_id);
                }); //->groupBy('type_ecriture_compte'); 
        })->recursiveTransactions($exercice_comptable_id);
    }

    public function scopeRecursiveTransactions(Builder $query, string $exercice_comptable_id) {
        if($query->getModel() instanceof Account){
            $query = $query->whereHas("sous_comptes", function ($query) use ($exercice_comptable_id) {
                $query->transactions($exercice_comptable_id);
            });
        }
        else if($query->getModel() instanceof SubAccount){
            $query = $query->whereHas("sub_divisions", function($query) use ($exercice_comptable_id) {
                $query->transactions($exercice_comptable_id);
            });
        }
        
        return $query;
    } */

    /**
     * Delete the user associate with the employee
     */
    public static function bootAccountable()
    {
    }
}
