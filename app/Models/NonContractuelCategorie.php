<?php

declare(strict_types=1);

namespace App\Models;

use Core\Data\Eloquent\Contract\ModelContract;
use Core\Utils\Enums\StatutContratEnum;
use Core\Utils\Enums\TypeContratEnum;

/**
 * Class ***`NonContractuelCategorie`***
 *
 * This model represents the `non_contractuel_categories` table in the database.
 * It extends the ModelContract class and provides access to the database table associated with the model.
 *
 * @property  string    $name;
 *
 * @package ***`\App\Models`***
 */
class NonContractuelCategorie extends ModelContract
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'non_contractuel_categories';


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'date_debut','date_fin',
        'employee_non_contractuel_id','categories_of_employee_id'
    ];
    
    
    /**
     * The model's default attribute values.
     *
     * @var array<string, mixed>
     */
    protected $attributes = [
        'date_fin'          =>null,
    ];


    /**
     * The attributes that should be visible in arrays.
     *
     * @var array<int, string>
     */
    protected $visible = [
        'date_debut','employee_non_contractuel_id','categories_of_employee_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date_debut'                                =>'datetime:Y-m-d H:i:s',
        'date_fin'                                  =>'datetime:Y-m-d H:i:s',
        'employee_non_contractuel_id'               =>'string',
        'categories_of_employee_id'                 =>'string',
    ];
    

}