<?php

declare(strict_types=1);

namespace App\Models\Finances;

use App\Models\Finances\PaySlip;
use Core\Data\Eloquent\Contract\ModelContract;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class ***`PaySlipItem`***
 *
 * This model represents the `pay_slip_items` table in the database.
 * It extends the ModelContract class and provides access to the database table associated with the model.
 *
 * @property  string        $libelle;
 * @property  double        $amount;
 * @property  string        $pay_slip_id;
 *
 * @package ***`\App\Models\Finances`***
 */
class PaySlipItem extends ModelContract
{
    /**
     * The database connection that should be used by the model.
     *
     * @var string
     */
    protected $connection = "pgsql";

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "pay_slip_items";
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
       "libelle", "amount", "pay_slip_id"
    ];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array<int, string>
     */
    protected $visible = [
        "libelle", "amount"
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'libelle'         => "string",
        "amount"          => "decimal:2",
        'pay_slip_id'     => 'string'
    ];

    /**
     * Get the pay_slip
     *
     * @return BelongsTo
     */
    public function pay_slip(): BelongsTo
    {
        return $this->belongsTo(PaySlip::class, 'pay_slip_id');
    }
}