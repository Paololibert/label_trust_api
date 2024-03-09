<?php

declare(strict_types=1);

namespace Domains\Users\Companies\Services\RESTful;

use Core\Logic\Services\Contracts\QueryServiceContract;
use Core\Logic\Services\RestJson\RestJsonQueryService;
use Domains\Users\Companies\Services\RESTful\Contracts\EmployeeContractuelRESTfulQueryServiceContract;

/**
 * Class ***`EmployeeContractuelRESTfulQueryService`***
 *
 * The `EmployeeContractuelRESTfulQueryService` class is responsible for providing a RESTful implementation of the query service for the People module.
 * It extends the `RestJsonQueryService` class provided by the Core module and implements the `EmployeeContractuelRESTfulQueryServiceContract` interface.
 *
 * The `EmployeeContractuelRESTfulQueryService` class primarily serves as a wrapper around the underlying query service, providing RESTful capabilities for querying EmployeeContractuel resources.
 *
 * @package ***`\Domains\Users\Companies\Services\RESTful`***
 */
class EmployeeContractuelRESTfulQueryService extends RestJsonQueryService implements EmployeeContractuelRESTfulQueryServiceContract
{
    /**
     * Constructor for the EmployeeContractuelRESTfulQueryService class.
     *
     * @param QueryServiceContract $queryService The query service instance to be used.
     */
    public function __construct(QueryServiceContract $queryService)
    {
        parent::__construct($queryService);
    }
}