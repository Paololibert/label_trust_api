<?php

declare(strict_types=1);

namespace Core\Data\Eloquent\ORMs;

use App\Models\Finances\LigneEcritureComptable;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * 
 */
trait Accountable
{
    /**
     * Get an account transactions
     *
     * @return MorphMany
     */
    public function transactions(): MorphMany
    {
        return $this->morphMany(LigneEcritureComptable::class, 'accountable');
    }

    /**
     * Delete the user associate with the employee
     */
    public static function bootAccountable()
    {
    }
}