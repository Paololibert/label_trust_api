<?php

declare(strict_types=1);

namespace Domains\Magasins\IQP\Repositories;

use App\Models\Magasins\IQP;
use Core\Data\Repositories\Eloquent\EloquentReadWriteRepository;

/**
 * ***`IQPReadWriteRepository`***
 *
 * This class extends the EloquentReadWriteRepository class, which suggests that it is responsible for providing read-only access to the IQP $instance data.
 *
 * @package ***`Domains\Magasins\Magasin\Repositories`***
 */
class IQPReadWriteRepository extends EloquentReadWriteRepository
{
    /**
     * Create a new IQPReadWriteRepository instance.
     *
     * @param  \App\Models\Magasins\IQP $model
     * @return void
     */
    public function __construct(IQP $model)
    {
        parent::__construct($model);
    }
    
}