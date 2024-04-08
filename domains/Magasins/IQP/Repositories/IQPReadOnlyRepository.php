<?php

declare(strict_types=1);

namespace Domains\Magasins\IQP\Repositories;

use App\Models\Magasins\IQP;
use Core\Data\Repositories\Eloquent\EloquentReadOnlyRepository;


/**
 * ***`IQPReadOnlyRepository`***
 *
 * This class extends the EloquentReadOnlyRepository class, which suggests that it is responsible for providing read-only access to the Magasin $instance data.
 *
 * @package ***`\Domains\Magasins\IQP\Repositories`***
 */
class IQPReadOnlyRepository extends EloquentReadOnlyRepository
{
    /**
     * Create a new IQPReadOnlyRepository instance.
     *
     * @param  \App\Models\Magasins\IQP $model
     * @return void
     */
    public function __construct(IQP $model)
    {
        parent::__construct($model);
    }
}