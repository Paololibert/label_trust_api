<?php

declare(strict_types=1);

namespace Domains\Finances\PlansComptable\Accounts\Repositories;

use App\Models\Finances\Account;
use Core\Data\Repositories\Eloquent\EloquentReadOnlyRepository;

/**
 * ***`AccountReadOnlyRepository`***
 *
 * This class extends the EloquentReadOnlyRepository class, which suggests that it is responsible for providing read-only access to the Account $instance data.
 *
 * @package ***`\Domains\Finances\PlansComptable\Accounts\Repositories`***
 */
class AccountReadOnlyRepository extends EloquentReadOnlyRepository
{
    /**
     * Create a new AccountReadOnlyRepository instance.
     *
     * @param  \App\Models\Finances\Account $model
     * @return void
     */
    public function __construct(Account $model)
    {
        parent::__construct($model);
    }
}