<?php

declare(strict_types=1);

namespace App\Models\Finances;

use Core\Data\Eloquent\Contract\ModelContract;
use Core\Data\Eloquent\ORMs\Ligneable;
use Core\Utils\Enums\StatusOperationDisponibleEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class ***`OperationComptableDisponible`***
 *
 * This model represents the `operations_comptable` table in the database.
 * It extends the ModelContract class and provides access to the database table associated with the model.
 *
 * @property  string    $name;
 *
 * @package ***`\App\Models\Finances`***
 */
class OperationComptableDisponible extends ModelContract
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
    protected $table = 'operations_comptable';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "libelle", "total_debit", "total_credit", "date_ecriture", "exercice_comptable_id", "status_operation"
    ];

    /**
     * The attributes that should be treated as dates.
     *
     * @var array<int, string>
     */
    protected $dates = [
        "date_ecriture"
    ];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array<int, string>
     */
    protected $visible = [
        "libelle", "total_debit", "total_credit", "date_ecriture", "status_operation"
    ];

    /**
     * The model's default attribute values.
     *
     * @var array<string, mixed>
     */
    protected $attributes = [
        'total_debit'   => 0.00,
        'total_credit'  => 0.00,
        "status_operation" => StatusOperationDisponibleEnum::DEFAULT,
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        "libelle"                => "string",
        "total_debit"            => "decimal:2",
        "total_credit"           => "decimal:2",
        "date_ecriture"          => "datetime",
        "exercice_comptable_id"  => "string",
        "status_operation"       => StatusOperationDisponibleEnum::class
    ];

    /**
     * The relationships that should always be loaded.
     *
     * @var array<int, string>
     */
    protected $with = [
        'lignes_ecriture'
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
     * Ecritures comptable
     *
     * @return BelongsTo
     */
    public function ecritures_comptable(): HasMany
    {
        return $this->hasMany(EcritureComptable::class, 'operation_disponible_id');
    }

    /**
     * Get the exercice comptable
     *
     * @return BelongsTo
     */
    public function exercice_comptable(): BelongsTo
    {
        return $this->belongsTo(ExerciceComptable::class, 'exercice_comptable_id');
    }

    public function exercice_comptable_journal(){
        return $this->belongsTo(ExerciceComptable::class, 'exercice_comptable_id');
    }
}