<?php

declare(strict_types=1);

namespace App\Models;

use Core\Data\Eloquent\Contract\ModelContract;
use Core\Utils\Enums\StatutContratEnum;
use Core\Utils\Enums\TypeContratEnum;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class ***`Contract`***
 *
 * This model represents the `contracts` table in the database.
 * It extends the ModelContract class and provides access to the database table associated with the model.
 *
 * @property  string    $name;
 *
 * @package ***`\App\Models`***
 */
class Contract extends ModelContract
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
    protected $table = 'contracts';


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'reference','type_contract',
        'duree','date_debut',
        'date_fin','contract_status',
        'renouvelable','est_renouveler',
        'poste_id','employee_contractuel_id',
        'unite_mesures_id'
    ];
    

    /**
     * The model's default attribute values.
     *
     * @var array<string, mixed>
     */
    protected $attributes = [
        'type_contract'         =>TypeContratEnum::DEFAULT,
        'contract_status'       =>StatutContratEnum::DEFAULT,
        'renouvelable'          =>true,
        'est_renouveler'        =>false
    ];


    /**
     * The attributes that should be visible in arrays.
     *
     * @var array<int, string>
     */
    protected $visible = [
        'est_convertir','categories_of_employee_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'reference'                     =>'string',
        'type_contract'                 =>TypeContratEnum::class,
        'duree'                         =>'float',
        'date_debut'                    =>'datetime:Y-m-d H:i:s',
        'date_fin'                      =>'datetime:Y-m-d H:i:s',
        'contract_status'               =>StatutContratEnum::class,
        'renouvelable'                  =>'boolean',
        'est_renouveler'                =>'string',
        'poste_id'                      =>'boolean',
        'employee_contractuel_id'       =>'string',
        'unite_mesures_id'              =>'boolean',
    ];
    
    /**
     * Get the poste of the contract. employee_contractuel_id
     *
     * @return BelongsTo
     */
    public function poste(): BelongsTo
    {
        return $this->belongsTo(Poste::class, 'poste_id');
    }

    /**
     * Get the employee to who the contract is.
     *
     * @return BelongsTo
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(EmployeeContractuel::class, 'employee_contractuel_id');
    }

    /**
     * Get the employee to who the contract is. 
     *
     * @return BelongsTo
     */
    public function unite_mesure(): BelongsTo
    {
        return $this->belongsTo(UniteMesure::class, 'unite_mesures_id');
    }
    
}