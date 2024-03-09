<?php

declare(strict_types=1);

namespace Domains\Employees\Services\RESTful;

use Core\Logic\Services\Contracts\QueryServiceContract;
use Core\Logic\Services\RestJson\RestJsonQueryService;
use Domains\Employees\Services\RESTful\Contracts\EmployeeRESTfulQueryServiceContract;

/**
 * Class ***`EmployeeRESTfulQueryService`***
 *
 * The `EmployeeRESTfulQueryService` class is responsible for providing a RESTful implementation of the query service for the Employees module.
 * It extends the `RestJsonQueryService` class provided by the Core module and implements the `EmployeeRESTfulQueryServiceContract` interface.
 *
 * The `EmployeeRESTfulQueryService` class primarily serves as a wrapper around the underlying query service, providing RESTful capabilities for querying Employee resources.
 *
 * @package ***`\Domains\Employees\Services\RESTful`***
 */
class EmployeeRESTfulQueryService extends RestJsonQueryService implements EmployeeRESTfulQueryServiceContract
{
    /**
     * Constructor for the EmployeeRESTfulQueryService class.
     *
     * @param QueryServiceContract $queryService The query service instance to be used.
     */
    public function __construct(QueryServiceContract $queryService)
    {
        parent::__construct($queryService);
    }

}