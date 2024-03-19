<?php

declare(strict_types=1);

namespace App\Models;

use Core\Data\Eloquent\Contract\ModelContract;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class ***`CategoryOfEmployee`***
 *
 * This model represents the `categories_of_employees` table in the database.
 * It extends the ModelContract class and provides access to the database table associated with the model.
 *
 * @property  string    $name;
 *
 * @package ***`\App\Models`***
 */
class CategoryOfEmployee extends ModelContract
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
    protected $table = 'categories_of_employees';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'category_id',
    ];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array<int, string>
     */
    protected $visible = [
        'name'
    ];

    /**
     * Get the Unit mesure of the unitTravaille.
     *
     * @return BelongsTo|null
     */
    public function categoryOfEmployees(): ?BelongsTo
    {
        return $this->belongsTo(CategoryOfEmployee::class, 'category_id');
    }

    /**
     * Interact with the CategoryOfEmployee's name.
     */
    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => ucfirst($value),
            set: fn (string $value) => strtolower($value)
        );
    }

    /**
     * Define a many-to-many relationship with the TauxAndSalary model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function taux(): BelongsToMany
    {
        return $this->belongsToMany(TauxAndSalary::class, 'category_of_employee_taux', 'category_of_employee_id', 'category_of_employee_taux_id')
                    ->withPivot('est_le_taux_de_base', 'status', 'deleted_at', 'can_be_delete')
                    ->withTimestamps() // Enable automatic timestamps for the pivot table
                    ->wherePivot('status', true) // Filter records where the status is true
                    ->wherePivot('deleted_at', null) // Filter records where the deleted_at column is null
                    ->using(CategoryOfEmployeeTaux::class); // Specify the intermediate model for the pivot relationship
    }

  
    /**
     * Define a many-to-many relationship with the EmployeeNonContractuel model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    /* public function employees(): BelongsToMany
    {
        return $this->belongsToMany(EmployeeNonContractuel::class, 'noncontractuelcategories', 'categorie_of_employee_id', 'employee_non_contractuel_id')
                    ->withPivot('date_debut', 'date_fin')
                    ->withTimestamps(); // Enable automatic timestamps for the pivot table
    } */

    
    public function employees()
    {
        return $this->belongsToMany(EmployeeNonContractuel::class,'employee_non_contractuel_categories','category_of_employee_id','employee_non_contractuel_id') 
                            ->withPivot('date_debut', 'category_of_employee_taux_id') //
                            ->withTimestamps();
    }
    

    /* public function employeenoncontractuels()
    {
        return $this->belongsToMany(EmployeeNonContractuel::class, 'non_contractuel_categories', 'category_of_employee_id', 'employee_non_contractuel_id')
                    ->withPivot('date_debut', 'date_fin', 'category_of_employee_taux_id')
                    ->withTimestamps()
                    ->using(NonContractuelCategorie::class);
    } */
}