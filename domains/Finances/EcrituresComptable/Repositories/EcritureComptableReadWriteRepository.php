<?php

declare(strict_types=1);

namespace Domains\Finances\EcrituresComptable\Repositories;

use App\Models\Finances\EcritureComptable;
use Core\Data\Repositories\Eloquent\EloquentReadWriteRepository;

/**
 * ***`EcritureComptableReadWriteRepository`***
 *
 * This class extends the EloquentReadWriteRepository class, which suggests that it is responsible for providing read-only access to the EcritureComptable $instance data.
 *
 * @package ***`Domains\Finances\EcrituresComptable\Repositories`***
 */
class EcritureComptableReadWriteRepository extends EloquentReadWriteRepository
{
    /**
     * Create a new EcritureComptableReadWriteRepository instance.
     *
     * @param  \App\Models\Finances\EcritureComptable $model
     * @return void
     */
    public function __construct(EcritureComptable $model)
    {
        parent::__construct($model);
    }
    
}