<?php

declare(strict_types=1);

namespace Core\Data\Eloquent\ORMs;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * Get the user of the employee.
 *
 * @return MorphOne
 */

trait Profilable
{
    
    /**
     * Get the user of the employee.
     *
     * @return MorphOne
     */
    public function user(): MorphOne
    {
        return $this->morphOne(User::class, 'profilable');
    }

    /**
     * Delete the user associate with the employee
     */
    public static function bootProfilale()
    {
        static::deleting(function ($model) {
            $model->user()->delete();
        });
    }
}