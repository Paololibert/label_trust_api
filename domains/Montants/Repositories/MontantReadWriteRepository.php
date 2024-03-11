<?php

declare(strict_types=1);

namespace Domains\Montants\Repositories;

use App\Models\Montant;
use Core\Data\Repositories\Eloquent\EloquentReadWriteRepository;

/**
 * ***`MontantReadWriteRepository`***
 *
 * This class extends the EloquentReadWriteRepository class, which suggests that it is responsible for providing read-only access to the Montant $instance data.
 *
 * @package ***`Domains\Montants\Repositories`***
 */
class MontantReadWriteRepository extends EloquentReadWriteRepository
{
    /**
     * Create a new MontantReadWriteRepository instance.
     *
     * @param  \App\Models\Montant $model
     * @return void
     */
    public function __construct(Montant $model)
    {
        parent::__construct($model);
    }
    
}