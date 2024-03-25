<?php

declare(strict_types=1);

namespace App\Models\Finances;

use Core\Data\Eloquent\Contract\ModelContract;
use Core\Data\Eloquent\ORMs\Ligneable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class ***`EcritureComptable`***
 *
 * This model represents the `ecritures_comptable` table in the database.
 * It extends the ModelContract class and provides access to the database table associated with the model.
 *
 * @property  string    $name;
 *
 * @package ***`\App\Models\Finances`***
 */
class EcritureComptable extends ModelContract
{
    use Ligneable;
    
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
    protected $table = 'ecritures_comptable';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'libelle', 'total_debit', 'total_credit', 'date_ecriture', 'exercice_comptable_journal_id', 'operation_disponible_id'
    ];

    /**
     * The attributes that should be treated as dates.
     *
     * @var array<int, string>
     */
    protected $dates = [
        'date_ecriture'
    ];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array<int, string>
     */
    protected $visible = [
        'libelle', 'total_debit', 'total_credit', 'date_ecriture'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'libelle'                           => 'string',
        'total_debit'                       => 'decimal:2',
        'total_credit'                      => 'decimal:2',
        'date_ecriture'                     => 'datetime',
        'exercice_comptable_journal_id'     => 'string',
        'operation_disponible_id'           => 'string'
    ];

    /**
     * Get the ecriture journal of the work unit for a poste
     *
     * @return BelongsTo
     */
    public function exercice_comptable_journal(): BelongsTo
    {
        return $this->belongsTo(ExerciceComptableJournal::class, 'exercice_comptable_journal_id');
    }

    /**
     * Get the operation_disponile
     *
     * @return BelongsTo|null
     */
    public function operation_disponible(): ?BelongsTo
    {
        return $this->belongsTo(OperationComptableDisponible::class, 'operation_disponible_id');
    }
}