<?php

declare(strict_types=1);

namespace Core\Data\Eloquent\ORMs;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * Get the user of the employee.
 *
 * @return MorphOne
 */

trait Contactuelable
{
    
    /**
     * Get all of the employees for the post.
     */
    public function employee(): MorphOne
    {
        return $this->morphOne(Employee::class, 'contractuelable');
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