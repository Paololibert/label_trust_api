<?php

declare(strict_types=1);

namespace Domains\CategoriesOfEmployees\Repositories;

use App\Models\CategoryOfEmployee;
use Core\Data\Repositories\Eloquent\EloquentReadOnlyRepository;


/**
 * ***`CategoryOfEmployeeReadOnlyRepository`***
 *
 * This class extends the EloquentReadOnlyRepository class, which suggests that it is responsible for providing read-only access to the CategoryOfEmployee $instance data.
 *
 * @package ***`\Domains\CategoriesOfEmployees\Repositories`***
 */
class CategoryOfEmployeeReadOnlyRepository extends EloquentReadOnlyRepository
{
    /**
     * Create a new CategoryOfEmployeReadOnlyRepository instance.
     *
     * @param  \App\Models\CategoryOfEmployee $model
     * @return void
     */
    public function __construct(CategoryOfEmployee $model)
    {
        parent::__construct($model);
    }
}