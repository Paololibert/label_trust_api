<?php

declare(strict_types=1);

namespace App\Models\Finances;

use Core\Data\Eloquent\Contract\ModelContract;
use Core\Utils\Enums\StatusExerciceEnum;
use Core\Utils\Exceptions\ApplicationException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\countOf;

/**
 * Class ***`ExerciceComptable`***
 *
 * This model represents the `exercices_comptable` table in the database.
 * It extends the ModelContract class and provides access to the database table associated with the model.
 *
 * @property  string    $name;
 *
 * @package ***`\App\Models\Finances`***
 */
class ExerciceComptable extends ModelContract
{
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
    protected $table = 'exercices_comptable';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'fiscal_year', 'date_ouverture', 'date_fermeture', 'status_exercice', 'periode_exercice_id', 'plan_comptable_id'
    ];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array<int, string>
     */
    protected $visible = [
        'fiscal_year', 'date_ouverture', 'date_fermeture', 'status_exercice'
    ];

    /**
     * The attributes that should be treated as dates.
     *
     * @var array<int, string>
     */
    protected $dates = [
        'date_ouverture', 'date_fermeture'
    ];


    /**
     * The model's default attribute values.
     *
     * @var array<string, mixed>
     */
    protected $attributes = [
        'date_fermeture' => NULL,
        'status_exercice' => StatusExerciceEnum::DEFAULT,
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'fiscal_year'               => 'string',
        'periode_exercice_id'       => 'string',
        'plan_comptable_id'         => 'string',
        'date_ouverture'            => 'datetime:Y-m-d',
        'date_fermeture'            => 'datetime:Y-m-d',
        'status_exercice'           => StatusExerciceEnum::class
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted(): void
    {
        static::observe(\App\Observers\ExerciceComptableObserver::class);
    }

    public function getUnmodifiableAttributes()
    {
        return [
            "date_ouverture"/* , "date_fermeture" */
        ];
    }

    public function getConditionallyUpdatableAttributes(): array
    {
        return [
            'date_fermeture'
        ];
    }

    /**
     * Get the plan_comptable
     *
     * @return BelongsTo
     */
    public function plan_comptable(): BelongsTo
    {
        return $this->belongsTo(PlanComptable::class, 'plan_comptable_id');
    }

    /**
     * Get the periode_exercice of the work unit for a poste
     *
     * @return BelongsTo
     */
    public function periode_exercice(): BelongsTo
    {
        return $this->belongsTo(PeriodeExercice::class, 'periode_exercice_id');
    }

    /**
     * Get the balance des comptes
     *
     * @return HasMany
     */
    public function balances(): HasMany
    {
        return $this->hasMany(BalanceDeCompte::class, 'exercice_comptable_id');
    }

    /**
     * Define a many-to-many relationship with the Journal model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function journaux(): BelongsToMany
    {
        return $this->belongsToMany(Journal::class, 'exercice_comptable_journaux', 'journal_id', 'exercice_comptable_id')
            ->withPivot('status', 'deleted_at', 'can_be_delete')
            ->withTimestamps() // Enable automatic timestamps for the pivot table
            ->wherePivot('status', true) // Filter records where the status is true
            ->using(ExerciceComptableJournal::class); // Specify the intermediate model for the pivot relationship
    }

    /**
     * 
     *
     * @return HasManyThrough
     */
    public function ecritures_comptable(): HasManyThrough
    {
        return $this->hasManyThrough(EcritureComptable::class, ExerciceComptableJournal::class);
    }

    /**
     * Define a method to access the accounts associated with the Exercice through its PlanComptable.
     *
     * @return
     */
    public function accounts()
    {
        return $this->plan_comptable->accounts();
    }

    /**
     * Define a method to access the sub_accounts associated with the Exercice through its PlanComptable.
     * @param \Illuminate\Database\Eloquent\Relations\Relation|\Illuminate\Database\Eloquent\Builder|null $query
     * @return
     */
    public function sub_accounts($query = null, bool $withSubDivision = false, $columns = ["*"])
    {
        return $this->plan_comptable->sub_accounts(query: $query, withSubDivision: $withSubDivision, columns: $columns);
    }

    /**
     * Define a method to access the sub_accounts associated with the Exercice through its PlanComptable.
     *
     * @param \Illuminate\Database\Eloquent\Relations\Relation|\Illuminate\Database\Eloquent\Builder|null $query
     * 
     * @return
     */
    public function sub_divisions($query = null)
    {
        return $this->plan_comptable->sub_divisions($query);
    }

    /**
     * Get the balance des comptes
     *
     * @return HasMany
     */
    public function balance_des_comptes(): HasMany
    {
        return $this->accounts()->with("balance");
    }

}
