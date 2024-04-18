<?php

declare(strict_types=1);

namespace App\Models\Finances;

use Core\Data\Eloquent\Contract\ModelContract;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class ***`Ammortissement`***
 *
 * This model represents the `immobilisations` table in the database.
 * It extends the ModelContract class and provides access to the database table associated with the model.
 *
 * @property  string    $name;
 *
 * @package ***`\App\Models\Finances`***
 */
class Ammortissement extends ModelContract
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
    protected $table = "ammortissements";
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "montant", "date_debut", "date_fin", "annete", "taux", "valeur_ammortissable", 'valeur_comptable', 'immobilisation_id'
    ];

    /**
     * The attributes that should be treated as dates.
     *
     * @var array<int, string>
     */
    protected $dates = [
        "date_debut", "date_fin"
    ];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array<int, string>
     */
    protected $visible = [
        "montant", "date_debut", "date_fin", "annete", "taux", "valeur_ammortissable", 'valeur_comptable', 'immobilisation_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        "montant"                       => "decimal:2",
        "valeur_ammortissable"          => "decimal:2",
        "valeur_comptable"              => "decimal:2",
        "taux"                          => "decimal:2",
        "annete"                        => "integer",
        'date_debut'                    => 'datetime:Y-m-d',
        'date_fin'                      => 'datetime:Y-m-d',
        'immobilisation_id'             => 'string'
    ];

    /**
     * Get the immobilisation
     *
     * @return BelongsTo
     */
    public function immobilisation(): BelongsTo
    {
        return $this->belongsTo(Immobilisation::class, 'immobilisation_id');
    }
}