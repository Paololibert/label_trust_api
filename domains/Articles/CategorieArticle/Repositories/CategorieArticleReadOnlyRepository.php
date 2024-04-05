<?php

declare(strict_types=1);

namespace Domains\Articles\CategorieArticle\Repositories;

use App\Models\Articles\CategorieArticle;
use Core\Data\Repositories\Eloquent\EloquentReadOnlyRepository;


/**
 * ***`CategorieArticleReadOnlyRepository`***
 *
 * This class extends the EloquentReadOnlyRepository class, which suggests that it is responsible for providing read-only access to the Article $instance data.
 *
 * @package ***`\Domains\Articles\CategorieArticle\Repositories`***
 */
class CategorieArticleReadOnlyRepository extends EloquentReadOnlyRepository
{
    /**
     * Create a new CategorieArticleReadOnlyRepository instance.
     *
     * @param  \App\Models\Articles\CategorieArticle $model
     * @return void
     */
    public function __construct(CategorieArticle $model)
    {
        parent::__construct($model);
    }
}