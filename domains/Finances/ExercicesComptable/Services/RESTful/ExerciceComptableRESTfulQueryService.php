<?php

declare(strict_types=1);

namespace Domains\Finances\ExercicesComptable\Services\RESTful;

use Core\Logic\Services\Contracts\QueryServiceContract;
use Core\Logic\Services\RestJson\RestJsonQueryService;
use Domains\Finances\ExercicesComptable\Services\RESTful\Contracts\ExerciceComptableRESTfulQueryServiceContract;

/**
 * Class ***`ExerciceComptableRESTfulQueryService`***
 *
 * The `ExerciceComptableRESTfulQueryService` class is responsible for providing a RESTful implementation of the query service for the ExercicesComptable module.
 * It extends the `RestJsonQueryService` class provided by the Core module and implements the `ExerciceComptableRESTfulQueryServiceContract` interface.
 *
 * The `ExerciceComptableRESTfulQueryService` class primarily serves as a wrapper around the underlying query service, providing RESTful capabilities for querying ExerciceComptable resources.
 *
 * @package ***`\Domains\Finances\ExercicesComptable\Services\RESTful`***
 */
class ExerciceComptableRESTfulQueryService extends RestJsonQueryService implements ExerciceComptableRESTfulQueryServiceContract
{
    /**
     * Constructor for the ExerciceComptableRESTfulQueryService class.
     *
     * @param QueryServiceContract $queryService The query service instance to be used.
     */
    public function __construct(QueryServiceContract $queryService)
    {
        parent::__construct($queryService);
    }

}