<?php

declare(strict_types=1);

namespace Domains\Montants\Services\RESTful;

use Core\Logic\Services\Contracts\QueryServiceContract;
use Core\Logic\Services\RestJson\RestJsonQueryService;
use Domains\Montants\Services\RESTful\Contracts\MontantRESTfulQueryServiceContract;

/**
 * Class ***`MontantRESTfulQueryService`***
 *
 * The `MontantRESTfulQueryService` class is responsible for providing a RESTful implementation of the query service for the Montants module.
 * It extends the `RestJsonQueryService` class provided by the Core module and implements the `MontantRESTfulQueryServiceContract` interface.
 *
 * The `MontantRESTfulQueryService` class primarily serves as a wrapper around the underlying query service, providing RESTful capabilities for querying Montant resources.
 *
 * @package ***`\Domains\Montants\Services\RESTful`***
 */
class MontantRESTfulQueryService extends RestJsonQueryService implements MontantRESTfulQueryServiceContract
{
    /**
     * Constructor for the MontantRESTfulQueryService class.
     *
     * @param QueryServiceContract $queryService The query service instance to be used.
     */
    public function __construct(QueryServiceContract $queryService)
    {
        parent::__construct($queryService);
    }

}