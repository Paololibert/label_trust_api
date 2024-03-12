<?php

declare(strict_types=1);

namespace App\Models;

use Core\Data\Eloquent\Contract\ModelContract;
use Core\Data\Eloquent\ORMs\Profilable;
use Core\Utils\Enums\StatutEmployeeEnum;
use Core\Utils\Enums\TypeEmployeeEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * Class ***`Employee`***
 *
 * This model represents the `employees` table in the database.
 * It extends the ModelContract class and provides access to the database table associated with the model.
 *
 * @property  string    $name;
 *
 * @package ***`\App\Models`***
 */
class Employee extends ModelContract
{
    use Profilable;
    
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
    protected $table = 'employees';


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'matricule','type_employee','statut_employee'
    ];

    /**
     * The model's default attribute values.
     *
     * @var array<string, mixed>
     */
    protected $attributes = [
        'type_employee'          => TypeEmployeeEnum::DEFAULT,
        'statut_employee'           => StatutEmployeeEnum::DEFAULT,
    ];


    /**
     * The attributes that should be visible in arrays.
     *
     * @var array<int, string>
     */
    protected $visible = [
        'matricule',
        'type_employee'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'matricule'             => 'string',
        'type_employee'         => TypeEmployeeEnum::class,
        'statut_employee'       => StatutEmployeeEnum::class,
    ];

    /**
     * The relationships that should always be loaded.
     *
     * @var array<int, string>
     */
    protected $with = [
        'employee_temporaire','user'
    ];

    /**
     * Interact with the Employee's name.
     */
    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => ucfirst($value),
            set: fn (string $value) => strtolower($value)
        );
    }


     /**
     * Get all of the posts that are assigned this tag.
     */
    public function employee_temporaire(): MorphToMany
    {
        return $this->morphedByMany(EmployeeNonContractuel::class, 'contractuelable');
    }

    /**
     * Get of the non_contractuel (temporaire) that is assigned this employee.
     */
    /* public function employee_temporaire(): MorphOne
    {
        return $this->morphedByOne(EmployeeNonContractuel::class, 'contractuelable');
    } */
    /*public function employee_temporaire()
    {
        return $this->morphedByMany(EmployeeNonContractuel::class, 'contractuelable', 'contractuelables', 'contractuelable_id', 'employee_id')
                    ->using(Contractuelable::class) ->wherePivot('actif', true) ; 
    }*/

       /**
     * Get of the non_contractuel (temporaire) that is assigned this employee.
     */
    /* public function employee_temporaire(): MorphOne
    {
        return $this->morphedByOne(EmployeeNonContractuel::class, 'contractuelable');
    } */
    /*public function employee_contractuel()
    {
        return $this->morphedByMany(EmployeeContractuel::class, 'contractuelable', 'contractuelables', 'contractuelable_id', 'employee_id')
                    ->using(Contractuelable::class) ->wherePivot('actif', true) ; 
    }*/
    
    public function employee_contractuel(): MorphToMany
    {
        return $this->morphedByMany(EmployeeContractuel::class, 'contractuelable');
    }

    /**
     * Get of the contractual that is assigned this tag.
     */
    /* public function employee_contractuel(): MorphOne
    {
        return $this->morphedByMany(EmployeeContractuel::class, 'contractuelable');
    } */
    
    
}