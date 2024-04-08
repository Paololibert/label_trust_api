<?php

namespace App\Models;

use Core\Data\Eloquent\Contract\ModelContract;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Concerns\AsPivot;

/**
 * Class CategoryOfEmployeeTaux
 *
 * This model represents the `category_of_employee_taux` pivot table in the database, serving as an intermediary for the relationship
 * between categories of employees and rates (TauxAndSalary). It extends the ModelContract class and uses the AsPivot trait.
 *
 * @property boolean                    $est_le_taux_de_base     Indicates whether this rate is the base rate for the associated category.
 * @property string                     $category_of_employee_id    The ID of the associated category of employees.
 * @property string                     $taux_id                 The ID of the associated rate (TauxAndSalary).
 *
 * @property-read CategoryOfEmployee     $category                Relationship: Get the category of the rate of the work unit.
 * @property-read TauxAndSalary         $taux                    Relationship: Get the rate of the work unit for a category of employees.
 *
 * @package App\Models
 */
class CategoryOfEmployeeTaux extends ModelContract
{
    use AsPivot;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'category_taux';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'est_le_taux_de_base',
        'category_of_employee_id',
        'taux_id'
    ];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array<int, string>
     */
    protected $visible = [
        'est_le_taux_de_base'
    ];

    /**
     * The model's default attribute values.
     *
     * @var array<string, mixed>
     */
    protected $attributes = [
        'est_le_taux_de_base'        => false,
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'est_le_taux_de_base'       => 'boolean',
        'category_of_employee_id'   => 'string',
        'taux_id'                   => 'string'
    ];

    /**
     * Get the category of the rate of the work unit.
     *
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(CategoryOfEmployee::class, 'category_of_employee_id');
    }

    /**
     * Get the rate of the work unit for a category of employees
     *
     * @return BelongsTo
     */
    public function taux(): BelongsTo
    {
        return $this->belongsTo(TauxAndSalary::class, 'taux_id');
    }

    
    
}