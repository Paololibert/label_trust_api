<?php

declare(strict_types=1);

namespace Domains\Finances\EcrituresComptable\Repositories;

use App\Models\Finances\EcritureComptable;
use Core\Data\Repositories\Eloquent\EloquentReadOnlyRepository;

/**
 * ***`EcritureComptableReadOnlyRepository`***
 *
 * This class extends the EloquentReadOnlyRepository class, which suggests that it is responsible for providing read-only access to the EcritureComptable $instance data.
 *
 * @package ***`\Domains\Finances\EcrituresComptable\Repositories`***
 */
class EcritureComptableReadOnlyRepository extends EloquentReadOnlyRepository
{
    /**
     * Create a new EcritureComptableReadOnlyRepository instance.
     *
     * @param  \App\Models\Finances\EcritureComptable $model
     * @return void
     */
    public function __construct(EcritureComptable $model)
    {
        parent::__construct($model);
    }
}