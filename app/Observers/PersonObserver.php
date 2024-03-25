<?php

namespace App\Observers;

use Core\Data\Eloquent\Contract\ModelContract;
use Core\Data\Eloquent\Observers\ModelContractObserver;

class PersonObserver extends ModelContractObserver
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
        
        $model->key = generate_key($model->name);
    }
}
