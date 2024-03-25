<?php

declare(strict_types=1);

namespace Domains\Finances\PlansComptable\Repositories;

use App\Models\Finances\PlanComptable;
use Core\Data\Repositories\Eloquent\EloquentReadOnlyRepository;

/**
 * ***`PlanComptableReadOnlyRepository`***
 *
 * This class extends the EloquentReadOnlyRepository class, which suggests that it is responsible for providing read-only access to the PlanComptable $instance data.
 *
 * @package ***`\Domains\Finances\PlansComptable\Repositories`***
 */
class PlanComptableReadOnlyRepository extends EloquentReadOnlyRepository
{
    /**
     * Create a new PlanComptableReadOnlyRepository instance.
     *
     * @param  \App\Models\Finances\PlanComptable $model
     * @return void
     */
    public function __construct(PlanComptable $model)
    {
        parent::__construct($model);
    }
}