<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Finances\ContractualEmployeePayrollAdjustement;
use App\Models\Finances\PaySlip;
use Core\Data\Eloquent\Contract\ModelContract;
use Core\Data\Eloquent\ORMs\Contractuelable;
use Core\Utils\Enums\StatutContratEnum;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * Class ***`EmployeeContractuel`***
 *
 * This model represents the `employee_contractuels` table in the database.
 * It extends the ModelContract class and provides access to the database table associated with the model.
 *
 * @property  string    $name;
 *
 * @package ***`\App\Models`***
 */
class EmployeeContractuel extends ModelContract
{
    //use Contractuelable;
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
    protected $table = 'employee_contractuels';


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [

    ];

    /**
     * The model's default attribute values.
     *
     * @var array<string, mixed>
     */
    protected $attributes = [

    ];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array<int, string>
     */
    protected $visible = [

    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        
    ];
    
     /**
     * Get all of the tags for the post.
     */
    public function employees()
    {
        return $this->morphToMany(Employee::class, 'newcontractable');
    }

    /**
     * Get the comments for the blog post.
    */
    public function contract(): HasOne
    {
        return $this->hasOne(Contract::class)->where("contract_status", StatutContratEnum::EN_COURS);
    }

    /**
     * Get the comments for the blog post.
    */
    public function contracts(): HasMany
    {
        return $this->hasMany(Contract::class);
    }

    /**
     * Get the pay_slips
     *
     * @return HasMany
     */
    public function pay_slips(): HasMany
    {
        return $this->hasMany(PaySlip::class, 'employee_contractuel_id');
    }

    /**
     * Payroll adjustements
     */
    public function payroll_adjustements(){
        return $this->hasMany(ContractualEmployeePayrollAdjustement::class, 'employee_contractuel_id');
    }
}