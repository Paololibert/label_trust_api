<?php

declare(strict_types=1);

namespace Domains\Finances\ClassesDeCompte\Repositories;

use App\Models\Finances\ClasseDeCompte;
use Core\Data\Repositories\Eloquent\EloquentReadWriteRepository;

/**
 * ***`ClasseDeCompteReadWriteRepository`***
 *
 * This class extends the EloquentReadWriteRepository class, which suggests that it is responsible for providing read-only access to the ClasseDeCompte $instance data.
 *
 * @package ***`Domains\Finances\ClassesDeCompte\Repositories`***
 */
class ClasseDeCompteReadWriteRepository extends EloquentReadWriteRepository
{
    /**
     * Create a new ClasseDeCompteReadWriteRepository instance.
     *
     * @param  \App\Models\Finances\ClasseDeCompte $model
     * @return void
     */
    public function __construct(ClasseDeCompte $model)
    {
        parent::__construct($model);
    }
    
}