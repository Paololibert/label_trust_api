<?php

declare(strict_types=1);

namespace Domains\Finances\PeriodesExercice\Repositories;

use App\Models\Finances\PeriodeExercice;
use Core\Data\Repositories\Eloquent\EloquentReadWriteRepository;

/**
 * ***`PeriodeExerciceReadWriteRepository`***
 *
 * This class extends the EloquentReadWriteRepository class, which suggests that it is responsible for providing read-only access to the PeriodeExercice $instance data.
 *
 * @package ***`Domains\Finances\PeriodesExercice\Repositories`***
 */
class PeriodeExerciceReadWriteRepository extends EloquentReadWriteRepository
{
    /**
     * Create a new PeriodeExerciceReadWriteRepository instance.
     *
     * @param  \App\Models\Finances\PeriodeExercice $model
     * @return void
     */
    public function __construct(PeriodeExercice $model)
    {
        parent::__construct($model);
    }
    
}