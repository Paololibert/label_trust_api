<?php

declare(strict_types=1);

namespace Domains\Postes\PosteSalaries\Services\RESTful;

use Core\Logic\Services\Contracts\QueryServiceContract;
use Core\Logic\Services\RestJson\RestJsonQueryService;
use Domains\Postes\PosteSalaries\Services\RESTful\Contracts\PosteSalaryRESTfulQueryServiceContract;

/**
 * Class ***`PosteSalaryRESTfulQueryService`***
 *
 * The `PosteSalaryRESTfulQueryService` class is responsible for providing a RESTful implementation of the query service for the TauxAndSalaries module.
 * It extends the `RestJsonQueryService` class provided by the Core module and implements the `PosteSalaryRESTfulQueryServiceContract` interface.
 *
 * The `PosteSalaryRESTfulQueryService` class primarily serves as a wrapper around the underlying query service, providing RESTful capabilities for querying PosteSalary resources.
 *
 * @package ***`\Domains\Postes\PosteSalaries\Services\RESTful`***
 */
class PosteSalaryRESTfulQueryService extends RestJsonQueryService implements PosteSalaryRESTfulQueryServiceContract
{
    /**
     * Constructor for the PosteSalaryRESTfulQueryService class.
     *
     * @param QueryServiceContract $queryService The query service instance to be used.
     */
    public function __construct(QueryServiceContract $queryService)
    {
        parent::__construct($queryService);
    }

}