<?php

declare(strict_types=1);

namespace App\Models\Finances;

use Core\Data\Eloquent\Contract\ModelContract;
use Core\Data\Eloquent\ORMs\Ligneable;
use Core\Utils\Enums\StatusOperationDisponibleEnum;

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
        'libelle', 'total_debit', 'total_credit', 'date_ecriture', 'status_operation'
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
        'libelle', 'total_debit', 'total_credit', 'date_ecriture', 'status_operation'
    ];

    /**
     * The model's default attribute values.
     *
     * @var array<string, mixed>
     */
    protected $attributes = [
        'status_operation' => StatusOperationDisponibleEnum::DEFAULT,
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'libelle'                => 'string',
        'total_debit'            => 'decimal:2',
        'total_credit'           => 'decimal:2',
        'date_ecriture'          => 'datetime',
        'status_operation'       => StatusOperationDisponibleEnum::class
    ];
}