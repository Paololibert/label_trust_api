<?php

declare(strict_types=1);

namespace App\Models\Finances;

use App\Models\Scopes\FindAccountByScope;
use Core\Data\Eloquent\Contract\ModelContract;
use Core\Data\Eloquent\ORMs\Accountable;
use Core\Data\Eloquent\ORMs\Balanceable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Concerns\AsPivot;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\DB;

/**
 * Class ***`Account`***
 *
 * This model represents the `plan_comptable_comptes` table in the database.
 * It extends the ModelContract class and provides access to the database table associated with the model.
 *
 * @property  string    $compte_id;
 *
 * @package ***`\App\Models\Finances`***
 */
class Account extends ModelContract
{
    use AsPivot, Balanceable, Accountable;

    /**
     * The database connection that should be used by the model.
     *
     * @var string
     */
    protected $connection = 'pgsql';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'plan_comptable_comptes';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'account_number', 'classe_id', 'compte_id', 'plan_comptable_id',
    ];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array<int, string>
     */
    protected $visible = [
        'account_number'
    ];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'intitule', 'classe_de_compte', 'classe_number', 'categorie_de_compte'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'account_number'    => 'string',
        'classe_id'         => 'string',
        'compte_id'         => 'string',
        'plan_comptable_id' => 'string'
    ];

    /**
     * The relationships that should always be loaded.
     *
     * @var array<int, string>
     */
    protected $with = [
        'sous_comptes'
    ];

    /**
     * Get intitule of the classe.
     *
     * @return string
     */
    public function getClasseDeCompteAttribute(): string
    {
        return $this->classe->intitule;
    }

    /**
     * Get intitule of the classe.
     *
     * @return string|int
     */
    public function getClasseNumberAttribute(): string|int
    {
        return $this->classe->class_number;
    }

    /**
     * Get attribute.
     *
     * @return string
     */
    public function getCategorieDeCompteAttribute(): string
    {
        return $this->compte->categorie_de_compte;
    }

    /**
     * Get the user's full name attribute.
     *
     * @return string The user's full name.
     */
    public function getIntituleAttribute(): string
    {
        return $this->compte->name;
    }

    /**
     * Get the plan_comptable of the salary of the work unit.
     *
     * @return BelongsTo
     */
    public function plan_comptable(): BelongsTo
    {
        return $this->belongsTo(PlanComptable::class, 'plan_comptable_id');
    }

    /**
     * Get the compte of the work unit for a poste
     *
     * @return BelongsTo
     */
    public function compte(): BelongsTo
    {
        return $this->belongsTo(Compte::class, 'compte_id');
    }

    /**
     * Get the classe of the account
     *
     * @return BelongsTo
     */
    public function classe(): BelongsTo
    {
        return $this->belongsTo(ClasseDeCompte::class, 'classe_id');
    }

    /**
     * Get sous comptes
     *
     * @return MorphMany
     */
    public function sous_comptes(): MorphMany
    {
        return $this->morphMany(SubAccount::class, 'subaccountable');
    }

    public function scopeSoldeDesComptes(Builder $query, string $exercice_comptable_id, string $start_date = null, string $end_date = null)
    {
        return $query->with("balance", function ($query) use ($exercice_comptable_id) {
            $query->where("exercice_comptable_id", $exercice_comptable_id);
        })->recursive($exercice_comptable_id);
    }

    public function scopeRecursive(Builder $query, string $exercice_comptable_id)
    {
        return $query->whereHas("sous_comptes", function ($query) use ($exercice_comptable_id) {
            $query->soldeDesComptes($exercice_comptable_id);
        });
    }

    public function scopeTransactions(Builder $query, $exercice_comptable_id)
    {
        return $query->with("transactions", function ($query) use ($exercice_comptable_id) {
            $query
                ->select("type_ecriture_compte", DB::raw('SUM(montant) as total')) // Specify the columns you want to select
                ->where("ligneable_type", "App\Models\Finances\EcritureComptable")
                ->whereHas("ligneable.exercice_comptable_journal", function ($ligne_query) use ($exercice_comptable_id) {
                    $ligne_query->where("exercice_comptable_id", $exercice_comptable_id);
                })->groupBy('type_ecriture_compte'); 
        })->recursiveTransactions($exercice_comptable_id);
    }

    public function scopeRecursiveTransactions(Builder $query, string $exercice_comptable_id)
    {
        return $query->whereHas("sous_comptes", function ($query) use ($exercice_comptable_id) {
                $query->transactions($exercice_comptable_id);
            });
    }
}
