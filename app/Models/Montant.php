<?php

declare(strict_types=1);

namespace App\Models;

use Core\Data\Eloquent\Contract\ModelContract;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class ***`Montant`***
 *
 * This model represents the `Montants` table in the database.
 * It extends the ModelContract class and provides access to the database table associated with the model.
 *
 * @property  string    $montant;
 *
 * @package ***`\App\Models`***
 */
class Montant extends ModelContract
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'montants';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'montant',
    ];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array<int, string>
     */
    protected $visible = [
        'montant'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'montant'       => 'decimal:2'
    ];

    /**
     * Define a many-to-many relationship with the Montant model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function unite_travailles(): BelongsToMany
    {
        return $this->belongsToMany(UniteTravaille::class, 'taux_and_salaries', 'montant_id', 'unite_travaille_id')
                    ->withPivot('hint', 'unite_mesure_id', 'status', 'deleted_at', 'can_be_delete')
                    ->withTimestamps() // Enable automatic timestamps for the pivot table
                    ->wherePivot('status', true) // Filter records where the status is true
                    ->wherePivot('deleted_at', null) // Filter records where the deleted_at column is null
                    ->using(TauxAndSalary::class); // Specify the intermediate model for the pivot relationship
    }
}