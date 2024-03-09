<?php

declare(strict_types=1);

namespace Domains\TauxAndSalaries\Repositories;

use App\Models\TauxAndSalary;
use Core\Data\Repositories\Eloquent\EloquentReadWriteRepository;

/**
 * ***`TauxAndSalaryReadWriteRepository`***
 *
 * This class extends the EloquentReadWriteRepository class, which suggests that it is responsible for providing read-only access to the TauxAndSalary $instance data.
 *
 * @package ***`Domains\TauxAndSalaries\Repositories`***
 */
class TauxAndSalaryReadWriteRepository extends EloquentReadWriteRepository
{
    /**
     * Create a new TauxAndSalaryReadWriteRepository instance.
     *
     * @param  \App\Models\TauxAndSalary $model
     * @return void
     */
    public function __construct(TauxAndSalary $model)
    {
        parent::__construct($model);
    }
    
}