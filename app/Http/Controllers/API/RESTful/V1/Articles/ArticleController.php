<?php

declare(strict_types = 1);

namespace App\Http\Controllers\API\RESTful\V1\Articles;

use App\Http\Requests\Articles\Article\v1\CreateArticleRequest;
use App\Http\Requests\Articles\Article\v1\UpdateArticleRequest;
use Core\Utils\Controllers\RESTful\RESTfulResourceController;
use Domains\Articles\Article\Services\RESTful\Contracts\ArticleRESTfulQueryServiceContract;
use Domains\Articles\Article\Services\RESTful\Contracts\ArticleRESTfulReadWriteServiceContract;

/**
 * **`ArticleController`**
 *
 * Controller for managing unite_mesure resources. This controller extends the RESTfulController
 * and provides CRUD operations for unite_mesure resources.
 *
 * @package **`\App\Http\Controllers\APIs\RESTful\V1`**
 */
class ArticleController extends RESTfulResourceController
{
    /**
     * Create a new ArticleController instance.
     *
     * @param \Domains\Articles\Article\Services\RESTful\Contracts\ArticleRESTfulQueryServiceContract $magasinRESTfulQueryService
     *        The Article RESTful Query Service instance.
     */
    public function __construct(ArticleRESTfulReadWriteServiceContract $magasinRESTfulReadWriteService, ArticleRESTfulQueryServiceContract $magasinRESTfulQueryService)
    {
        parent::__construct($magasinRESTfulReadWriteService, $magasinRESTfulQueryService);

        // Set specific request classes for store and update methods
        $this->setRequestClass('store', CreateArticleRequest::class);
        $this->setRequestClass('update', UpdateArticleRequest::class);
    }
}
