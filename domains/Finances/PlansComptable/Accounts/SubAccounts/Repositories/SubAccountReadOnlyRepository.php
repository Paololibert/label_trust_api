<?php

declare(strict_types=1);

namespace Domains\Finances\PlansComptable\Accounts\SubAccounts\Repositories;

use App\Models\Finances\SubAccount;
use Core\Data\Repositories\Eloquent\EloquentReadOnlyRepository;

/**
 * ***`SubAccountReadOnlyRepository`***
 *
 * This class extends the EloquentReadOnlyRepository class, which suggests that it is responsible for providing read-only access to the SubAccount $instance data.
 *
 * @package ***`\Domains\Finances\PlansComptable\Accounts\SubAccounts\Repositories`***
 */
class SubAccountReadOnlyRepository extends EloquentReadOnlyRepository
{
    /**
     * Create a new SubAccountReadOnlyRepository instance.
     *
     * @param  \App\Models\Finances\SubAccount $model
     * @return void
     */
    public function __construct(SubAccount $model)
    {
        parent::__construct($model);
    }
}