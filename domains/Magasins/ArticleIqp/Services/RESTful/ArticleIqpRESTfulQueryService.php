<?php

declare(strict_types=1);

namespace Domains\Magasins\ArticleIqp\Services\RESTful;

use Core\Logic\Services\Contracts\QueryServiceContract;
use Core\Logic\Services\RestJson\RestJsonQueryService;
use Domains\Magasins\ArticleIqp\Services\RESTful\Contracts\ArticleIqpRESTfulQueryServiceContract;

/**
 * Class ***`ArticleIqpRESTfulQueryService`***
 *
 * The `ArticleIqpRESTfulQueryService` class is responsible for providing a RESTful implementation of the query service for the ArticleIqps module.
 * It extends the `RestJsonQueryService` class provided by the Core module and implements the `ArticleIqpRESTfulQueryServiceContract` interface.
 *
 * The `ArticleIqpRESTfulQueryService` class primarily serves as a wrapper around the underlying query service, providing RESTful capabilities for querying ArticleIqp resources.
 *
 * @package ***`\Domains\Magasins\ArticleIqp\Services\RESTful`***
 */
class ArticleIqpRESTfulQueryService extends RestJsonQueryService implements ArticleIqpRESTfulQueryServiceContract
{
    /**
     * Constructor for the ArticleIqpRESTfulQueryService class.
     *
     * @param QueryServiceContract $queryService The query service instance to be used.
     */
    public function __construct(QueryServiceContract $queryService)
    {
        parent::__construct($queryService);
    }

}