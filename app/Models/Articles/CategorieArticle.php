<?php

declare(strict_types=1);

namespace App\Models\Articles;

use Core\Data\Eloquent\Contract\ModelContract;
use Core\Data\Eloquent\ORMs\HasPermissions;
use Core\Utils\Helpers\Sluggable\HasSlug;
use Illuminate\Database\Eloquent\Casts\Attribute;

/**
 * Class ***`CategorieArticle`***
 *
 * This model represents the `CategorieArticles` table in the database.
 * It extends the ModelContract class and provides access to the database table associated with the model.
 *
 * @property  string    $name;
 *
 * @package ***`\App\Models`***
 */
class CategorieArticle extends ModelContract
{
    use HasSlug;

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
    protected $table = 'categorie_articles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

    /**
     * The attributes that should be treated as dates.
     *
     * @var array<int, string>
     */
    protected $dates = [
        
    ];

    /**
     * The model's default attribute values.
     *
     * @var array<string, mixed>
     */
    protected $attributes = [
    ];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array<int, string>
     */
    protected $visible = [
        'name'
    ];

    /**
     * The accessors to append to the model's array and JSON representation.
     *
     * @var array<int, string>
     */
    protected $appends = [

    ];

    /**
     * Interact with the CategorieArticle's name.
     */
    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => ucfirst($value),
            set: fn (string $value) => strtolower($value)
        );
    }
}