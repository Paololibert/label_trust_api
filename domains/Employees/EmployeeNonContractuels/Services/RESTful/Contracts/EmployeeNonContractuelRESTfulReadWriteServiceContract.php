<?php

declare(strict_types=1);

namespace Domains\Employees\EmployeeNonContractuels\Services\RESTful\Contracts;

use Core\Logic\Services\RestJson\Contracts\RestJsonReadWriteServiceContract;

/**
 * Interface ***`EmployeeNonContractuelRESTfulReadWriteServiceContract`***
 *
 * The `EmployeeNonContractuelRESTfulReadWriteServiceContract` interface defines the contract for a RESTful read-write service specific to the EmployeeNonContractuel module.
 * This interface extends the RestJsonReadWriteServiceContract interface provided by the Core module.
 * It inherits the methods for both reading and writing resources in a RESTful manner.
 *
 * Implementing classes should provide the necessary functionality to perform `read` and `write` operations on EmployeeNonContractuel resources via RESTful API endpoints.
 *
 * @package ***`\Domains\Employees\EmployeeNonContractuels\Services\RESTful\Contracts`***
 */
interface EmployeeNonContractuelRESTfulReadWriteServiceContract extends RestJsonReadWriteServiceContract
{

}