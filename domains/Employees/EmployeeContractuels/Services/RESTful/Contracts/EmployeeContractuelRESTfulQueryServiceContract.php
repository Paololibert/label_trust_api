<?php

declare(strict_types=1);

namespace Domains\Employees\EmployeeContractuels\Services\RESTful\Contracts;

use Core\Logic\Services\RestJson\Contracts\RestJsonQueryServiceContract;

/**
 * Interface ***`EmployeeContractuelRESTfulQueryServiceContract`***
 *
 * The `EmployeeContractuelRESTfulQueryServiceContract` interface is a contract that defines the methods
 * for a RESTful query service specific to EmployeeContractuel resources.
 *
 * This interface extends the RestJsonQueryServiceContract interface, which provides
 * a set of common methods for performing RESTful queries on JSON-based resources.
 *
 * Implementing classes should provide the necessary implementation for each method
 * defined in this interface, which includes `querying`, `filtering`, `sorting`, `pagination`,
 * and other operations specific to EmployeeContractuel resources.
 *
 * @package ***`\Domains\Employees\EmployeeContractuels\Services\RESTful\Contracts`***
 */
interface EmployeeContractuelRESTfulQueryServiceContract extends RestJsonQueryServiceContract
{
    /**
     * List of pay slips
     *
     * @param  string                                   $employeeContractuelId      The unique identifier of the employee contractuel.
     * @return \Illuminate\Http\JsonResponse                                        The JSON response indicating the success of the operation.
     *
     * @throws \Core\Utils\Exceptions\ServiceException                              If there is an issue.
     */
    public function pay_slips(string $employeeContractuelId): \Illuminate\Http\JsonResponse;
}