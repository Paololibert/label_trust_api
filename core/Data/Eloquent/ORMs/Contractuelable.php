<?php

declare(strict_types=1);

namespace Core\Data\Eloquent\ORMs;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * Get the user of the employee.
 *
 * @return MorphOne
 */

trait Contractuelable
{
    
    /**
     * Get all of the employees for the post.
     */
    public function employee(): MorphToMany
    {
        return $this->morphToMany(Employee::class, 'contractuelable');
    }

    /**
     * Delete the user associate with the employee
     */
    public static function bootContactuelable()
    {
        static::deleting(function ($model) {
            $model->employee()->delete();
        });
    }
}