<?php

declare(strict_types=1);

namespace App\Models;

use Core\Data\Eloquent\Contract\ModelContract;
use Core\Utils\Enums\TypeUniteTravailleEnum;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class UniteTravaille
 *
 * This model represents the `unite_travailles` table in the database.
 * It extends the ModelContract class and provides access to the database table associated with the model.
 *
 * @property TypeUniteTravailleEnum     $type_of_unite_travaille - The type of unite travaille, using the `TypeUniteTravailleEnum` enumeration.
 * @property string                     $unite_mesure_id         - The ID of the associated unit of measure.
 * @property string|null                $article_id              - The ID of the associated article (nullable).
 * @property string                     $unite_mesure_symbol     - Accessor for the symbol of the associated unit of measure.
 *
 * @package \App\Models
 */
class UniteTravaille extends ModelContract
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
    protected $table = 'unite_travailles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'type_of_unite_travaille',
        'unite_mesure_id',
        'article_id'
    ];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array<int, string>
     */
    protected $visible = [
        'type_of_unite_travaille',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'type_of_unite_travaille'   => TypeUniteTravailleEnum::class,
        'unite_mesure_id'           => 'string',
        'article_id'                => 'string',
    ];
    
    /**
     * The accessors to append to the model's array and JSON representation.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'unite_mesure_symbol'
    ];

    /**
     * The relationships that should always be loaded.
     *
     * @var array<int, string>
     */
    protected $with = [
        'taux'
    ];

    /**
     * Get the Unit mesure of the unitTravaille.
     *
     * @return BelongsTo
     */
    public function uniteMesure(): BelongsTo
    {
        return $this->belongsTo(UniteMesure::class, 'unite_mesure_id');
    }

    /**
     * Get the user's full name attribute.
     *
     * @return string|null The user's full name.
     */
    public function getUniteMesureSymbolAttribute(): ?string
    {
        return $this->uniteMesure?->symbol ;
    }

    /**
     * Get the Unit mesure of the unitTravaille.
     *
     * @return BelongsTo|null
     */
    public function article(): ?BelongsTo
    {
        return $this->belongsTo(Article::class, 'article_id');
    }

    /**
     * Define a many-to-many relationship with the Montant model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function montants(): BelongsToMany
    {
        return $this->belongsToMany(Montant::class, 'taux_and_salaries', 'unite_travaille_id', 'montant_id')
                    ->as('taux') // Set the alias for the pivot relationship
                    ->withPivot('hint', 'unite_mesure_id', 'status', 'deleted_at', 'can_be_delete')
                    ->withTimestamps() // Enable automatic timestamps for the pivot table
                    ->wherePivot('status', true) // Filter records where the status is true
                    ->wherePivot('deleted_at', null) // Filter records where the deleted_at column is null
                    ->using(TauxAndSalary::class); // Specify the intermediate model for the pivot relationship
    }

    /**
     * Define a one-to-many relationship with the TauxAndSalary model, representing the rates associated with this work unit.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function taux(): HasMany
    {
        return $this->hasMany(TauxAndSalary::class, 'unite_travaille_id')
                    ->where('status', true) // Filter rates with active status
                    ->whereNull('deleted_at') // Exclude deleted rates
                    ->latest(); // Order by the latest created_at timestamp
    }

}