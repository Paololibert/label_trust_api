<?php

namespace App\Observers;

use Core\Data\Eloquent\Contract\ModelContract;
use Core\Data\Eloquent\Observers\ModelContractObserver;
use Core\Utils\Enums\Users\TypeOfAccountEnum;
use Illuminate\Database\Eloquent\Model;

class UserObserver extends ModelContractObserver
{
    /**
     * Listen to the role creating event.
     *
     * Handle the User "creating" event.
     *
     * @param ModelContract $model The model instance.
     * @return void
     */
    public function creating(ModelContract $model): void
    {
        parent::creating($model);

        if($model->type_of_account === TypeOfAccountEnum::PERSONAL)
        {
            $model->username = $model->userable->last_name .".". $model->userable->first_name;
        }
        else if($model->type_of_account === TypeOfAccountEnum::MORAL)
        {
            $model->username = $model->userable?->name;
        }
    }
}
