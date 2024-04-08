<?php

declare(strict_types=1);

namespace Domains\Articles\CategorieArticle\Repositories;

use App\Models\Articles\CategorieArticle;
use Core\Data\Repositories\Eloquent\EloquentReadWriteRepository;
use Core\Utils\Exceptions\QueryException;
use Core\Utils\Exceptions\RepositoryException;
use Exception;
use Illuminate\Support\Facades\DB;
use Throwable;

/**
 * ***`CategorieArticleReadWriteRepository`***
 *
 * This class extends the EloquentReadWriteRepository class, which suggests that it is responsible for providing read-only access to the Article $instance data.
 *
 * @package ***`Domains\Articles\CategorieArticle\Repositories`***
 */
class CategorieArticleReadWriteRepository extends EloquentReadWriteRepository
{
    /**
     * Create a new ArticleReadWriteRepository instance.
     *
     * @param  \App\Models\Articles\CategorieArticle $model
     * @return void
     */
    public function __construct(CategorieArticle $model)
    {
        parent::__construct($model);
    }
    
}