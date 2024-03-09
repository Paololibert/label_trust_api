<?php

declare(strict_types=1);

namespace App\Models;

use Core\Data\Eloquent\Contract\ModelContract;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class ***`ClasseDeCompte`***
 *
 * This model represents the `classes_de_compte` table in the database.
 * It extends the ModelContract class and provides access to the database table associated with the model.
 *
 * @property  string    $name;
 *
 * @package ***`\App\Models`***
 */
class ClasseDeCompte extends ModelContract
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
    protected $table = 'classes_de_compte';
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
     * Interact with the ClasseDeCompte's name.
     */
    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => ucfirst($value),
            set: fn (string $value) => strtolower($value)
        );
    }
    
    /**
     * Get the accounts of the work unit for a poste
     *
     * @return HasMany
     */
    public function accounts(): HasMany
    {
        return $this->hasMany(Account::class, 'classe_id');
    }
}