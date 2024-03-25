<?php

declare(strict_types=1);

namespace App\Models;

use Core\Data\Eloquent\Contract\ModelContract;
use Core\Data\Eloquent\ORMs\Profilable;

use Core\Utils\Enums\TypePartnerEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * Class ***`Partner`***
 *
 * This model represents the `partners` table in the database.
 * It extends the ModelContract class and provides access to the database table associated with the model.
 *
 * @property  string    $name;
 *
 * @package ***`\App\Models`***
 */
class Partner extends ModelContract
{
    use Profilable;
    
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
    protected $table = 'partners';


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'country','type_partner','company'
    ];

    /**
     * The model's default attribute values.
     *
     * @var array<string, mixed>
     */
    protected $attributes = [
        'type_partner'          => TypePartnerEnum::DEFAULT
    ];


    /**
     * The attributes that should be visible in arrays.
     *
     * @var array<int, string>
     */
    protected $visible = [
        'country','company',
        'type_partner'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'country'             => 'string',
        'company'             => 'string',
        'type_partner'         => TypePartnerEnum::class,
    ];

    /**
     * The relationships that should always be loaded.
     *
     * @var array<int, string>
     */
    protected $with = [
        'suppliers','user','clients'
    ];

    /**
     * Interact with the Partner's name.
     */
    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => ucfirst($value),
            set: fn (string $value) => strtolower($value)
        );
    }


     /**
     * Get all of the suppliers that are assigned this partner.
     */
    public function suppliers()
    {
        return $this->morphedByMany(Supplier::class, 'partnerable');
    }


    public function clients()
    {
        return $this->morphedByMany(Client::class, 'partnerable');
    }
    
    
}