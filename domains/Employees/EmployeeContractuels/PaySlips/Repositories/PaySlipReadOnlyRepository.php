<?php

declare(strict_types=1);

namespace Domains\Employees\EmployeeContractuels\PaySlips\Repositories;

use App\Models\Finances\PaySlip;
use Core\Data\Repositories\Eloquent\EloquentReadOnlyRepository;

/**
 * ***`PaySlipReadOnlyRepository`***
 *
 * This class extends the EloquentReadOnlyRepository class, which suggests that it is responsible for providing read-only access to the PaySlip $instance data.
 *
 * @package ***`\Domains\Employees\EmployeeContractuels\PaySlips\Repositories`***
 */
class PaySlipReadOnlyRepository extends EloquentReadOnlyRepository
{
    /**
     * Create a new PaySlipReadOnlyRepository instance.
     *
     * @param  \App\Models\Finances\PaySlip $model
     * @return void
     */
    public function __construct(PaySlip $model)
    {
        parent::__construct($model);
    }
}