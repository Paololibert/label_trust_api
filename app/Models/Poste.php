<?php

declare(strict_types=1);

namespace App\Models;

use Core\Data\Eloquent\Contract\ModelContract;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class ***`Poste`***
 *
 * This model represents the `postes` table in the database.
 * It extends the ModelContract class and provides access to the database table associated with the model.
 *
 * @property  string    $name;
 *
 * @package ***`\App\Models`***
 */
class Poste extends ModelContract
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
    protected $table = 'postes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'department_id',
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
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'name'              => 'string',
        'department_id'     => 'string'
    ];
    
    /**
     * The accessors to append to the model's array and JSON representation.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'departement_name',
    ];

    
    /**
     * The relationships that should always be loaded.
     *
     * @var array<int, string>
     */
    protected $with = [
        'salaryBase'
    ];

    /**
     * Get the Unit mesure of the unitTravaille.
     *
     * @return BelongsTo
     */
    public function departement(): BelongsTo
    {
        return $this->belongsTo(Departement::class, 'department_id');
    }

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
     * Get the user's full name attribute.
     *
     * @return string|null The user's full name.
     */
    public function getDepartementNameAttribute(): ?string
    {
        return $this->departement?->name ;
    }

    /**
     * Interact with the Poste's name.
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
    public function salaries(): BelongsToMany
    {
        return $this->belongsToMany(TauxAndSalary::class, 'poste_salaries', 'poste_id', 'salary_id')
                    ->withPivot('est_le_salaire_de_base', 'status', 'deleted_at', 'can_be_delete')
                    ->withTimestamps() // Enable automatic timestamps for the pivot table
                    ->wherePivot('status', true) // Filter records where the status is true
                    ->wherePivot('deleted_at', null) // Filter records where the deleted_at column is null
                    ->using(PosteSalary::class); // Specify the intermediate model for the pivot relationship
    }
   
    /**
     * Define a one-to-one relationship with the PosteSalary model representing the base salary.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOneThrough
     */
    public function salaryBase()
    {
        return $this->hasOne(PosteSalary::class, 'poste_id')
                    ->where('est_le_salaire_de_base', true)
                    ->where('status', true);
    }

    
 

}