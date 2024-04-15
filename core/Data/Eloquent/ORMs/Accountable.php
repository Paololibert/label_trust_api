<?php

declare(strict_types=1);

namespace Core\Data\Eloquent\ORMs;

use App\Models\Finances\Account;
use App\Models\Finances\ExerciceComptable;
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

    /**
     * Delete the user associate with the employee
     */
    public static function bootAccountable()
    {
    }

    public function scopeMouvements(Builder $query, string $exercice_comptable_id, string $start_at, string $end_at)
    {
        $query = $this->transactions()
        ->where("ligneable_type", "App\Models\Finances\EcritureComptable")
        ->whereHas("ligneable", function ($query) use ($start_at, $end_at) {
            $query->whereBetween("date_ecriture", [$start_at, $end_at]);
        });

        return $query->select("type_ecriture_compte", DB::raw('SUM(montant) as total'))
        ->groupBy('type_ecriture_compte'); // Specify the columns you want to select;

        return $this->transactions()
            ->where("ligneable_type", "App\Models\Finances\EcritureComptable")
            ->whereHas("ligneable", function ($query) use ($start_at, $end_at) {
                $query->whereBetween("date_ecriture", [$start_at, $end_at]);
            })->whereHas("ligneable.exercice_comptable_journal", function ($ligne_query) use ($exercice_comptable_id) {
                $ligne_query->where("exercice_comptable_id", $exercice_comptable_id);
            })/* ->groupBy('type_ecriture_compte') */
            ->select("type_ecriture_compte", DB::raw('SUM(montant) as total'))
            ->groupBy('type_ecriture_compte'); // Specify the columns you want to select;
    }

    public function scopeMouvementDebit(Builder $query, string $exercice_comptable_id, string $start_at, string $end_at)
    {
        return $query->mouvements(exercice_comptable_id: $exercice_comptable_id, start_at: $start_at, end_at: $end_at)->where("type_ecriture_compte", "debit")->first()?->total ?? 0.00;
    }

    public function scopeMouvementCredit(Builder $query, string $exercice_comptable_id, string $start_at, string $end_at)
    {
        return $query->mouvements(exercice_comptable_id: $exercice_comptable_id, start_at: $start_at, end_at: $end_at)->where("type_ecriture_compte", "credit")->first()?->total ?? 0.00;
    }

    /**
     * Load sub divisions on an sub account
     * 
     * @return Builder $query
     */
    public function scopeWithSousComptes(Builder $query, bool $withSub = false)
    {
        return $query->with(["sous_comptes" => function ($query) use ($withSub) {
            $query = $query->ordoring()->without(["sub_divisions"]);
            if ($withSub) $query->withSubDivisions($withSub);
            return $query;
        }]);
    }

    /**
     * Load sub divisions on an sub account
     * 
     * @return Builder $query
     */
    public function scopeWithSubDivisions(Builder $query, bool $withSub = false): Builder
    {
        return $query->with(["sub_divisions" => function ($query) use ($withSub) {
            $query = $query->ordoring()->without(["sub_divisions"]);
            if ($withSub) $query->withSubDivisions($withSub);
            return $query;
        }]);
    }
}
