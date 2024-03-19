<?php

declare(strict_types=1);

namespace App\Models;

use Core\Data\Eloquent\Contract\ModelContract;
use Core\Utils\Traits\CPivot;

/**
 * Class ***`Contractuelable`***
 *
 * This model represents the `contractuelables` table in the database.
 * It extends the ModelContract class and provides access to the database table associated with the model.
 *
 * @property  string    $name;
 *
 * @package ***`\App\Models`***
 */
class Contractuelable extends ModelContract
{
    use  CPivot;
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
    protected $table = 'contractuelables';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'employee_id','contractuelable_type',
        'actif','contractuelable_id'
    ];
    
    /**
     * The model's default attribute values.
     *
     * @var array<string, mixed>
     */
    protected $attributes = [
        'actif'          =>true,
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'contractuelable_type',
        'contractuelable_id',
    ];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array<int, string>
     */
    protected $visible = [
        'actif'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'employee_id'                     =>'string',
        'contractuelable_id'              =>'string',
        'contractuelable_type'            =>'string',
        'actif'                           =>'boolean',
    ];
    
    
}