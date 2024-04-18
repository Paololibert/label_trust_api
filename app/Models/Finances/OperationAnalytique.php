<?php

declare(strict_types=1);

namespace App\Models\Finances;

use Core\Data\Eloquent\Contract\ModelContract;
use Core\Data\Eloquent\ORMs\Ligneable;
use Core\Utils\Enums\StatusOperationDisponibleEnum;
use Core\Utils\Enums\TypeEcritureCompteEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * Class ***`OperationAnalytique`***
 *
 * This model represents the `operations_analytique` table in the database.
 * It extends the ModelContract class and provides access to the database table associated with the model.
 *
 * @property  string    $name;
 *
 * @package ***`\App\Models\Finances`***
 */
class OperationAnalytique extends ModelContract
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
    protected $table = "operations_analytique";
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "libelle", "montant", "type_ecriture_compte", "date_ecriture", "status_operation", "exercice_comptable_id", "accountable_id", "accountable_type"
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
        "libelle", "montant", "type_ecriture_compte", "date_ecriture", "status_operation"
    ];

    /**
     * The model's default attribute values.
     *
     * @var array<string, mixed>
     */
    protected $attributes = [
        "type_ecriture_compte"  => TypeEcritureCompteEnum::DEFAULT,
        "status_operation"      => StatusOperationDisponibleEnum::DEFAULT,
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        "libelle"                => "string",
        "montant"                => "decimal:2",
        "accountable_id"         => "string",
        "accountable_type"       => "string",
        "date_ecriture"          => "datetime:Y-m-d H:i:s",
        "exercice_comptable_id"  => "string",
        "type_ecriture_compte"   => TypeEcritureCompteEnum::class,
        "status_operation"       => StatusOperationDisponibleEnum::class
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
     * Get the exercice comptable
     *
     * @return BelongsTo
     */
    public function exercice_comptable(): BelongsTo
    {
        return $this->belongsTo(ExerciceComptable::class, 'exercice_comptable_id');
    }
}