<?php

declare(strict_types=1);

namespace Domains\Employees\EmployeeContractuels\PaySlips\Repositories;

use App\Models\Finances\PaySlip;
use Core\Data\Repositories\Eloquent\EloquentReadWriteRepository;

/**
 * ***`PaySlipReadWriteRepository`***
 *
 * This class extends the EloquentReadWriteRepository class, which suggests that it is responsible for providing read-only access to the EmployeeContractuel $instance data.
 *
 * @package ***`Domains\Employees\EmployeeContractuels\Repositories`***
 */
class PaySlipReadWriteRepository extends EloquentReadWriteRepository
{
    /**
     * Create a new PaySlipReadWriteRepository instance.
     *
     * @param  \App\Models\Finances\PaySlip $model
     * @return void
     */

    public function __construct(PaySlip $model)
    {
        parent::__construct($model);
    }
}