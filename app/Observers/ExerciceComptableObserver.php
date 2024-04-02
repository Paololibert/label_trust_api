<?php

namespace App\Observers;

use Core\Data\Eloquent\Contract\ModelContract;
use Core\Data\Eloquent\Observers\ModelContractObserver;

class ExerciceComptableObserver extends ModelContractObserver
{
    /**
     * Listen to the role creating event.
     *
     * Handle the Role "creating" event.
     *
     * @param ModelContract $model The model instance.
     * @return void
     */
    public function creating(ModelContract $model): void
    {
        parent::creating($model);
        
        $model->date_ouverture = $model->fiscal_year . "-" . $model->periode_exercice->date_debut_periode->format('m-d');
        $model->date_fermeture = null;
    }
}
