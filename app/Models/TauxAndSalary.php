<?php

declare(strict_types=1);

namespace App\Models;

use Core\Data\Eloquent\Contract\ModelContract;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\Concerns\AsPivot;

/**
 * Class TauxAndSalary
 *
 * This model represents the `taux_and_salaries` table in the database, serving as a pivot for managing rates and salaries.
 * It extends the ModelContract class and uses the AsPivot trait.
 *
 * @property decimal                    $hint                     The hint value associated with the rate.
 * @property string                     $montant_id               The ID of the associated rate amount (Montant).
 * @property string                     $unite_mesure_id          The ID of the associated rate measure unit (UniteMesure).
 * @property string                     $unite_travaille_id       The ID of the associated work unit (UniteTravaille).
 *
 * @property-read Montant               $montant                  Relationship: Get the rate amount of the work unit.
 * @property-read string                $rate                     Accessor: Get the rate amount value of the work unit attribute.
 * @property-read UniteMesure           $unite_mesure             Relationship: Get the measure unit of the rate amount.
 * @property-read string                $rate_measure_unit_symbol Accessor: Get the rate measure unit symbol.
 * @property-read UniteTravaille        $unite_travaille          Relationship: Get the work unit details.
 * @property-read array                 $work_unit                Accessor: Get the details of the work unit.
 *
 * @package App\Models
 */
class TauxAndSalary extends ModelContract
{
    use AsPivot;
    
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
    protected $table = 'taux_and_salaries';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'hint',
        'montant_id',
        'unite_mesure_id',
        'unite_travaille_id'
    ];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array<int, string>
     */
    protected $visible = [
        'hint'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'hint'                      => 'decimal:2',
        'unite_travaille_id'        => 'string',
        'montant_id'                => 'string',
        'unite_mesure_id'           => 'string'
    ];
    
    /**
     * The accessors to append to the model's array and JSON representation.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'rate',
        'rate_measure_unit_symbol',
        'work_unit'
    ];

    /**
     * Get the rate amount of the work unit.
     *
     * @return BelongsTo
     */
    public function montant(): BelongsTo
    {
        return $this->belongsTo(Montant::class, 'montant_id');
    }

    /**
     * Get the rate amount value of the work unit attribute.
     *
     * @return string The rate amount value.
     */
    public function getRateAttribute(): string
    {
        return $this->montant->montant;
    }

    /**
     * Get the measure unit of the rate amount.
     *
     * @return BelongsTo
     */
    public function unite_mesure(): BelongsTo
    {
        return $this->belongsTo(UniteMesure::class, 'unite_mesure_id');
    }

    /**
     * Get the rate measure unit attribute.
     *
     * @return string The rate amount measure unit symbole.
     */
    public function getRateMeasureUnitSymbolAttribute(): string
    {
        return $this->unite_mesure->symbol;
    }

    /**
     * Get the work unit.
     *
     * @return BelongsTo
     */
    public function unite_travaille(): BelongsTo
    {
        return $this->belongsTo(UniteTravaille::class, 'unite_travaille_id');
    }

    /**
     * Get the work unit details attribute.
     *
     * @return array The details of work unit.
     */
    public function getWorkUnitAttribute(): array
    {
        return [
                "type" => $this->unite_travaille->type_of_unite_travaille,
                "symbol" => $this->unite_travaille->uniteMesure?->symbol
            ];
    }

    /**
     * Define a many-to-many relationship with the CategoryOfEmployee model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories_of_employees(): BelongsToMany
    {
        return $this->belongsToMany(CategoryOfEmployee::class, 'category_of_employee_taux', 'taux_id', 'category_of_employee_id')
                    ->withPivot('est_le_taux_de_base', 'status', 'deleted_at', 'can_be_delete')
                    ->withTimestamps() // Enable automatic timestamps for the pivot table
                    ->wherePivot('status', true) // Filter records where the status is true
                    ->wherePivot('deleted_at', null) // Filter records where the deleted_at column is null
                    ->using(CategoryOfEmployeeTaux::class); // Specify the intermediate model for the pivot relationship
    }

    /**
     * Define a many-to-many relationship with the Poste model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function postes(): BelongsToMany
    {
        return $this->belongsToMany(Poste::class, 'poste_salaries', 'salary_id', 'poste_id')
                    ->withPivot('est_le_salaire_de_base', 'status', 'deleted_at', 'can_be_delete')
                    ->withTimestamps() // Enable automatic timestamps for the pivot table
                    ->wherePivot('status', true) // Filter records where the status is true
                    ->wherePivot('deleted_at', null) // Filter records where the deleted_at column is null
                    ->using(PosteSalary::class); // Specify the intermediate model for the pivot relationship
    }
}