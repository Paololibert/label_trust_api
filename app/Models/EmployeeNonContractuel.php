<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Finances\EmployeeNonContractuelInvoice;
use Core\Data\Eloquent\Contract\ModelContract;
use Core\Data\Eloquent\ORMs\Contractuelable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

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
    //use Contractuelable;
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
        'est_convertir','category_of_employee_id'
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
        'category_of_employee_id'     =>'string'
    ];

    /**
     * The relationships that should always be loaded.
     *
     * @var array<int, string>
     */
    protected $with = [
        'categories'
    ];

    public function actual_category(){
        return $this->belongsTo(CategoryOfEmployee::class, "category_of_employee_id");
    }

    
    public function categories()
    {
        return $this->belongsToMany(CategoryOfEmployee::class,'employee_non_contractuel_categories','employee_non_contractuel_id','category_of_employee_id') 
                            ->withPivot('date_debut', 'category_of_employee_taux_id') //
                            ->withTimestamps();
    }
    
    
    /**
     * Define a many-to-many relationship with the CategorieOfEmployee model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */

     /* public function categories()
     {
         return $this->belongsToMany(CategoryOfEmployee::class, 'non_contractuel_categories', 'employee_non_contractuel_id', 'categorie_of_employee_id')
                     ->withPivot('date_debut', 'date_fin', 'taux_id')
                     ->withTimestamps()
                     ->using(NonContractuelCategorie::class);
     } */

    /**
     * Get all of the employee for the post.
     */
    public function employees()
    {
        return $this->morphToMany(Employee::class, 'newcontractable');
    }

    /**
     * Get the invoices
     *
     * @return HasMany
     */
    public function invoices(): HasMany
    {
        return $this->hasMany(EmployeeNonContractuelInvoice::class, 'employee_non_contractuel_id');
    }

}