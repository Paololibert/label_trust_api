<?php

declare(strict_types=1);

namespace App\Models;

use Core\Data\Eloquent\Contract\ModelContract;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class ***`CategorieDeCompte`***
 *
 * This model represents the `categories_de_compte` table in the database.
 * It extends the ModelContract class and provides access to the database table associated with the model.
 *
 * @property  string    $name;
 *
 * @package ***`\App\Models`***
 */
class CategorieDeCompte extends ModelContract
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
    protected $table = 'categories_de_compte';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code', 'name'
    ];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array<int, string>
     */
    protected $visible = [
        'code', 'name',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'code'         => 'string',
        'name'         => 'string'
    ];
    
    /**
     * Interact with the CategorieDeCompte's name.
     */
    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => ucfirst($value),
            set: fn (string $value) => strtolower($value)
        );
    }

    /**
     * 
     *
     * @return HasMany
     */
    public function comptes(): HasMany
    {
        return $this->hasMany(Compte::class, 'categorie_de_compte_id');
    }
}