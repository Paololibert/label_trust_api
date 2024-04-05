<?php

declare(strict_types=1);

namespace Domains\Magasins\StorageSpace\Repositories;

use App\Models\Magasins\StorageSpace;
use Core\Data\Repositories\Eloquent\EloquentReadOnlyRepository;


/**
 * ***`StorageSpaceReadOnlyRepository`***
 *
 * This class extends the EloquentReadOnlyRepository class, which suggests that it is responsible for providing read-only access to the StorageSpace $instance data.
 *
 * @package ***`\Domains\Magasins\StorageSpace\Repositories`***
 */
class StorageSpaceReadOnlyRepository extends EloquentReadOnlyRepository
{
    /**
     * Create a new StorageSpaceReadOnlyRepository instance.
     *
     * @param  \App\Models\Magasins\StorageSpace $model
     * @return void
     */
    public function __construct(StorageSpace $model)
    {
        parent::__construct($model);
    }
}