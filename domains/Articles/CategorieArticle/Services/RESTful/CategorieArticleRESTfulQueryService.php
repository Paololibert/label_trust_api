<?php

declare(strict_types=1);

namespace Domains\Articles\CategorieArticle\Services\RESTful;

use Core\Logic\Services\Contracts\QueryServiceContract;
use Core\Logic\Services\RestJson\RestJsonQueryService;
use Domains\Articles\CategorieArticle\Services\RESTful\Contracts\CategorieArticleRESTfulQueryServiceContract;

/**
 * Class ***`ArticleRESTfulQueryService`***
 *
 * The `CategorieArticleRESTfulQueryService` class is responsible for providing a RESTful implementation of the query service for the CategorieArticles module.
 * It extends the `RestJsonQueryService` class provided by the Core module and implements the `CategorieArticleRESTfulQueryServiceContract` interface.
 *
 * The `CategorieArticleRESTfulQueryService` class primarily serves as a wrapper around the underlying query service, providing RESTful capabilities for querying CategorieArticle resources.
 *
 * @package ***`\Domains\Articles\CategorieArticle\Services\RESTful`***
 */
class CategorieArticleRESTfulQueryService extends RestJsonQueryService implements CategorieArticleRESTfulQueryServiceContract
{
    /**
     * Constructor for the ArticleRESTfulQueryService class.
     *
     * @param QueryServiceContract $queryService The query service instance to be used.
     */
    public function __construct(QueryServiceContract $queryService)
    {
        parent::__construct($queryService);
    }

}