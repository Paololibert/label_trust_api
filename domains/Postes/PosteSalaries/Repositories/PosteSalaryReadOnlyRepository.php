<?php

declare(strict_types=1);

namespace Domains\Postes\PosteSalaries\Repositories;

use App\Models\PosteSalary;
use Core\Data\Repositories\Eloquent\EloquentReadOnlyRepository;

/**
 * ***`PosteSalaryReadOnlyRepository`***
 *
 * This class extends the EloquentReadOnlyRepository class, which suggests that it is responsible for providing read-only access to the PosteSalary $instance data.
 *
 * @package ***`\Domains\Postes\PosteSalaries\Repositories`***
 */
class PosteSalaryReadOnlyRepository extends EloquentReadOnlyRepository
{
    /**
     * Create a new PosteSalaryReadOnlyRepository instance.
     *
     * @param  \App\Models\PosteSalary $model
     * @return void
     */
    public function __construct(PosteSalary $model)
    {
        parent::__construct($model);
    }
}