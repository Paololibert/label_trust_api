<?php

declare(strict_types=1);

namespace Domains\Finances\ExercicesComptable\Repositories;

use App\Models\Finances\ExerciceComptable;
use Core\Data\Repositories\Eloquent\EloquentReadWriteRepository;

/**
 * ***`ExerciceComptableReadWriteRepository`***
 *
 * This class extends the EloquentReadWriteRepository class, which suggests that it is responsible for providing read-only access to the ExerciceComptable $instance data.
 *
 * @package ***`Domains\Finances\ExercicesComptable\Repositories`***
 */
class ExerciceComptableReadWriteRepository extends EloquentReadWriteRepository
{
    /**
     * Create a new ExerciceComptableReadWriteRepository instance.
     *
     * @param  \App\Models\Finances\ExerciceComptable $model
     * @return void
     */
    public function __construct(ExerciceComptable $model)
    {
        parent::__construct($model);
    }
    
}