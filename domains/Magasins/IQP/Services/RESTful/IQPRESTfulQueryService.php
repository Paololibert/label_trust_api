<?php

declare(strict_types=1);

namespace Domains\Magasins\IQP\Services\RESTful;

use Core\Logic\Services\Contracts\QueryServiceContract;
use Core\Logic\Services\RestJson\RestJsonQueryService;
use Domains\Magasins\IQP\Services\RESTful\Contracts\IQPRESTfulQueryServiceContract;

/**
 * Class ***`IQPRESTfulQueryService`***
 *
 * The `IQPRESTfulQueryService` class is responsible for providing a RESTful implementation of the query service for the IQPs module.
 * It extends the `RestJsonQueryService` class provided by the Core module and implements the `IQPRESTfulQueryServiceContract` interface.
 *
 * The `IQPRESTfulQueryService` class primarily serves as a wrapper around the underlying query service, providing RESTful capabilities for querying IQP resources.
 *
 * @package ***`\Domains\Magasins\IQP\Services\RESTful`***
 */
class IQPRESTfulQueryService extends RestJsonQueryService implements IQPRESTfulQueryServiceContract
{
    /**
     * Constructor for the IQPRESTfulQueryService class.
     *
     * @param QueryServiceContract $queryService The query service instance to be used.
     */
    public function __construct(QueryServiceContract $queryService)
    {
        parent::__construct($queryService);
    }

}