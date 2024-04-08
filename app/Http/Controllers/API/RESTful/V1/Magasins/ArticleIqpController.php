<?php

declare(strict_types = 1);

namespace App\Http\Controllers\API\RESTful\V1\Magasins;

use App\Http\Requests\Magasins\ArticleIqp\v1\CreateArticleIqpRequest;
use App\Http\Requests\Magasins\ArticleIqp\v1\UpdateArticleIqpRequest;
use Core\Utils\Controllers\RESTful\RESTfulResourceController;
use Domains\Magasins\ArticleIqp\Services\RESTful\Contracts\ArticleIqpRESTfulQueryServiceContract;
use Domains\Magasins\ArticleIqp\Services\RESTful\Contracts\ArticleIqpRESTfulReadWriteServiceContract;

/**
 * **`ArticleIqpController`**
 *
 * Controller for managing unite_mesure resources. This controller extends the RESTfulController
 * and provides CRUD operations for unite_mesure resources.
 *
 * @package **`\App\Http\Controllers\APIs\RESTful\V1`**
 */
class ArticleIqpController extends RESTfulResourceController
{
    /**
     * Create a new ArticleIqpController instance.
     *
     * @param \Domains\Magasins\ArticleIqp\Services\RESTful\Contracts\ArticleIqpRESTfulQueryServiceContract $article_iqpRESTfulQueryService
     *        The ArticleIqp RESTful Query Service instance.
     */
    public function __construct(ArticleIqpRESTfulReadWriteServiceContract $article_iqpRESTfulReadWriteService, ArticleIqpRESTfulQueryServiceContract $article_iqpRESTfulQueryService)
    {
        parent::__construct($article_iqpRESTfulReadWriteService, $article_iqpRESTfulQueryService);

        // Set specific request classes for store and update methods
        $this->setRequestClass('store', CreateArticleIqpRequest::class);
        $this->setRequestClass('update', UpdateArticleIqpRequest::class);
    }
}
