<?php

declare(strict_types=1);

namespace App\Models\Magasins;

use Core\Data\Eloquent\Contract\ModelContract;
use Core\Utils\Enums\TypeIQPEnum;
use Core\Utils\Enums\TypeOfIQPEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class ***`IQP`***
 *
 * This model represents the `iqps` table in the database.
 * It extends the ModelContract class and provides access to the database table associated with the model.
 *
 * @property  string    $name;
 *
 * @package ***`\App\Models`***
 */
class IQP extends ModelContract
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
    protected $table = 'iqps';


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'type_of_iqp',
        'iqp_type'
    ];


    /**
     * The attributes that should be visible in arrays.
     *
     * @var array<int, string>
     */
    protected $visible = [
        'name',
        'type_of_iqp',
        'iqp_type'
    ];

    
    /**
     * The model's default attribute values.
     *
     * @var array<string, mixed>
     */
    protected $attributes = [
        'type_of_iqp'          => TypeIQPEnum::DEFAULT,
        'iqp_type'             => TypeOfIQPEnum::DEFAULT
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'name'              => 'string',
        'type_of_iqp'       => TypeIQPEnum::class,
        'iqp_type'          => TypeOfIQPEnum::class
    ];

    /**
     * Interact with the IQP's name.
     */
    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => ucfirst($value),
            set: fn (string $value) => strtolower($value)
        );
    }


}