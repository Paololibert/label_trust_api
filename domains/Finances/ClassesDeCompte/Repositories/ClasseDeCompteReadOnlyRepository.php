<?php

declare(strict_types=1);

namespace Domains\Finances\ClassesDeCompte\Repositories;

use App\Models\Finances\ClasseDeCompte;
use Core\Data\Repositories\Eloquent\EloquentReadOnlyRepository;

/**
 * ***`ClasseDeCompteReadOnlyRepository`***
 *
 * This class extends the EloquentReadOnlyRepository class, which suggests that it is responsible for providing read-only access to the ClasseDeCompte $instance data.
 *
 * @package ***`\Domains\Finances\ClassesDeCompte\Repositories`***
 */
class ClasseDeCompteReadOnlyRepository extends EloquentReadOnlyRepository
{
    /**
     * Create a new ClasseDeCompteReadOnlyRepository instance.
     *
     * @param  \App\Models\Finances\ClasseDeCompte $model
     * @return void
     */
    public function __construct(ClasseDeCompte $model)
    {
        parent::__construct($model);
    }
}