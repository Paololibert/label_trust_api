<?php

declare(strict_types=1);

namespace Domains\Articles\Article\Repositories;

use App\Models\Articles\Article;
use Core\Data\Repositories\Eloquent\EloquentReadWriteRepository;

/**
 * ***`ArticleReadWriteRepository`***
 *
 * This class extends the EloquentReadWriteRepository class, which suggests that it is responsible for providing read-only access to the Article $instance data.
 *
 * @package ***`Domains\Articles\Article\Repositories`***
 */
class ArticleReadWriteRepository extends EloquentReadWriteRepository
{
    /**
     * Create a new ArticleReadWriteRepository instance.
     *
     * @param  \App\Models\Articles\Article $model
     * @return void
     */
    public function __construct(Article $model)
    {
        parent::__construct($model);
    }
    
}