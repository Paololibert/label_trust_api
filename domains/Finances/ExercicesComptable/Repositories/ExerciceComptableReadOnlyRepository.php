<?php

declare(strict_types=1);

namespace Domains\Finances\ExercicesComptable\Repositories;

use App\Models\Finances\ExerciceComptable;
use Core\Data\Repositories\Eloquent\EloquentReadOnlyRepository;

/**
 * ***`ExerciceComptableReadOnlyRepository`***
 *
 * This class extends the EloquentReadOnlyRepository class, which suggests that it is responsible for providing read-only access to the ExerciceComptable $instance data.
 *
 * @package ***`\Domains\Finances\ExercicesComptable\Repositories`***
 */
class ExerciceComptableReadOnlyRepository extends EloquentReadOnlyRepository
{
    /**
     * Create a new ExerciceComptableReadOnlyRepository instance.
     *
     * @param  \App\Models\Finances\ExerciceComptable $model
     * @return void
     */
    public function __construct(ExerciceComptable $model)
    {
        parent::__construct($model);
    }
}