<?php

declare(strict_types = 1);

namespace App\Http\Controllers\API\RESTful\V1\Articles;

use App\Http\Requests\Articles\CategorieArticle\v1\CreateCategorieArticleRequest;
use App\Http\Requests\Articles\CategorieArticle\v1\UpdateCategorieArticleRequest;
use Core\Utils\Controllers\RESTful\RESTfulResourceController;
use Domains\Articles\CategorieArticle\Services\RESTful\Contracts\CategorieArticleRESTfulQueryServiceContract;
use Domains\Articles\CategorieArticle\Services\RESTful\Contracts\CategorieArticleRESTfulReadWriteServiceContract;

/**
 * **`CategorieArticleController`**
 *
 * Controller for managing unite_mesure resources. This controller extends the RESTfulController
 * and provides CRUD operations for unite_mesure resources.
 *
 * @package **`\App\Http\Controllers\APIs\RESTful\V1`**
 */
class CategorieArticleController extends RESTfulResourceController
{
    /**
     * Create a new CategorieArticleController instance.
     *
     * @param \Domains\Magasins\CategorieArticle\Services\RESTful\Contracts\CategorieArticleRESTfulQueryServiceContract $storage_spaceRESTfulQueryService
     *        The CategorieArticle RESTful Query Service instance.
     */
    public function __construct(CategorieArticleRESTfulReadWriteServiceContract $storage_spaceRESTfulReadWriteService, CategorieArticleRESTfulQueryServiceContract $storage_spaceRESTfulQueryService)
    {
        parent::__construct($storage_spaceRESTfulReadWriteService, $storage_spaceRESTfulQueryService);

        // Set specific request classes for store and update methods
        $this->setRequestClass('store', CreateCategorieArticleRequest::class);
        $this->setRequestClass('update', UpdateCategorieArticleRequest::class);
    }
}
