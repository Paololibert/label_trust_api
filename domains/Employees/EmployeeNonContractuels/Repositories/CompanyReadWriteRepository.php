<?php

declare(strict_types=1);

namespace Domains\Users\Companies\Repositories;

use App\Models\Company;
use Core\Data\Repositories\Eloquent\EloquentReadWriteRepository;

/**
 * ***`CompanyReadWriteRepository`***
 *
 * This class extends the EloquentReadWriteRepository class, which suggests that it is responsible for providing read-only access to the Company $instance data.
 *
 * @package ***`Domains\Users\Companies\Repositories`***
 */
class CompanyReadWriteRepository extends EloquentReadWriteRepository
{
    /**
     * Create a new CompanyReadWriteRepository instance.
     *
     * @param  \App\Models\Company $model
     * @return void
     */
    public function __construct(Company $model)
    {
        parent::__construct($model);
    }
}