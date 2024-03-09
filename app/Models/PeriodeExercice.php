<?php

declare(strict_types=1);

namespace App\Models;

use Core\Data\Eloquent\Contract\ModelContract;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class ***`PeriodeExercice`***
 *
 * This model represents the `periodes_exercice` table in the database.
 * It extends the ModelContract class and provides access to the database table associated with the model.
 *
 * @property  string    $name;
 *
 * @package ***`\App\Models`***
 */
class PeriodeExercice extends ModelContract
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
    protected $table = 'periodes_exercice';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'date_debut_periode', 'date_fin_periode'
    ];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array<int, string>
     */
    protected $visible = [
        'name', 'date_debut_periode', 'date_fin_periode'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'name'                  => 'string',
        'date_debut_periode'    => 'date:d/m',
        'date_fin_periode'      => 'date:d/m'
    ];
    
    /**
     * Interact with the PeriodeExercice's name.
     */
    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => ucfirst($value),
            set: fn (string $value) => strtolower($value)
        );
    }

    /**
     *
     *
     * @return HasMany
     */
    public function exercices_comptable(): HasMany
    {
        return $this->hasMany(ExerciceComptable::class, 'periode_exercice_id');
    }
}