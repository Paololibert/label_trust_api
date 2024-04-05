<?php

declare(strict_types=1);

namespace Domains\Articles\Article\Repositories;

use App\Models\Articles\Article;
use Core\Data\Repositories\Eloquent\EloquentReadOnlyRepository;


/**
 * ***`ArticleReadOnlyRepository`***
 *
 * This class extends the EloquentReadOnlyRepository class, which suggests that it is responsible for providing read-only access to the Article $instance data.
 *
 * @package ***`\Domains\Articles\Article\Repositories`***
 */
class ArticleReadOnlyRepository extends EloquentReadOnlyRepository
{
    /**
     * Create a new ArticleReadOnlyRepository instance.
     *
     * @param  \App\Models\Articles\Article $model
     * @return void
     */
    public function __construct(Article $model)
    {
        parent::__construct($model);
    }
}