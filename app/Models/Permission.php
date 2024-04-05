<?php

declare(strict_types=1);

namespace App\Models;

use Core\Data\Eloquent\Contract\ModelContract;
use Core\Utils\Helpers\Sluggable\HasSlug;

/**
 * Class ***`Permission`***
 *
 * This model represents the `permissions` table in the database.
 * It extends the ModelContract class and provides access to the database table associated with the model.
 *
 * @property  string    $name;
 * @property  string    $slug;
 * @property  string    $key;
 * @property  string    $description;
 *
 * @package ***`\App\Models`***
 */
class Permission extends ModelContract
{
    use HasSlug;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'permissions';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array<int, string>
     */
    public $guarded = [
        'slug', 'key'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'key',
        'description'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'key'
    ];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array<int, string>
     */
    protected $visible = [
        'name', 'slug',
        'description'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'name'         => 'string',
        'slug'         => 'string',
        'key'          => 'string',
        'description'  => 'string'
    ];

    public function authorable(): ?string
    {
        return null;
    }
}