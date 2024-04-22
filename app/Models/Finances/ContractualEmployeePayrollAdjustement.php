<?php

declare(strict_types=1);

namespace App\Models\Finances;

use App\Models\EmployeeContractuel;
use Core\Data\Eloquent\Contract\ModelContract;
use Core\Utils\Enums\AdjustementCategoryEnum;
use Core\Utils\Enums\AdjustementTypeEnum;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class ***`ContractualEmployeePayrollAdjustement`***
 *
 * This model represents the `employee_non_contractuel_invoices` table in the database.
 * It extends the ModelContract class and provides access to the database table associated with the model.
 *
 * @property  string    ajustement_category
 * @property  double    ajustement_value
 * @property  date      valid_from
 * @property  date      valid_to
 * @property  boolean   ajustement_status
 * @property  string    employee_contractuel_id
 *
 * @package ***`\App\Models\Finances`***
 */
class ContractualEmployeePayrollAdjustement extends ModelContract
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
    protected $table = "contractual_employee_payroll_adjustments";
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
       "ajustement_category", "ajustement_type", "ajustement_name", "ajustement_value", "base_value", "ajustement_value_type", "valid_from", "valid_to", "ajustement_status", 'employee_contractuel_id'
    ];

    /**
     * The attributes that should be treated as dates.
     *
     * @var array<int, string>
     */
    protected $dates = [
        "valid_from",
        "valid_to",
    ];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array<int, string>
     */
    protected $visible = [
       "ajustement_category", "ajustement_type", "ajustement_name", "ajustement_value", "base_value", "ajustement_value_type", "valid_from", "valid_to", "ajustement_status"
    ];

    /**
     * The model's default attribute values.
     *
     * @var array<string, mixed>
     */
    protected $attributes = [
        "ajustement_category"   => AdjustementCategoryEnum::DEFAULT,
        "ajustement_type"       => AdjustementTypeEnum::DEFAULT,
        'ajustement_value'      => 0.00,
        'ajustement_status'     => false,
        "base_value"            => 0.00,
        "ajustement_value_type" => "fixe"
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'ajustement_name'               => 'string',
        'ajustement_category'           => AdjustementCategoryEnum::class,
        'ajustement_type'               => AdjustementTypeEnum::class,
        "ajustement_value"              => "decimal:2",
        "base_value"                    => "decimal:2",
        "ajustement_value_type"         => "string",
        "ajustement_status"             => "boolean",
        'valid_from'                    => 'datetime:Y-m-d',
        'valid_to'                      => 'datetime:Y-m-d',
        'employee_contractuel_id'       => 'string'
    ];

    /**
     * The relationships that should always be loaded.
     *
     * @var array<int, string>
     */
    protected $with = [
    ];

    /**
     * The "boot" method of the model.
     *
     * @return void
     */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
        });
    }

    /**
     * Get the employee_non_contractuel
     *
     * @return BelongsTo
     */
    public function employee_contractuel(): BelongsTo
    {
        return $this->belongsTo(EmployeeContractuel::class, 'employee_contractuel_id');
    }
}