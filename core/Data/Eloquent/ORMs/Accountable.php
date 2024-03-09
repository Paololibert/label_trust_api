<?php

declare(strict_types=1);

namespace Core\Data\Eloquent\ORMs;

use App\Models\LigneEcritureComptable;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * 
 */
trait Accountable
{
    /**
     * Get the user of the employee.
     *
     * @return MorphOne
     */
    public function lignes_ecriture_comptable(): MorphOne
    {
        return $this->morphOne(LigneEcritureComptable::class, 'accountable');
    }

    /**
     * Delete the user associate with the employee
     */
    public static function bootAccountable()
    {
        static::deleting(function ($model) {
            $model->lignes_ecriture_comptable()->delete();
        });
    }
}