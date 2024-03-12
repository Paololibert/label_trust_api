<?php

declare(strict_types=1);

namespace Domains\PeriodesExercice\Repositories;

use App\Models\PeriodeExercice;
use Core\Data\Repositories\Eloquent\EloquentReadWriteRepository;

/**
 * ***`PeriodeExerciceReadWriteRepository`***
 *
 * This class extends the EloquentReadWriteRepository class, which suggests that it is responsible for providing read-only access to the PeriodeExercice $instance data.
 *
 * @package ***`Domains\PeriodesExercice\Repositories`***
 */
class PeriodeExerciceReadWriteRepository extends EloquentReadWriteRepository
{
    /**
     * Create a new PeriodeExerciceReadWriteRepository instance.
     *
     * @param  \App\Models\PeriodeExercice $model
     * @return void
     */
    public function __construct(PeriodeExercice $model)
    {
        parent::__construct($model);
    }
    
}