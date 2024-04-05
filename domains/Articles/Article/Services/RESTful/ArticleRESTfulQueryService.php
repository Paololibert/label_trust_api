<?php

declare(strict_types=1);

namespace Domains\Articles\Article\Services\RESTful;

use Core\Logic\Services\Contracts\QueryServiceContract;
use Core\Logic\Services\RestJson\RestJsonQueryService;
use Domains\Articles\Article\Services\RESTful\Contracts\ArticleRESTfulQueryServiceContract;

/**
 * Class ***`ArticleRESTfulQueryService`***
 *
 * The `ArticleRESTfulQueryService` class is responsible for providing a RESTful implementation of the query service for the Articles module.
 * It extends the `RestJsonQueryService` class provided by the Core module and implements the `ArticleRESTfulQueryServiceContract` interface.
 *
 * The `ArticleRESTfulQueryService` class primarily serves as a wrapper around the underlying query service, providing RESTful capabilities for querying Article resources.
 *
 * @package ***`\Domains\Articles\Article\Services\RESTful`***
 */
class ArticleRESTfulQueryService extends RestJsonQueryService implements ArticleRESTfulQueryServiceContract
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