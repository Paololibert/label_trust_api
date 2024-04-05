<?php

declare(strict_types=1);

namespace App\Models\Magasins;

use Core\Data\Eloquent\Contract\ModelContract;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class ***`StorageSpace`***
 *
 * This model represents the `storage_spaces` table in the database.
 * It extends the ModelContract class and provides access to the database table associated with the model.
 *
 * @property  string    $name;
 *
 * @package ***`\App\Models`***
 */
class StorageSpace extends ModelContract
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
    protected $table = 'storage_spaces';


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'code',
        'magasin_id'
    ];


    /**
     * The attributes that should be visible in arrays.
     *
     * @var array<int, string>
     */
    protected $visible = [
        'name',
        'code'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'name'              => 'string',
        'code'              => 'string',
        'magasin_id'        => 'string'
    ];

    /**
     * Interact with the StorageSpace's name.
     */
    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => ucfirst($value),
            set: fn (string $value) => strtolower($value)
        );
    }

    /**
     * Interact with the StorageSpace's address.
     */
    protected function code(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => strtolower($value),
            set: fn (string $value) => strtolower($value)
        );
    }
    
    /**
     * Get the magasin to whom belong the storage_space
     */
    public function store(): BelongsTo
    {
        return $this->belongsTo(Magasin::class, 'magasin_id');
    }

}