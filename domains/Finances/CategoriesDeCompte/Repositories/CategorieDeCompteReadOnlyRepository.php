<?php

declare(strict_types=1);

namespace Domains\Finances\CategoriesDeCompte\Repositories;

use App\Models\Finances\CategorieDeCompte;
use Core\Data\Repositories\Eloquent\EloquentReadOnlyRepository;

/**
 * ***`CategorieDeCompteReadOnlyRepository`***
 *
 * This class extends the EloquentReadOnlyRepository class, which suggests that it is responsible for providing read-only access to the CategorieDeCompte $instance data.
 *
 * @package ***`\Domains\Finances\CategoriesDeCompte\Repositories`***
 */
class CategorieDeCompteReadOnlyRepository extends EloquentReadOnlyRepository
{
    /**
     * Create a new CategorieDeCompteReadOnlyRepository instance.
     *
     * @param  \App\Models\Finances\CategorieDeCompte $model
     * @return void
     */
    public function __construct(CategorieDeCompte $model)
    {
        parent::__construct($model);
    }
}