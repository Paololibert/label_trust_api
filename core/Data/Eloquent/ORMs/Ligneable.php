<?php

declare(strict_types=1);

namespace Core\Data\Eloquent\ORMs;

use App\Models\LigneEcritureComptable;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * 
 */
trait Ligneable
{
    
    /**
     * Get the user of the employee.
     *
     * @return MorphOne
     */
    public function ligne(): MorphOne
    {
        return $this->morphOne(LigneEcritureComptable::class, 'ligneable');
    }

    /**
     * Delete the user associate with the employee
     */
    public static function bootLigneable()
    {
        static::deleting(function ($model) {
            $model->ligne()->delete();
        });
    }
}