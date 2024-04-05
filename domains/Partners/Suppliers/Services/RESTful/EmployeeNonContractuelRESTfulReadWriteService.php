<?php

declare(strict_types=1);

namespace Domains\Partners\Suppliers\Services\RESTful;

use Core\Logic\Services\Contracts\ReadWriteServiceContract;
use Core\Logic\Services\RestJson\RestJsonReadWriteService;
use Domains\Partners\Suppliers\Services\RESTful\Contracts\SupplierRESTfulReadWriteServiceContract;


/**
 * The ***`SupplierRESTfulReadWriteService`*** class provides RESTful CRUD operations for the "Supplier" resource.
 *
 * This service class extends the `RestJsonReadWriteService` class to handle the read and write operations for the "Supplier" resource.
 * It implements the `SupplierRESTfulReadWriteServiceContract` interface that defines the contract for this service.
 * The class leverages the `JsonResponseTrait` to create consistent JSON responses with `success`, `error`, and `validation` error structures.
 *
 * @package ***`\Domains\Partners\Suppliers\Services\RESTful`***
 */
class SupplierRESTfulReadWriteService extends RestJsonReadWriteService implements SupplierRESTfulReadWriteServiceContract
{
    /**
     * Constructor for the SupplierRESTfulReadWriteService class.
     *
     * @param ReadWriteServiceContract $readWriteService The query service instance to be used.
     */
    public function __construct(ReadWriteServiceContract $readWriteService)
    {
        parent::__construct($readWriteService);
    }

}