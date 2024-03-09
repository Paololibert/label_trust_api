<?php

declare(strict_types=1);

namespace App\Models;

use Core\Data\Eloquent\Contract\ModelContract;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * Class ***`BalanceDeCompte`***
 *
 * This model represents the `balance_des_comptes` table in the database.
 * It extends the ModelContract class and provides access to the database table associated with the model.
 *
 * @property  string    $name;
 *
 * @package ***`\App\Models`***
 */
class BalanceDeCompte extends ModelContract
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
    protected $table = 'balance_des_comptes';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'solde_debit', 'solde_credit', 'date_report', 'date_cloture', 'exercice_comptable_id', 'balanceable_id', 'balanceable_type'
    ];

    /**
     * The model's default attribute values.
     *
     * @var array<string, mixed>
     */
    protected $attributes = [
        'date_cloture' => NULL
    ];

    /**
     * The attributes that should be treated as dates.
     *
     * @var array<int, string>
     */
    protected $dates = [
        'date_cloture', 'date_report'
    ];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array<int, string>
     */
    protected $visible = [
        'solde_debit', 'solde_credit', 'date_report', 'date_cloture'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'solde_debit'                   => 'decimal:2',
        'solde_credit'                  => 'decimal:2',
        'date_report'                   => 'datetime',
        'date_cloture'                  => 'datetime',
        'balanceable_id'                => 'string',
        'balanceable_type'              => 'string',
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
    
    /**
     * Get the user details.
     *
     * @return MorphTo
     */
    public function balanceable(): MorphTo
    {
        return $this->morphTo();
    }
}