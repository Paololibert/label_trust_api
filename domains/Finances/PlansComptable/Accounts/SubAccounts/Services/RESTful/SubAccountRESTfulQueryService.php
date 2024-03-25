<?php

declare(strict_types=1);

namespace Domains\Finances\PlansComptable\Accounts\SubAccounts\Services\RESTful;

use Core\Logic\Services\Contracts\QueryServiceContract;
use Core\Logic\Services\RestJson\RestJsonQueryService;
use Domains\Finances\PlansComptable\Accounts\SubAccounts\Services\RESTful\Contracts\SubAccountRESTfulQueryServiceContract;

/**
 * Class ***`SubAccountRESTfulQueryService`***
 *
 * The `SubAccountRESTfulQueryService` class is responsible for providing a RESTful implementation of the query service for the SubAccounts module.
 * It extends the `RestJsonQueryService` class provided by the Core module and implements the `SubAccountRESTfulQueryServiceContract` interface.
 *
 * The `SubAccountRESTfulQueryService` class primarily serves as a wrapper around the underlying query service, providing RESTful capabilities for querying SubAccount resources.
 *
 * @package ***`\Domains\Finances\PlansComptable\Accounts\SubAccounts\Services\RESTful`***
 */
class SubAccountRESTfulQueryService extends RestJsonQueryService implements SubAccountRESTfulQueryServiceContract
{
    /**
     * Constructor for the SubAccountRESTfulQueryService class.
     *
     * @param QueryServiceContract $queryService The query service instance to be used.
     */
    public function __construct(QueryServiceContract $queryService)
    {
        parent::__construct($queryService);
    }

}