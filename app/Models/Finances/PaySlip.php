<?php

declare(strict_types=1);

namespace App\Models\Finances;

use App\Models\EmployeeContractuel;
use Core\Data\Eloquent\Contract\ModelContract;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class ***`PaySlip`***
 *
 * This model represents the `pay_slips` table in the database.
 * It extends the ModelContract class and provides access to the database table associated with the model.
 *
 * @property  string    reference
 * @property  double    total_hors_taxe
 * @property  double    tva
 * @property  double    ttc
 * @property  date      issue_date
 * @property  date      periode_date
 * @property  date      start_date
 * @property  date      end_date
 * @property  boolean   pay_slip_status
 * @property  string    employee_contractuel_id
 *
 * @package ***`\App\Models\Finances`***
 */
class PaySlip extends ModelContract
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
    protected $table = "pay_slips";
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
       "reference", "total_hors_taxe", "tva", "ttc", "issue_date", "periode_date", "start_date", "end_date", "pay_slip_status", 'employee_contractuel_id'
    ];

    /**
     * The attributes that should be treated as dates.
     *
     * @var array<int, string>
     */
    protected $dates = [
        "issue_date",
        "periode_date",
        "start_date",
        "end_date"
    ];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array<int, string>
     */
    protected $visible = [
        "reference", "total_hors_taxe", "tva", "ttc", "issue_date", "periode_date", "start_date", "end_date", "pay_slip_status"
    ];

    /**
     * The model's default attribute values.
     *
     * @var array<string, mixed>
     */
    protected $attributes = [
        "total_hors_taxe"   => 0.00,
        "tva"               => 1.00,
        "ttc"               => 0.00,
        "pay_slip_status"   => false
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        "reference"                 => "string",
        "total_hors_taxe"           => "decimal:2",
        "tva"                       => "decimal:2",
        "ttc"                       => "decimal:2",
        "pay_slip_status"           => "boolean",
        "issue_date"                => "datetime:Y-m-d",
        "periode_date"              => "date:m/Y",
        "start_date"                => "date:Y-m-d",
        "end_date"                  => "date:Y-m-d",
        "employee_contractuel_id"   => "string"
    ];

    /**
     * The relationships that should always be loaded.
     *
     * @var array<int, string>
     */
    protected $with = [
        "items"
    ];

    /**
     * Interact with the user's middle name.
     * 
     * @return Attribute
     */
    protected function periodeDate(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => \Carbon\Carbon::createFromFormat('m/Y', $value)
        );
    }

    /**
     * The "boot" method of the model.
     *
     * @return void
     */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            $model->issue_date     = now();
            $model->reference = "PAY" . "-" . \Carbon\Carbon::now()->format("Ymd") . "-". $model->reference_code(); 
        });

    }

    /**
     * Get the employee_non_contractuel
     *
     * @return BelongsTo
     */
    public function employee_contractuel(): BelongsTo
    {
        return $this->belongsTo(EmployeeContractuel::class, "employee_contractuel_id");
    }

    /**
     * Get the invoice items
     *
     * @return HasMany
     */
    public function items(): HasMany
    {
        return $this->hasMany(PaySlipItem::class, "pay_slip_id");
    }

    private function reference_code(){
        $invoice = $this->latest()->first();
        if($invoice){
            $inter = explode("-", $invoice->reference);

            $code = $inter = ((int) end($inter)) + 1;

            if(strlen((string) $code) === 5) return $code;

            for ($i=0; $i < 5 - strlen((string) $inter); $i++) { 
                
                $code = "0" . $code;
            }

            return $code;
        }

        return "00001";
    }
}