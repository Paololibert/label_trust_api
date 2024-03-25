<?php

declare(strict_types=1);

namespace Domains\Finances\Devises\Repositories;

use App\Models\Finances\Devise;
use Core\Data\Repositories\Eloquent\EloquentReadWriteRepository;

/**
 * ***`DeviseReadWriteRepository`***
 *
 * This class extends the EloquentReadWriteRepository class, which suggests that it is responsible for providing read-only access to the Devise $instance data.
 *
 * @package ***`Domains\Finances\Devises\Repositories`***
 */
class DeviseReadWriteRepository extends EloquentReadWriteRepository
{
    /**
     * Create a new DeviseReadWriteRepository instance.
     *
     * @param  \App\Models\Finances\Devise $model
     * @return void
     */
    public function __construct(Devise $model)
    {
        parent::__construct($model);
    }
    
}