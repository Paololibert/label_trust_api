<?php

declare(strict_types=1);

namespace Domains\CategoriesOfEmployees\CategoryOfEmployeeTaux\Repositories;

use App\Models\CategoryOfEmployeeTaux;
use Core\Data\Repositories\Eloquent\EloquentReadOnlyRepository;

/**
 * ***`CategoryOfEmployeeTauxReadOnlyRepository`***
 *
 * This class extends the EloquentReadOnlyRepository class, which suggests that it is responsible for providing read-only access to the CategoryOfEmployeeTaux $instance data.
 *
 * @package ***`\Domains\CategoriesOfEmployees\CategoryOfEmployeeTaux\Repositories`***
 */
class CategoryOfEmployeeTauxReadOnlyRepository extends EloquentReadOnlyRepository
{
    /**
     * Create a new CategoryOfEmployeeTauxReadOnlyRepository instance.
     *
     * @param  \App\Models\CategoryOfEmployeeTaux $model
     * @return void
     */
    public function __construct(CategoryOfEmployeeTaux $model)
    {
        parent::__construct($model);
    }
}