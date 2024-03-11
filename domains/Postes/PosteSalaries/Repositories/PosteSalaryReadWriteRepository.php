<?php

declare(strict_types=1);

namespace Domains\Postes\PosteSalaries\Repositories;

use App\Models\PosteSalary;
use Core\Data\Repositories\Eloquent\EloquentReadWriteRepository;

/**
 * ***`PosteSalaryReadWriteRepository`***
 *
 * This class extends the EloquentReadWriteRepository class, which suggests that it is responsible for providing read-only access to the PosteSalary $instance data.
 *
 * @package ***`\Domains\Postes\PosteSalaries\Repositories`***
 */
class PosteSalaryReadWriteRepository extends EloquentReadWriteRepository
{
    /**
     * Create a new PosteSalaryReadWriteRepository instance.
     *
     * @param  \App\Models\PosteSalary $model
     * @return void
     */
    public function __construct(PosteSalary $model)
    {
        parent::__construct($model);
    }
    
}