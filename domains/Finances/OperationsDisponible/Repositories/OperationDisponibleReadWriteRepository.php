<?php

declare(strict_types=1);

namespace Domains\Finances\OperationsDisponible\Repositories;

use App\Models\Finances\OperationComptableDisponible;
use Core\Data\Repositories\Eloquent\EloquentReadWriteRepository;

/**
 * ***`OperationDisponibleReadWriteRepository`***
 *
 * This class extends the EloquentReadWriteRepository class, which suggests that it is responsible for providing read-only access to the OperationDisponible $instance data.
 *
 * @package ***`Domains\Finances\OperationsDisponible\Repositories`***
 */
class OperationDisponibleReadWriteRepository extends EloquentReadWriteRepository
{
    /**
     * Create a new OperationDisponibleReadWriteRepository instance.
     *
     * @param  \App\Models\Finances\OperationComptableDisponible $model
     * @return void
     */
    public function __construct(OperationComptableDisponible $model)
    {
        parent::__construct($model);
    }
    
}