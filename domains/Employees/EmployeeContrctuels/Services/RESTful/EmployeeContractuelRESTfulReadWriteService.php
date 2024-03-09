<?php

declare(strict_types=1);

namespace Domains\Employees\EmployeeContractuels\Services\RESTful;

use Core\Logic\Services\Contracts\ReadWriteServiceContract;
use Core\Logic\Services\RestJson\RestJsonReadWriteService;
use Domains\Employees\EmployeeContractuels\Services\RESTful\Contracts\EmployeeContractuelRESTfulReadWriteServiceContract as ContractsEmployeeContractuelRESTfulReadWriteServiceContract;

/**
 * The ***`EmployeeContractuelRESTfulReadWriteService`*** class provides RESTful CRUD operations for the "EmployeeContractuel" resource.
 *
 * This service class extends the `RestJsonReadWriteService` class to handle the read and write operations for the "EmployeeContractuel" resource.
 * It implements the `EmployeeContractuelRESTfulReadWriteServiceContract` interface that defines the contract for this service.
 * The class leverages the `JsonResponseTrait` to create consistent JSON responses with `success`, `error`, and `validation` error structures.
 *
 * @package ***`\Domains\Employees\EmployeeContractuels\Services\RESTful`***
 */
class EmployeeContractuelRESTfulReadWriteService extends RestJsonReadWriteService implements ContractsEmployeeContractuelRESTfulReadWriteServiceContract
{
    /**
     * Constructor for the EmployeeContractuelRESTfulReadWriteService class.
     *
     * @param ReadWriteServiceContract $readWriteService The query service instance to be used.
     */
    public function __construct(ReadWriteServiceContract $readWriteService)
    {
        parent::__construct($readWriteService);
    }
}