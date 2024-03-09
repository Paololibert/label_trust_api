<?php

declare(strict_types=1);

namespace Domains\Employees\EmployeeNonContractuels\Repositories;

use App\Models\EmployeeNonContractuel;
use Core\Data\Repositories\Eloquent\EloquentReadWriteRepository;

/**
 * ***`EmployeeNonContractuelReadWriteRepository`***
 *
 * This class extends the EloquentReadWriteRepository class, which suggests that it is responsible for providing read-only access to the EmployeeNonContractuel $instance data.
 *
 * @package ***`Domains\Employees\EmployeeNonContractuels\Repositories`***
 */
class EmployeeNonContractuelReadWriteRepository extends EloquentReadWriteRepository
{
    /**
     * Create a new EmployeeNonContractuelReadWriteRepository instance.
     *
     * @param  \App\Models\EmployeeNonContractuel $model
     * @return void
     */
    public function __construct(EmployeeNonContractuel $model)
    {
        parent::__construct($model);
    }
}