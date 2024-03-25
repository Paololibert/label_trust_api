<?php

declare(strict_types=1);

namespace App\Models\Finances;

use Core\Data\Eloquent\Contract\ModelContract;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

/**
 * Class ***`Journal`***
 *
 * This model represents the `journaux` table in the database.
 * It extends the ModelContract class and provides access to the database table associated with the model.
 *
 * @property  string    $name;
 *
 * @package ***`\App\Models\Finances`***
 */
class Journal extends ModelContract
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
    protected $table = 'journaux';
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
        'code', 'name'
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
     * Define a many-to-many relationship with the Compte model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function exercices_comptable(): BelongsToMany
    {
        return $this->belongsToMany(ExerciceComptable::class, 'exercice_comptable_journaux', 'exercice_comptable_id', 'journal_id')
                    ->withPivot('status', 'deleted_at', 'can_be_delete')
                    ->withTimestamps() // Enable automatic timestamps for the pivot table
                    ->wherePivot('status', true) // Filter records where the status is true
                    ->using(ExerciceComptableJournal::class); // Specify the intermediate model for the pivot relationship
    }

    /**
     * 
     *
     * @return HasManyThrough
     */
    public function ecritures_comptable(): HasManyThrough
    {
        return $this->hasManyThrough(EcritureComptable::class, ExerciceComptableJournal::class);
    }
}