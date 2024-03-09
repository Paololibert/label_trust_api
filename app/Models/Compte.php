<?php

declare(strict_types=1);

namespace App\Models;

use Core\Data\Eloquent\Contract\ModelContract;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class ***`Compte`***
 *
 * This model represents the `categories_de_compte` table in the database.
 * It extends the ModelContract class and provides access to the database table associated with the model.
 *
 * @property  string    $name;
 *
 * @package ***`\App\Models`***
 */
class Compte extends ModelContract
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
    protected $table = 'categories_de_compte';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code', 'name'
    ];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array<int, string>
     */
    protected $visible = [
        'code', 'name',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'code'         => 'string',
        'name'         => 'string'
    ];
    
    /**
     * Interact with the Compte's name.
     */
    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => ucfirst($value),
            set: fn (string $value) => strtolower($value)
        );
    }

    /**
     * Get the categorie of the work unit for a poste
     *
     * @return BelongsTo
     */
    public function categorie(): BelongsTo
    {
        return $this->belongsTo(CategorieDeCompte::class, 'categorie_de_compte_id');
    }

    /**
     * 
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function plans_comptable(): BelongsToMany
    {
        return $this->belongsToMany(PlanComptable::class, 'plan_comptable_comptes', 'compte_id', 'plan_comptable_id')
                    ->withPivot('classe_id', 'status', 'deleted_at', 'can_be_delete')
                    ->withTimestamps() // Enable automatic timestamps for the pivot table
                    ->wherePivot('status', true) // Filter records where the status is true
                    ->using(Account::class); // Specify the intermediate model for the pivot relationship
    }

    /**
     * Define a many-to-many relationship with the Compte model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function sous_comptes(): BelongsToMany
    {
        return $this->belongsToMany(Compte::class, 'plan_comptable_compte_sous_comptes', 'plan_comptable_compte_id', 'sous_compte_id')
                    ->withPivot('status', 'deleted_at', 'can_be_delete')
                    ->withTimestamps() // Enable automatic timestamps for the pivot table
                    ->wherePivot('status', true) // Filter records where the status is true
                    ->using(SubAccount::class); // Specify the intermediate model for the pivot relationship
    }
}