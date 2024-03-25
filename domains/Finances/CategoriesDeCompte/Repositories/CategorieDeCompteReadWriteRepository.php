<?php

declare(strict_types=1);

namespace Domains\Finances\CategoriesDeCompte\Repositories;

use App\Models\Finances\CategorieDeCompte;
use Core\Data\Repositories\Eloquent\EloquentReadWriteRepository;

/**
 * ***`CategorieDeCompteReadWriteRepository`***
 *
 * This class extends the EloquentReadWriteRepository class, which suggests that it is responsible for providing read-only access to the CategorieDeCompte $instance data.
 *
 * @package ***`Domains\Finances\CategoriesDeCompte\Repositories`***
 */
class CategorieDeCompteReadWriteRepository extends EloquentReadWriteRepository
{
    /**
     * Create a new CategorieDeCompteReadWriteRepository instance.
     *
     * @param  \App\Models\Finances\CategorieDeCompte $model
     * @return void
     */
    public function __construct(CategorieDeCompte $model)
    {
        parent::__construct($model);
    }
    
}