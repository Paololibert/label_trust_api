<?php

declare(strict_types=1);

namespace App\Models;

use Core\Data\Eloquent\Contract\ModelContract;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * Class `Company`
 *
 * This model represents the `companies` table in the database, storing information about different companies.
 * It extends the base `ModelContract` class, providing access to the underlying database table associated with the model.
 *
 * @property string $name                - The name of the company.
 * @property string $registration_number - The registration number of the company.
 *
 * @package `App\Models`
 */
class Company extends ModelContract
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'companies';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'registration_number',
    ];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array<int, string>
     */
    protected $visible = [
        'name',
        'registration_number',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'name'                  => 'string',
        'registration_number'   => 'string',
    ];

    /**
     * Get the user's morphed relation.
     *
     * @return MorphOne
     */
    public function user(): MorphOne
    {
        return $this->morphOne(User::class, 'userable');
    }
}