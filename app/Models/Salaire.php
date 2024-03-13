<?php

declare(strict_types=1);

namespace App\Models;

use Core\Data\Eloquent\Contract\ModelContract;
use Core\Utils\Enums\StatutContratEnum;
use Core\Utils\Enums\TypeContratEnum;

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
        'date_fin','est_valide'
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
        'montant'                     =>'decimal',
        'date_debut'                 =>'datetime:Y-m-d H:i:s',
        'date_fin'                         =>'datetime:Y-m-d H:i:s',
        'est_valide'                    =>'boolean',
    ];
    

}