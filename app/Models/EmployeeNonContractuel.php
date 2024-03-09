<?php

declare(strict_types=1);

namespace App\Models;

use Core\Data\Eloquent\Contract\ModelContract;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class ***`EmployeeNonContractuel`***
 *
 * This model represents the `employee_non_contractuels` table in the database.
 * It extends the ModelContract class and provides access to the database table associated with the model.
 *
 * @property  string    $name;
 *
 * @package ***`\App\Models`***
 */
class EmployeeNonContractuel extends ModelContract
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
    protected $table = 'employee_non_contractuels';


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'est_convertir','categories_of_employee_id'
    ];

    /**
     * The model's default attribute values.
     *
     * @var array<string, mixed>
     */
    protected $attributes = [
        'est_convertir'                 =>false,
    ];


    /**
     * The attributes that should be visible in arrays.
     *
     * @var array<int, string>
     */
    protected $visible = [

    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'est_convertir'                 =>'boolean',
        'categories_of_employee_id'     =>'string'
    ];

    /**
     * Define a many-to-many relationship with the CategorieOfEmployee model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(CategorieOfEmployee::class, 'noncontractuelcategories', 'employee_non_contractuel_id', 'categorie_of_employee_id')
                    ->withPivot('date_debut', 'date_fin')
                    ->withTimestamps()
                    ->using(NonContractuelCategorie::class); // Enable automatic timestamps for the pivot table
    }


}