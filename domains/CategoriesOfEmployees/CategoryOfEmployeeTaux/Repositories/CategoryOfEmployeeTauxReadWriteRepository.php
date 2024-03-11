<?php

declare(strict_types=1);

namespace Domains\CategoriesOfEmployees\CategoryOfEmployeeTaux\Repositories;

use App\Models\CategoryOfEmployeeTaux;
use Core\Data\Repositories\Eloquent\EloquentReadWriteRepository;

/**
 * ***`CategoryOfEmployeeTauxReadWriteRepository`***
 *
 * This class extends the EloquentReadWriteRepository class, which suggests that it is responsible for providing read-only access to the CategoryOfEmployeeTaux $instance data.
 *
 * @package ***`\Domains\CategoriesOfEmployees\CategoryOfEmployeeTaux\Repositories`***
 */
class CategoryOfEmployeeTauxReadWriteRepository extends EloquentReadWriteRepository
{
    /**
     * Create a new CategoryOfEmployeeTauxReadWriteRepository instance.
     *
     * @param  \App\Models\CategoryOfEmployeeTaux $model
     * @return void
     */
    public function __construct(CategoryOfEmployeeTaux $model)
    {
        parent::__construct($model);
    }
    
}