<?php

declare(strict_types=1);

namespace Domains\Partners\Suppliers\Services\RESTful;

use Core\Logic\Services\Contracts\QueryServiceContract;
use Core\Logic\Services\RestJson\RestJsonQueryService;
use Domains\Partners\Suppliers\Services\RESTful\Contracts\SupplierRESTfulQueryServiceContract;

/**
 * Class ***`SupplierRESTfulQueryService`***
 *
 * The `SupplierRESTfulQueryService` class is responsible for providing a RESTful implementation of the query service for the People module.
 * It extends the `RestJsonQueryService` class provided by the Core module and implements the `SupplierRESTfulQueryServiceContract` interface.
 *
 * The `SupplierRESTfulQueryService` class primarily serves as a wrapper around the underlying query service, providing RESTful capabilities for querying Supplier resources.
 *
 * @package ***`\Domains\Partners\Suppliers\Services\RESTful`***
 */
class SupplierRESTfulQueryService extends RestJsonQueryService implements SupplierRESTfulQueryServiceContract
{
    /**
     * Constructor for the SupplierRESTfulQueryService class.
     *
     * @param QueryServiceContract $queryService The query service instance to be used.
     */
    public function __construct(QueryServiceContract $queryService)
    {
        parent::__construct($queryService);
    }
}