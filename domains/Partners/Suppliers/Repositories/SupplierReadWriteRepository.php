<?php

declare(strict_types=1);

namespace Domains\Partners\Suppliers\Repositories;

use App\Models\Supplier;
use Core\Data\Repositories\Eloquent\EloquentReadWriteRepository;

/**
 * ***`SupplierReadWriteRepository`***
 *
 * This class extends the EloquentReadWriteRepository class, which suggests that it is responsible for providing read-only access to the Supplier $instance data.
 *
 * @package ***`Domains\Partners\Suppliers\Repositories`***
 */
class SupplierReadWriteRepository extends EloquentReadWriteRepository
{

    /**
     * Create a new SupplierReadWriteRepository instance.
     *
     * @param  \App\Models\Supplier $model
     * 
     * 
     * @return void
     */
    public function __construct(Supplier $model)
    {
        parent::__construct($model);
    }

}