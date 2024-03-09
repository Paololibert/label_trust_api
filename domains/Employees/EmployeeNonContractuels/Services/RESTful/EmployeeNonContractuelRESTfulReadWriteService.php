<?php

declare(strict_types=1);

namespace Domains\Employees\EmployeeNonContractuels\Services\RESTful;

use Core\Logic\Services\Contracts\ReadWriteServiceContract;
use Core\Logic\Services\RestJson\RestJsonReadWriteService;
use Domains\Employees\EmployeeNonContractuels\Services\RESTful\Contracts\EmployeeNonContractuelRESTfulReadWriteServiceContract;

/**
 * The ***`EmployeeNonContractuelRESTfulReadWriteService`*** class provides RESTful CRUD operations for the "EmployeeNonContractuel" resource.
 *
 * This service class extends the `RestJsonReadWriteService` class to handle the read and write operations for the "EmployeeNonContractuel" resource.
 * It implements the `EmployeeNonContractuelRESTfulReadWriteServiceContract` interface that defines the contract for this service.
 * The class leverages the `JsonResponseTrait` to create consistent JSON responses with `success`, `error`, and `validation` error structures.
 *
 * @package ***`\Domains\Employees\EmployeeNonContractuels\Services\RESTful`***
 */
class EmployeeNonContractuelRESTfulReadWriteService extends RestJsonReadWriteService implements EmployeeNonContractuelRESTfulReadWriteServiceContract
{
    /**
     * Constructor for the EmployeeNonContractuelRESTfulReadWriteService class.
     *
     * @param ReadWriteServiceContract $readWriteService The query service instance to be used.
     */
    public function __construct(ReadWriteServiceContract $readWriteService)
    {
        parent::__construct($readWriteService);
    }
}