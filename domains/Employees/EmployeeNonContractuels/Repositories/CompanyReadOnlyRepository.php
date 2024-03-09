<?php

declare(strict_types=1);

namespace Domains\Users\Companies\Repositories;

use App\Models\Company;
use Core\Data\Repositories\Eloquent\EloquentReadOnlyRepository;


/**
 * ***`CompanyReadOnlyRepository`***
 *
 * This class extends the EloquentReadOnlyRepository class, which suggests that it is responsible for providing read-only access to the Company $instance data.
 *
 * @package ***`\Domains\Users\Companies\Repositories`***
 */
class CompanyReadOnlyRepository extends EloquentReadOnlyRepository
{
    /**
     * Create a new CompanyReadOnlyRepository instance.
     *
     * @param  \App\Models\Company $model
     * @return void
     */
    public function __construct(Company $model)
    {
        parent::__construct($model);
    }
}