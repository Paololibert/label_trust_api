<?php

declare(strict_types=1);

namespace App\Models;

use Core\Data\Eloquent\Contract\ModelContract;
use Core\Utils\Enums\StatutContratEnum;
use Core\Utils\Enums\TypeContratEnum;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class ***`Salaire`***
 *
 * This model represents the `salaires` table in the database.
 * It extends the ModelContract class and provides access to the database table associated with the model.
 *
 * @property  string    $name;
 *
 * @package ***`\App\Models`***
 */
class Salaire extends ModelContract
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
    protected $table = 'salaires';


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'montant','date_debut',
        'date_fin','est_valide',
        'contract_id','poste_salarie_id'
    ];
    

    /**
     * The model's default attribute values.
     *
     * @var array<string, mixed>
     */
    protected $attributes = [
        'est_valide'          =>true,
    ];


    /**
     * The attributes that should be visible in arrays.
     *
     * @var array<int, string>
     */
    protected $visible = [
        'montant','date_debut','date_fin'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'montant'                       =>'decimal',
        'date_debut'                    =>'datetime:Y-m-d H:i:s',
        'date_fin'                      =>'datetime:Y-m-d H:i:s',
        'est_valide'                    =>'boolean',
        'contract_id'                   =>'string',
        'poste_salarie_id'              =>'string'
    ];
    
    /**
     * Get the contract of the employee attach to the salary. 
     *
     * @return BelongsTo
     */
    public function contract(): BelongsTo
    {
        return $this->belongsTo(Contract::class, 'contract_id');
    }

    /**
     * Get the salary attach to the poste. 
     *
     * @return BelongsTo || Null
     */
    public function poste_salary(): ?BelongsTo
    {
        return $this->belongsTo(PosteSalary::class, 'poste_salarie_id');
    }

}