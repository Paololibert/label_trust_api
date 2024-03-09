<?php

declare(strict_types=1);

namespace Domains\TauxAndSalaries\Repositories;

use App\Models\TauxAndSalary;
use Core\Data\Repositories\Eloquent\EloquentReadOnlyRepository;


/**
 * ***`TauxAndSalaryReadOnlyRepository`***
 *
 * This class extends the EloquentReadOnlyRepository class, which suggests that it is responsible for providing read-only access to the TauxAndSalary $instance data.
 *
 * @package ***`\Domains\TauxAndSalaries\Repositories`***
 */
class TauxAndSalaryReadOnlyRepository extends EloquentReadOnlyRepository
{
    /**
     * Create a new TauxAndSalaryReadOnlyRepository instance.
     *
     * @param  \App\Models\TauxAndSalary $model
     * @return void
     */
    public function __construct(TauxAndSalary $model)
    {
        parent::__construct($model);
    }
}