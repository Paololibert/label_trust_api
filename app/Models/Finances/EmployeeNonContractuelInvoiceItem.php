<?php

declare(strict_types=1);

namespace App\Models\Finances;

use App\Models\EmployeeNonContractuel;
use App\Models\UniteTravaille;
use Core\Data\Eloquent\Contract\ModelContract;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * Class ***`EmployeeNonContractuelInvoiceItem`***
 *
 * This model represents the `employee_non_contractuel_invoice_items` table in the database.
 * It extends the ModelContract class and provides access to the database table associated with the model.
 *
 * @property  integer       $quantity;
 * @property  double        $unit_price;
 * @property  double        $total;
 * @property  string        $detail_id;
 * @property  string        $detail_type;
 * @property  string        $unite_travaille_id;
 * @property  string        $employee_non_contractuel_invoice_id;
 *
 * @package ***`\App\Models\Finances`***
 */
class EmployeeNonContractuelInvoiceItem extends ModelContract
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
    protected $table = "employee_non_contractuel_invoice_items";
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
       "quantity", "unit_price", "total", 'unite_travaille_id', 'employee_non_contractuel_invoice_id', 'detail_id', 'detail_type'
    ];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array<int, string>
     */
    protected $visible = [
        "quantity", "unit_price", "total"
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'quantity'                      => "decimal:2",
        "unit_price"                    => "decimal:2",
        "total"                         => "decimal:2",
        'unite_travaille_id'            => 'string',
        'employee_non_contractuel_id'   => 'string',
        'detail_id'                     => 'string',
        'detail_type'                   => 'string'
    ];

    /**
     * Get the unite_travaille
     *
     * @return BelongsTo
     */
    public function unite_travaille(): BelongsTo
    {
        return $this->belongsTo(UniteTravaille::class, 'unite_travaille_id');
    }

    /**
     * Get the employee_non_contractuel
     *
     * @return BelongsTo
     */
    public function employee_non_contractuel(): BelongsTo
    {
        return $this->belongsTo(EmployeeNonContractuel::class, 'employee_non_contractuel_id');
    }

    /**
     * Get the item detail.
     *
     * @return MorphTo|null
     */
    public function detail(): ?MorphTo
    {
        return $this->morphTo();
    }
}