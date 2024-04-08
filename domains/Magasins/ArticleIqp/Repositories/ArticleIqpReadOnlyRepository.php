<?php

declare(strict_types=1);

namespace Domains\Magasins\ArticleIqp\Repositories;

use App\Models\Magasins\ArticleIqp;
use Core\Data\Repositories\Eloquent\EloquentReadOnlyRepository;


/**
 * ***`ArticleIqpReadOnlyRepository`***
 *
 * This class extends the EloquentReadOnlyRepository class, which suggests that it is responsible for providing read-only access to the Magasin $instance data.
 *
 * @package ***`\Domains\Magasins\ArticleIqp\Repositories`***
 */
class ArticleIqpReadOnlyRepository extends EloquentReadOnlyRepository
{
    /**
     * Create a new ArticleIqpReadOnlyRepository instance.
     *
     * @param  \App\Models\Magasins\ArticleIqp $model
     * @return void
     */
    public function __construct(ArticleIqp $model)
    {
        parent::__construct($model);
    }
}