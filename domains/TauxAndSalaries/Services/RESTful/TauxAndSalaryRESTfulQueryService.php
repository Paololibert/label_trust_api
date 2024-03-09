<?php

declare(strict_types=1);

namespace Domains\TauxAndSalaries\Services\RESTful;

use Core\Logic\Services\Contracts\QueryServiceContract;
use Core\Logic\Services\RestJson\RestJsonQueryService;
use Domains\TauxAndSalaries\Services\RESTful\Contracts\TauxAndSalaryRESTfulQueryServiceContract;

/**
 * Class ***`TauxAndSalaryRESTfulQueryService`***
 *
 * The `TauxAndSalaryRESTfulQueryService` class is responsible for providing a RESTful implementation of the query service for the TauxAndSalaries module.
 * It extends the `RestJsonQueryService` class provided by the Core module and implements the `TauxAndSalaryRESTfulQueryServiceContract` interface.
 *
 * The `TauxAndSalaryRESTfulQueryService` class primarily serves as a wrapper around the underlying query service, providing RESTful capabilities for querying TauxAndSalary resources.
 *
 * @package ***`\Domains\TauxAndSalaries\Services\RESTful`***
 */
class TauxAndSalaryRESTfulQueryService extends RestJsonQueryService implements TauxAndSalaryRESTfulQueryServiceContract
{
    /**
     * Constructor for the TauxAndSalaryRESTfulQueryService class.
     *
     * @param QueryServiceContract $queryService The query service instance to be used.
     */
    public function __construct(QueryServiceContract $queryService)
    {
        parent::__construct($queryService);
    }

}