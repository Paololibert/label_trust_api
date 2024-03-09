<?php

declare(strict_types=1);

namespace Domains\Employees\EmployeeNonContractuels\Repositories;

use App\Models\EmployeeNonContractuel;
use Core\Data\Repositories\Eloquent\EloquentReadOnlyRepository;


/**
 * ***`EmployeeNonContractuelReadOnlyRepository`***
 *
 * This class extends the EloquentReadOnlyRepository class, which suggests that it is responsible for providing read-only access to the EmployeeNonContractuel $instance data.
 *
 * @package ***`\Domains\Employees\EmployeeNonContractuels\Repositories`***
 */
class EmployeeNonContractuelReadOnlyRepository extends EloquentReadOnlyRepository
{
    /**
     * Create a new EmployeeNonContractuelReadOnlyRepository instance.
     *
     * @param  \App\Models\EmployeeNonContractuel $model
     * @return void
     */
    public function __construct(EmployeeNonContractuel $model)
    {
        parent::__construct($model);
    }
}