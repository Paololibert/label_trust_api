<?php

declare(strict_types=1);

namespace App\Models\Finances;

use Core\Data\Eloquent\Contract\ModelContract;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class ***`ExerciceComptableJournal`***
 *
 * This model represents the `journaux` table in the database.
 * It extends the ModelContract class and provides access to the database table associated with the model.
 *
 * @property  string    $name;
 *
 * @package ***`\App\Models\Finances`***
 */
class ExerciceComptableJournal extends ModelContract
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
    protected $table = 'exercice_comptable_journaux';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'total', 'total_debit', 'total_credit', 'exercice_comptable_id', 'journal_id'
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
        'exercice_comptable_id'         => 'string',
        'journal_id'                    => 'string'
    ];

    /**
     * Get the exercice_comptable
     *
     * @return BelongsTo
     */
    public function exercice_comptable(): BelongsTo
    {
        return $this->belongsTo(ExerciceComptable::class, 'exercice_comptable_id');
    }

    /**
     * Get the journal
     *
     * @return BelongsTo
     */
    public function journal(): BelongsTo
    {
        return $this->belongsTo(ExerciceComptable::class, 'journal_id');
    }

    /**
     * 
     *
     * @return HasMany
     */
    public function ecritures_comptable(): HasMany
    {
        return $this->hasMany(EcritureComptable::class, 'exercice_comptable_journal_id');
    }
}