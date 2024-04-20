<?php

declare(strict_types=1);

namespace App\Models\Finances;

use Core\Data\Eloquent\Contract\ModelContract;
use Core\Utils\Enums\TypeEcritureCompteEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * Class ***`EcritureAnalytique`***
 *
 * This model represents the `ecritures_analytique` table in the database.
 * It extends the ModelContract class and provides access to the database table associated with the model.
 *
 * @property  string    $name;
 *
 * @package ***`\App\Models\Finances`***
 */
class EcritureAnalytique extends ModelContract
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
    protected $table = 'ecritures_analytique';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'libelle', 'montant', 'type_ecriture_compte', 'date_ecriture', 'projet_production_id', 'exercice_comptable_journal_id', 'operation_disponible_id', 'accountable_id', 'accountable_type'
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
        'libelle', 'montant', 'type_ecriture_compte', 'date_ecriture'
    ];

    /**
     * The model's default attribute values.
     *
     * @var array<string, mixed>
     */
    protected $attributes = [
        'type_ecriture_compte'   => TypeEcritureCompteEnum::DEFAULT
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'libelle'                           => 'string',
        'montant'                           => 'decimal:2',
        'accountable_id'                    => 'string',
        'accountable_type'                  => 'string',
        'type_ecriture_compte'              => TypeEcritureCompteEnum::class,
        'date_ecriture'                     => 'datetime:Y-m-d',
        'exercice_comptable_journal_id'     => 'string',
        'operation_disponible_id'           => 'string',
        'projet_production_id'              => 'string'
    ];

    /**
     * Interact with the Compte's name.
     */
    protected function date_ecriture(): Attribute
    {
        return Attribute::make(
            set: function (string $value) {
                $this->date_ecriture = \Carbon\Carbon::createFromFormat("Y-m-d", $value)->format('Y-m-d H:i:s');
            }
        );
    }
    
    /**
     * Get the account details.
     *
     * @return MorphTo
     */
    public function accountable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the ecriture journal
     *
     * @return BelongsTo
     */
    public function exercice_comptable_journal(): BelongsTo
    {
        return $this->belongsTo(ExerciceComptableJournal::class, 'exercice_comptable_journal_id');
    }

    /**
     * Get the projet
     *
     * @return BelongsTo
     */
    public function projet_production(): BelongsTo
    {
        return $this->belongsTo(ProjetProduction::class, 'projet_production_id');
    }


    /**
     * Get the operation_disponile
     *
     * @return BelongsTo|null
     */
    public function operation_analytique(): ?BelongsTo
    {
        return $this->belongsTo(OperationAnalytique::class, 'operation_disponible_id');
    }
}
