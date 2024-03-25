<?php

declare(strict_types=1);

namespace Domains\Finances\Comptes\Services\RESTful;

use Core\Logic\Services\Contracts\QueryServiceContract;
use Core\Logic\Services\RestJson\RestJsonQueryService;
use Domains\Finances\Comptes\Services\RESTful\Contracts\CompteRESTfulQueryServiceContract;

/**
 * Class ***`CompteRESTfulQueryService`***
 *
 * The `CompteRESTfulQueryService` class is responsible for providing a RESTful implementation of the query service for the Comptes module.
 * It extends the `RestJsonQueryService` class provided by the Core module and implements the `CompteRESTfulQueryServiceContract` interface.
 *
 * The `CompteRESTfulQueryService` class primarily serves as a wrapper around the underlying query service, providing RESTful capabilities for querying Compte resources.
 *
 * @package ***`\Domains\Finances\Comptes\Services\RESTful`***
 */
class CompteRESTfulQueryService extends RestJsonQueryService implements CompteRESTfulQueryServiceContract
{
    /**
     * Constructor for the CompteRESTfulQueryService class.
     *
     * @param QueryServiceContract $queryService The query service instance to be used.
     */
    public function __construct(QueryServiceContract $queryService)
    {
        parent::__construct($queryService);
    }

}