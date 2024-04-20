<?php

declare(strict_types=1);

namespace Domains\Magasins\Commandes\CommandeArticle\Services\RESTful;

use Core\Logic\Services\Contracts\QueryServiceContract;
use Core\Logic\Services\RestJson\RestJsonQueryService;
use Domains\Magasins\Commandes\CommandeArticle\Services\RESTful\Contracts\CommandeArticleRESTfulQueryServiceContract;

/**
 * Class ***`CommandeArticleRESTfulQueryService`***
 *
 * The `CommandeArticleRESTfulQueryService` class is responsible for providing a RESTful implementation of the query service for the CommandeArticles module.
 * It extends the `RestJsonQueryService` class provided by the Core module and implements the `CommandeArticleRESTfulQueryServiceContract` interface.
 *
 * The `CommandeArticleRESTfulQueryService` class primarily serves as a wrapper around the underlying query service, providing RESTful capabilities for querying CommandeArticle resources.
 *
 * @package ***`\Domains\Magasins\Commandes\CommandeArticle\Services\RESTful`***
 */
class CommandeArticleRESTfulQueryService extends RestJsonQueryService implements CommandeArticleRESTfulQueryServiceContract
{
    /**
     * Constructor for the CommandeArticleRESTfulQueryService class.
     *
     * @param QueryServiceContract $queryService The query service instance to be used.
     */
    public function __construct(QueryServiceContract $queryService)
    {
        parent::__construct($queryService);
    }

}