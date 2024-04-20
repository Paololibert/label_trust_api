<?php

declare(strict_types=1);

namespace App\Models\Finances;

use App\Models\EmployeeNonContractuel;
use Core\Data\Eloquent\Contract\ModelContract;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class ***`EmployeeNonContractuelInvoice`***
 *
 * This model represents the `employee_non_contractuel_invoices` table in the database.
 * It extends the ModelContract class and provides access to the database table associated with the model.
 *
 * @property  string    invoice_number
 * @property  double    total
 * @property  date      issue_date
 * @property  date      due_date
 * @property  boolean   invoice_status
 * @property  string    employee_non_contractuel_id
 *
 * @package ***`\App\Models\Finances`***
 */
class EmployeeNonContractuelInvoice extends ModelContract
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
    protected $table = "employee_non_contractuel_invoices";
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
       "invoice_number", "total", "issue_date", "due_date", "invoice_status", 'employee_non_contractuel_id'
    ];

    /**
     * The attributes that should be treated as dates.
     *
     * @var array<int, string>
     */
    protected $dates = [
        "issue_date",
        "due_date",
    ];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array<int, string>
     */
    protected $visible = [
        "invoice_number", "total", "issue_date", "due_date", "invoice_status"
    ];

    /**
     * The model's default attribute values.
     *
     * @var array<string, mixed>
     */
    protected $attributes = [
        'total'             => 0.00,
        'invoice_status'    => false
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'invoice_number'                => 'string',
        "total"                         => "decimal:2",
        "invoice_status"                => "boolean",
        'issue_date'                    => 'datetime:Y-m-d',
        'due_date'                      => 'datetime:Y-m-d',
        'employee_non_contractuel_id'   => 'string'
    ];

    /**
     * The relationships that should always be loaded.
     *
     * @var array<int, string>
     */
    protected $with = [
        'items'
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
            $model->issue_date     = now();
            $model->due_date       = now();
            $model->invoice_number = "INV" . "-" . \Carbon\Carbon::now()->format("Ymd") . "-". $model->invoice_code(); 
        });
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
     * Get the invoice items
     *
     * @return HasMany
     */
    public function items(): HasMany
    {
        return $this->hasMany(EmployeeNonContractuelInvoiceItem::class, 'employee_non_contractuel_invoice_id');
    }

    private function invoice_code(){
        $invoice = $this->latest()->first();
        if($invoice){
            $inter = explode("-", $invoice->invoice_number);

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