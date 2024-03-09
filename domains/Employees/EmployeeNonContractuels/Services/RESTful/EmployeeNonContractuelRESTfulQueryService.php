<?php

declare(strict_types=1);

namespace Domains\Employees\EmployeeNonContractuels\Services\RESTful;

use Core\Logic\Services\Contracts\QueryServiceContract;
use Core\Logic\Services\RestJson\RestJsonQueryService;
use Domains\Employees\EmployeeNonContractuels\Services\RESTful\Contracts\EmployeeNonContractuelRESTfulQueryServiceContract;

/**
 * Class ***`EmployeeNonContractuelRESTfulQueryService`***
 *
 * The `EmployeeNonContractuelRESTfulQueryService` class is responsible for providing a RESTful implementation of the query service for the People module.
 * It extends the `RestJsonQueryService` class provided by the Core module and implements the `EmployeeNonContractuelRESTfulQueryServiceContract` interface.
 *
 * The `EmployeeNonContractuelRESTfulQueryService` class primarily serves as a wrapper around the underlying query service, providing RESTful capabilities for querying EmployeeNonContractuel resources.
 *
 * @package ***`\Domains\Employees\EmployeeNonContractuels\Services\RESTful`***
 */
class EmployeeNonContractuelRESTfulQueryService extends RestJsonQueryService implements EmployeeNonContractuelRESTfulQueryServiceContract
{
    /**
     * Constructor for the EmployeeNonContractuelRESTfulQueryService class.
     *
     * @param QueryServiceContract $queryService The query service instance to be used.
     */
    public function __construct(QueryServiceContract $queryService)
    {
        parent::__construct($queryService);
    }
}