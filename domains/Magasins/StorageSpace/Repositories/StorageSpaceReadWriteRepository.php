<?php

declare(strict_types=1);

namespace Domains\Magasins\StorageSpace\Repositories;

use App\Models\Magasins\StorageSpace;
use Core\Data\Repositories\Eloquent\EloquentReadWriteRepository;

/**
 * ***`StorageSpaceReadWriteRepository`***
 *
 * This class extends the EloquentReadWriteRepository class, which suggests that it is responsible for providing read-only access to the StorageSpace $instance data.
 *
 * @package ***`Domains\Magasins\StorageSpace\Repositories`***
 */
class StorageSpaceReadWriteRepository extends EloquentReadWriteRepository
{
    /**
     * Create a new StorageSpaceReadWriteRepository instance.
     *
     * @param  \App\Models\Magasins\StorageSpace $model
     * @return void
     */
    public function __construct(StorageSpace $model)
    {
        parent::__construct($model);
    }
    
}