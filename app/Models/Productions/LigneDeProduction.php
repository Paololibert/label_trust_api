<?php

declare(strict_types=1);

namespace App\Models\Productions;

use App\Models\Finances\ProjetProduction;
use Core\Data\Eloquent\Contract\ModelContract;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class ***`LigneDeProduction`***
 *
 * This model represents the `lignes_de_production` table in the database.
 * It extends the ModelContract class and provides access to the database table associated with the model.
 *
 * @property  string    $name;
 *
 * @package ***`\App\Models\Productions`***
 */
class LigneDeProduction extends ModelContract
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
    protected $table = "lignes_de_production";
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "name", "description"
    ];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array<int, string>
     */
    protected $visible = [
        "name", "description"
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        "name"          => "string",
        "description"   => "string"
    ];
    
    /**
     * Interact with the LigneDeProduction's name.
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
    public function projetsDeProduction(): HasMany
    {
        return $this->hasMany(ProjetProduction::class, 'ligne_de_production_id');
    }
}