<?php

declare(strict_types=1);

namespace App\Models;

use Core\Data\Eloquent\Contract\ModelContract;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class ***`Journal`***
 *
 * This model represents the `journaux` table in the database.
 * It extends the ModelContract class and provides access to the database table associated with the model.
 *
 * @property  string    $name;
 *
 * @package ***`\App\Models`***
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
        'total', 'total_debit', 'total_credit', 'exercice_comptable_id'
    ];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array<int, string>
     */
    protected $visible = [
        'total', 'total_debit', 'total_credit'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'total'                         => 'decimal:2',
        'total_debit'                   => 'decimal:2',
        'total_credit'                  => 'decimal:2',
        'exercice_comptable_id'         => 'string'
    ];

    /**
     * Get the exercice_comptable of the work unit for a poste
     *
     * @return BelongsTo
     */
    public function exercice_comptable(): BelongsTo
    {
        return $this->belongsTo(ExerciceComptable::class, 'exercice_comptable_id');
    }
}