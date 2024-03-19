<?php

declare(strict_types=1);

namespace Domains\Contrats\Repositories;

use App\Models\Contract;
use Core\Data\Repositories\Eloquent\EloquentReadOnlyRepository;

/**
 * ***`ContractReadOnlyRepository`***
 *
 * This class extends the EloquentReadOnlyRepository class, which suggests that it is responsible for providing read-only access to the Contract $instance data.
 *
 * @package ***`\ Domains\Contrats\Repositories`***
 */
class ContractReadOnlyRepository extends EloquentReadOnlyRepository
{
    /**
     * Create a new ContractReadOnlyRepository instance.
     *
     * @param  \App\Models\Contract $model
     * @return void
     */
    public function __construct(Contract $model)
    {
        parent::__construct($model);
    }
}