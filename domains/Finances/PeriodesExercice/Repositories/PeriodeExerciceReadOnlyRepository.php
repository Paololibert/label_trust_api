<?php

declare(strict_types=1);

namespace Domains\Finances\PeriodesExercice\Repositories;

use App\Models\Finances\PeriodeExercice;
use Core\Data\Repositories\Eloquent\EloquentReadOnlyRepository;

/**
 * ***`PeriodeExerciceReadOnlyRepository`***
 *
 * This class extends the EloquentReadOnlyRepository class, which suggests that it is responsible for providing read-only access to the PeriodeExercice $instance data.
 *
 * @package ***`\Domains\Finances\PeriodesExercice\Repositories`***
 */
class PeriodeExerciceReadOnlyRepository extends EloquentReadOnlyRepository
{
    /**
     * Create a new PeriodeExerciceReadOnlyRepository instance.
     *
     * @param  \App\Models\Finances\PeriodeExercice $model
     * @return void
     */
    public function __construct(PeriodeExercice $model)
    {
        parent::__construct($model);
    }
}