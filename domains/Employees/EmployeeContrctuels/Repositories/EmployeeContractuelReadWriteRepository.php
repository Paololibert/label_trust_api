<?php

declare(strict_types=1);

namespace Domains\Users\Companies\Repositories;

use App\Models\EmployeeContractuel;
use Core\Data\Repositories\Eloquent\EloquentReadWriteRepository;

/**
 * ***`EmployeeContractuelReadWriteRepository`***
 *
 * This class extends the EloquentReadWriteRepository class, which suggests that it is responsible for providing read-only access to the EmployeeContractuel $instance data.
 *
 * @package ***`Domains\Users\Companies\Repositories`***
 */
class EmployeeContractuelReadWriteRepository extends EloquentReadWriteRepository
{
    /**
     * Create a new EmployeeContractuelReadWriteRepository instance.
     *
     * @param  \App\Models\EmployeeContractuel $model
     * @return void
     */
    public function __construct(EmployeeContractuel $model)
    {
        parent::__construct($model);
    }
}