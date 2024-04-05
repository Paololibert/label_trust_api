<?php

declare(strict_types=1);

namespace App\Models\Finances;

use Core\Data\Eloquent\Contract\ModelContract;
use Core\Utils\Enums\TypeCompteEnum;
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
 * @package ***`\App\Models\Finances`***
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
    protected $table = 'comptes';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code', 'name', 'type_de_compte', 'categorie_de_compte_id'
    ];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array<int, string>
     */
    protected $visible = [
        'code', 'name', 'type_de_compte'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'code'                          => 'string',
        'name'                          => 'string',
        'type_de_compte'                => TypeCompteEnum::class,
        'categorie_de_compte_id'        => 'string'
    ];

    /**
     * The model's default attribute values.
     *
     * @var array<string, mixed>
     */
    protected $attributes = [
        'type_de_compte'                => TypeCompteEnum::DEFAULT,
    ];

    /**
     * The accessors to append to the model's array and JSON representation.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'categorie_de_compte'
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

    public function getCategorieDeCompteAttribute(){
        return $this->categorie->name;
    }

    /**
     * 
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function plans_comptable(): BelongsToMany
    {
        return $this->belongsToMany(PlanComptable::class, 'plan_comptable_comptes', 'compte_id', 'plan_comptable_id')
                    ->withPivot('account_number', 'classe_id', 'status', 'deleted_at', 'can_be_delete')
                    ->withTimestamps() // Enable automatic timestamps for the pivot table
                    ->wherePivot('status', true) // Filter records where the status is true
                    ->using(Account::class); // Specify the intermediate model for the pivot relationship
    }

    /**
     * Define a many-to-many relationship with the Compte model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function sub_divisions(): BelongsToMany
    {
        return $this->belongsToMany(Compte::class, 'plan_comptable_compte_sous_comptes', 'account_id', 'sub_division_id')
                    ->withPivot('account_number', 'status', 'deleted_at', 'can_be_delete')
                    ->withTimestamps() // Enable automatic timestamps for the pivot table
                    ->wherePivot('status', true) // Filter records where the status is true
                    ->using(SubAccount::class); // Specify the intermediate model for the pivot relationship
    }
}