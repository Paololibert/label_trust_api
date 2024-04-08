<?php

declare(strict_types=1);

namespace Domains\Magasins\ArticleIqp\Repositories;

use App\Models\Magasins\ArticleIqp;
use Core\Data\Repositories\Eloquent\EloquentReadWriteRepository;

/**
 * ***`ArticleIqpReadWriteRepository`***
 *
 * This class extends the EloquentReadWriteRepository class, which suggests that it is responsible for providing read-only access to the ArticleIqp $instance data.
 *
 * @package ***`Domains\Magasins\Magasin\Repositories`***
 */
class ArticleIqpReadWriteRepository extends EloquentReadWriteRepository
{
    /**
     * Create a new ArticleIqpReadWriteRepository instance.
     *
     * @param  \App\Models\Magasins\ArticleIqp $model
     * @return void
     */
    public function __construct(ArticleIqp $model)
    {
        parent::__construct($model);
    }
    
}