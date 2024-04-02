<?php

declare(strict_types=1);

namespace Core\Data\Eloquent\ORMs;

use App\Models\Finances\LigneEcritureComptable;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * 
 */
trait Ligneable
{
    
    /**
     * Get the user of the employee.
     *
     * @return MorphMany
     */
    public function lignes_ecriture(): MorphMany
    {
        return $this->morphMany(LigneEcritureComptable::class, 'ligneable');
    }

    /**
     * Delete the user associate with the employee
     */
    public static function bootLigneable()
    {
    }
}