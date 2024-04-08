<?php

namespace App\Models;

use Core\Data\Eloquent\Contract\ModelContract;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Concerns\AsPivot;

/**
 * Class PosteSalary
 *
 * This model represents the `poste_salaries` pivot table in the database, serving as an intermediary for the relationship
 * between job positions (Poste) and salaries (TauxAndSalary). It extends the ModelContract class and uses the AsPivot trait.
 *
 * @property      boolean                    $est_le_salaire_de_base  Indicates whether this salary is the base salary for the associated job position.
 * @property      string                     $poste_id                The ID of the associated job position.
 * @property      string                     $salary_id               The ID of the associated salary (TauxAndSalary).
 *
 * @property-read Poste                      $poste                   Relationship: Get the job position of the salary of the work unit.
 * @property-read TauxAndSalary              $salary                  Relationship: Get the salary of the work unit for a job position.
 *
 * @package App\Models
 */
class PosteSalary extends ModelContract
{
    use AsPivot;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'poste_salaries';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'est_le_salaire_de_base',
        'poste_id',
        'salary_id'
    ];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array<int, string>
     */
    protected $visible = [
        'est_le_salaire_de_base'
    ];

    
    /**
     * The accessors to append to the model's array and JSON representation.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'base_salary'
    ];
    /**
     * The model's default attribute values.
     *
     * @var array<string, mixed>
     */
   /*  protected $attributes = [
        'est_le_salaire_de_base'        => false,
    ]; */

    
    /**
     * Get the base salary attribute.
     *
     * @return string|null The base salary.
     */
    public function getBaseSalaryAttribute(): ?string
    {
        return $this->salary?->rate ;
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'est_le_salaire_de_base'    => 'boolean',
        'poste_id'                  => 'string',
        'salary_id'                 => 'string'
    ];

    /**
     * Get the poste of the salary of the work unit.
     *
     * @return BelongsTo
     */
    public function poste(): BelongsTo
    {
        return $this->belongsTo(Poste::class, 'poste_id');
    }

    /**
     * Get the salary of the work unit for a poste
     *
     * @return BelongsTo
     */
    public function salary(): BelongsTo
    {
        return $this->belongsTo(TauxAndSalary::class, 'salary_id');
    }

}